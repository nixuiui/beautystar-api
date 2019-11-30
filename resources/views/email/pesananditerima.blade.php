@extends('email.layout')

@section('content')
<div class="content">
    <h3>Hello, {{ $booking->name }}</h3>
    <p>
        {{ $mua->brand_name }} telah menerima Permintaan Orderan kamu. Booking kamu akan di proses setelah kamu melakukan pembayaran.
    </p>

    <p>
        Untuk memudahkan kami dalam proses verifikasi, mohon mentransfer tepat sesuai nominal total hingga 3 Digit terakhir.
    </p>
    <p>
        Total Pembayaran: <strong>{{ formatUang($booking->total_cost+$booking->unique_code) }}</strong>
    </p>
    @if($booking->total_dp < $booking->total_cost)
    <p>
        Atau Anda bisa membayar DP terlebih dahulu sejumlah: {{ formatUang($booking->total_dp+$booking->unique_code) }}
    </p>
    @endif
    <p>
        Klik tombol di bawah ini untuk melihat intruksi pembayaran.
    </p>
    <div class="btn">
        <a href="{{ env("APP_URL_WEB") . "/bookings/" . $booking->id }}" class="btn-bayar">BAYAR SEKARANG</a>
    </div>
    <p>
        Catatan <br>
        Mohon diperhatikan bahwa pembayaran harus di lakukan paling lambat tanggal <strong>{{ hariTanggalWaktu($booking->expired_date) }}</strong>. Apabila sampai dengan batas waktu tersebut beum dilakukan pembayaran, maka Orderan ini akan dibatalkan.
    </p>
</div>
@endsection