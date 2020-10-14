<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Price;
use App\Policy;
use App\Vehicle;
use App\Relation_p_o as PO;
use App\VehicleClass;
use App\Estado;
use App\Municipio;
use App\Parroquia;
use Illuminate\Support\Facades\File;
use PDF;
use Carbon\Carbon;

class PoliciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $today = Carbon::now();
        $policies = User::find($user_id)->policies;
        $counter = 0;

        return view('user-modules.Policies.policies-index', compact('policies', 'counter', 'today'));
    }

    public function index_admin()
    {
        $policies = Policy::all();
        $today = Carbon::now();
        $counter = 0;

        return view('admin-modules.Policies.admin-policies-index', compact('policies', 'counter', 'today'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicle_classes = VehicleClass::all();
        $vehicles = Vehicle::distinct()->get('brand');
        $estados = Estado::all();
        return view('user-modules.Policies.policies-create', compact('vehicles', 'vehicle_classes', 'estados'));
    }

    public function create_admin()
    {
        $vehicle_classes = VehicleClass::all();
        $vehicles = Vehicle::distinct()->get('brand');
        $estados = Estado::all();
        return view('admin-modules.Policies.admin-policies-create', compact('vehicles', 'vehicle_classes', 'estados'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            // $data = Vehicle::where('brand', 'LIKE', $request->vehicle.'%')->orWhere('model', 'LIKE', $request->vehicle.'%')->get();
            $data = Vehicle::where('brand', 'LIKE', $request->brandId . '%')->get();
            // declare an empty array for output
            $output = '';
            $output = '<option value="0"> - Seleccionar Modelo - </option>';
            // if searched countries count is larger than zero

            foreach ($data as $row) {
                $output .= '<option value="' . $row->model . '">' . $row->model . '</option>';
            }

            return $output;
        }
    }

    public function price_view(Request $request)
    {
        if ($request->ajax()) {
            $data = Price::where('id', $request->priceId)->get();

            $price_info = '';

            foreach ($data as $row) {
                $price_info .= '<div class="col-6">' .
                    '<h6 class="mt-2"><span class="font-weight-bold">Daño a cosas: </span>' . '<span class="price_show">' . number_format($row->damage_things, 2) . '</span>' . ' Bs.S' . '</h6>' .
                    '<h6><span class="font-weight-bold">Prima: </span>' . '<span class="price_show">' . number_format($row->premium1, 2) . '</span>' . ' Bs.S' . '</h6>' .

                    '<h6 class="mt-3"><span class="font-weight-bold">Invalidez: </span>' . '<span class="price_show">' . number_format($row->disability, 2) . '</span>' . ' Bs.S' . '</h6>' .
                    '<h6><span class="font-weight-bold">Prima: </span>' . '<span class="price_show">' . number_format($row->premium3, 2) . '</span>' . ' Bs.S' . '</h6>' .

                    '<h6 class="mt-3"><span class="font-weight-bold">Muerte: </span>' . '<span class="price_show">' . number_format($row->death, 2) . '</span>' . ' Bs.S' . '</h6>' .
                    '<h6><span class="font-weight-bold">Prima: </span>' . '<span class="price_show">' . number_format($row->premium5, 2) . '</span>' . ' Bs.S' . '</h6>' .

                    '<h6 class="mt-4"><span class="font-weight-bold">Grua: </span>' . '<span class="price_show">' . number_format($row->crane, 2) . '</span>' . ' Bs.S' . '</h6>' .
                    '<h6><span class="font-weight-bold">Total Prima: </span>' . '<span class="price_show">' . number_format($row->crane, 2) . '</span>' . ' Bs.S' . '</h6>' .
                    '<h6 class="mt-4"><span class="font-weight-bold">Total Cobertura: </span>' . '<span class="price_show">' . number_format($row->total_all, 2) . '</span>' . ' Bs.S' . '</h6>' .

                    '</div>';
                $price_info .= '<div class="col-6">' .
                    '<h6 class="mt-2"><span class="font-weight-bold">Daño a personas: </span>' . '<span class="price_show">' . number_format($row->damage_people, 2) . '</span>' . ' Bs.S' . '</h6>' .
                    '<h6><span class="font-weight-bold">Prima: </span>' . '<span class="price_show">' . number_format($row->premium2, 2) . '</span>' . ' Bs.S' . '</h6>' .

                    '<h6 class="mt-3"><span class="font-weight-bold">Asistencia Juridica: </span>' . '<span class="price_show">' . number_format($row->legal_assistance, 2) . '</span>' . ' Bs.S' . '</h6>' .
                    '<h6><span class="font-weight-bold">Prima: </span>' . '<span class="price_show">' . number_format($row->premium4, 2) . '</span>' . ' Bs.S' . '</h6>' .

                    '<h6 class="mt-3"><span class="font-weight-bold">Gastos Medicos: </span>' . '<span class="price_show">' . number_format($row->medical_expenses, 2) . '</span>' . ' Bs.S' . '</h6>' .
                    '<h6><span class="font-weight-bold">Prima: </span>' . '<span class="price_show">' . number_format($row->premium6) . '</span>' . ' Bs.S' . '</h6>' .
                    '</div>';
            }

            return $price_info;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'client_name' => ['required', 'max:255', 'min:2'],
                'client_lastname' => ['required', 'max:255', 'min:2'],
                'client_email' => ['required', 'string', 'email', 'max:255'],
                'client_ci' => ['required', 'max:10', 'min:7', 'regex:/[^A-Za-z-\s]+$/'],
                'client_name_contractor' => ['required', 'max:255', 'min:2'],
                'client_lastname_contractor' => ['required', 'max:255', 'min:2'],
                'client_ci_contractor' => ['required', 'max:10', 'min:7', 'regex:/[^A-Za-z-\s]+$/'],
                'estado' => ['required'],
                'municipio' => ['required'],
                'parroquia' => ['required'],
                'vehicleBrand' => ['required'],
                'vehicleModel' => ['required'],
                'vehicle_year' => ['required', 'numeric', 'min:1918', 'max:2100'],
                'vehicle_class' => ['required'],
                'vehicle_color' => ['required', 'max:25', 'min:2', 'regex:/^[a-zA-Z_ ]+$/'],
                'used_for' => ['required'],
                'vehicle_bodywork_serial' => ['required', 'max:25', 'min:2', 'alpha_num'],
                'vehicle_motor_serial'  => ['required', 'max:25', 'min:2', 'alpha_num'],
                'vehicle_certificate_number' => ['required', 'max:25', 'min:2', 'alpha_num'],
                'vehicle_registration' => ['required', 'max:15', 'min:2', 'alpha_num'],
                'vehicle_weight' => ['required', 'regex:/[^A-Za-z-\s]+$/'],
                'price' => ['required'],
                'client_phone'      => ['min:5', 'max:8', 'regex:/[^A-Za-z-\s]+$/']
            ]
        );

        $vehicle_id = Vehicle::where('brand', $request->vehicleBrand)
            ->where('model', $request->vehicleModel)
            ->pluck('id');

        $vehicle_type = Vehicle::select('type_id')
            ->where('brand', $request->vehicleBrand)
            ->where('model', $request->vehicleModel)
            ->get()
            ->load('types')
            ->pluck('types')
            ->pluck('type');

        $policy  = new Policy;

        $user           = Auth::user();
        $user_id        = $user->id;
        $client_ci      = $request->input('id_type') . $request->input('client_ci');
        $vehicle_weight = $request->input('vehicle_weight') . 'Kg';

        $policy->user_id             = $user_id;

        //Fecha de vencimiento
        $expiring_date = Carbon::now()->addYear();
        $policy->expiring_date = $expiring_date;


        // Datos del vehiculo
        $policy->vehicle_id                 = $vehicle_id[0];
        $policy->vehicle_class_id           = $request->input('vehicle_class');
        $policy->vehicle_type               = $vehicle_type[0];
        $policy->vehicle_brand              = strtoupper($request->vehicleBrand);
        $policy->vehicle_model              = strtoupper($request->vehicleModel);
        $policy->vehicle_year               = $request->input('vehicle_year');
        $policy->vehicle_color              = ucwords($request->input('vehicle_color'));
        $policy->vehicle_weight             = $vehicle_weight;
        $policy->vehicle_bodywork_serial    = strtoupper($request->input('vehicle_bodywork_serial'));
        $policy->vehicle_motor_serial       = strtoupper($request->input('vehicle_motor_serial'));
        $policy->vehicle_certificate_number = strtoupper($request->input('vehicle_certificate_number'));
        $policy->vehicle_registration       = strtoupper($request->input('vehicle_registration'));
        $policy->used_for                   = $request->input('used_for');

        // Datos del cliente
        $client_names = strtolower($request->input('client_name'));
        $client_lastname = strtolower($request->input('client_lastname'));

        $policy->client_name          = ucwords($client_names);
        $policy->client_lastname      = ucwords($client_lastname);
        $policy->client_email         = $request->input('client_email');
        $policy->client_phone         = $request->input('sp_prefix') . $request->input('client_phone');
        $policy->client_ci            = strtoupper($client_ci);
        $policy->id_estado            = $request->input('estado');
        $policy->id_municipio         = $request->input('municipio');
        $policy->id_parroquia         = $request->input('parroquia');
        $policy->client_address       = $request->input('client_address');

        // Datos del beneficiario
        $client_names_contractor    = strtolower($request->input('client_name_contractor'));
        $client_lastname_contractor = strtolower($request->input('client_lastname_contractor'));
        $client_ci_contractor       = $request->input('id_type_contractor') . $request->input('client_ci_contractor');

        $policy->client_name_contractor     = ucwords($client_names_contractor);
        $policy->client_lastname_contractor = ucwords($client_lastname_contractor);
        $policy->client_ci_contractor       = strtoupper($client_ci_contractor);

        // Datos del precio al momento de crear la poliza
        $price_info = Price::where('id', $request->input('price'))->first();

        $policy->price_id = $request->input('price');
        $policy->damage_things = $price_info->damage_things;
        $policy->premium1 = $price_info->premium1;
        $policy->damage_people = $price_info->damage_people;
        $policy->premium2 = $price_info->premium2;
        $policy->disability = $price_info->disability;
        $policy->premium3 = $price_info->premium3;
        $policy->legal_assistance = $price_info->legal_assistance;
        $policy->premium4 = $price_info->premium4;
        $policy->death = $price_info->death;
        $policy->premium5 = $price_info->premium5;
        $policy->medical_expenses = $price_info->medical_expenses;
        $policy->premium6 = $price_info->premium6;
        $policy->crane = $price_info->crane;
        $policy->total_premium = $price_info->total_premium;
        $policy->total_all = $price_info->total_all;

        $policy->save();
        
        return redirect('/user/index-policies');
    }

    public function store_admin(Request $request)
    {
        $this->validate(
            $request,
            [
                'client_name' => ['required', 'max:255', 'min:2'],
                'client_lastname' => ['required', 'max:255', 'min:2'],
                'client_email' => ['required', 'string', 'email', 'max:255'],
                'client_ci' => ['required', 'max:10', 'min:7', 'regex:/[^A-Za-z-\s]+$/'],
                'client_phone'      => ['min:5', 'max:8', 'regex:/[^A-Za-z-\s]+$/'],
                'client_name_contractor' => ['required', 'max:255', 'min:2'],
                'client_lastname_contractor' => ['required', 'max:255', 'min:2'],
                'client_ci_contractor' => ['required', 'max:10', 'min:7', 'regex:/[^A-Za-z-\s]+$/'],
                'estado' => ['required'],
                'municipio' => ['required'],
                'parroquia' => ['required'],
                'vehicleBrand' => ['required'],
                'vehicleModel' => ['required'],
                'vehicle_year' => ['required', 'numeric', 'min:1918', 'max:2100'],
                'vehicle_class' => ['required'],
                'vehicle_color' => ['required', 'max:25', 'min:2', 'regex:/^[a-zA-Z_ ]+$/'],
                'used_for' => ['required'],
                'vehicle_bodywork_serial' => ['required', 'max:25', 'min:2', 'alpha_num'],
                'vehicle_motor_serial'  => ['required', 'max:25', 'min:2', 'alpha_num'],
                'vehicle_certificate_number' => ['required', 'max:25', 'min:2', 'alpha_num'],
                'vehicle_registration' => ['required', 'max:15', 'min:2', 'alpha_num'],
                'vehicle_weight' => ['required', 'regex:/[^A-Za-z-\s]+$/'],
                'price' => ['required']
            ]
        );

        // Get Vehicle id from select option using pluck to get the value in an arry of 1 item
        $vehicle_id = Vehicle::where('brand', $request->vehicleBrand)
            ->where('model', $request->vehicleModel)
            ->pluck('id');

        // Get Vehicle type from select option using pluck to get the value in an arry of 1 item
        $vehicle_type = Vehicle::select('type_id')
            ->where('brand', $request->vehicleBrand)
            ->where('model', $request->vehicleModel)
            ->get()
            ->load('types')
            ->pluck('types')
            ->pluck('type');


        $policy  = new Policy;
        $policy->price_id             = $request->input('price');

        $user           = Auth::user();
        $user_id        = $user->id;
        $vehicle_weight = $request->input('vehicle_weight') . 'Kg';

        $policy->admin_id             = $user_id;

        //Fecha de vencimiento
        $expiring_date = Carbon::now()->addYear();
        $policy->expiring_date = $expiring_date;

        // Datos del vehiculo
        $policy->vehicle_id                 = $vehicle_id[0];
        $policy->vehicle_class_id           = $request->input('vehicle_class');
        $policy->vehicle_type               = $vehicle_type[0];
        $policy->vehicle_brand              = strtoupper($request->vehicleBrand);
        $policy->vehicle_model              = strtoupper($request->vehicleModel);
        $policy->vehicle_year               = $request->input('vehicle_year');
        $policy->vehicle_color              = ucwords($request->input('vehicle_color'));
        $policy->vehicle_weight             = $vehicle_weight;
        $policy->vehicle_bodywork_serial    = strtoupper($request->input('vehicle_bodywork_serial'));
        $policy->vehicle_motor_serial       = strtoupper($request->input('vehicle_motor_serial'));
        $policy->vehicle_certificate_number = strtoupper($request->input('vehicle_certificate_number'));
        $policy->vehicle_registration       = strtoupper($request->input('vehicle_registration'));
        $policy->used_for                   = $request->input('used_for');

        // Datos del cliente        
        $client_names = strtolower($request->input('client_name'));
        $client_lastname = strtolower($request->input('client_lastname'));
        $client_ci      = $request->input('id_type') . $request->input('client_ci');

        $policy->client_name          = ucwords($client_names);
        $policy->client_lastname      = ucwords($client_lastname);
        $policy->client_email         = $request->input('client_email');
        $policy->client_phone         = $request->input('sp_prefix') . $request->input('client_phone');
        $policy->client_ci            = strtoupper($client_ci);
        $policy->id_estado            = $request->input('estado');
        $policy->id_municipio         = $request->input('municipio');
        $policy->id_parroquia         = $request->input('parroquia');
        $policy->client_address       = $request->input('client_address');

        // Datos del beneficiario
        $client_names_contractor    = strtolower($request->input('client_name_contractor'));
        $client_lastname_contractor = strtolower($request->input('client_lastname_contractor'));
        $client_ci_contractor       = $request->input('id_type_contractor') . $request->input('client_ci_contractor');

        $policy->client_name_contractor     = ucwords($client_names_contractor);
        $policy->client_lastname_contractor = ucwords($client_lastname_contractor);
        $policy->client_ci_contractor       = strtoupper($client_ci_contractor);

        // Datos del precio al momento de crear la poliza
        $price_info = Price::where('id', $request->input('price'))->first();

        $policy->price_id = $request->input('price');
        $policy->damage_things = $price_info->damage_things;
        $policy->premium1 = $price_info->premium1;
        $policy->damage_people = $price_info->damage_people;
        $policy->premium2 = $price_info->premium2;
        $policy->disability = $price_info->disability;
        $policy->premium3 = $price_info->premium3;
        $policy->legal_assistance = $price_info->legal_assistance;
        $policy->premium4 = $price_info->premium4;
        $policy->death = $price_info->death;
        $policy->premium5 = $price_info->premium5;
        $policy->medical_expenses = $price_info->medical_expenses;
        $policy->premium6 = $price_info->premium6;
        $policy->crane = $price_info->crane;
        $policy->total_premium = $price_info->total_premium;
        $policy->total_all = $price_info->total_all;

        $policy->save();

        return redirect('/admin/index-policies')->with('success' . 'Póliza registrada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $policy = Policy::findOrFail($id);
        $today = Carbon::now();
        $expiring_date = Carbon::parse($policy->expiring_date);

        return view('user-modules.Policies.policy-show', compact('policy', 'today', 'expiring_date'));
    }

    public function show_admin($id)
    {
        $policy = Policy::findOrFail($id);
        $today = Carbon::now();
        $expiring_date = Carbon::parse($policy->expiring_date);

        return view('admin-modules.Policies.admin-policy-show', compact('policy', 'today', 'expiring_date'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function admin_edit($id)
    {
        $policy          = Policy::findOrFail($id);
        $vehicles        = Vehicle::all();
        $prices          = Price::all();
        $estados         = Estado::all();
        $vehicle_classes = VehicleClass::all();

        $cedula = $policy->client_ci;
        $cedula_contractor = $policy->client_ci_contractor;
        $id_type = substr($cedula, 0, 2);
        $id_type_contractor = substr($cedula_contractor, 0, 2);

        $identification = preg_split('/[A-Z].*?-/', $cedula);
        array_push($identification, $id_type);
        $identification_contractor = preg_split('/[A-Z].*?-/', $cedula_contractor);
        array_push($identification_contractor, $id_type_contractor);

        $kilos = $policy->vehicle_weight;
        $weight_num = preg_split('/[A-Z].*/', $kilos);

        $phone = $policy->client_phone;
        $client_phone = preg_split('/-/', $phone);

        return  view('admin-modules.Policies.admin-policy-edit', compact('policy', 'id', 'vehicles', 'prices', 'identification', 'identification_contractor', 'weight_num', 'client_phone', 'estados', 'vehicle_classes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'client_name' => ['required', 'max:255', 'min:2'],
                'client_lastname' => ['required', 'max:255', 'min:2'],
                'client_email' => ['required', 'string', 'email', 'max:255'],
                'client_ci' => ['required', 'max:10', 'min:7', 'regex:/[^A-Za-z-\s]+$/'],
                'client_name_contractor' => ['required', 'max:255', 'min:2'],
                'client_lastname_contractor' => ['required', 'max:255', 'min:2'],
                'client_ci_contractor' => ['required', 'max:10', 'min:7', 'regex:/[^A-Za-z-\s]+$/'],
                'estado' => ['required'],
                'municipio' => ['required'],
                'parroquia' => ['required'],
                'vehicleBrand' => ['required'],
                'vehicleModel' => ['required'],
                'vehicle_year' => ['required', 'numeric', 'min:1918', 'max:2100'],
                'vehicle_class' => ['required'],
                'vehicle_color' => ['required', 'max:25', 'min:2', 'regex:/^[a-zA-Z_ ]+$/'],
                'used_for' => ['required'],
                'vehicle_bodywork_serial' => ['required', 'max:25', 'min:2', 'alpha_num'],
                'vehicle_motor_serial'  => ['required', 'max:25', 'min:2', 'alpha_num'],
                'vehicle_certificate_number' => ['required', 'max:25', 'min:2', 'alpha_num'],
                'vehicle_registration' => ['required', 'max:15', 'min:2', 'alpha_num'],
                'vehicle_weight' => ['required', 'regex:/[^A-Za-z-\s]+$/'],
                'price' => ['required'],
                'client_phone'      => ['min:5', 'max:8', 'regex:/[^A-Za-z-\s]+$/']
            ]
        );


        //Get Vehicle id from select option using pluck to get the value in an arry of 1 item
        $vehicle_id = Vehicle::where('brand', $request->vehicleBrand)
            ->where('model', $request->vehicleModel)
            ->pluck('id');

        //Get Vehicle type from select option using pluck to get the value in an arry of 1 item
        $vehicle_type = Vehicle::select('type_id')
            ->where('brand', $request->vehicleBrand)
            ->where('model', $request->vehicleModel)
            ->get()
            ->load('types')
            ->pluck('types')
            ->pluck('type');

        $policy  = Policy::findOrFail($id);

        $vehicle_weight = $request->input('vehicle_weight') . 'Kg';

        // $policy->price_id             = $request->input('price');

        // Datos del vehiculo
        $policy->vehicle_id                 = $vehicle_id[0];
        $policy->vehicle_type               = $vehicle_type[0];
        $policy->vehicle_brand              = strtoupper($request->input('vehicleBrand'));
        $policy->vehicle_model              = strtoupper($request->input('vehicleModel'));
        $policy->vehicle_class_id           = $request->input('vehicle_class');
        $policy->vehicle_year               = $request->input('vehicle_year');
        $policy->vehicle_color              = strtoupper($request->input('vehicle_color'));
        $policy->vehicle_weight             = $vehicle_weight;
        $policy->vehicle_bodywork_serial    = strtoupper($request->input('vehicle_bodywork_serial'));
        $policy->vehicle_motor_serial       = strtoupper($request->input('vehicle_motor_serial'));
        $policy->vehicle_certificate_number = strtoupper($request->input('vehicle_certificate_number'));
        $policy->vehicle_registration       = strtoupper($request->input('vehicle_registration'));
        $policy->used_for                   = strtoupper($request->input('used_for'));

        // Datos del cliente
        $client_names = strtolower($request->input('client_name'));
        $client_lastname = strtolower($request->input('client_lastname'));
        $client_ci      = $request->input('id_type') . $request->input('client_ci');

        $policy->client_name          = ucwords($client_names);
        $policy->client_lastname      = ucwords($client_lastname);
        $policy->client_email         = $request->input('client_email');
        $policy->client_ci            = strtoupper($client_ci);
        $policy->id_estado            = $request->input('estado');
        $policy->id_municipio         = $request->input('municipio');
        $policy->id_parroquia         = $request->input('parroquia');
        $policy->client_address       = $request->input('client_address');

        // Datos del beneficiario
        $client_names_contractor    = strtolower($request->input('client_name_contractor'));
        $client_lastname_contractor = strtolower($request->input('client_lastname_contractor'));
        $client_ci_contractor       = $request->input('id_type_contractor') . $request->input('client_ci_contractor');

        // Datos del precio
        $price_info = Price::where('id', $request->input('price'))->withTrashed()->first();        

        if($request->input('price') == $policy->price_id){ 
            $policy->save();
            // return redirect('/admin/index-policies');
            // return gettype($policy->price_id);
            return redirect('/admin/index-policies');
        }else{
            $policy->price_id = $request->input('price');
            $policy->damage_things = $price_info->damage_things;
            $policy->premium1 = $price_info->premium1;
            $policy->damage_people = $price_info->damage_people;
            $policy->premium2 = $price_info->premium2;
            $policy->disability = $price_info->disability;
            $policy->premium3 = $price_info->premium3;
            $policy->legal_assistance = $price_info->legal_assistance;
            $policy->premium4 = $price_info->premium4;
            $policy->death = $price_info->death;
            $policy->premium5 = $price_info->premium5;
            $policy->medical_expenses = $price_info->medical_expenses;
            $policy->premium6 = $price_info->premium6;
            $policy->crane = $price_info->crane;
            $policy->total_premium = $price_info->total_premium;
            $policy->total_all = $price_info->total_all;
    
            $policy->client_name_contractor     = ucwords($client_names_contractor);
            $policy->client_lastname_contractor = ucwords($client_lastname_contractor);
            $policy->client_ci_contractor       = strtoupper($client_ci_contractor);
            $policy->save();
            return redirect('/admin/index-policies');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function admin_destroy($id)
    {
        $policies = Policy::findOrFail($id);
        $policies->delete();
        return redirect('/admin/index-policies');
    }

    public function user_exportpdf($id)
    {
        $policy = Policy::find($id);
        $counter = 0;

        $data = ['policy' => $policy];

        $customPaper = array(0,0,700,1050);
        $pdf = PDF::loadView('user-modules.Policies.policy-pdf', $data)->setPaper($customPaper);

        $fileName = $policy->id . $policy->client_name . \Carbon\Carbon::parse($policy->created_at)->format('d-m-Y');

        return $pdf->stream($fileName . '.pdf');
    }

    public function admin_exportpdf($id)
    {
        $policy = Policy::find($id);
        $data = ['policy' => $policy];

        $customPaper = array(0,0,700,1050);

        $pdf = PDF::loadView('admin-modules.Policies.admin-policy-pdf', $data)->setPaper($customPaper);

        $fileName = $policy->id . $policy->client_name . \Carbon\Carbon::parse($policy->created_at)->format('d-m-Y');

        return $pdf->stream($fileName . '.pdf');
    }

    public function renew($id)
    {
        $expiring_date = Carbon::now()->addYear();
        $policy = Policy::find($id);
        $policy->expiring_date = $expiring_date;

        $policy->update();

        return redirect('/user/index-policies')->with('success', 'Póliza renovada correctamente');
    }

    public function admin_renew($id)
    {
        $expiring_date = Carbon::now()->addYear();
        $policy = Policy::find($id);
        $policy->expiring_date = $expiring_date;

        $policy->update();

        return redirect('/admin/index-policies')->with('success', 'Póliza renovada correctamente');
    }

    public function admin_price_renew($id)
    {  
        $policy = Policy::find($id);
        $price = Price::find($policy->price_id);

        $policy->damage_things = $price->damage_things;
        $policy->premium1 = $price->premium1;
        $policy->damage_people = $price->damage_people;
        $policy->premium2 = $price->premium2;
        $policy->disability = $price->disability;
        $policy->premium3 = $price->premium3;
        $policy->legal_assistance = $price->legal_assistance;
        $policy->premium4 = $price->premium4;
        $policy->death = $price->death;
        $policy->premium5 = $price->premium5;
        $policy->medical_expenses = $price->medical_expenses;
        $policy->premium6 = $price->premium6;
        $policy->crane = $price->crane;
        $policy->total_premium = $price->total_premium;
        $policy->total_all = $price->total_all;

        $policy->update();
        return redirect('/admin/index-policies')->with('success', 'Póliza renovada correctamente');
    }
    
    //export CSV
    public function showExport(){
        return view('user-modules.Export.show-export');
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'polizas.csv';
        $policies = Policy::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('id', 'user_id', 'admin_id', 'price_id', 'vehicle_id', 'id_estado', 'id_municipio', 'id_parroquia', 'vehicle_class_id', 'client_address', 'client_email', 'client_name', 'clien_lastname', 'client_ci', 'client_name_contractor', 'client_lastname_contractor', 'client_ci_contractor', 'client_phone', 'vehicle_brand', 'vehicle_model', 'vehicle_type', 'vehicle_registration', 'vehicle_bodywork_serial', 'vehicle_weight', 'vehicle_motor_serial', 'vehicle_certificate_number', 'vehicle_color', 'vehicle_year', 'used_for', 'status', 'expiring_date', 'created_at', 'updated_at', 'deleted_at', 'damage_things', 'premium1', 'damage_people', 'premium2', 'disability', 'premium3', 'legal_assistance', 'premium4', 'death', 'premium5', 'medical_expenses', 'premium6', 'crane', 'total_premium', 'total_all');

        $callback = function () use ($policies, $columns) {
            $file = fopen('php://output', 'w');
            // fputcsv($file, $columns);

            foreach ($policies as $policy) {
                $row['id']  = $policy->id;
                $row['user_id']  = $policy->user_id;
                $row['admin_id']    = $policy->admin_id;
                $row['price_id']    = $policy->price_id;
                $row['vehicle_id']  = $policy->vehicle_id;
                $row['id_estado']  = $policy->id_estado;
                $row['id_municipio']  = $policy->id_municipio;
                $row['id_parroquia']  = $policy->id_parroquia;
                $row['vehicle_class_id']  = $policy->vehicle_class_id;
                $row['client_address']  = $policy->client_address;
                $row['client_email']  = $policy->client_email;
                $row['client_name']  = $policy->client_name;
                $row['client_lastname']  = $policy->client_lastname;
                $row['client_ci']  = $policy->client_ci;
                $row['client_name_contractor']  = $policy->client_name_contractor;
                $row['client_lastname_contractor']  = $policy->client_lastname_contractor;
                $row['client_ci_contractor']  = $policy->client_ci_contractor;
                $row['client_phone']  = $policy->client_phone;
                $row['vehicle_brand']  = $policy->vehicle_brand;
                $row['vehicle_model']  = $policy->vehicle_model;
                $row['vehicle_type']  = $policy->vehicle_type;
                $row['vehicle_registration']  = $policy->vehicle_registration;
                $row['vehicle_bodywork_serial']  = $policy->vehicle_bodywork_serial;
                $row['vehicle_weight']  = $policy->vehicle_weight;
                $row['vehicle_motor_serial']  = $policy->vehicle_motor_serial;
                $row['vehicle_certificate_number']  = $policy->vehicle_certificate_number;
                $row['vehicle_color']  = $policy->vehicle_color;
                $row['vehicle_year']  = $policy->vehicle_year;
                $row['used_for']  = $policy->used_for;
                $row['status']  = $policy->status;
                $row['expiring_date']  = $policy->expiring_date;
                $row['created_at']  = $policy->created_at;
                $row['updated_at']  = $policy->updated_at;
                $row['deleted_at']  = $policy->deleted_at;
                $row['damage_things']  = $policy->damage_things;
                $row['premium1']  = $policy->premium1;
                $row['damage_people']  = $policy->damage_people;
                $row['premium2']  = $policy->premium2;
                $row['disability']  = $policy->disability;
                $row['premium3']  = $policy->premium3;
                $row['legal_assistance']  = $policy->legal_assistance;
                $row['premium4']  = $policy->premium4;
                $row['death']  = $policy->death;
                $row['premium5']  = $policy->premium5;
                $row['medical_expenses']  = $policy->medical_expenses;
                $row['premium6']  = $policy->premium6;
                $row['crane']  = $policy->crane;
                $row['total_premium']  = $policy->total_premium;
                $row['total_all']  = $policy->total_all;
               
                fputcsv($file, array(
                    $row['id'], 
                    $row['admin_id'], 
                    $row['admin_id'], 
                    $row['price_id'], 
                    $row['vehicle_id'], 
                    $row['id_estado'], 
                    $row['id_municipio'], 
                    $row['id_parroquia'], 
                    $row['vehicle_class_id'], 
                    $row['client_address'],
                    $row['client_email'],
                    $row['client_name'],
                    $row['client_lastname'],
                    $row['client_ci'],
                    $row['client_name_contractor'],
                    $row['client_lastname_contractor'],
                    $row['client_ci_contractor'],
                    $row['client_phone'],
                    $row['vehicle_brand'],
                    $row['vehicle_model'],
                    $row['vehicle_type'],
                    $row['vehicle_registration'],
                    $row['vehicle_bodywork_serial'],
                    $row['vehicle_weight'],
                    $row['vehicle_motor_serial'],
                    $row['vehicle_certificate_number'],
                    $row['vehicle_color'],
                    $row['vehicle_year'],
                    $row['used_for'],
                    $row['status'],
                    $row['expiring_date'],
                    $row['created_at'],
                    $row['updated_at'],
                    $row['created_at'],
                    $row['damage_things'],
                    $row['premium1'],
                    $row['damage_people'],
                    $row['premium2'],
                    $row['disability'],
                    $row['premium3'],
                    $row['legal_assistance'],
                    $row['premium4'],
                    $row['death'],
                    $row['premium5'],
                    $row['medical_expenses'],
                    $row['premium6'],
                    $row['crane'],
                    $row['total_premium'],
                    $row['total_all']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    // upload CSV file
    public function uploadFile(Request $request){

        
        if ($request->input('submit') != null ){
    
          $file = $request->file('file');
    
          // File Details 
          $filename = $file->getClientOriginalName();
          $extension = $file->getClientOriginalExtension();
          $tempPath = $file->getRealPath();
          $fileSize = $file->getSize();
          $mimeType = $file->getMimeType();
    
          // Valid File Extensions
          $valid_extension = array("csv");
    
          // 2MB in Bytes
        //   $maxFileSize = 2097152; 
    
          // Check file extension
          if(in_array(strtolower($extension),$valid_extension)){
        
              // File upload location
              $location = 'uploads';
    
              // Upload file
              $file->move($location,$filename);
    
              // Import CSV to Database
              $filepath = public_path($location."/".$filename);
    
              // Reading file
              $file = fopen($filepath,"r");

              $importData_arr = array();
              $i = 0;
    
              while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                 $num = count($filedata );
                 
                 // Skip first row (Remove below comment if you want to skip the first row)
                //  if($i == 0){
                //     $i++;
                //     continue; 
                //  }
                 for ($c=0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata [$c];
                 }
                 $i++;
              }
              fclose($file);
              
            // if(File::exists(public_path($location."/".$filename))){
            //     File::delete(public_path($location."/".$filename));
            // }
              // Insert to MySQL database
              foreach($importData_arr as $importData){
    
                $insertData = array(
                    "id"=>$importData[0],
                    "user_id"=>$importData[1],
                    "admin_id"=>NULL,
                    "price_id"=>$importData[3],
                    "vehicle_id"=>$importData[4],
                    "id_estado"=>$importData[5],
                    "id_municipio"=>$importData[6],
                    "id_parroquia"=>$importData[7],
                    "vehicle_class_id"=>$importData[8],
                    "client_address"=>$importData[9],
                    "client_email"=>$importData[10],
                    "client_name"=>$importData[11],
                    "client_lastname"=>$importData[12],
                    "client_ci"=>$importData[13],
                    "client_name_contractor"=>$importData[14],
                    "client_lastname_contractor"=>$importData[15],
                    "client_ci_contractor"=>$importData[16],
                    "client_phone"=>$importData[17],
                    "vehicle_brand"=>$importData[18],
                    "vehicle_model"=>$importData[19],
                    "vehicle_type"=>$importData[20],
                    "vehicle_registration"=>$importData[21],
                    "vehicle_bodywork_serial"=>$importData[22],
                    "vehicle_weight"=>$importData[23],
                    "vehicle_motor_serial"=>$importData[24],
                    "vehicle_certificate_number"=>$importData[25],
                    "vehicle_color"=>$importData[26],
                    "vehicle_year"=>$importData[27],
                    "used_for"=>$importData[28],
                    "status"=>$importData[29],
                    "expiring_date"=>$importData[30],
                    "created_at"=>$importData[31],
                    "updated_at"=>$importData[32],
                    "deleted_at"=>NULL,
                    "damage_things"=>$importData[34],
                    "premium1"=>$importData[35],
                    "damage_people"=>$importData[36],
                    "premium2"=>$importData[37],
                    "disability"=>$importData[38],
                    "premium3"=>$importData[39],
                    "legal_assistance"=>$importData[40],
                    "premium4"=>$importData[41],
                    "death"=>$importData[42],
                    "premium5"=>$importData[43],
                    "medical_expenses"=>$importData[44],
                    "premium6"=>$importData[45],
                    "crane"=>$importData[46],
                    "total_premium"=>$importData[47],
                    "total_all"=>$importData[48]);
    
                    Policy::insertData($insertData);
    
              }
    
              Session::flash('message','Import Successful.');
           
    
          }else{
             Session::flash('message','Invalid File Extension.');
          }
    
        }
    
        // Redirect to index
        return redirect('/admin/show-import-form');
      }


    // AJAX REQUESTS
    public function price_select(Request $request)
    {
        if ($request->ajax()) {
            $data = Price::where('class_id',  $request->priceData)->get();

            $output = '';
            $output = '<option value=""> - Seleccionar - </option>';

            foreach ($data as $row) {
                $output .= '<option value="' . $row->id . '">' . $row->description . '</option>';
            }

            return $output;
        }
    }
}
