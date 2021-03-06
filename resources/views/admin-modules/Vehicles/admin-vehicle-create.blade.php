@extends('layouts.admin-modules')

@section('module')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Registro de vehiculo</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.vehicle.submit') }}" id="vehicle_form">
                        @csrf

                        <div class="form-group row">
                            <label for="brand" class="col-md-4 col-form-label text-md-right">Marca</label>

                            <div class="col-md-6">
                                <input id="brand" type="text" class="form-control @error('brand') is-invalid @enderror is-invalid" name="brand" autocomplete="brand" autofocus>

                                @error('brand')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="model" class="col-md-4 col-form-label text-md-right">Modelo</label>

                            <div class="col-md-6">
                                <input id="model" type="model" class="form-control @error('model') is-invalid @enderror is-invalid" name="model" autocomplete="model">

                                @error('model')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vehicleType" class="col-md-4 col-form-label text-md-right">Tipo de vehiculo</label>

                            <div class="col-md-6">
                                <select id="vehicleType" name="vehicleType" class="form-control @error('vehicleType') @enderror custom-select is-invalid" required>
                                    <option value="">- Seleccionar -</option>
                                    @foreach($vehicle_types as $type)
                                    <option value="{{$type->id}}">{{$type->type}}</option>
                                    @endforeach
                                </select>
                                
                                @error('vehicleType')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4"></label>
                            <div class="col-md-6">
                                <a class="text-success" href="#" data-toggle="modal" data-target="#typeModal">Registar tipo de vehículo</a>
                           </div>
                       </div>


                       <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Registrar
                            </button>

                            <a href="{{ route('index.vehicles') }}" class="btn btn-danger" style="width: 90px;">
                                Volver
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@include('partials.register-type-modal')
@endsection

@section('scripts')
<script src="{{asset('js/Form-Validations/Vehicles.js')}}"></script>    
@endsection