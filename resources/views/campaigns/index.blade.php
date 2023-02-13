@extends('adminlte::page')

@section('title', 'Campaña')

@section('content_header')
    <h1>Campaña</h1>
@stop

@section('content')
    @if (isset($campaiign))
        <h1>holi</h1>
    @else
        <h1>no holi</h1>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
