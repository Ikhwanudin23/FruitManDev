<?php

namespace App\Http\Controllers\Api\User\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function profile()
    {
    	$user = Auth::user();

    	return response()->json([
    		'message' => 'successfully get profile',
    		'status' => true,
    		'data' => $user
    	]);
    }

    public function updateprofile(Request $request)
    {
    	$user = Auth::user();
    	$user->name = $request->name;
    	$user->password = $request->password;
    	$user->address = $request->address;
    	$user->phone = $request->phone;
    	if ($request->file('image') == '') {
               $user->image = $user->image;
           } else {
               $user->image = $request->file('image')->store('upload/image');
           }
    	$user->update();

    	return response()->json([
    		'message' => 'successfully update profile',
    		'status' => true,
    		'data' => $user
    	]);
    }
}
