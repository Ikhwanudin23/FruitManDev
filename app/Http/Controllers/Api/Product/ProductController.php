<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try{
            $fruits = Product::all();

            return response()->json([
                'message' => 'success',
                'status' => true,
                'data' => ProductResource::collection($fruits),
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => false,
                'data' => (object)[],
            ]);
        }
    }

    public function store(Request $request) {
        try {

            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'price' => 'required|numeric',
            ]);

            if ($validator->fails()){
                return response()->json([
                    'message' => $validator->errors(),
                    'status' => false,
                    'data' => (object)[]
                ]);
            }

            $image = $request->file('image')->store('upload/product');
            $product = Product::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'address' => $request->address,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $image,
                'status' => true
            ]);

            return response()->json([
                'message' => 'success',
                'status' => true,
                'data' => new ProductResource($product)
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => false,
                'data' => (object)[],
            ]);
        }



    }
}
