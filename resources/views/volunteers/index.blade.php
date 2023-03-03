@extends('adminlte::page')

@section('title', 'Voluntarios')

@section('content_header')
    <h1>Voluntarios</h1>
@stop

@section('content')
    <section class="container">
        <div class="table-responsive">
            <table class="table table-stripped table-sm text-center" id="table">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Tipo Voluntario</th>
                        <th>Notas</th>
                        <th>Más Detalles</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </section>
    <input type="hidden" id="apiRoute" value="{{ route('api.volunteers.getAllVolunteers') }}"/>
    <input type="hidden" id="jwt" value="{{ $jwt }}"/>
@stop

@section('css')
@stop

@section('js')
    <script src="{{ asset('js/volunteers/volunteers.index.js') }}"></script>
@stop
