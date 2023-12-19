<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ url('css/signin.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css') }}" rel="stylesheet">
        <link href="{{ url('css/project.css') }}" rel="stylesheet">
        <link href="{{ url('css/task.css') }}" rel="stylesheet">
        <link href="{{ url('css/createTask.css') }}" rel="stylesheet">
        <link href="{{ url('css/allProjects.css') }}" rel="stylesheet">
        <link href="{{ url('css/createProject.css') }}" rel="stylesheet">
        <link href="{{ url('css/index.css') }}" rel="stylesheet">
        <link href="{{ url('css/navbar.css') }}" rel="stylesheet">
        <link href="{{ url('css/forgotPassword.css') }}" rel="stylesheet">
        <link href="{{ url('css/dashboard.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
        <script src="https://js.pusher.com/7.0/pusher.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/70585eb28b.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <main>
            <header>
                @if(!Request::is('login') && !Request::is('register'))
                    @if(Auth::check())
                        @if(Request::is('index'))
                            @include('partials.authNavbar')
                            @yield('authNavbar')
                        @else
                            @include('partials.navbar')
                            @yield('navbar')
                        @endif
                    @endif
                @endif
            </header>

            <section id="content">
                @yield('content')
            </section>
        </main>
        @include('sweetalert::alert')
    </body>
</html>

