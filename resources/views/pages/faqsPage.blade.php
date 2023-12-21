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
                <p>In Home Page, there is a button saying "Create Project". Click it and insert the details you want in the fields.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How do I create a Task?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>In the project page, in the Dashboard, there is a button saying "Create Task". Click it and insert the details you want in the fields.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                What can I do if I forgot my password?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>In the Login page, there is a button saying "Forgot password?". AFter clicking, you need to insert your email in the field, and you will receive an email to recover it.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How can I invite users to a project?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>In the project page, in the Dashboard, if you are the coordinator, there is a button saying "Add Member". Click in the members that you want to invite.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How do I edit my profile?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>In your profile, there is a button saying "Edit Profile". Click it and edit the fields you wish.</p>
            </div>
        </div>
        <div class="faq-element">
            <button class="faq-toggle">
                How do I kick someone out of a project?
                <i class="fas fa-plus icon"></i>
            </button>
            <div class="faq-content">
                <p>In the project page, in the Member section, if you are the coordinator, next to each member there is an icon with an 'X'. Click in the members that you want to kick.</p>
            </div>
        </div>
    </div>
</div>




@endsection