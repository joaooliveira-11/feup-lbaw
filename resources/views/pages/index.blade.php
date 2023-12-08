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
    <div id="about-wrapper">
        <div class="about-header">
            <h2 class="lp-section-title">About Us</h2>
            <p>At TeamSync, we're more than just a brand – we're a collective of passionate individuals united by a common vision. Our journey began with a simple idea: to to allow users to. Since then, we've grown, evolved, and forged a path driven by innovation and dedication.</p>
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