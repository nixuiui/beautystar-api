<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuaOrder extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_mua_orders';
    protected $dates = ['deleted_at'];
    protected $append = ['phone'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
        });
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    //RELATION table
    public function mua()
    {
        return $this->belongsTo('App\Models\Mua', 'mua_id')->withDefault();
    }
    public function client()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
    }
    public function city()
    {
        return $this->belongsTo('App\Models\SetCity', 'city_id')->withDefault();
    }
    public function province()
    {
        return $this->belongsTo('App\Models\SetProvince', 'province_id')->withDefault();
    }
    public function status()
    {
        return $this->belongsTo('App\Models\SetLibrary', 'order_status_id')->withDefault();
    }
    public function bookingType()
    {
        return $this->belongsTo('App\Models\SetLibrary', 'booking_type_id')->withDefault();
    }
    public function paymentType()
    {
        return $this->belongsTo('App\Models\SetLibrary', 'payment_type')->withDefault();
    }
    public function details()
    {
        return $this->hasMany('App\Models\MuaOrderDetail', 'order_id');
    }
    public function statusHistories()
    {
        return $this->hasMany('App\Models\MuaOrderStatus', 'order_id');
    }
    public function additionalCosts()
    {
        return $this->hasMany('App\Models\MuaOrderAdditionalCost', 'order_id');
    }
    public function income()
    {
        return $this->hasOne('App\Models\WalletHistory', 'object_id')->withDefault();
    }

    public function getPhoneAttribute()
    {
        if ($this->phone_number) {
            return "+62" . $this->phone_number;
        }

        return null;
    }

    public static function mapData($data, $additionalAttribute = null)
    {

        // DATA LAYANAN
        $services = "";
        foreach ($data->details as $key => $service) {
            if ($key > 1) {
                break;
            }

            if ($key > 0) {
                $services .= ", ";
            }

            $services .= $service->service->name;
        }
        if ($data->details->count() > 2) {
            $services .= ($data->details->count() - 2) . "lagi...";
        }

        $result = [
            "id" => $data->id,
            "user_id" => $data->user_id,
            "mua_id" => $data->mua_id,
            "mua" => $data->mua->brand_name,
            "name" => $data->name,
            "profile_photo" => $data->client->photo,
            "phone_number" => $data->phone_number,
            "email" => $data->email,
            "planing_time" => $data->planing_time,
            "planing_date" => hariTanggal($data->planing_time),
            "planing_clock" => jamMenitA($data->planing_time),
            "address" => $data->address ?: $data->mua->address,
            "services" => $services,
            "province_id" => $data->province_id,
            "province" => $data->province->name,
            "city_id" => $data->city_id,
            "city" => $data->city->name,
            "total_cost" => $data->total_cost,
            "total_cost_formatted" => formatUang($data->total_cost),
            "order_status_id" => $data->order_status_id,
            "order_status" => $data->status->name,
            "is_rated" => $data->is_rated,
        ];
        if ($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }

    public static function mapDataDetail($data, $additionalAttribute = null)
    {
        $result = [
            "id" => $data->id,
            "user_id" => $data->user_id,
            "mua_id" => $data->mua_id,
            "mua" => $data->mua->brand_name,
            "name" => $data->name,
            "profile_photo" => $data->client->photo,
            "phone_number" => $data->phone_number,
            "email" => $data->email,
            "planing_time" => $data->planing_time,
            "planing_date" => hariTanggal($data->planing_time),
            "planing_clock" => jamMenitA($data->planing_time),
            "address" => $data->address,
            "province_id" => $data->province_id,
            "province" => $data->province->name,
            "city_id" => $data->city_id,
            "city" => $data->city->name,
            "comment" => $data->comment,
            "coupon_id" => $data->coupon_id,
            "subtotal_cost" => $data->subtotal_cost,
            "subtotal_cost_formatted" => formatUang($data->subtotal_cost),
            "discount" => $data->discount,
            "discount_formatted" => formatUang($data->discount),
            "additional_cost" => $data->additional_cost,
            "additional_cost_formatted" => formatUang($data->additional_cost),
            "total_cost" => $data->total_cost,
            "total_cost_formatted" => formatUang($data->total_cost),
            "total_dp" => $data->total_dp,
            "total_dp_formatted" => formatUang($data->total_dp),
            "unique_code" => $data->unique_code,
            "unique_code_formatted" => formatUang($data->unique_code),
            "confirmation_deadline" => $data->confirmation_deadline,
            "confirmation_deadline_formatted" => hariTanggalWaktu($data->confirmation_deadline),
            "expired_date" => $data->expired_date,
            "expired_date_formatted" => hariTanggalWaktu($data->expired_date),
            "payment_date" => $data->payment_date,
            "payment_date_formatted" => hariTanggalWaktu($data->payment_date),
            "payment_type_id" => $data->payment_type,
            "payment_type" => $data->paymentType->name,
            "amount_paid" => $data->amount_paid,
            "amount_paid_formatted" => $data->amount_paid ? formatUang($data->amount_paid) : null,
            "remaining_pay" => $data->amount_paid ? $data->total_cost + $data->unique_code - $data->amount_paid : null,
            "remaining_pay_formatted" => $data->amount_paid ? formatUang($data->total_cost + $data->unique_code - $data->amount_paid) : null,
            "payment_confirmed_by" => $data->payment_confirmed_by,
            "order_status_id" => $data->order_status_id,
            "order_status" => $data->status->name,
            "is_rated" => $data->is_rated,
            "services" => $data->details->map(function ($item) {
                return MuaOrderDetail::mapData($item);
            }),
            "status_histories" => $data->statusHistories->map(function ($item) {
                return MuaOrderStatus::mapData($item);
            }),
            "additional_costs" => $data->additionalCosts->map(function ($item) {
                return MuaOrderAdditionalCost::mapData($item);
            }),
            "income" => $data->order_status_id >= 1210 ? $data->income->deb_cr : null,
            "income_formatted" => $data->order_status_id >= 1210 ? formatUang($data->income->deb_cr) : null,
        ];
        if ($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }
}
