@extends('layouts.app')

@section('content')

    <div id="lp-content">
        <h2 class="lp-section-title">What We Offer</h2>
        <div class="container lp-service">
            <div class="col-7 service-text">
                <h4>Create Any Project You Imagine</h4>
                <p>Turn your ideas into reality.  Code, create, and collaborate on any project you can imagine</p>
            </div>
            <div class="service-img-container">
                <img class="service-image" src="{{ asset('img/creation.png') }}" alt="Project Creation">
            </div>
        </div>
        <div class="container lp-service">
            <div class="service-img-container">
                <img class="service-image" src="{{ asset('img/showcase.png') }}" alt="Project Showcase">
            </div>
            <div class="col-7 service-text">
                <h4>Showcase Your Talent</h4>
                <p>Elevate your profile by showcasing your noteworthy projects and accomplishments for all to see</p>
            </div>
        </div>
        <div class="container lp-service">
            <div class="col-7 service-text">
                <h4>Chat and Collaborate with Fellow Members</h4>
                <p>Connect and collaborate effortlessly with other members through many chat channels</p>
            </div>
            <div class="service-img-container">
                <img class="service-image" src="{{ asset('img/communication.png') }}" alt="Communication">
            </div>
        </div>
    </div>

    <div id="lp-content" class="about-about-us">
            <div class="row about-header">
                <h2 class="lp-section-title">About Us</h2>
            </div>
            <div id="about-container" class="container">
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
            <div class="footer-left">
                <a class="footer-teamsync-button" href="{{ url('/register') }}">TeamSync</a>
                <h6>Where collaboration meets inovation</h6>
            </div>
            <div class="footer-middle">
                <h5>Pages</h5>
                <ul>
                    <li> <a href="{{ url('/index') }}">Home</a></li>
                    <li> <a href="{{ url('/about') }}">About</a></li>
                    <li> <a href="{{ url('/faqs') }}">FAQs</a></li>
                </ul>
            </div>

            <div class="footer-right">
                <h5>Contact</h5>
                <p>+351 912 345 678</p>
                <p>contact@teamsync.com</p>
                <a class="footer-directions" href="https://www.google.com/maps/place/FEUP+-+Faculdade+de+Engenharia+da+Universidade+do+Porto/@41.1783583,-8.5958454,17z/data=!3m1!4b1!4m6!3m5!1s0xd246446d48922a3:0x8b1e4a0bcdacc840!8m2!3d41.1783583!4d-8.5958454!16s%2Fg%2F1tj92tyc?entry=ttu" target="_blank">
                    <p>R. Dr. Roberto Frias, Porto</p>
                </a>
            </div>
        </div>
    </div>
@endsection