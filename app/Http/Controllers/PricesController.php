<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Price;
use App\VehicleClass;

class PricesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $prices = Price::all();

        return view('user-modules.Prices.prices-index', compact('prices'));
    }

    public function index_admin()
    {
        $prices = Price::all();
        $counter = 0;

        return view('admin-modules.Prices.admin-prices-index', compact('prices', 'counter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $vehicle_classes = VehicleClass::all();
      return view('admin-modules.Prices.admin-prices-create', compact('vehicle_classes'));
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
            'vehicle_class'    => ['required'],
            'description'      => ['required','min:1'],
            'damage_things'    => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'premium1'         => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'damage_people'    => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'premium2'         => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'disability'       => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'premium3'         => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'legal_assistance' => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'premium4'         => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'death'            => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'premium5'         => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'medical_expenses' => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'premium6'         => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'crane'            => ['max:25', 'regex:/[^A-Za-z-\s]+$/'],

        ]);

        $price = new Price;
        $all = $request->all();

        $pricesarr = [];
        foreach ($all as $item) {
            $replaced = str_replace(',', '', $item);
            
            array_push($pricesarr, $replaced);
        }
        
        $price->class_id         = $request->input('vehicle_class'); 
        $price->damage_things    = $pricesarr[3];
        $price->premium1         = $pricesarr[4];
        $price->damage_people    = $pricesarr[5];
        $price->premium2         = $pricesarr[6];
        $price->disability       = $pricesarr[7];
        $price->premium3         = $pricesarr[8];
        $price->legal_assistance = $pricesarr[9];
        $price->premium4         = $pricesarr[10];
        $price->death            = $pricesarr[11];
        $price->premium5         = $pricesarr[12];
        $price->medical_expenses = $pricesarr[13];
        $price->premium6         = $pricesarr[14];
        $price->crane            = $pricesarr[15];
        $price->description      = $request->input('description');

        $sum = $pricesarr[4] + $pricesarr[6] + $pricesarr[8] + $pricesarr[10] + $pricesarr[12] + $pricesarr[14];
        $sum2 = $pricesarr[3] + $pricesarr[4] + $pricesarr[5] + $pricesarr[6] + $pricesarr[7] + $pricesarr[8] + $pricesarr[9] + $pricesarr[10] + $pricesarr[11] + $pricesarr[12] + $pricesarr[13] + $pricesarr[14] + $pricesarr[15];
        $price->total_premium = $sum;
        $price->total_all = $sum2;
        $price->save();

        return redirect('/admin/index-prices');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $price = Price::find($id);

        return view('user-modules.Prices.price-show', compact('price'));
    }


    public function show_admin($id)
    {
        $price = Price::find($id);
        return view('admin-modules.Prices.admin-price-show', compact('price'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_edit($id)
    {
        $price = Price::findOrFail($id);

        $vehicle_classes = VehicleClass::all();
        return  view('admin-modules.Prices.admin-price-edit', compact('price', 'id','vehicle_classes'));
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
            'vehicle_class'    => ['required'],
            'description'      => ['required','min:1'],
            'damage_things'    => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'premium1'         => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'damage_people'    => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'premium2'         => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'disability'       => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'premium3'         => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'legal_assistance' => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'premium4'         => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'death'            => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'premium5'         => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'medical_expenses' => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'premium6'         => ['required', 'max:25', 'min:1', 'regex:/[^A-Za-z-\s]+$/'],
            'crane'            => ['max:25', 'regex:/[^A-Za-z-\s]+$/'],

        ]);

        $price = Price::findOrFail($id);
                $all = $request->all();

        $pricesarr = [];
        foreach ($all as $item) {
            $replaced = str_replace(',', '', $item);
            
            array_push($pricesarr, $replaced);
        }

        $price->class_id         = $request->input('vehicle_class'); 
        $price->damage_things    = $pricesarr[4];
        $price->premium1         = $pricesarr[5];
        $price->damage_people    = $pricesarr[6];
        $price->premium2         = $pricesarr[7];
        $price->disability       = $pricesarr[8];
        $price->premium3         = $pricesarr[9];
        $price->legal_assistance = $pricesarr[10];
        $price->premium4         = $pricesarr[11];
        $price->death            = $pricesarr[12];
        $price->premium5         = $pricesarr[13];
        $price->medical_expenses = $pricesarr[14];
        $price->premium6         = $pricesarr[15];
        $price->crane            = $pricesarr[16];
        $price->description      = $request->input('description');

        $sum = $pricesarr[5] + $pricesarr[7] + $pricesarr[9] + $pricesarr[11] + $pricesarr[13] + $pricesarr[15];
        $sum2 = $pricesarr[4] + $pricesarr[5] + $pricesarr[6] + $pricesarr[7] + $pricesarr[8] + $pricesarr[9] + $pricesarr[10] + $pricesarr[11] + $pricesarr[12] + $pricesarr[13] + $pricesarr[14] + $pricesarr[15] + $pricesarr[16];
        $price->total_premium = $sum;
        $price->total_all = $sum2;
        $price->save();

        return redirect('/admin/index-prices');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prices = Price::findOrFail($id);
        $prices->delete();
        return redirect('/admin/index-prices');
    }
}
