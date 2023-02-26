@extends('adminlte::page')

@section('title', 'Estados')

@section('content_header')
    <h1>Estados</h1>
@stop

@section('content')
    <section class="container">
        <div class="table-responsive">
            <table class="table table-stripped table-sm text-center" id="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($states as $state)
                        <tr>
                            <th>{{ $state->id }}</th>
                            <td>{{ $state->name }}</td>
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
    <script src="{{ asset('js/states/state.index.js') }}" type="text/javascript"></script>
@stop
