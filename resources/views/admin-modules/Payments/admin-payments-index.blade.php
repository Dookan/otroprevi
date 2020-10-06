@extends('layouts.admin-modules')
<?php use \App\Http\Controllers\PaymentsController; ?>

@section('module')
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Consultas de Pago</h6>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0" style="font-size: 12px;">
				<thead>
					<tr>
						<th>Vendedor</th>
						<th>Oficina</th>
						<th>Último pago</th>
						<th>Pólizas por pagar</th>
						<th>Total</th>
						<th>%</th>
						<th>Total a pagar</th>
						<th>Efectuar Pago</th>

					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>{{$user->name.' '.$user->lastname}}</td>
						<td>{{$user->office->office_address}}</td>
						@if(count($user->payments()->get()) > 0 )
						<?php $last_payment = $user->payments()->latest()->pluck('until')?>
						<td class="text-warning">{{\Carbon\Carbon::parse($last_payment->first())->format('d-m-Y')}}</td>
						@else
						<td>No se ha efectuado el primer pago</td>
						@endif

						<td>{{PaymentsController::policies_not_paid($user->id)}}</td>

						<td>{{number_format(PaymentsController::policies_not_paid_price($user->id), 2)}} Bs.S</td>

						<td class="text-warning">{{$user->profit_percentage.'%'}}</td>

						<?php $total_all = PaymentsController::policies_not_paid_price($user->id)?>
						<td class="text-success"><span class="prices_se">{{PaymentsController::profit_percentage($total_all, $user->profit_percentage)}}</span> Bs.S</td>
						@if($total_all == 0)
						<td class="text-success text-center">
							No hay pagos pendientes <br>
							<a href="/admin/index-payment/{{$user->id}}" class="btn bg-transparent action-button pr-3 mt-1" style="width: 5px; color: #f2a413;"><i class="fas fa-eye"></i></a>
						</td>
						@else				  
						<td>
							<span class="btn bg-transparent action-button pr-3 mt-1" id="openModal" data-toggle="modal" data-target="{{'#'."openForm-".$user->id}}" style="width: 5px; color: #41d19d;"><i class="fas fa-dollar-sign"></i></span>
							<a href="/admin/index-payment/{{$user->id}}" class="btn bg-transparent action-button pr-3 mt-1" style="width: 5px; color: #f2a413;"><i class="fas fa-eye"></i></a>
						</td>
						@endif
					</tr>
					<div class="modal fade" id="{{"openForm-".$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Seguro que desea efectuar esta operacion?</h5>
									<button class="close" type="button" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>
								<div class="modal-body">Seleccione "continuar" para efectuar la operacion, seleccione "cancelar" para cancelar la operacion</div>
								<div class="modal-footer">
									<form action="/admin/register-payment/{{$user->id}}" method="POST"
										class="d-inline-block">
										@csrf
										<input type="hidden" value="{{$user->name.' '.$user->lastname}}" name="name">
										<input type="hidden" value="{{$user->office->office_address}}" name="office">
										<input type="hidden" value="{{$user->id}}" name="user_id">					
										<input type="hidden" value="{{PaymentsController::policies_not_paid_price($user->id)}}" name="total">
										<input type="hidden" value="{{$user->profit_percentage}}" name="profit_percentage">
										<input type="hidden" value="{{PaymentsController::profit_percentage($total_all, $user->profit_percentage)}}" name="total_payment">

										<button class="btn btn-secondary" type="button" data-dismiss="modal">cancelar</button>
										<button type="submit" class="btn btn-primary">continuar</button>
									</form>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>	


@endsection

@section('scripts')
<script>
$(document).ready(function() {
	$("tbody").find('tr').each(function() {
		let objects = $(this).find('span.prices_se');
		console.log(objects);
		for(object of objects){
			console.log(object.innerText);
			object.innerText = number_format(object.innerText);
		}
	})
});

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
  prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
  sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
  dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
  s = '',
  toFixedFix = function(n, prec) {
  	var k = Math.pow(10, prec);
  	return '' + Math.round(n * k) / k;
  };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
  	s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
  	s[1] = s[1] || '';
  	s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}
</script>
@endsection