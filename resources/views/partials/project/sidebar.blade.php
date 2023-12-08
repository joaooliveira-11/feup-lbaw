<div id="Sidebar">
    <h1 class="sidebar-project-title">{{ $project->title }}</h1> 
    <form id="projectForm">
        <label for="dashboard" class = "selected">
            <input type="radio" id="dashboard" name="project" value="Dashboard" checked>
            Dashboard
        </label>
        <label for="chat">
            <input type="radio" id="chat" name="project" value="Chat">
            Chat
        </label>
        <label for="tasks">
            <input type="radio" id="tasks" name="project" value="Tasks">
            Tasks
        </label>
        <label for="members">
            <input type="radio" id="members" name="project" value="Members">
            Members
        </label>
    </form>
    <form id="leaveProjectForm">
        @csrf
        <button type="submit">Leave Project</button>
    </form>
    @if($project->is_member(auth()->user()))
        <button id="leaveProject">Leave Project</button>
    @endif
</div>
