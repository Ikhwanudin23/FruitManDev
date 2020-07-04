<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:user');
    }

    public function register(Request $request) {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->api_token = Str::random(80);
        $user->fcm_token = $request->fcm_token;
        $user->save();
        $user->sendApiEmailVerificationNotification();
        $message = "Cek Email Anda, Verifikasi Dahulu";


        return response()->json([
           'message' => $message,
           'status' => true,
        ]);

/*        $validator = Validator::make($request->all(),
            [
                'name' => ['required', 'string', 'max:191'],
                'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
                'password' => ['required', 'string', 'min:8' ],
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
                'data' => (object) []
            ], 401);
        }*/
    }
}
