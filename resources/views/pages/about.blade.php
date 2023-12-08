@extends('layouts.app')

@section('content')


    <div id="about-wrapper">
        <div class="about-header">
            <h1>ABOUT US</h1>
            <p>At TeamSync, we're more than just a brand – we're a collective of passionate individuals united by a common vision. Our journey began with a simple idea: to to allow users to. Since then, we've grown, evolved, and forged a path driven by innovation and dedication.</p>
            <a class="auth-register-button" href="{{ url('/register') }}">Get Started</a>
        </div>
        <div id="lp-services">
            <div class="lp-service">
                <div class="service-text">
                    <h4>Our Values</h4>
                    <p>Integrity, innovation, and inclusivity – these are the pillars that uphold TeamSync. We believe in making progression every day and incorporate ethics and discipline into every aspect of our work. It's not just about what we create; it's about how we create it. Our values shape our culture and influence the positive experiences we aim to provide.</p>
                </div>
                <img class="service-image" src="{{ asset('img/creation.png') }}" alt="Project Creation">
            </div>
            <div class="lp-service">
                <img class="service-image" src="{{ asset('img/showcase.png') }}" alt="Project Showcase">
                <div class="service-text">
                    <h4>Sustainability and Responsibility</h4>
                    <p>We are committed to minimizing our environmental impact and giving back to the communities we serve. Through sustainable practices and social responsibility initiatives, we aim to improve the efficieny of web programming.</p>
                </div>
            </div>
            <div class="lp-service">
                <div class="service-text">
                    <h4>Customer-Centric Approach</h4>
                    <p>At TeamSync, our customers are at the heart of everything we do. We listen, adapt, and constantly strive to exceed expectations. Your satisfaction is our priority, and we're dedicated to building lasting relationships with each and every one of you.</p>
                </div>
                <img class="service-image" src="{{ asset('img/communication.png') }}" alt="Communication">
            </div>
        </div>
        <div id="footer">
            <div class="footer-left">
                <a class="footer-teamsync-button" href="{{ url('/register') }}">TeamSync</a>
                <h6>Where collaboration meets inovation</h6>
            </div>
            <div class="footer-middle">
                <h5>Pages</h5>
                <ul>
                    <li>Home</li>
                    <li>About</li>
                    <li>FAQs</li>
                </ul>
            </div>
            <div class="footer-right">
                <h5>Contact</h5>
                <p>+351 912 345 678</p>
                <p>contact@teamsync.com</p>
                <p>Rua Olivia Rodrigo 123</p>
            </div>
        </div>
    </div>
@endsection