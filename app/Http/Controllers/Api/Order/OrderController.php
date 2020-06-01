<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Resources\OrderResource;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index () {
        $orders = Order::all();
        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function complete($id)
    {
        $order = Order::findOrFail($id);
        $order->complete = true;
        $order->update();

        return response()->json([
            'message' => 'completed order',
            'status' => true,
            'data' => new OrderResource($order),
        ]);
    }

    public function collectorWaiting()
    {
        $orders = Order::where('collector_id', Auth::user()->id)->where('status', '1')->get();
        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function collectorInProgress()
    {
        $orders = Order::where('collector_id', Auth::user()->id)->where('status', '2')->get();
        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function sellerOrderIn()
    {
        $orders = Order::where('seller_id', Auth::user()->id)->where('status', '1')->get();
        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function confirmed($id)
    {
        $user = Auth::user()->id;
        $order = Order::where('id', $id)
            ->where('seller_id', $user)
            ->where('status', '1')
            ->update(['status' => '2']);

        return response()->json([
            'message' => 'successfully confirmed order',
            'status' => true,
            'data' => $order
        ]);
    }

    public function decline($id, Request $request)
    {
        $user = Auth::user()->id;
        $order = Order::where('id', $id)
            ->where($request->role, $user)
            ->where('status', '1')
            ->update(['status' => '0']);

        return response()->json([
            'message' => 'successfully decline order',
            'status' => true,
            'data' => (object)[]
        ]);
    }

    public function store (Request $request)
    {
        try {

            $validator = Validator::make($request->all(), ['offer_price' => 'required|numeric']);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors(), 'status' => false, 'data' => (object)[]]);
            }

            if ($request->seller_id == Auth::user()->id){
                return response()->json(['message' => 'tidak dapat mengorder produk sendiri', 'status' => false]);
            }

            $order = Order::create([
                'collector_id' => Auth::user()->id,
                'seller_id' => $request->seller_id,
                'product_id' => $request->product_id,
                'offer_price' => $request->offer_price,
            ]);

            return response()->json([
                'message' => 'success',
                'status' => true,
                'data' => new OrderResource($order)
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => false,
                'data' => (object)[],
            ]);
        }
    }
}
