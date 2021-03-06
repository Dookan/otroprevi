@extends('layouts.user-modules')

@section('module')
<div class="card shadow mb-4">
	<div class="card-header py-2">
		<h6 class="m-0 font-weight-bold text-primary d-inline-block py-2">Precios</h6>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Clase de vehículo</th>
						<th>Tipo de plan</th>
						<th>Cobertura</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach($prices as $price)
					@if(!$price->deleted_at)
					<tr>
						<td>{{$price->class->class}}</td>
						<td>{{$price->description}}</td>
						<td>{{number_format($price->total_all, 2)}} <strong>Bs.S</strong></td>
						<td>
							<a href="/user/index-price/{{$price->id}}" class="btn btn-primary">Ver</a>
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