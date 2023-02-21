@extends('adminlte::page')

@section('title', 'Campaña')

@section('content_header')
    <h1>Campaña Actual</h1>
@stop

@section('content')
    <section class="card">
        <img src="" alt="logo campaign" class="card-img-top"/>
        <div class="card-body">
            <h6 class="d-flex">Nombre</h6>
            <div class="form-group ">
                <input type="text" name="name" id="name" class="form-control"
                    placeholder="Ingrese el nombre de la campaña" value="{{ $campaign->name }}" disabled="">
            </div>
            <h6 class="d-flex">Partido político</h6>
            <div class="form-group ">
                <input type="text" name="party" id="party" class="form-control"
                    placeholder="Ingrese el nombre del partido político" value="{{ $campaign->party }}" disabled="">
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h6 class="d-flex">Fecha de inicio de
                        la
                        campaña</h6>
                    <div class="form-group">
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            placeholder="Ingrese el nombre" value="{{ $campaign->start_date }}" disabled="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <h6 class="d-flex">Fecha de fin de la
                        campaña</h6>
                    <div class="form-group">
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            placeholder="Ingrese los apellidos" value="{{ $campaign->end_date }}" disabled="">
                    </div>
                </div>
            </div>
            <h6 class="d-flex">Descrpción
                (Opcional)
            </h6>
            <div class="form-group">
                <textarea class="form-control" name="description" id="description" rows="7"
                    placeholder="Ingrese una breve descripcion de su campaña" disabled="">{{ $campaign->description }}</textarea>
            </div>
        </div>
    </section>

@stop

@section('css')

@stop

@section('js')

@stop
