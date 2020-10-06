<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use App\User;
use App\VehicleType;
use App\VehicleClass;
use Auth;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        $vehicle_classes = VehicleClass::all();
        return view('user-modules.Vehicles.vehicles-index', compact('vehicles','vehicle_classes'));
    }

    public function index_admin()
    {        
        $vehicles = Vehicle::orderBy('created_at', 'asc')->get();

        return view('admin-modules.Vehicles.admin-vehicles-index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicle_types = VehicleType::all();
    return view('user-modules.Vehicles.vehicle-create', compact('vehicle_types'));
    }

    public function create_admin()
    {
        $vehicle_types = VehicleType::all();
        return view('admin-modules.Vehicles.admin-vehicle-create', compact('vehicle_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'brand' => 'required|max:20',
            'model'=> 'required|max:20',
            'vehicleType' => 'required'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $vehicle = new Vehicle;
        $vehicle->user_id      = $user_id;
        $vehicle->brand        = strtoupper($request->input('brand'));
        $vehicle->model        = strtoupper($request->input('model'));
        $vehicle->type_id =  $request->input('vehicleType');
        $vehicle->save();


        return redirect('/user/index-vehicles')->with('success', 'Vehiculo registrado correctamente');
    }

    public function store_admin(Request $request)
    {
        $this->validate(
            $request, [
            'brand' => ['required', 'max:40', 'min:2'],
            'model'=> ['required', 'max:40', 'min:2'],
            'vehicleType' => ['required']
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $vehicle = new Vehicle;
        $vehicle->admin_id = $user_id;
        $vehicle->brand = strtoupper($request->input('brand'));
        $vehicle->model= strtoupper($request->input('model'));
        $vehicle->type_id = $request->input('vehicleType');
        $vehicle->save();

        return redirect('/admin/index-vehicles')->with('success', 'Vehiculo registrado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_edit($id)
    {
        $vehicle   = Vehicle::findOrFail($id);
        $vehicle_types = VehicleType::all();
        return  view('admin-modules.Vehicles.admin-vehicle-edit', compact('vehicle', 'id', 'vehicle_types'));
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
        $this->validate($request, [
            'brand' => ['required', 'max:40', 'min:2'],
            'model'=> ['required', 'max:40', 'min:2'],
            'vehicleType' => ['required']
        ]);

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->brand = strtoupper($request->input('brand'));
        $vehicle->model= strtoupper($request->input('model'));
        $vehicle->type_id =  $request->input('vehicleType');
        $vehicle->save();

        return redirect('/admin/index-vehicles')->with('success', 'Vehiculo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicles = Vehicle::findOrFail($id);
        $vehicles->delete();
        return redirect('/admin/index-vehicles')->with('success', 'Vehiculo eliminado correctamente');


    }
}
