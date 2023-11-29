@section('projectPage')
@include('partials.projectDashboard')
@include('partials.projectMembers')
@include('partials.projectChat')
@include('partials.tasksInProject')



<div id="MainContent">
    @yield('projectDashboard')
    @yield('projectMembers')
    @yield('projectChat')
    @yield('tasksInProject')
    
</div>

@endsection