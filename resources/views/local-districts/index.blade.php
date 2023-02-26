@extends('adminlte::page')

@section('title', 'Distritos Locales')

@section('content_header')
    <h1>Distritos Locales</h1>
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
                    @foreach ($localDistricts as $localDistrict)
                        <tr>
                            <th>{{ $localDistrict->id }}</th>
                            <td>{{ $localDistrict->name }}</td>
                            <td>{{ $localDistrict->number }}</td>
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
    <script src="{{ asset('js/local-districts/local.index.js') }}" type="text/javascript"></script>
@stop
