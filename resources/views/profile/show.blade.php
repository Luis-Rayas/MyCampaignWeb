@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <h1>Perfil</h1>
@stop

@section('content')
    <section class="card">
        <img src="{{ $image }}" class="img-thumbnail rounded mx-auto d-block" alt="..."
            style="height: 10rem; width: 10rem;" />
        <div class="card-body">
            <hr
                style="border: 0; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));" />
            <p class="card-text">
            <h5>Información General</h5>
            <div class="row">
                <div class="col-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nombre</span>
                        </div>
                        <span type="text" class="form-control">{{ $user->name }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Email</span>
                        </div>
                        <span type="text" class="form-control">{{ $user->email }}</span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Usuario creado en</span>
                </div>
                <span type="text" class="form-control">{{ $user->created_at }}</span>
            </div>
            <hr
                style="border: 0; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));" />
            <h5>Cambiar contraseña</h5>
            <x-user-password-update></x-user-password-update>
    </section>
@stop

@section('css')
@stop

@section('js')
    <script src="{{ asset('js/profile/show.js') }}" type="text/javascript"></script>
@stop
