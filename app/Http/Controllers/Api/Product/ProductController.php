<?php

namespace App\Http\Controllers\Api\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $fruits = Product::all();
        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => $fruits
        ]);
    }

    public function store(Request $request) {
        $image = $request->file('image')->store('upload/product');
        $product = Product::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $image,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => $product
        ]);
    }
}
