@extends('layouts.app')

@section('content')
<div id="projects-container">
    <p class="projects-label">Projects:</p>
    @if ($projects->isEmpty())
        <p>No projects yet!</p>
    @else
        <ul class="projects-list">
            @foreach ($projects as $project)
                <a href="{{ url('project/' . $project->project_id) }}" class="project-link">
                    <li class="project-item">
                        <div>
                            <h2 class="project-title">{{ $project->title }}</h2>
                            <p class="project-description">{{ $project->description }}</p>
                        </div>
                    </li>
                </a>
            @endforeach
        </ul>
    @endif
</div>
@endsection