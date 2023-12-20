@extends('layouts.app')

@section('content')

<div class="dashboardPage">
    <div class="row">
        <div class="col-md-8 mx-auto mt-6">
            <h4 class="mb-3">Search Users:</h4>
            <div class="input-group mb-3">
                <form id="userSearchForm">
                    <input type="text" id="userSearchInput" class="form-control" placeholder="Search for users...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="userSearchButton">Search</button>
                    </div>
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
</div>

@endsection
