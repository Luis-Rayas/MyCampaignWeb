@extends('adminlte::page')

@section('title', 'Voluntario')

@section('content_header')
    <h1>Voluntario</h1>
@stop

@section('content')
    <section class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title font-weight-bold">{{ $volunteer->id}}&nbsp;</h3><h4 class="card-title">{{ $volunteer->name .  ' ' . $volunteer->fathers_lastname . ' ' . $volunteer->mothers_lastname}}</h4>
                <p class="card-text">
                    <div class="form-control">
                    </div>
                </p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
        </div>
    </section>
@stop

@section('css')
@stop

@section('js')
@stop
