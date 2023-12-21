@extends('layouts.app')

@section('content')

<div id="faqs-content">
    <h1 class="faqs-title">Frequently Asked Questions</h1>
    <div class="faq-elements-wrapper">
        <div class="faq-element">
            <button class="faq-toggle">
                How do I create a Project?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta aliquam facere adipisci quod mollitia, aut nemo deleniti fugiat et, corrupti sequi. Omnis dolorem quos eligendi placeat soluta sint corrupti quod.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How do I create a Task?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores error doloremque, quibusdam qui necessitatibus autem aperiam reprehenderit? Ipsum maiores dolore inventore ea. Accusantium fuga eius laboriosam iusto blanditiis doloremque ullam?</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                What can I do if I forgot my password?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae consectetur officiis labore commodi sunt ex praesentium dolor magnam asperiores reiciendis. Minus magnam nesciunt aliquid eos ipsam sequi recusandae quos incidunt.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How can I invite users to a project?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae consectetur officiis labore commodi sunt ex praesentium dolor magnam asperiores reiciendis. Minus magnam nesciunt aliquid eos ipsam sequi recusandae quos incidunt.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How do I edit my profile?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae consectetur officiis labore commodi sunt ex praesentium dolor magnam asperiores reiciendis. Minus magnam nesciunt aliquid eos ipsam sequi recusandae quos incidunt.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How do I kick someone out of a project?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae consectetur officiis labore commodi sunt ex praesentium dolor magnam asperiores reiciendis. Minus magnam nesciunt aliquid eos ipsam sequi recusandae quos incidunt.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How do I kick someone out of a project?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae consectetur officiis labore commodi sunt ex praesentium dolor magnam asperiores reiciendis. Minus magnam nesciunt aliquid eos ipsam sequi recusandae quos incidunt.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How do I kick someone out of a project?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae consectetur officiis labore commodi sunt ex praesentium dolor magnam asperiores reiciendis. Minus magnam nesciunt aliquid eos ipsam sequi recusandae quos incidunt.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How do I kick someone out of a project?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae consectetur officiis labore commodi sunt ex praesentium dolor magnam asperiores reiciendis. Minus magnam nesciunt aliquid eos ipsam sequi recusandae quos incidunt.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How do I kick someone out of a project?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae consectetur officiis labore commodi sunt ex praesentium dolor magnam asperiores reiciendis. Minus magnam nesciunt aliquid eos ipsam sequi recusandae quos incidunt.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How do I kick someone out of a project?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae consectetur officiis labore commodi sunt ex praesentium dolor magnam asperiores reiciendis. Minus magnam nesciunt aliquid eos ipsam sequi recusandae quos incidunt.</p>
            </div>
        </div>
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