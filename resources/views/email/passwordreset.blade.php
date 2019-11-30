
@extends('email.layout')

@section('content')
<div class="content">
    <h3>Hello, {{ $nama }}</h3>
    <p>
        Kamu Menerima Email ini karena kmau mengajukan password reset untuk akun BeautyStar mu. Jika kamu merasa tidak mengajukan perintah ini, silakan acuhkan email ini.
    </p>
    <p>
        Untuk mengisi password baru dan menyelesaikan permintaan kamu silakan klik link dibawah ini : 
    </p>

    
    <div class="btn mb-20">
        <a href="{{ route('auth.password.reset.form', ['token' => $token]) }}" class="btn-bayar">RESET PASSWORD</a>
    </div>
    
    <p>
        Jika link yang tersedia tidak bisa di klik silakan salin URL ini ke browser kamu :
    </p>

    <p>
        <a href="{{ route('auth.password.reset.form', ['token' => $token]) }}">{{ route('auth.password.reset.form', ['token' => $token]) }}</a>
    </p>

    <p>
        kamu bisa mengganti password kamukapan saja pada bagian <br>
        <strong>Profile -> Profile Setting -> Password -></b> di <b>beautystar.id</strong>
    </p>

</div>
@endsection