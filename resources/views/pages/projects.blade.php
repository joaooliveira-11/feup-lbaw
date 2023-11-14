@extends('layouts.app')

@section('title', 'Project')

@section('content')

<section id="projects">
    @each('partials.project', $projects, 'project')
    <article class="project">
        <form class="new_project">
            <input type="text" name="name" placeholder="new project">
        </form>
    </article>
</section>

@endsection