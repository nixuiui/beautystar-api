@extends('layout.master')

@section('title')
Verifikasi Email
@endsection

@section('content')
<div class="section bg-white-soft" style="min-height: 70vh">
    <div class="container">
        <div class="card">
            <div class="card-body text-center">
                {!! $success !!}
            </div>
        </div>
    </div>
</div>
@endsection
