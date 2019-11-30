@extends('email.layout')

@section('content')
<div class="content">
    <h3>Hello, {{ $booking->name }}</h3>
    <p>
        Terima Kasih atas kepercayaan kamu menggunakan layanan BeautyStar. Pembayaran Anda untuk order #{{ $booking->id }} telah kami verifikasi.
    </p>
    <p>
        Jadwal makeup Anda adalah {{ hariTanggalWaktu($booking->planing_time) }}.
    </p>
    <div class="btn">
        <a href="{{ route('profile.booking', $booking->id) }}" class="btn-bayar">SELENGKAPNYA</a>
    </div>
</div>
@endsection