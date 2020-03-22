<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;


class LoginController extends Controller
{ 
    //Constructor para dejar ver la pantalla de login a usuarios no registrados
    public function __construct(){
        $this->middleware('guest',['only' => 'showLogin']);
    }

    public function showLogin(){
        return view('auth.login');
    }

    public function login(){
        $credentials= $this->validate(request(), [
            'email' => 'email|required|string',
            'password' => 'required|string'
         ]);

         if(Auth::attempt($credentials)){
             return redirect()->route('dashboard');
         }
         return back()
         ->withErrors(['email' => trans('auth.failed')])
         ->withInput(request(['email']));
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

}
