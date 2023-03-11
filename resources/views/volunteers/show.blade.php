@extends('adminlte::page')

@section('title', 'Voluntario')

@section('content_header')
    <div class="card">
        <h1 class="card-title text-center">{{ $volunteer->id }} &nbsp;
            {{ $volunteer->name . ' ' . $volunteer->fathers_lastname . ' ' . $volunteer->mothers_lastname }}</h1>
    </div>
@stop

@section('content')
    <section class="container">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Datos del voluntario</h1>
                <p class="card-text">
                <div class="row">
                    <div class="col-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">ID</span>
                            </div>
                            <span type="text" class="form-control" id="idVolunteer">{{ $volunteer->id }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombre(s)</span>
                            </div>
                            <span type="text" class="form-control">{{ $volunteer->name }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Apellido Paterno</span>
                            </div>
                            <span type="text" class="form-control">{{ $volunteer->fathers_lastname }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Apellido Materno</span>
                            </div>
                            <span type="text" class="form-control">{{ $volunteer->mothers_lastname }}</span>
                        </div>
                    </div>
                </div>
                <hr
                    style="border: 0; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));" />
                <h5>Dirección</h5>
                <div class="row">
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Calle</span>
                            </div>
                            <span type="text" class="form-control">{{ $volunteer->address->street }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Núm. Externo</span>
                            </div>
                            <span type="text" class="form-control">{{ $volunteer->address->external_number }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Núm. Interno</span>
                            </div>
                            <span type="text" class="form-control">{{ $volunteer->address->internal_number }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Colonia</span>
                            </div>
                            <span type="text" class="form-control">{{ $volunteer->address->suburb }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">C.P.</span>
                            </div>
                            <span type="text" class="form-control">{{ $volunteer->address->zipcode }}</span>
                        </div>
                    </div>
                </div>
                <hr
                    style="border: 0; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));" />
                <h5>Datos de Ubicación</h5>
                <div class="row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Estado</span>
                            </div>
                            <span type="text" class="form-control">
                                <strong>{{ $volunteer->section->state->id }}</strong>
                                {{ $volunteer->section->state->name }}
                            </span>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Municipio</span>
                            </div>
                            <span type="text" class="form-control">
                                <strong>{{ $volunteer->section->municipality->number }}</strong>
                                {{ $volunteer->section->municipality->name }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Distrito Federal</span>
                            </div>
                            <span type="text" class="form-control">
                                <strong>{{ $volunteer->section->federalDistrict->number }}</strong>
                                {{ $volunteer->section->federalDistrict->name }}
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Distrito Local</span>
                            </div>
                            <span type="text" class="form-control">
                                <strong>{{ $volunteer->section->localDistrict->number }}</strong>
                                {{ $volunteer->section->localDistrict->name }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Sección</span>
                            </div>
                            <span type="text" class="form-control">
                                {{ $volunteer->section->section }}
                            </span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Sector</span>
                            </div>
                            <span type="text" class="form-control">
                                {{ $volunteer->auxVolunteer->sector }}
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tipo de Voluntario</span>
                            </div>
                            <span type="text" class="form-control">
                                <strong>{{ $volunteer->auxVolunteer->typeVolunteer->id }}</strong>
                                {{ $volunteer->auxVolunteer->typeVolunteer->name }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-check">
                        <input type="checkbox" {{ $volunteer->section->new == null ? 'checked' : '' }} />
                        <label class="form-check-label">Sección Verificada por INE</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{ $volunteer->auxVolunteer->local_voting_booth ? 'checked' : '' }} />
                        <label class="form-check-label">Va a votar localmente</label>
                    </div>
                </div>
                <hr
                    style="border: 0; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));" />
                <h5>Otros Datos</h5>
                <div class="row">
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Clave de elector</span>
                            </div>
                            <span type="text" class="form-control">{{ $volunteer->auxVolunteer->elector_key }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Fecha de nacimiento</span>
                            </div>
                            <span type="text" class="form-control">{{ $volunteer->auxVolunteer->birthdate }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label>Notas</label>
                    <textarea readonly class="form-control">{{ $volunteer->auxVolunteer->notes }}</textarea>
                </div>
                <hr
                    style="border: 0; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));" />
                <h5>Campaña Asociada</h5>
                <div class="row">
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombre de campaña</span>
                            </div>
                            <span type="text" class="form-control">{{ $volunteer->campaign->name }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Partido Asociado</span>
                            </div>
                            <span type="text" class="form-control">{{ $volunteer->campaign->party }}</span>
                        </div>
                    </div>
                </div>
                <hr
                    style="border: 0; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));" />
                <h5>Imagenes Asociadas</h5>
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-success btn-lg btn-block">INE</button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-success btn-lg btn-block">Firma</button>
                    </div>
                </div>
                </p>
            </div>
        </div>
        <input type="hidden" id="apiRoute" value="{{ route('api.volunteers.getImage') }}"/>
        <input type="hidden" id="jwt" value="{{ $jwt }}"/>
    </section>

    {{-- Modal Image --}}
    <x-adminlte-modal id="modalCustom" title="Account Policy" size="lg" theme="teal" icon="fas fa-bell"
        v-centered static-backdrop scrollable>
        <div style="height:800px;">Read the account policies...</div>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Accept" />
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('css')
@stop

@section('js')
    <script src="{{ asset('js/volunteers/volunteers.show.js') }}"></script>
@stop
