<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getLogin() {
        return view('loginTemplate');
    }

    public function login (Request $request){
        $this->validate($request,[
           'email'=>'required|email',
           'password'=>'required'
        ]);

        $credential = [
          'email'=>$request->email,
          'password'=>$request->password
        ];

        if (Auth::guard('admin')->attempt($credential)){
            return redirect()->intended(route('index'));
        }

        return redirect()->back()->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.getLogin');
    }

}
