<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PDF - Poliza</title>
</head>

<style>
  *{
    font-family: arial, "sans-serif";
    font-size: 11px;
  }

  table, th, td{
    padding: 5px;
    border-bottom: 1px solid black;
    border-collapse: collapse;
  }

  .vp-table .right-bd{
    border-right: 1px solid black;
  }

  .vp-table .rid-bb{
    border-bottom: none;
  }

  .dp-table .rid-bb{
    border-bottom: none;
  }

  .sign-table .rid-bb{
    border-bottom: none;
  }

  .vp-table .end-vp{
    border-bottom: 1px solid black;
  }

</style>

<body>

  <table style="width:100%">
    <caption><h1 style="font-size: 18px;">DATOS DE AFILIACIÓN:</h1></caption>
    <tr style="text-align:center;">
      <td style="width: 33%;"><strong>Número de afilición: </strong>{{$policy->id}}</td>
      <td style="width: 33%;"><strong>Emision: </strong>{{\Carbon\Carbon::parse($policy->created_at)->format('d-m-Y')}}</td>
      <td style="width: 33%;"><strong>Vigencia: </strong>{{\Carbon\Carbon::parse($policy->created_at)->format('d-m-Y')}}</td>
      <td style="width: 33%;"><strong>Vencimiento: </strong>{{\Carbon\Carbon::parse($policy->expiring_date)->format('d-m-Y')}}</td>
    </tr>
  </table> 

  <table style="width:100%; border-bottom: none; text-align: center;" class="dp-table">
    <caption><h1 style="font-size: 18px;">DATOS PERSONALES:</h1></caption>
    <tr>
      <td class="rid-bb" style="width: 50%;"><strong>Contratante: </strong>{{$policy->client_name_contractor. " " .$policy->client_lastname_contractor}}</td>
      <td class="rid-bb" style="width: 50%;"><strong>Rif/Cédula: </strong>{{$policy->client_ci_contractor}}</td>
    </tr>
  </table>

  <table style="width:100%;" class="dp-table">
    <tr>
      <td><strong>Beneficiario: </strong>{{$policy->client_name. " " .$policy->client_lastname}}</td>
      <td><strong>Rif/Cédula: </strong>{{$policy->client_ci}}</td>
      <td><strong>Dirección: </strong>{{$policy->estado->estado.' '.$policy->municipio->municipio}}</td>
      <td><strong>Teléfono: </strong>{{$policy->client_phone}}</td>
      <td><strong>Email: </strong>{{$policy->client_email}}</td>
    </tr>
  </table>

  <table style="width:100%;" class="vp-table">
    <caption><h1 style="font-size: 18px;">DATOS DEL VEHÍCULO:</h1></caption>
    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Marca: </strong>{{$policy->vehicle_brand}}</td>
      <td class="rid-bb"><strong>Número de certificado: </strong>{{$policy->vehicle_certificate_number}}</td>
    </tr>
    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Modelo: </strong>{{$policy->vehicle_model}}</td>
      <td class="rid-bb"><strong>Placa: </strong>{{$policy->vehicle_registration}}</td>
    </tr>   
    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Tipo: </strong>{{$policy->vehicle_type}}</td>
      <td class="rid-bb"><strong>Serial motor:  </strong>{{$policy->vehicle_motor_serial}}</td>
    </tr>
    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Año: </strong>{{$policy->vehicle_year}}</td>
      <td class="rid-bb" style="width: 50%"><strong>Serial de carroceria: </strong>{{$policy->vehicle_bodywork_serial}}</td>
    </tr>
    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Color: </strong>{{$policy->vehicle_color}}</td>
      <td class="rid-bb"><strong>Uso: </strong>{{$policy->used_for}}</td>
    </tr>
    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Peso: </strong>{{$policy->vehicle_weight}}</td>
      <td class="rid-bb"><strong>Clase de vehículo: </strong>{{$policy->class->class}}</td>
    </tr>
  </table>

  <table style="width:100%;" class="vp-table">
    <caption><h1 style="font-size: 18px;">DESCRIPCION DE POLIZA</h1></caption>
    <caption><h5>{{$policy->price->description}}</h5></caption>
    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Daños a cosas: </strong>{{number_format($policy->damage_things, 2)}} bs.S</td>
      <td class="rid-bb"><strong>Prima: </strong>{{number_format($policy->premium1, 2)}}</td>
    </tr>
    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Daños a personas: </strong>{{number_format($policy->damage_people, 2)}} bs.S</td>
      <td class="rid-bb"><strong>Prima: </strong>{{number_format($policy->premium2, 2)}}</td>
    </tr>   
    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Asistencia jurídica: </strong>{{number_format($policy->legal_assistance, 2)}} bs.S</td>
      <td class="rid-bb"><strong>Prima: </strong>{{number_format($policy->premium3, 2)}}</td>
    </tr>
    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Muerte: </strong>{{number_format($policy->death, 2)}} bs.S</td>
      <td class="rid-bb" style="width: 50%"><strong>Prima: </strong>{{number_format($policy->premium4, 2)}}</td>
    </tr>
    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Invalidez: </strong>{{number_format($policy->disability, 2)}} bs.S</td>
      <td class="rid-bb"><strong>Prima: </strong>{{number_format($policy->premium5, 2)}}</td>
    </tr>
    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Gastos médicos: </strong>{{number_format($policy->medical_expenses, 2)}} bs.S</td>
      <td class="rid-bb"><strong>Prima: </strong>{{number_format($policy->premium6, 2)}}</td>
    </tr>
    <tr style="text-align:center;">
      @if($policy->crane == 0)
      <td class="right-bd rid-bb"><strong>Grua: </strong>No aplica</td>
      @else
      <td class="right-bd rid-bb"><strong>Grua: </strong>{{number_format($policy->crane, 2)}}</td>
      @endif
      <td class="rid-bb"></td>
    </tr>

    <tr style="text-align:center;">
      <td class="right-bd rid-bb">&nbsp;</td>
      <td class="rid-bb"></td>
    </tr>

    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Total Cobertura: </strong>{{number_format($policy->total_all, 2)}}</td>
      <td class="rid-bb"><strong>Total Prima: </strong>{{number_format($policy->total_premium, 2)}}</td>
    </tr>
  </table>
  <table style="width:100%;">
    <caption><h1 style="font-size: 18px;">DATOS DEL VENDEDOR:</h1></caption>
    <tr style="text-align:center;">
      @if(isset($policy->user_id))
      <<td></td> style="width: 33%;"><strong>Asesor: </strong>{{$policy->user->name . " " . $policy->user->lastname}}</td>
      @else
      <td style="width: 33%;"><strong>Asesor: </strong>Administrador</td>
      @endif
      @if(isset($policy->user_id))
      <td style="width: 33%;"><strong>Rif/Cedula: </strong>{{$policy->user->ci}}</td>
      @else
      <td style="width: 33%;"><strong>Rif/Cedula: </strong>Administrador</td>
      @endif
      @if(isset($policy->user_id))
      <td style="width: 33%;"><strong>Teléfono: </strong>{{$policy->user->phone_number}}</td>
      @else
      <td style="width: 33%;"><strong>Teléfono: </strong>Administrador</td>
      @endif
      @if(isset($policy->user_id))
      <td style="width: 33%"><strong>Dirección: </strong>{{$policy->user->office->estado->estado.', '.$policy->user->office->municipio->municipio}}</td>
      @else
      <td style="width: 33%;"><strong>Dirección: </strong>Administrador</td>
      @endif
    </tr>   
  </table>

  <table style="width:100%; margin-top: 60px; text-align: center; border-bottom: none;" class="sign-table">
    <tr>
      <td style="width: 50%">&nbsp;</td>
      <td class="rid-bb" style="width: 50%">&nbsp;</td>
      <td style="width: 50%">&nbsp;</td>
    </tr>
    <tr>
      <td class="rid-bb">FIRMA PREVISEGUROS</td>
      <td class="rid-bb">&nbsp;</td>
      <td class="rid-bb" >FIRMA {{$policy->client_name_contractor.' '.$policy->client_lastname_contractor}}</td>
    </tr>
  </table>

  <table style="width:100%; margin-top: 20px;" class="vp-table">
    <tr style="text-align:center;">
      <th class="right-bd rid-bb"><strong>Contratante </strong></th>
      <th class="rid-bb"><strong>Beneficiario </strong></th>
    </tr>

    <tr style="text-align:center;">
      <td class="right-bd rid-bb">{{$policy->client_name_contractor.' '. $policy->client_lastname_contractor}}</td>
      <td class="rid-bb">{{$policy->client_name.' '.$policy->client_lastname}}</td>
    </tr>

    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Rif/Cédula: </strong>{{$policy->client_ci_contractor}}</td>
      <td class="rid-bb"><strong>Rif/Cédula: </strong>{{$policy->client_ci}}</td>
    </tr>

    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Marca: </strong>{{$policy->vehicle_brand}}</td>
      <td class="rid-bb"><strong>S/C: </strong>{{$policy->vehicle_bodywork_serial}}</td>
    </tr>

    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Modelo: </strong>{{$policy->vehicle_model}}</td>
      <td class="rid-bb"><strong>S/M: </strong>{{$policy->vehicle_motor_serial}}</td>
    </tr>

    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Año: </strong>{{$policy->vehicle_year}}</td>
      <td class="rid-bb"><strong>Placa: </strong>{{$policy->vehicle_registration}}</td>
    </tr>

    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Color: </strong>{{$policy->vehicle_color}}</td>
      <td class="rid-bb"><strong>Emisión: </strong>{{$policy->created_at}}</td>
    </tr>

    <tr style="text-align:center;">
      <td class="right-bd rid-bb"><strong>Tipo: </strong>{{$policy->vehicle_type}}</td>
      <td class="rid-bb"><strong>Vence: </strong>{{$policy->expiring_date}}</td>
    </tr>

  </table>

</body>
</html>