@extends('email.layout')

@section('content')
<div class="content">
    <h3>Hello, {{ $mua->user->name }}</h3>
    <p>
        Kamu telah mendapatkan pesanan layanan kecantikan dari {{ $booking->name }}. <br>
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
        Mohon segera lakukan konfirmasi dalam waktu paling lama 2 x 24 Jam ke depan.
    </p>
    <div class="btn">
        <a href="{{ route('muaDashboard.orders', $booking->id) }}" class="btn-bayar">KONFIRMASI SEKARANG</a>
    </div><br>
</div>
@endsection