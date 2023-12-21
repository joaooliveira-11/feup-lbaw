@extends('layouts.app')

@section('content')
<div id="ProjectPage">
    <div id="projects-container">
        <input class="row" type="text" id="projectSearch" placeholder="Search projects..." oninput="searchProjects({{ $projects->currentPage() }})">

        @if ($projects->isEmpty())
            <p>No results.</p>
        @else
            <ul class="projects-list">
                @foreach ($projects as $project)
                    <a href="{{ url('project/' . $project->project_id) }}" class="container project-link">
                        <li class="project-item">
                            <div class="container project-content {{ $project->project_id }}">
                                <h2 class="project-title">{{ $project->title }}</h2>
                                <p class="project-deadline project-info">
                                    {{ $project->finish_date ?? 'Not defined' }}
                                </p>
                                <p class="project-coordinator project-info">{{ $project->coordinator->name }}</p>
                            </div>
                            <div class="project-details">
                                <p class="project-description">{{ $project->description }}</p>
                            </div>
                        </li>
                    </a>
                @endforeach
            </ul>

            @if($projects->count() > 0)
                <div class="pagination-container">
                    @if ($projects->currentPage() != 1)
                        <button class="btn " onclick="searchProjects( {{ $projects->currentPage() - 1 }})">Previous</button>
                    @endif

                    <span>Page {{ $projects->currentPage() }} of {{ $projects->lastPage() }}</span>

                    @if ($projects->hasMorePages())
                        <button class="btn" onclick="searchProjects( {{ $projects->currentPage() + 1 }})">Next</button>
                    @endif
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
