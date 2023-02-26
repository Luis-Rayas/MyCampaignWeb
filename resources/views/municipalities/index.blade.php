@extends('adminlte::page')

@section('title', 'Municipios')

@section('content_header')
    <h1>Municipios</h1>
@stop

@section('content')
    <section class="container">
        <div class="table-responsive">
            <table class="table table-stripped table-sm text-center" id="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Número</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($municipalities as $municipality)
                        <tr>
                            <th>{{ $municipality->id }}</th>
                            <td>{{ $municipality->name }}</td>
                            <td>{{ $municipality->number }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@stop

@section('css')
@stop

@section('js')
    <script src="{{ asset('js/municipality/municipality.index.js') }}" type="text/javascript"></script>
@stop
