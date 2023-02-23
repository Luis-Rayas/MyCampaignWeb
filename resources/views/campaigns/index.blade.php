@extends('adminlte::page')

@section('title', 'Campañas')

@section('content_header')
    <h1>Campañas</h1>
@stop

@section('content')
    <section class="container-fluid">

        @if (session('result'))
            <div class="alert alert-{{ session('result')->status }}">
                {{ session('result')->message }}
            </div>
        @endif


        <div class="table-responsive">
            <table class="table table-sm table-stripped  text-center">
                <thead class="table-dark">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Partido</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de termino</th>
                    <th>Descripción</th>
                    <th>Opciones</th>
                </thead>
                <tbody>
                    @foreach ($campaigns as $campaign)
                        <tr>
                            <th>{{ $campaign->id }}</th>
                            <td>{{ $campaign->name }}</td>
                            <td>{{ $campaign->party }}</td>
                            <td>{{ $campaign->start_date }}</td>
                            <td>{{ $campaign->end_date }}</td>
                            <td>{{ $campaign->description }}</td>
                            <td>
                                <a class="btn btn-success" href="{{ route('campaign.show', $campaign->id) }}"><i class="fa fa-eye"></i> Ver</a>
                                @if(!isset($campaign->end_date))
                                    <a class="btn btn-secondary" href="{{ route('campaign.edit', $campaign->id) }}"><i class="fa fa-pen"></i> Editar</a>
                                @endif
                            </td>
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

@stop
