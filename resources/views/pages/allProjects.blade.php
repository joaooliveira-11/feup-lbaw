@extends('layouts.app')

@section('content')
<div id="projects-container">
    <div class="search-bar">
        <input type="text" id="projectSearch" placeholder="Search projects..." oninput="searchProjects()">
        <button onclick="searchProjects()" class="rounded-button">Search</button>
    </div>

    @if ($projects->isEmpty())
        <p>No projects yet!</p>
    @else
        <ul class="projects-list">
        @foreach ($projects as $project)
            <a href="{{ url('project/' . $project->project_id) }}" class="projects-link">
                <li class="project-item">
                    <div class="project-content">
                        <h2 class="projects-title">{{ $project->title }}</h2>
                        <p class="project-info"><strong>Coordinator:</strong> {{ $project->coordinator->name }}</p>
                        <p class="project-info">
                            <strong>Deadline:</strong>
                            @if ($project->finish_date)
                                {{ $project->finish_date }}
                            @else
                                Not defined
                            @endif
                        </p>
                    </div>
                </li>
            </a>
        @endforeach
        </ul>
    @endif
</div>
@endsection