<?php

namespace App\Http\Controllers\MuaDashboard;

use App\Http\Controllers\Controller;
use App\Models\BeautyFinance;
use App\Models\MuaOrder;
use App\Models\MuaOrderAdditionalCost;
use App\Models\MuaOrderStatus;
use App\Models\SetGeneral;
use App\Models\WalletHistory;
use App\Traits\DownpaymentTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;

class OrderController extends Controller
{
   
    use DownpaymentTrait;

    public function orderNewest() {
        $order = MuaOrder::where("mua_id", Auth::user()->mua->id)
                        ->where("order_status_id", 1201)
                        ->get();
        $data = $order->map(function($item) {
            return MuaOrder::mapData($item);
        });
        return $this->responseOK(null, $data);
    }
    
    public function orderFinished() {
        $order = MuaOrder::where("mua_id", Auth::user()->mua->id)
                        ->whereIn("order_status_id", [1210, 1211])
                        ->get();
        $data = $order->map(function($item) {
            return MuaOrder::mapData($item);
        });
        return $this->responseOK(null, $data);
    }

    public function orderCanceled() {
        $order = MuaOrder::where("mua_id", Auth::user()->mua->id)
                        ->whereIn("order_status_id", [1202, 1208, 1209])
                        ->get();
        $data = $order->map(function($item) {
            return MuaOrder::mapData($item);
        });
        return $this->responseOK(null, $data);
    }
    
    public function orderOnGoing() {
        $order = MuaOrder::where("mua_id", Auth::user()->mua->id)
                        ->whereIn("order_status_id", [1201, 1202, 1204, 1205, 1207])
                        ->get();
        $data = $order->map(function($item) {
            return MuaOrder::mapData($item);
        });
        return $this->responseOK(null, $data);
    }
    
    public function detailOrder($id) {
        $order = MuaOrder::where("mua_id", Auth::user()->mua->id)
                        ->where("id", $id)
                        ->first();
        // return $service = $order->additionalCosts;
        $data = MuaOrder::mapDataDetail($order);
        return $this->responseOK(null, $data);
    }

    public function approvalOrder(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'status_id'         => 'required|in:1202,1203',
            'cost'              => 'numeric'
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }

        $mua = Auth::user()->mua;
        $order = MuaOrder::where("mua_id", $mua->id)
                            ->where("id", $id)
                            ->first();
        if(!$order) return $this->responseError("Data order tidak ada", null);
        if($order->order_status_id != 1201) return $this->responseError("Orderan Anda sudah ditanggapi", null);

        $statusOld = $order->order_status_id;

        // MENGUBAH STATUS ORDER
        $status = new MuaOrderStatus;
        $status->order_id = $order->id;
        $status->status_id = $request->status_id;
        $status->user_id = Auth::user()->id;
        $status->comment = $request->comment;
        $status->save();
        
        $order->order_status_id = $status->status_id;
        $order->save();

        $urlOrder = env("APP_URL_WEB") . "/bookings/" . $order->id;

        if($request->status_id == 1202) {
            if($request->cost && $request->additional_cost) {
                $additionalCost = new MuaOrderAdditionalCost;
                $additionalCost->order_id = $order->id;
                $additionalCost->cost_for = $request->additional_cost;
                $additionalCost->cost = $request->cost;
                $additionalCost->save();

                $order->additional_cost = $additionalCost->cost;
                $order->total_cost += $additionalCost->cost;
                $order->total_dp = $this->getMuaDownpayment($order->total_cost, $order->mua_id);
                $order->save();
            }
            $message = "Orderan kamu telah disetujui oleh vendor (" . $order->mua->brand_name . "). Silahkan melakukan pembayaran dengan mengikuti langkah pada link berikut. \n";
            $message .= $urlOrder;

            // EMAIL TO CUSTOMER
            $dataEmail = ['mua' => $mua,'booking' => $order];
            Mail::send('email.pesananditerima', $dataEmail, function ($mail) use ($order, $mua)  {
                $mail->to($order->email, $order->name);
                $mail->subject('Pesanan Anda Diterima Oleh ' . $mua->brand_name . '. Segera Lakukan Pembayaran.');
            });
        }

