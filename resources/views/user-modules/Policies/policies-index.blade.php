@extends('layouts.user-modules')

@section('module')
<div class="card shadow mb-4">
	<div class="card-header py-2">
		<h6 class="m-0 font-weight-bold text-primary d-inline-block py-2">Pólizas</h6>
		<a class="btn btn-success float-right" href="{{ route('user.register.policy')}}">Registrar Poliza</a>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Num. Afiliación</th>
						<th>Beneficiario</th>
						<th>C.I/RIF</th>
						<th>Dirección</th>
						<th>Vehículo</th>
						<th>Fecha de emisión</th>
						<th>Estatus</th>		      
						<th>Acciones</th>	    
					</tr>
				</thead>
				<tbody>
					@foreach($policies as $policy)
					@if(!$policy->deleted_at)
					<tr>
						<td>{{$policy->id}}</td>
						<td>{{$policy->client_name. ' ' .$policy->client_lastname}}</td>
						<td>{{$policy->client_ci}}</td>
						<td>{{$policy->estado->estado.', '.$policy->municipio->municipio}}</td>
						<td>{{$policy->vehicle_brand. ' ' .$policy->vehicle_model}}</td>
						<td>{{ \Carbon\Carbon::parse($policy->created_at)->format('d-m-Y')}}</td>
						@if(Carbon\Carbon::parse($policy->expiring_date) > $today)
						<td class="text-success">Vigente</td>
						@elseif(Carbon\Carbon::parse($policy->expiring_date) == $today)
						<td class="text-warning">Vence Hoy</td>
						@else
						<td class="text-danger">Vencido</td>
						@endif			      
						<td class="justify-content-center">
							<a href="/user/index-policy/{{$policy->id}}" class="btn bg-transparent action-button pr-3 mt-1" style="width: 5px; color: #f2a413;"><i class="fas fa-eye"></i></a>
							<a href="/user/user-exportpdf/{{$policy->id}}" class="btn bg-transparent action-button pr-3 mt-1" target="blank"><i class="fas fa-file-export" style="width: 5px; color: #5a5c69;"></i></a>
						</td>
					</tr>
					@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>				
@endsection