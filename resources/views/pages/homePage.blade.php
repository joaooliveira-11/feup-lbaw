@extends('layouts.app')

@section('content')

<div id="ProjectPage">
    <div id="ProjectInfo">
        <div id="home-page-wrapper">
            <h1 class="home-page-title">Welcome, {{ Auth::user()->name }}</h1> <!-- Assuming you are using Laravel's authentication -->
            <div class="home-middle-section">
                <div class="project-directory">
                    <div class="project-directory-header">
                        <h3 class="home-page-section-title">Project Directory</h3>
                        <form class="home-form" action="">
                            <button class="home-button">Create Project</button>
                        </form>
                    </div>
                    <div class="project-directory-projects">
                        @foreach (Auth::user()->projects() as $project)
                            <a href="{{ url('project/' . $project->project_id) }}" class="home-page-a">
                                <li class="project-directory-item">
                                    <h5 class="project-directory-title">{{ $project->title }}</h5>
                                    <p class="project-directory-members"> Members: {{ $project->members()->count() }} </p>
                                </li>

                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="upcoming-tasks">


                </div>
            </div>

            <div class="home-lower-section">
                <div class="project-progression">

                </div>
                <div class="home-page-tasks">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
