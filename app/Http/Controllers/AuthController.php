<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        // dd(Hash::make(123456));
        if(!empty(Auth::check())){
            return redirect('admin/dashboard');
        }
        return view('auth.login');
    }

    public function AuthLogin(Request $request){
        // dd($request->all());
        $remember = !empty($request->remeber) ? true :false;
        if(Auth::attempt(['username'=>$request->username,'password'=>$request->password],$remember)){
            return redirect('admin/dashboard');
        }
        else{
            return redirect()->back()->with('error','Please Enter correct credentials');
        }
    }
    public function logout(){
        Auth::logout();
        return redirect(url(''));
    }
}
