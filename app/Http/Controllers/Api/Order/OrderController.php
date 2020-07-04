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

    public function collectorWaiting()
    {
        $orders = Order::where('collector_id', Auth::user()->id)
        ->where('status', '1')
        ->where('arrive', false)
        ->where('completed', false)->get();
        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function collectorInProgress()
    {
        $orders = Order::where('collector_id', Auth::user()->id)
        ->where('status', '2')
        ->where('completed', false)->get();
        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function collectorComplete()
    {
        $orders = Order::where('collector_id', Auth::user()->id)
        ->where('status', '2')
        ->where('arrive', true)
        ->where('completed', true)->get();
        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function sellerOrderIn()
    {
        $orders = Order::where('seller_id', Auth::user()->id)
        ->where('status', '1')
        ->where('arrive', false)
        ->where('completed', false)->get();
        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function sellerInProgress()
    {
        $orders = Order::where('seller_id', Auth::user()->id)
        ->where('status', '2')
        ->where('completed', false)->get();

        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function sellerComplete(){
        $orders = Order::where('seller_id', Auth::user()->id)
            ->where('status', '2')
            ->where('arrive', true)
            ->where('completed', true)->get();

        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function confirmed($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == '0'){
            return response()->json([
                'message' => 'orderan sudah di batalkan sama pembeli',
                'status' => false
            ]);
        }else{
            $order->update(['status' => '2']);

            return response()->json([
                'message' => 'successfully confirmed order',
                'status' => true,
                'data' => (object)[]
            ]);
        }
    }

    public function decline($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == '2'){
            return response()->json([
                'message' => 'orderan sudah di konfirmasi sama penjual',
                'status' => false
            ]);
        }else{
            $order->update(['status' => '0']);

            return response()->json([
                'message' => 'successfully decline order',
                'status' => true,
                'data' => (object)[]
            ]);
        }


    }

    public function completed($id)
    {
        $order = Order::findOrFail($id);
        $order->completed = true;
        $order->update();

        return response()->json([
            'message' => 'completed order',
            'status' => true,
            'data' => (object)[],
        ]);
    }

    public function arrived($id)
    {
        $order = Order::findOrFail($id);
        $order->arrive = true;
        $order->update();

        return response()->json([
            'message' => 'i arrive to your home',
            'status' => true,
            'data' => (object)[],
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

            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60*20);

            $notificationBuilder = new PayloadNotificationBuilder('my title');
            $notificationBuilder->setBody('Hello world')->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['a_data' => 'my_data']);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();

            $data = $dataBuilder->build();
            $token = $order->seller->fcm_token;
            $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

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
