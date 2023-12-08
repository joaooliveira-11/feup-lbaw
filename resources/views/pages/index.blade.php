@extends('layouts.app')

@section('content')

<div id="lp-content">
    <div class="lp-header">
        <div class="lp-header-content">
            <h1>Where Collaboration Meets Inovation</h1>
            <h4>Explore, create, and collaborate seamlessly on a diverse range of projects, fostering innovation and collective achievement with ease</h3>
            <a class="lp-button" href="{{ url('/register') }}">Get Started</a>
        </div>
        <img class="lp-header-image" src="{{ asset('img/lp_header_img.png') }}" alt="Programming">
    </div>
    <div id="lp-services">
        <h2 class="lp-section-title">What We Offer</h2>
        <div class="lp-service">
            <div class="service-text">
                <h4>Create Any Project You Imagine</h4>
                <p>Turn your ideas into reality.  Code, create, and collaborate on any project you can imagine</p>
            </div>
            <img class="service-image" src="{{ asset('img/creation.png') }}" alt="Project Creation">
        </div>
        <div class="lp-service">
            <img class="service-image" src="{{ asset('img/showcase.png') }}" alt="Project Showcase">
            <div class="service-text">
                <h4>Showcase Your Talent</h4>
                <p>Elevate your profile by showcasing your noteworthy projects and accomplishments for all to see</p>
            </div>
        </div>
        <div class="lp-service">
            <div class="service-text">
                <h4>Chat and Collaborate with Fellow Members</h4>
                <p>Connect and collaborate effortlessly with other members through many chat channels</p>
            </div>
            <img class="service-image" src="{{ asset('img/communication.png') }}" alt="Communication">
        </div>
    </div>
    <div class="lp-cta">
        <h2 class="lp-section-title">Are you ready to take your work to the <span>next level?</span></h2>
        <div class="cta-buttons">
            <a class="lp-button" href="{{ url('/register') }}">Get Started</a>
            <a class="learn-more-button" href="{{ url('/register') }}">Learn More</a>
        </div>
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

@endsection