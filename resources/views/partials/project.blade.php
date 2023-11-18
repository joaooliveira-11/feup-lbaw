<article class="project" data-id="{{ $project->id }}">
    <header>
        <h2><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h2>
        <a href="#" class="delete">&#10761;</a>
    </header>
    <ul>
        @each('partials.task', $project->tasks()->orderBy('id')->get(), 'task')
    </ul>
    <form class="new_task">
        <input type="text" name="description" placeholder="new task">
    </form>
</article>