        // MUA MENOLAK ORDERAN
        else if($request->status_id == 1203) {
            $message = "Mohon maaf vendor (" . $order->mua->brand_name . ") belum bisa menerima orderan kamu, dengan alasan: \n";
            $message .= $request->comment . ".\n";
            $message .= "Jangan sedih, kamu masih bisa cari vendor lain di link \n";
            $message .= route('mua');
        }

        // $this->sendWhatsapp($order->phone, $message);

        return $this->responseOK(null, MuaOrder::mapDataDetail($order));
    }

    public function completeOrder(Request $request, $id) {
        $mua = Auth::user()->mua;
        $order = MuaOrder::where("mua_id", $mua->id)
                            ->where("id", $id)
                            ->first();
        if(!$order) return $this->responseError("Data order tidak ada", null);
        if($order->order_status_id != 1207) return $this->responseError("Orderan ini tidak bisa dilakukan tindakan", null);

        // MENGUBAH STATUS ORDER
        $status = new MuaOrderStatus;
        $status->order_id = $order->id;
        $status->status_id = 1210;
        $status->user_id = Auth::user()->id;
        $status->comment = $request->comment;
        $status->save();
        
        $order->order_status_id = $status->status_id;
        $order->save();

        // INCOME UNTUK MUA DAN BEAUTY STAR
        $general = SetGeneral::default();
        $totalTransaksi = $order->subtotal_cost + $order->additional_cost;
        $subsidi = $order->discount;
        $feeAdmin = ($this->adminFeePercentage * $totalTransaksi) + $order->unique_code;
        $feeMua = ($order->amount_paid + $subsidi) - $feeAdmin;

        // Relesae Beauty Finance
        $finance = new BeautyFinance;
        $finance->user_id = $order->client->id;
        $finance->deb_cr = -($order->amount_paid);
        $finance->category_id = 1503;
        $finance->object_id = $order->id;
        $finance->balance = $general->balance - ($order->amount_paid + $subsidi);
        $finance->comment = "Release untuk dibagi ke Makeup Artist dan biaya admin";
        $finance->save();

        // 0
        $generalBalance = $finance->balance;

        // FEE BUAT MUA
        // $feeMua Diambil dari: (Total Bayar + Subsidu Dari Beauty Star) - Fee Admin
        $finance = new BeautyFinance;
        $finance->user_id = $order->mua->owner->id;
        $finance->deb_cr = $feeMua;
        $finance->category_id = 1504;
        $finance->object_id = $order->id;
        $finance->balance = $generalBalance + $feeMua;
        $finance->comment = "Fee untuk Vendor MUA";
        $finance->save();

        $generalBalance = $finance->balance;

        $finance = new BeautyFinance;
        $finance->user_id = $order->mua->owner->id;
        $finance->deb_cr = $feeAdmin;
        $finance->category_id = 1505;
        $finance->object_id = $order->id;
        $finance->balance = $generalBalance + $feeAdmin;
        $finance->comment = "Fee untuk Biaya Administrator";
        $finance->save();

        // Jika terdapat subsidi
        if($subsidi) {
            $generalBalance = $finance->balance;

            $finance = new BeautyFinance;
            $finance->user_id = $order->mua->owner->id;
            $finance->deb_cr = -($subsidi);
            $finance->category_id = 1506;
            $finance->object_id = $order->id;
            $finance->balance = $generalBalance - $subsidi;
            $finance->comment = "Pengeluaran: Subsidi buat diskon";
            $finance->save();
        }

        // Membuat history Waller MUA
        $muaWallet = new WalletHistory;
        $muaWallet->user_id = Auth::user()->id;
        $muaWallet->deb_cr = $feeMua;
        $muaWallet->category_id = $order->payment_type == 1301 ? 1601 : 1602;
        $muaWallet->object_id = $order->id;
        $muaWallet->balance = Auth::user()->balance + $feeMua;
        $muaWallet->comment = "Pembayaran order Makeup untuk Vendor";
        $muaWallet->save();

        // Update Saldo MUA
        $user = Auth::user();
        $user->balance = $muaWallet->balance;
        $user->save();

        return $this->responseOK(null, MuaOrder::mapDataDetail($order));
    }

}
