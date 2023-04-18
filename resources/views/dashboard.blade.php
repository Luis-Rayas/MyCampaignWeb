@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Inicio</h1>
@stop

@section('content')
    @if (isset($campaign))
        <h3 class="font-weight-bold text-center">Campaña actual: <span class="description fs-5">{{ $campaign->name }} -
                {{ $campaign->party }}</span></h3>
        <div class="row">
            <div class="col-md-4">
                <x-adminlte-small-box title="{{ $campaign->volunteers_count }}" text="Voluntarios registrados"
                    icon="fas fa-users text-white" theme="purple" url="{{ route('volunteers.index') }}"
                    url-text="Ver detalles..." />
            </div>
            <div class="col-md-4">
                <x-adminlte-small-box title="{{ $campaign->administrators_count }}" text="Administradores registrados"
                    icon="fas fa-user-shield text-white" theme="dark" url="{{ route('admin.index') }}"
                    url-text="Ver detalles..." />
            </div>
            <div class="col-md-4">
                <x-adminlte-small-box title="{{ $campaign->sympathizers_count }}" text="Simpatizanters registrados"
                    icon="fas fa-user-plus text-white" theme="teal" url="{{ route('sympathizer.index') }}"
                    url-text="Ver detalles..." />
            </div>
        </div>
    @else
        <x-adminlte-card theme="warning" title="Ups... Parece que no hay ninguna campaña activa"
            icon="fas fa-lg fa-exclamation-circle">
            <div class="text-center">
                <img src="{{ asset('storage/img/alert-icon.png') }}" style="width: 35%;" class="p-3" />
                <h2>Crea una para comenzar a registrar a tus defensores de casilla</h2>
                <a href="{{ route('campaign.create') }}" class="btn btn-success btn-lg btn-block">Crear campaña</a>
            </div>
        </x-adminlte-card>
    @endif
@stop

@section('footer')
    <section class="text-center">
        My Campaign ©
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
