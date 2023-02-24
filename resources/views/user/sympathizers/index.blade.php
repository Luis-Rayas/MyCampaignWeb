@extends('adminlte::page')

@section('title', 'Simpatizantes')

@section('content_header')
    <h1>Simpatizantes</h1>
@stop

@section('content')
    @if (session('result'))
        <div class="alert alert-{{ session('result')->status }}">
            {{ session('result')->message }}
        </div>
    @endif
    <div class="text-right">
        <a class="btn btn-success" href="{{ route('user.create') }}"><i class="fa fa-plus"></i> Añadir Nuevo Usuario</a>
    </div>
    <section class="table-responsive">
        <table class="table table-stripped table-sm text-center">
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
                @foreach ($sympathizers as $sympathizer)
                    <tr>
                        <td>{{ $sympathizer->id }}</td>
                        <td>{{ $sympathizer->name }}</td>
                        <td>{{ $sympathizer->email }}</td>
                        <td>{{ $sympathizer->created_at }}</td>
                        <td>
                            <form action="{{ route('sympathizer.delete', $sympathizer->id) }}" action="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
