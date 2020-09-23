@extends('layouts.admin-modules')

@section('module')
<div class="card">
  <div class="card-header">
    <ul class="nav nav-pills card-header-pills">
      <li class="nav-item">
        <a class="nav-link ml-2 bg-warning text-dark active" href="/admin/edit-price/{{$price->id}}">Editar Precio</a>
      </li>
      <li class="nav-item">
        <form action="/admin/delete-price/{{$price->id}}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="nav-link ml-2 btn btn-danger">Eliminar</button>  
        </form>
      </li>
    </ul>
  </div>

  <div class="card-body">
    <h3 class="card-title text-center">Descripción del plan</h3>
    <h5 class="card-title text-center">Clase de vehículo: <strong>{{$price->class->class}}</strong></h5>
    <div class="row border-bottom border-dark mb-4">
      <div class="col-6 text-center border-right border-dark">
        <h6><span class="font-weight-bold mr-2">Daños a cosas: </span><span class="prices_se">{{number_format($price->damage_things, 2)}}</span> Bs.S</h6>     
        <h6><span class="font-weight-bold mr-2">Daños a personas: </span><span class="prices_se">{{number_format($price->damage_people, 2)}}</span> Bs.S</h6>     
        <h6><span class="font-weight-bold mr-2">Asistencia jurídica: </span><span class="prices_se">{{number_format($price->legal_assistance, 2)}}</span> Bs.S</h6>     
        <h6><span class="font-weight-bold mr-2">Muerte: </span><span class="prices_se">{{number_format($price->death, 2)}}</span> Bs.S</h6>     
        <h6><span class="font-weight-bold mr-2">Invalidez: </span><span class="prices_se">{{number_format($price->disability, 2)}}</span> Bs.S</h6>     
        <h6><span class="font-weight-bold mr-2">Gastos médicos: </span><span class="prices_se">{{number_format($price->medical_expenses, 2)}}</span> Bs.S</h6>  
        @if($price->crane == 0)
        <h6><span class="font-weight-bold mr-2">Grua: </span>No aplica</h6>
        @else
        <h6><span class="font-weight-bold mr-2">Grua: </span><span class="prices_se">{{number_format($price->crane, 2)}}</span> Bs.S</h6>
        @endif       
        <h6 class="mt-4"><span class="font-weight-bold mr-2">Total Cobertura: </span><span class="prices_se">{{number_format($price->total_all, 2)}}</span> Bs.S</h6>
      </div>
      <div class="col-6 text-center">
        <h6><span class="font-weight-bold mr-2">Prima: </span><span class="prices_se">{{number_format($price->premium1, 2)}}</span> Bs.S</h6>     
        <h6><span class="font-weight-bold mr-2">Prima: </span><span class="prices_se">{{number_format($price->premium2, 2)}}</span> Bs.S</h6>     
        <h6><span class="font-weight-bold mr-2">Prima: </span><span class="prices_se">{{number_format($price->premium3, 2)}}</span> Bs.S</h6>     
        <h6><span class="font-weight-bold mr-2">Prima: </span><span class="prices_se">{{number_format($price->premium4, 2)}}</span> Bs.S</h6>     
        <h6><span class="font-weight-bold mr-2">Prima: </span><span class="prices_se">{{number_format($price->premium5, 2)}}</span> Bs.S</h6>     
        <h6><span class="font-weight-bold mr-2">Prima: </span><span class="prices_se">{{number_format($price->premium6, 2)}}</span> Bs.S</h6>
        <h6 class="mt-5"><span class="font-weight-bold mr-2">Total Prima: </span><span class="prices_se">{{number_format($price->total_premium, 2)}}</span> Bs.S</h6>     
      </div>
    </div>



    <a href="{{url()->previous()}}" class="btn btn-danger active">Volver</a>
  </div>
</div>  

@endsection