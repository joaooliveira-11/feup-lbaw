@extends('layouts.app')

@section('content')
<div id="ProjectPage">
<div id="projects-container">
    <input type="text" id="projectSearch" placeholder="Search projects..." oninput="searchProjects({{ $projects->currentPage() }})">

    @if ($projects->isEmpty())
        <p>No projects yet!</p>
    @else
        <ul class="projects-list">
        @foreach ($projects as $project)
            <a href="{{ url('project/' . $project->project_id) }}" class="project-link">
                <li class="project-item">
                    <div class="project-content {{ $project->project_id }}">
                        <h2 class="project-title">{{ $project->title }}</h2>
                        <p class="project-deadline project-info">
                            @if ($project->finish_date)
                                {{ $project->finish_date }}
                            @else
                                Not defined
                            @endif
                        </p>
                        <p class="project-coordinator project-info"> {{ $project->coordinator->name }}</p>
                    </div>
                </li>
            </a>
        @endforeach
        </ul>

        <div class="pagination-container">
            @if ($projects->currentPage() != 1)
                <a href="{{ $projects->previousPageUrl() }}" class="btn">Previous</a>
            @endif

            <span>Page {{ $projects->currentPage() }} of {{ $projects->lastPage() }}</span>

            @if ($projects->hasMorePages())
                <a href="{{ $projects->nextPageUrl() }}" class="btn">Next</a>
            @endif
        </div>
    @endif
</div>
</div>
@endsection
