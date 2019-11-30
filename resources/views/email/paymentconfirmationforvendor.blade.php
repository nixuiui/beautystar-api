@extends('email.layout')

@section('content')
<div class="content">
    <h3>Hello, {{ $booking->mua->brand_name }}</h3>
    <p>
        Terima Kasih atas kepercayaan kamu menggunakan layanan BeautyStar. {{ $booking->name }} telah melakukan pembayaran untuk order #{{ $booking->id }}.
    </p>
    <p>
        Jadwal makeup Anda adalah {{ hariTanggalWaktu($booking->planing_time) }}.
    </p>
    <div class="btn">
        <a href="{{ route('muaDashboard.orders', $booking->id) }}" class="btn-bayar">SELENGKAPNYA</a>
    </div>
</div>
@endsection