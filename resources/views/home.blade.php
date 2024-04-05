@extends('layouts.app_template')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h1>Selamat Datang Di Aplikasi {{ env('APP_NAME') }}</h1>
                <p class="small">
                    Aplikasi pendataan perizinan
                </p>
            </div>
        </div>
    </div>
</div>
@endsection