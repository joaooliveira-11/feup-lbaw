@extends('layouts.app')

@section('content')

<div id="ProjectPage">
    <div id="ProjectInfo">
        <div id="home-page-wrapper">
            <h1 class="home-page-title">Welcome, {{ Auth::user()->name }}</h1>
            <div class="home-middle-section">
                <div class="project-directory">
                    <div class="project-directory-header">
                        <h3 class="home-page-section-title">Project Directory</h3>
                        <button type="button" id="CreateProjectModalButton" class="home-button">Create Project</button>
                        @include('modal.create_proj')
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
                    <h3 class="home-page-section-title">Upcoming Tasks</h3>
                    <div class="project-directory-projects">
                        @php
                            $upcomingTasks = Auth::user()->upcoming_tasks();
                        @endphp

                        @if($upcomingTasks->count() > 0)
                            @foreach ($upcomingTasks as $task)
                                <a href="{{ url('task/' . $task->task_id) }}" class="home-page-a">
                                    <li class="project-directory-item">
                                        <h5 class="project-directory-title">{{ $task->title }}</h5>

                                        @if($task->finish_date)
                                            <h5 class="project-directory-title">{{ $task->finish_date }}</h5>
                                        @else
                                            <p class="project-directory-title">Deadline not Specified</p>
                                        @endif
                                    </li>
                                </a>
                            @endforeach
                        @else
                            <p class="project-directory-title">You have no upcoming tasks</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="home-lower-section">

                <div class="project-progression">
                    <h3 class="home-page-section-title">Project Progression</h3>

                    <div class="project-directory-projects">
                        @foreach (Auth::user()->projects() as $project)
                            <a href="{{ url('project/' . $project->project_id) }}" class="project-progression-a">
                                <li class="project-progression-item">
                                    <h5 class="project-progression-title">{{ $project->title }}</h5>
                                    @if ($project->is_coordinator(Auth::user()))
                                        <h5 class="project-progression-element">Coordinator</h5>
                                    @else
                                        <h5 class="project-progression-element">Member</h5>
                                    @endif
                                    @php
                                        $tasksArchivedCount = $project->tasksArchived->count();
                                        $totalTasksCount = $project->tasks->count();
                                        $percentage = ($totalTasksCount > 0) ? round(($tasksArchivedCount / $totalTasksCount) * 100) : 0;
                                    @endphp
                                    <div class="project-directory-progress">
                                        <div class="progress-bar-div">
                                            <div class="progress-bar" role="progressbar" style="width:{{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p>
                                            {{ $tasksArchivedCount }} tasks done out of {{ $totalTasksCount }}
                                            ({{ $percentage }}%)
                                        </p>

                                    </div>
                                </li>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="home-page-tasks">
                    <h3 class="home-page-section-title">Tasks</h3>
                    <div class="project-directory-projects">
                        @foreach (Auth::user()->projects() as $project)
                            @foreach ($project->tasks as $task)
                                @if($task->assigned_to() == Auth::user()->id)
                                    <a href="{{ url('task/' . $task->task_id )}}" class="home-page-a">
                                        <li class="project-directory-item">
                                            <h5 class="project-directory-title">{{ $task->title }}</h5>
                                        </li>
                                    </a>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection