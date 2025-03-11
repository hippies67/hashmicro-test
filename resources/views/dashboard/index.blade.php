@extends('layouts.index')

@section('title')
    Dashboard
@endsection

@section('css')
    <link href="{{ asset('style/vendor/owl-carousel/owl.carousel.css" rel="stylesheet') }}">
    <link href="{{ asset('style/css/style.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-xxl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4>Hi <b>{{ Auth::user()->name }}</b>, Selamat datang di halaman dashboard.</h4>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('style/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('style/js/custom.min.js') }}"></script>
    <script src="{{ asset('style/js/deznav-init.js') }}"></script>
    <script src="{{ asset('style/vendor/owl-carousel/owl.carousel.js') }}"></script>

    <!-- Chart piety plugin files -->
    <script src="{{ asset('style/vendor/peity/jquery.peity.min.js') }}"></script>
@endsection
