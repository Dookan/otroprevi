@extends('layouts.admin-modules')

@section('module')
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary d-inline-block py-2">Registro de poliza</h6>
		<a href="{{route('index.policies')}}" class="float-right btn btn-danger text-white">X</a> 

	</div>
	<div class="card-body">

		<form action="{{ route('register.policy.submit')}}" method="POST" id="form_policies">
			@csrf

			{{-- DATOS DEL CLIENTE --}}
			<h3>Datos del cliente</h3>

			{{-- CONTRATANTE --}}
			<h5>Contratante</h5>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="client_name_contractor">Nombre</label>
					<input autocomplete="off" type="text" name="client_name_contractor" id="client_name_contractor" class="form-control @error('client_name_contractor') is-invalid @enderror is-invalid" placeholder="..." value="{{ old('client_name_contractor') }}">

					@error('client_name_contractor')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>

				<div class="form-group col-md-4">
					<label for="client_lastname_contractor">Apellido</label>
					<input autocomplete="off" type="text" name="client_lastname_contractor" id="client_lastname_contractor" class="form-control @error('client_lastname_contractor') is-invalid @enderror is-invalid" placeholder="..." value="{{ old('client_lastname_contractor') }}">

					@error('client_lastname_contractor')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
	
				<div class="form-group col-md-4">
					<label for="ci_contractor">Documento de identificación</label>
					<div class="input-group">
						<div class="input-group-prepend">				
							<select name="id_type_contractor" class="form-control @error('id_type_contractor')is-invalid @enderror custom-select is-invalid" id="id_type_contractor" required>
								<option value="">-</option>
								<option value="V-">V</option>
								<option value="E-">E</option>
								<option value="I-">I</option>
								<option value="J-">J</option>
								<option value="G-">G</option>				
							</select>					
						</div>

						@error('id_type_contractor')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror

						<input autocomplete="off" type="text" class="form-control @error('client_ci_contractor') is-invalid @enderror is-invalid" name="client_ci_contractor" id="ci_contractor" placeholder="..." value="{{ old('client_ci_contractor') }}">

						@error('client_ci_contractor')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>
			</div>
			{{-- FIN DATOS DEL CONTRATANTE --}}

			{{-- BENEFICIARIO --}}
			<h5>Beneficiario</h5>
			<div class="form-row border-bottom border-dark">
			{{-- Nombre y apellido --}}
				<div class="form-group col-md-6">
					<label for="client_name">Nombre</label>
					<input autocomplete="off" type="text" name="client_name" id="client_name" class="form-control @error('client_name') is-invalid @enderror is-invalid" placeholder="..." value="{{ old('client_name') }}">

					@error('client_name')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>

				<div class="form-group col-md-6">
					<label for="client_lastname">Apellido</label>
					<input autocomplete="off" type="text" name="client_lastname" id="client_lastname" class="form-control @error('client_lastname') is-invalid @enderror is-invalid" placeholder="..." value="{{ old('client_lastname') }}">

					@error('client_lastname')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				{{-- FIN NOMBRE Y APELLIDO --}}

				{{-- Datos de contacto e identificacion --}}
				<div class="form-group col-md-4">
					<label for="ci">Documento de identificación</label>
					<div class="input-group">
						<div class="input-group-prepend">				
							<select name="id_type" class="form-control @error('id_type')
							is-invalid @enderror custom-select is-invalid" id="id_type">
								<option value="" selected> - </option>
								<option value="V-" {{old('id_type') == 'V-' ? 'selected' : ''}}>V</option>
								<option value="E-" {{old('id_type') == 'E-' ? 'selected' : ''}}>E</option>
								<option value="I-" {{old('id_type') == 'I-' ? 'selected' : ''}}>I</option>
								<option value="J-" {{old('id_type') == 'J-' ? 'selected' : ''}}>J</option>
								<option value="G-" {{old('id_type') == 'G-' ? 'selected' : ''}}>G</option>				
							</select>									
						</div>
						
						@error('id_type')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror

						<input autocomplete="off" type="text" class="form-control @error('client_ci') is-invalid @enderror is-invalid" name="client_ci" id="ci" placeholder="..." value="{{ old('client_ci') }}">

						@error('client_ci')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>

				<div class="form-group col-md-4">                            
					<label for="client_phone" class="text-md-right">Número de teléfono</label>
					<div class="input-group">
						<div class="input-group-prepend">               
							<select name="sp_prefix" class="form-control @error('sp_prefix') is-invalid @enderror custom-select is-invalid" id="number_code">
								<option value="">-</option>
								<option value="212-" {{old('sp_prefix') == '212-' ? 'selected' : ''}}>212</option>
								<option value="412-" {{old('sp_prefix') == '412-' ? 'selected' : ''}}>412</option>
								<option value="416-" {{old('sp_prefix') == '416-' ? 'selected' : ''}}>416</option>
								<option value="426-" {{old('sp_prefix') == '426-' ? 'selected' : ''}}>426</option>
								<option value="414-" {{old('sp_prefix') == '414-' ? 'selected' : ''}}>414</option>               
								<option value="424-" {{old('sp_prefix') == '424-' ? 'selected' : ''}}>424</option>               
							</select>                                   
						</div>

						@error('sp_prefix')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror

						<input type="text" name="client_phone" id="client_phone" value="{{old('client_phone')}}"class="form-control @error('client_phone') is-invalid @enderror is-invalid" placeholder="...">

						@error('client_phone')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>

				<div class="form-group col-md-4">
					<label for="client_email">Correo Electronico</label>
					<input autocomplete="off" type="email" class="form-control @error('client_email') is-invalid @enderror is-invalid" name="client_email" id="client_email" placeholder="..." value="{{ old('client_email') }}">

					@error('client_email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				{{-- FIN DATOS DE CONTACTO E IDENTIFICACION --}}

				{{-- Direccion del cliente --}}
				<div class="form-group col-md-4">
					<label for="estado">Estado</label>
					<select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror is-invalid custom-select">
						<option value="">- Seleccionar Estado -</option>
						@foreach($estados as $estado)
						<option value="{{$estado->id_estado}}">{{$estado->estado}}</option>
						@endforeach
					</select>

					@error('estado')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>

				<div class="form-group col-md-4">
					<label for="municipio">Municipio</label>
					<select name="municipio" id="municipio" class="form-control @error('municipio') is-invalid @enderror is-invalid custom-select">
						<option value="">- Seleccionar Municipio -</option>
					</select>

					@error('municipio')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>

				<div class="form-group col-md-4">
					<label for="parroquia">Parroquia</label>
					<select name="parroquia" id="parroquia" class="form-control @error('parroquia') is-invalid @enderror is-invalid custom-select">
						<option value="">- Seleccionar Parroquia -</option>
					</select>

					@error('parroquia')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>

				<div class="form-group col-md-12">
					<label for="client_address">Dirección</label>
					<textarea name="client_address" id="client_address" class="form-control @error('client_address') is-invalid @enderror">No especificado</textarea>

					@error('client_address')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				{{-- FIN DIRECCION DEL BENEFICIARIO --}}
			</div>
			{{-- FIN DATOS DEL BENEFICIARIO --}}
			{{-- FIN DATOS DEL CLIENTE --}}

			<h3 class="mt-4">Datos del vehiculo</h3>

			<div class="form-row border-bottom border-dark">
				<div class="form-group col-md-6">
					<label for="brand">Marca</label>
					<select name="vehicleBrand" class="form-control @error('vehicleBrand') is-invalid @enderror is-invalid custom-select" id="brand" >
						<option value=""> - Seleccionar Marca -</option>
						@foreach($vehicles as $vehicle)
						<option value="{{$vehicle->brand}}" {{old('vehicleBrand') == $vehicle->brand ? 'selected' : ''}}>{{$vehicle->brand}}</option>
						@endforeach
					</select>

					@error('vehicleBrand')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
					
					<label for="model">Modelo</label>
					<select name="vehicleModel" class="form-control @error('vehicleModel') is-invalid @enderror is-invalid custom-select" id="model" >
						<option value=""> - Seleccionar Modelo - </option>
					</select>

					@error('vehicleModel')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror

					<label for="vehicle_year">Año</label>
					<input autocomplete="off" type="number" name="vehicle_year" id="vehicle_year" class="form-control @error('vehicle_year') is-invalid @enderror is-invalid" placeholder="..." value="{{ old('vehicle_year') }}">

					@error('vehicle_year')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror

					<label for="vehicle_color">Color</label>
					<input autocomplete="off" type="text" name="vehicle_color" id="vehicle_color" class="form-control @error('vehicle_color') is-invalid @enderror is-invalid" placeholder="..." value="{{ old('vehicle_color') }}">

					@error('vehicle_color')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror


					<label for="used_for">Uso del vehiculo</label>
					<select id="used_for" name="used_for" class="form-control @error('used_for') is-invalid @enderror is-invalid custom-select">
						<option value="">- Seleccionar -</option>				
						<option value="Particular">Particular</option>				
						<option value="Carga">Carga</option>				
						<option value="Grua">Grua</option>				
						<option value="Transporte Publico">Transporte Publico</option>
						<option value="Competencia">Competencia</option>				
					</select>

					@error('used_for')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror


				</div>

				<div class="form-group col-md-6">

					<label for="vehicle_bodywork_serial">Serial de carroceria</label>
					<input autocomplete="off" type="text" name="vehicle_bodywork_serial" id="vehicle_bodywork_serial" class="form-control @error('vehicle_bodywork_serial') is-invalid @enderror is-invalid" style="text-transform:uppercase;" placeholder="..." value="{{ old('vehicle_bodywork_serial') }}">

					@error('vehicle_bodywork_serial')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror

					<label for="vehicle_motor_serial">Serial del motor</label>
					<input autocomplete="off" type="text" name="vehicle_motor_serial" id="vehicle_motor_serial" class="form-control @error('vehicle_motor_serial') is-invalid @enderror is-invalid" style="text-transform:uppercase;" placeholder="..." value="{{ old('vehicle_motor_serial') }}">

					@error('vehicle_motor_serial')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror

					<label for="vehicle_certificate_number">Numero de certificado</label>
					<input autocomplete="off" type="text" name="vehicle_certificate_number" id="vehicle_certificate_number" class="form-control @error('vehicle_certificate_number') is-invalid @enderror is-invalid" style="text-transform:uppercase;" placeholder="..." value="{{ old('vehicle_certificate_number') }}">

					@error('vehicle_certificate_number')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror

					<label for="vehicle_weight">Peso del vehiculo</label>
					<div class="input-group">
						<input autocomplete="off" type="number" name="vehicle_weight" id="vehicle_weight" class="form-control @error('vehicle_weight') is-invalid @enderror is-invalid" placeholder="Kg" value="{{ old('vehicle_weight') }}">
						<div class="input-group-append">
							<span class="input-group-text">Kg</span>
						</div>
					</div>

					@error('vehicle_weight')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror

					<label for="vehicle_registration">Matricula</label>
					<input autocomplete="off" type="text" name="vehicle_registration" id="vehicle_registration" class="form-control @error('vehicle_registration') is-invalid @enderror is-invalid" style="text-transform:uppercase;" placeholder="..." value="{{ old('vehicle_registration') }}">

					@error('vehicle_registration')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror

				</div>

			</div>

			<h3 class="mt-4">Poliza</h3>

			<div class="form-group">
				<label for="vehicle_class">Clase de vehículo</label>
				<select name="vehicle_class" id="vehicle_class" class="form-control @error('vehicle_class') is-invalid @enderror is-invalid custom-select">
					<option value="">- Seleccionar clase de vehículo -</option>
					@foreach($vehicle_classes as $class)
					<option value="{{$class->id}}">{{$class->class}}</option>
					@endforeach
				</select>

				@error('vehicle_class')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror

				<label for="price">Seleccionar poliza</label>
				<select name="price" class="form-control @error('price') is-invalid @enderror is-invalid custom-select" id="price" >
					<option value=""> - Seleccionar - </option>
				</select>
				
				@error('price')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>

			<div class="row mb-4" id="quick_view">
				{{-- price view ajax request --}}
			</div>

			<button id="submitButton" type="submit" class="btn btn-primary btn-block mt-3">Registrar Poliza</button>
		</form>
	</div>
</div>

@endsection

@section('scripts')
	<script src="{{asset('js/Form-Validations/Policies.js')}}"></script>
@endsection