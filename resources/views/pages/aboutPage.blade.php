@extends('layouts.app')

@section('content')

    <div id="about-wrapper" class="container">
        <div class="row about-header">
            <h2 class="lp-section-title">About Us</h2>
        </div>
        <div id="lp-services" class="container">
            <div class="container lp-service">
                <div class="col-7 service-text">
                    <h4>Our Values</h4>
                    <p>At TeamSync, we're more than just a brand – we're a collective of passionate individuals united by a common vision. Our journey began with a simple idea: to to allow users to. Since then, we've grown, evolved, and forged a path driven by innovation and dedication.</p>
                </div>
                <img class="service-image" src="{{ asset('img/values.png') }}" alt="Our Values">
            </div>
            <div class="container lp-service">
                <img class="service-image" src="{{ asset('img/sustain.png') }}" alt="Sustainability and Responsibility">
                <div class="col-7 service-text">
                    <h4>Sustainability and Responsibility</h4>
                    <p>We are committed to minimizing our environmental impact and giving back to the communities we serve. Through sustainable practices and social responsibility initiatives, we aim to improve the efficieny of web programming.</p>
                </div>
            </div>
            <div class="container lp-service">
                <div class="col-7 service-text">
                    <h4>Customer-Centric Approach</h4>
                    <p>At TeamSync, our customers are at the heart of everything we do. We listen, adapt, and constantly strive to exceed expectations. Your satisfaction is our priority, and we're dedicated to building lasting relationships with each and every one of you.</p>
                </div>
                <img class="service-image" src="{{ asset('img/CCA.png') }}" alt="Customer-Centric Approach">
            </div>
        </div>
    </div>
    <div id="footer-wrapper">
            <div class="footer-row">
                <div class="col-4 footer-left">
                    <a class="footer-teamsync-button" href="{{ url('/register') }}">TeamSync</a>
                    <h6>Where collaboration meets inovation</h6>
                </div>
                <div class="col-3 footer-middle">
                    <h5>Pages</h5>
                    <ul>
                        <li>Home</li>
                        <li>About</li>
                        <li>FAQs</li>
                    </ul>
                </div>
                <div class="col-4 footer-right">
                    <h5>Contact</h5>
                    <p>+351 912 345 678</p>
                    <p>contact@teamsync.com</p>
                    <p>Rua Olivia Rodrigo 123</p>
                </div>
            </div>
        </div>
@endsection