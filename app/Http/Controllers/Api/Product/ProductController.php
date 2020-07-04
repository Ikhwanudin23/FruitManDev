<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            $fruits = Product::with(['orders' => function($query){
                $query->where('status', '0')->orWhere('status', '1');
            }])->where('user_id', '!=', Auth::user()->id)->get();

            return response()->json([
                'message' => 'success',
                'status' => true,
                'data' => ProductResource::collection(collect($fruits)),
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => false,
                'data' => (object)[],
            ]);
        }
    }

    public function show()
    {
        try {
            $fruits = Product::where('user_id', Auth::user()->id)->get();

            

            return response()->json([
                'message' => 'success',
                'status' => true,
                'data' => ProductResource::collection(collect($fruits)),
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => false,
                'data' => (object)[],
            ]);
        }
    }


    public function search($name)
    {
        $ucwords = ucwords($name);
        $products = Product::query()
            ->where('name', 'LIKE', "%{$ucwords}%")
            ->where('status', true)->get();

        return response()->json([
            'message' => 'Successfully search product by name',
            'status' => true,
            'data' => ProductResource::collection($products)
        ]);
    }



    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors(), 'status' => false, 'data' => (object)[]]);
            }

            $photo = $request->file('image');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $filepath = 'product/' . $filename;
            Storage::disk('s3')->put($filepath, file_get_contents($photo));

            $product = Product::create([
                'user_id' => Auth::user()->id,
                'name' => ucwords($request->name),
                'address' => $request->address,
                'description' => $request->description,
                'price' => $request->price,
                'image' =>  Storage::disk('s3')->url($filepath, $filename),
                'status' => true
            ]);

            return response()->json([
                'message' => 'success',
                'status' => true,
                'data' => new ProductResource($product)
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => false,
                'data' => (object)[],
            ]);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors(),
                    'status' => false,
                    'data' => (object)[]
                ]);
            }

            $data = Product::findOrFail($id);
            $data->user_id = Auth::user()->id;
            $data->name = $request->name;
            $data->address = $request->address;
            $data->description = $request->description;
            $data->price = $request->price;

            if ($request->file('image') == '') {
                $data->image = $data->image;
            } else {
                $data->image = $request->file('image')->store('upload/product');
            }

            return response()->json([
                'message' => 'success update product',
                'status' => true,
                'data' => new ProductResource($data)
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => false,
                'data' => (object)[],
            ]);
        }
    }

    public function delete ($id){
        $data = Product::find($id);
        $data->delete();
        return response()->json([
            'message' => "berhasil menghapus product",
            'status' => true,
            'data' => (object)[],
        ]);
    }

}
