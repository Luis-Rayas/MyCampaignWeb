@extends('adminlte::page')

@section('title', 'Campaña')

@section('content_header')
    <h1>Nuevo Usuario</h1>
@stop

@section('content')
    <section class="card">
        @if ($errors->any())
            <div class="alert alert-danger p-0">
                <ul class="list-group list-group-flush bg-transparent">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item bg-transparent">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre del usuario*</label>
                    <input type="text" class="@error('nombre') is-invalid @enderror form-control" id="nombre" required value="{{ old('nombre') }}" name="nombre" />
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" class="form-control" id="email" required value="{{ old('email') }}" name="email" />
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="password" class="form-label">Contraseña provisional*</label>
                            <input type="password" class="@error('password') is-invalid @enderror form-control" id="password" required
                                value="{{ old('password') }}" name="password" />
                        </div>
                        {{-- <div class="col-6">
                            <label for="fin_campania" class="@error('fin_campania') is-invalid @enderror inicio_campania">Fin de Campaña*</label>
                            <input type="date" class="form-control" id="fin_campania" required value="{{ old('fin_campania') }}"
                                name="fin_campania" />
                        </div> --}}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="tipo_usuario" class="form-label @error('tipo_usuario') is-invalid @enderror">Tipo de usuario*</label>
                    <select name="tipo_usuario" id="tipo_usuario" class="form-control">
                        @foreach ($typesUser as $typeUser)
                            <option value="{{$typeUser->id}}">{{ $typeUser->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary form-control">Guardar</button>
            </div>
        </form>
    </section>

@stop

@section('css')
@stop

@section('js')
@stop
