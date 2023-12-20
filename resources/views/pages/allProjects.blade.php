@extends('layouts.app')

@section('content')
<div id="ProjectPage">

    <div id="projects-container">
        <input class="row" type="text" id="projectSearch" placeholder="Search projects..." oninput="searchProjects({{ $projects->currentPage() }})">

        @if ($projects->isEmpty())
            <p>No projects yet!</p>
        @else
            <ul class="projects-list">
            @foreach ($projects as $project)
                <a href="{{ url('project/' . $project->project_id) }}" class="container project-link">
                    <li class="project-item">
                        <div class="container project-content {{ $project->project_id }}">
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
                        <div class="project-details">
                            <p class="project-description">{{ $project->description }}</p>
                        </div>
                    </li>
                </a>
            @endforeach
            </ul>

            <div class="pagination-container">
                @if ($projects->currentPage() != 1)
                    <button class="btn " onclick = "searchProjects( {{ $projects->currentPage() - 1}})">Previous</button>
                @endif

                <span>Page {{ $projects->currentPage() }} of {{ $projects->lastPage() }}</span>

                @if ($projects->hasMorePages())
                    <button class="btn" onclick = "searchProjects( {{ $projects->currentPage() + 1}})">Next</button>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
