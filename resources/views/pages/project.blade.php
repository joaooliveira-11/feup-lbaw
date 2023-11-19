@extends('layouts.app')

@section('title', $project->name)

@section('content')

<link href="{{ asset('css/project.css') }}" rel="stylesheet">

<main class="container">
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Board View - {{ $project->title }}</h3>
                </div>
                <div class="card-body">
                    <p>{{ $project->description }}</p>
                </div>
                <div class="card-body">
                  {{-- Add your task display logic here --}}
                  @if($project->tasks->count() > 0)
                      <h4>Tasks:</h4>
                      <ul>
                          @foreach($project->tasks as $task)
                              <li>{{ $task->name }} - {{ $task->description }}</li>
                          @endforeach
                      </ul>
                  @else
                      <p>No tasks found for this project.</p>
                  @endif
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
