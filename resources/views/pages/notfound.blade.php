@extends('layouts.app')
<div class="error-message">
    <div class="title" data-content="404">
        404 - PAGE NOT FOUND
    </div>

    <div class="subtitle">
        Oops, the page you are looking for does not exist.
    </div>

    <div class="buttons">
        <a class="home-button " href="{{ url('/home') }}">Go to homepage</a>
    </div>
</div>