@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Inicio</h1>
@stop

@section('content')
    @if (isset($campaign))
        <h3 class="font-weight-bold text-center">Campaña actual: <span class="description fs-5">{{ $campaign->name }} - {{ $campaign->party }}</span></h3>
        <div class="row">
            <div class="col-lg-4 col-12">
                <!-- small card -->
                <div class="small-box bg-gray">
                    <div class="inner">
                        <h3>{{ $campaign->volunteers_count }} registrados</h3>
                        <p>Voluntario(s)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('volunteers.index') }}" class="small-box-footer">
                        Ver detalles... <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $campaign->users[1]->num }} registrados</h3>

                        <p>Simpatizante(s)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="{{ route('sympathizer.index') }}" class="small-box-footer">
                        Ver detalles... <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $campaign->users[0]->num }} registrados</h3>

                        <p>Administrador(es)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <a href="{{ route('admin.index') }}" class="small-box-footer">
                        Ver detalles... <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.row -->
        @else
        <div class="card text-center">
            <div class="alert alert-warning">
                <h2>Ups... Parece que no hay ninguna campaña activa</h2>
            </div>
            <div class="h-50">
                <img src="{{ asset('storage/img/alert-icon.png') }}" style="width: 50%;"/>
            </div>
            <h2>Crea una para comenzar a registrar a tus defensores de casilla</h2>
            <a href="{{ route('campaign.create') }}" class="btn btn-success btn-lg btn-block">Crear campaña</a>
        </div>
        @endif
    @stop

    @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
    @stop

    @section('js')
        <script>
            console.log('Hi!');
        </script>
    @stop
