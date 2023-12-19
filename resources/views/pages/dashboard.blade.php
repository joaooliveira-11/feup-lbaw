@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <a href="{{ url('/project/create') }}" class="btn btn-primary float-right mb-3">Criar Projeto</a>
    </div>
    <div class="col-md-8 mx-auto">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <!-- Outros campos que deseja exibir -->
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <!-- Outros campos do usuário -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
