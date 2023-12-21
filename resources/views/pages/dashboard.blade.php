@extends('layouts.app')

@section('content')

<div class="dashboardPage">
    <div class="row">
        <div class="col-md-8 mx-auto mt-6">
            <h4 class="mb-3">Search Users:</h4>
            <div class="search-bar-container">
                <form id="userSearchForm" class="input-group mb-3">
                    <input type="text" id="userSearchInput" class="form-control" placeholder="Search for users...">
                </form>
            </div>

            <table class="table table-hover table-bordered custom-table">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @foreach($users as $user)
                        <tr onclick="window.location='{{ url('/profile/' . $user->id) }}';" style="cursor:pointer;">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 mx-auto">
            <div class="add-user-container">
                <h4 class="mb-3">Add New User:</h4>
                <form class="form-group" method="POST" action="{{ route('admin.dashboard') }}">
                    {{ csrf_field() }}
                    
                    <div class="form-content mb-3">
                        <input type="text" class="form-box" name="name" required placeholder="Name">
                    </div>

                    <div class="form-content mb-3">
                        <input type="text" class="form-box" name="username" required placeholder="Username">
                    </div>

                    <div class="form-content mb-3">
                        <input type="email" class="form-box" name="email" required placeholder="Email">
                    </div>

                    <div class="form-content mb-3">
                        <input type="password" class="form-box" name="password" required placeholder="Password">
                    </div>

                    <div class="form-content mb-3">
                        <input type="password" class="form-box" name="password_confirmation" required placeholder="Confirm Password">
                    </div>

                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
