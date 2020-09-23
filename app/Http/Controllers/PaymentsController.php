<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Policy;
use App\Payment;
use DB;
use Carbon\Carbon;

class PaymentsController extends Controller
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

      $payments = Payment::where('user_id',$user_id)->get();
      return view('user-modules.Payments.payments-index', compact('payments'));
    }

    public function index_admin()
    {
      $users = User::all();
      $payments = Payment::all();
      return view('admin-modules.Payments.admin-payments-index', compact('users', 'payments'));
    }

    public static function profit_percentage($value1, $value2)
    {
      $result = ($value2 * $value1) / 100;
      return $result;
    }

    //Cantidad de polizas sin pagar
    public static function policies_not_paid($user_id)
    {
      $policies = Policy::where('deleted_at', null)
                          ->where('user_id', $user_id)
                          ->where('status', FALSE)
                          ->get();

      // Check if policies is not null to avoid errors
      if($policies->first() != null){
        $policies_to_num = [];
        
        // Iterate over $policies to push each element to an array with the purpose of count the elements in it 
        foreach ($policies as $row) {
          array_push($policies_to_num, $row);
        }

        // Count and return the counted elements
        $counted_policies = count($policies_to_num);
        return $counted_policies;
      }

      // Return 0 if $policies is null
      return 0;
    }

    //Total neto de las polizas sin pagar
    public static function policies_not_paid_price($user_id)
    {
      $policies = Policy::select('price_id')
                          ->where('deleted_at', null)
                          ->where('user_id', $user_id)
                          ->where('status', FALSE)
                          ->get();

      //Check if $policies is not null
      if ($policies->first() != null) {
         $prices = [];

         //Iterate over $policies to get the prices and push each price to an array
         foreach ($policies as $row) {
            array_push($prices, $row->total_all);
         }

         //Sum the prices to get a total and return it
         $total = array_sum($prices);
         return $total;
       } 

       // return 0 if $policies is null
       return 0;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_admin(Request $request, $id)
    {
      $from_raw = Policy::where('user_id', $id)
      ->where('status', FALSE)
      ->orderBy('created_at', 'asc')
      ->limit(1)
      ->get('created_at');

      $until_raw = Policy::where('user_id', $id)
      ->where('status', FALSE)
      ->orderBy('created_at', 'desc')
      ->limit(1)
      ->get('created_at');

      $from = Carbon::parse($from_raw[0]->created_at);
      $until = Carbon::parse($until_raw[0]->created_at);
        // echo $from;
        // exit();

      $payment = new Payment;
      $payment->name = $request->name;
      $payment->office = $request->office;
      $payment->user_id = $request->user_id;
      $payment->total = $request->total;
      $payment->profit_percentage = $request->profit_percentage;
      $payment->total_payment = $request->total_payment;
      $payment->from = $from;
      $payment->until = $until;
      $payment->save();
      $policy_update = Policy::where('user_id', $id)->where('status', FALSE)->update(['status'=> TRUE]);
        // $policy_update->save();

      return redirect('/admin/index-payments')->with('success', 'Pago realizado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_admin($id)
    {
      $payments = Payment::where('user_id', $id)->get();
      return view('admin-modules.Payments.admin-payment-show', compact('id','payments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate(
        $request,[
          'bill' => ['required','mimes:jpeg,bmp,png,gif,svg,pdf']  
        ]);

      $payment = Payment::findOrFail($id);
      $payment->bill = $request->file('bill')->store('public');

      $payment->update();

      return redirect()->back()->with('success', 'Comprobante adjuntado exitosamente');
    }

  }
