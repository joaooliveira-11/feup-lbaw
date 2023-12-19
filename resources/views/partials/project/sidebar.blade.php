<div id="Sidebar" class="container">
    <h1 class="row sidebar-project-title">{{ $project->title }}</h1> 
    <form id="projectForm" class="row">
        <label for="dashboard" class="selected dashboard-element">
            <input type="radio" id="dashboard" name="project" value="Dashboard" checked>
            Dashboard
        </label>
        <label for="chat" class="dashboard-element">
            <input type="radio" id="chat" name="project" value="Chat">
            Chat
        </label>
        <label for="tasks" class="dashboard-element">
            <input type="radio" id="tasks" name="project" value="Tasks">
            Tasks
        </label>
        <label for="members" class="dashboard-element">
            <input type="radio" id="members" name="project" value="Members">
            Members
        </label>
    </form>
    @if($project->is_member(auth()->user()))
        <button class="row" id="leaveProject" @if(Auth::user()->id == $project->project_coordinator) class =  "coordinator" @endif >Leave Project</button>
    @endif
</div>

