<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Validator;

class LoginController extends Controller
{
    //
    function index()
    {
     return view('login');
    }

    function checklogin(Request $request)
    {
        $this->validate($request, [
      	'email'   => 'required|email',
      	'password'  => 'required|alphaNum|min:3'
    	]);

		$user_data = array(
		'email'  => $request->get('email'),
		'password' => $request->get('password')
		);

		if(Auth::attempt($user_data))
		{
			return redirect('dashboard')->with('success', 'You are successfully login ');
		}
		else
		{
			return back()->with('error', 'Wrong Login Details');
		}
    }

    function successlogin()
    {
     	return view('successlogin');
    }
	
    function logout()
    {
     Auth::logout();
    return redirect()->route('login')->with('info','You are successfully logout');
    }
    
}
