@extends('email.layout')

@section('content')
<div class="content">
    <h3>Hello, {{ $booking->name }}</h3>
    <p>
        Terimakasih telah memesan layanan kecantikan di {{ $booking->mua->brand_name}}. <br>
        Berikut ini adalah detail Booking kamu :
    </p>
    
    {{-- table Booking --}}
    <div class="card mb-20">
        <div class="card-header">
            Info Booking
        </div>
        <div class="card-body">
            <strong>ID Booking</strong>: #{{ $booking->id }} <br>
            <strong>Nama Panggilan</strong>: {{ $booking->name }}<br>
            <strong>Email</strong>: {{ $booking->email }}<br>
            <strong>Telfon</strong>: {{ $booking->phone_number }}<br>
            <strong>Lokasi Layanan</strong>: {{ $booking->address }}, {{ $booking->city->name }}, {{ $booking->province->name }}<br>
            <strong>Beauty Artist</strong>: {{ $booking->mua->brand_name }}<br>
            <strong>Catatan</strong>: {{ $booking->comment }}<br>
        </div>
    </div>

    {{-- Item Layanan --}}
    <h4>Item Layanan : </h4>

    {{-- LAYANAN --}}
    @foreach ($booking->details as $item)   
    <div class="row border-top list-item">
        <div class="left">
            {{ $item->service->name }}
            <br>
            {{ $item->count }} X {{ formatUang($item->price) }}
        </div>
        <div class="right">
            <span>{{ formatUang($item->total_price) }}</span>
        </div>
    </div>
    @endforeach

    {{-- SUBTOTAL --}}
    <div class="right-sub border-top">
        <div class="left"><b>Subtotal</b></div>
        <div class="right"><b>{{ formatUang($booking->subtotal_cost) }}</b></div>
    </div>

    {{-- DISKON --}}
    @if($booking->discount)
    <div class="right-sub border-top">
        <div class="left">Diskon</div>
        <div class="right">-{{ formatUang($booking->discount) }}</div>
    </div>
    @endif

    {{-- BIAYA TAMBAHAN --}}
    @foreach ($booking->additionalCosts as $item) 
    <div class="right-sub border-top">
        <div class="left">{{ $item->cost_for }}</div>
        <div class="right">{{ formatUang($item->cost) }}</div>
    </div>
    @endforeach

    {{-- KODE UNIK --}}
    @if ($booking->unique_code) 
    <div class="right-sub border-top">
        <div class="left">Kode Unik</div>
        <div class="right">{{ formatUang($booking->unique_code) }}</div>
    </div>
    @endif

    <div class="right-sub border-top mb-40">
        <div class="left"><b>Total Estimasi Harga</b></div>
        <div class="right"><b>{{ formatUang($booking->total_cost+$booking->unique_code) }}</b></div>
    </div>

    <p class="text-center">
        Booking Kamu telah kmi teruskan ke {{ $booking->mua->brand_name}} <br>
        Mohon tunggu konfirmasi dari {{ $booking->mua->brand_name}} maksimal dalam 2 x 24jam.
    </p>
    <div class="btn mb-40">
        <a href="{{ route('profile.booking', $booking->id) }}" class="btn-bayar">LIHAT SELENGKAPNYA</a>
    </div>
    
    <div>
        <small>Catatan : Harga yang tertera belum termasuk biaya-biaya lain ( apabila ada ) yang mungkin dibebankan oleh Client. {{ $booking->mua->brand_name}} akan mengirimkan tagihan final setelah menerima permintaan pesanan kamu.</small>
    </div>
</div>
@endsection
