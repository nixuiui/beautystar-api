
@extends('email.layout')

@section('content')
<div class="content">
    <h3>Hello, {{ $nama }}</h3>
    <p>
        Kamu Menerima Email ini karena kmau ingin melakukan verifikasi email.
    </p>
    
    <div class="btn mb-20">
        <a href="{{ route('email.verification') }}?username={{ $username }}&&code={{$code}}" class="btn-bayar">Verifikasi</a>
    </div>
    
    <p>
        Jika link yang tersedia tidak bisa di klik silakan salin URL ini ke browser kamu :
    </p>

    <p>
        <a href="{{ route('email.verification') }}?username={{ $username }}&&code={{$code}}">{{ route('email.verification') }}?username={{ $username }}&&code={{$code}}</a>
    </p>

</div>
@endsection