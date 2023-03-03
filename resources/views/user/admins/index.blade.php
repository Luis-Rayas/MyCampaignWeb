@extends('adminlte::page')

@section('title', 'Administradores')

@section('content_header')
    <h1>Administradores</h1>
@stop

@section('content')
    <section class="container">
        @if (session('result'))
            <div class="alert alert-{{ session('result')->status }}">
                {{ session('result')->message }}
            </div>
        @endif
        <div class="text-right">
            <a class="btn btn-success" href="{{ route('user.create') }}"><i class="fa fa-plus"></i> Añadir Nuevo Usuario</a>
        </div>
        <hr style="border: 0; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));" />
        <div class="table-responsive">
            <table class="table table-stripped table-sm text-center" id="table">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha de Alta</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->created_at }}</td>
                            <td>
                                <form action="{{ route('admin.delete', $admin->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Estás seguro?')">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="{{ asset('js/admins/admins.index.js') }}"></script>
@stop
