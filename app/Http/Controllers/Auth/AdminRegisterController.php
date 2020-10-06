<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class AdminRegisterController extends Controller
{
	public function showRegistrationForm()
	{
		return view('auth.admin.admin-register');
	}

	public function register(Request $request)
	{
		$this->validate(
			$request, [
            'name' => ['required', 'string', 'max:255', 'min:2', 'unique:admins'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'phone_number'      => ['min:5', 'max:8', 'regex:/[^A-Za-z-\s]+$/'],
            'ci'                => ['required', 'max:10', 'min:7', 'unique:users', 'regex:/[^A-Za-z-\s]+$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

		$user = new Admin;
		$user->name = $request->input('name');
		$user->email = $request->input('email');
            $user->ci = $request->input('id_type').$request->input('ci');
            $user->phone_number = $request->input('sp_prefix').$request->input('phone_number');
		$password = Hash::make($request->input('password'));
		$user->password = $password;
		$user->save();

		return redirect('/admin/index-admins');
	}
}
