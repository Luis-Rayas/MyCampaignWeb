@extends('adminlte::page')

@section('title', 'Distritos Federales')

@section('content_header')
    <h1>Distritos Federales</h1>
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
                    @foreach ($federalDistricts as $federalDistrict)
                        <tr>
                            <th>{{ $federalDistrict->id }}</th>
                            <td>{{ $federalDistrict->name }}</td>
                            <td>{{ $federalDistrict->number }}</td>
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
    <script src="{{ asset('js/federal-districts/federal.index.js') }}" type="text/javascript"></script>
@stop
