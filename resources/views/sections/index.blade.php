@extends('adminlte::page')

@section('title', 'Secciones')

@section('content_header')
    <h1>Secciones</h1>
@stop

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-2">
                <label for="state">Estado</label>
                <select name="state_id" id="state_id" class="form-control select">
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-10">
                <div class="text-right ">
                    <button title="Haz clic sobre una casilla para obtener información extra" type="button" class="btn btn-primary btn-tooltip rounded-circle" data-toggle="tooltip" data-placement="bottom"><i class="fa-solid fa-question"></i></button>
                </div>
            </div>
        </div>
        <hr style="border: 0; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));" />
        <div class="table-responsive">
            <table class="table table-stripped table-sm text-center" id="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sección</th>
                        <th>Estado</th>
                        <th>Municipio</th>
                        <th>Distrito Local</th>
                        <th>Distrito Federal</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </section>
    <input type="hidden" value="{{ route('api.sections.getAll') }}" id="apiRoute" />
    <input type="hidden" value="{{ $jwt }}" id="jwt" />
@stop

@section('css')

@stop

@section('js')
    <script src="{{ asset('js/sections/section.index.js') }}" type="text/javascript"></script>
@stop
