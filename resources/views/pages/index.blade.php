@extends('layouts.app')

@section('content')

<div id="lp-content">
    <div class="lp-header">
        <div class="lp-header-content">
            <h1>Where Collaboration Meets Inovation</h1>
            <h4>Explore, create, and collaborate seamlessly on a diverse range of projects, fostering innovation and collective achievement with ease</h3>
            <a class="auth-register-button" href="{{ url('/register') }}">Get Started</a>
        </div>
        <img class="lp-header-image" src="{{ asset('img/lp_header_img.png') }}" alt="Programming">
    </div>


</div>

@endsection