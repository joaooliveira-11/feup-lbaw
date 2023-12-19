@extends('layouts.app')

<div class="error-message">
    <div class="title" data-content="404">
        403 - ACCESS DENIED
    </div>

    <div class="subtitle">
        Oops, You don't have permission to access this page.
    </div>

    <div class="buttons">
        <a class="home-button " href="{{ url('/home') }}">Go to homepage</a>
    </div>
</div>