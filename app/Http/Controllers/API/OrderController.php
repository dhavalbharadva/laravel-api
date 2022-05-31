<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\ApiController;
use App\Models\Item;
use Validator;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Transformers\OrderTransformer;
use Carbon\Carbon;

class OrderController extends ApiController
{

    protected $auth;

    /**
     * @var \App\Transformers\OrderTransformer
     * */

    protected $orderTransformer;

    public function __construct()
    {
        $this->auth = auth()->guard('api');
    }

    public function store(Request $request)
    {
        $user_id = $this->auth->user()->id;
        
        $data = $request->all();

        $rules = array(
            'shipping_address' => 'required',
            'billing_address' => 'required',
            'item' => 'required',
            'item.*.id' => 'required',
            'item.*.quantity' => 'required',

        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return $this->respondValidationError(array('errors' => $validator->errors()->all()));
        }

        $data['user_id'] = $user_id;
        $data['delivery_time'] = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        //dd($data);
        $order = Order::create($data);
        $lastInsertId = $order->id;

        $totalAmount = 0;
        foreach ($data['item'] as $item) {
            $itemData = Item::find($item['id']);
            
            if($itemData){
                $orderDetail = new OrderDetail;
                $orderDetail->order_id = $lastInsertId;
                $orderDetail->item_id = $item['id'];
                $orderDetail->quantity = $item['quantity'];
                $orderDetail->price = $itemData->price;
                $orderDetail->save();

                $totalAmount += ($itemData->price * $item['quantity']);
            }
        }

        $order->amount = $totalAmount;
        $order->save();
        return $this->respondWithData($order, "You Order successfully");

    }

    public function getOrders(Request $request)
    {
        $user_id = $this->auth->user()->id;

        $data = Order::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        if (count($data)) {
            $this->orderTransformer = new OrderTransformer();
            $data = $this->orderTransformer->transform($data);

            $data->makeHidden('updated_at');

            return $this->respondWithData($data, NULL);
        } else {
            return $this->respondWithError(['No order Found']);
        }
    }

    public function getDelayedOrders(Request $request)
    {
        $user_id = $this->auth->user()->id;
        $currentTime = Carbon::now()->format('Y-m-d H:i:s');

        $data = Order::where('user_id', $user_id)->where('delivery_time','<',$currentTime)->orderBy('created_at', 'desc')->get();
        if (count($data)) {
            $this->orderTransformer = new OrderTransformer();
            $data = $this->orderTransformer->transform($data);

            $data->makeHidden('updated_at');

            return $this->respondWithData($data, NULL);
        } else {
            return $this->respondWithError(['No order Found']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateStatus(Request $request) {

        $data = $request->all();

        $rules = array(
            'order_id' => 'required',
            'status' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return $this->respondValidationError(array('errors' => $validator->errors()->all()));
        }

        $order = Order::findOrFail($data['order_id']);
        $order->update($data);
        
        return $this->respondWithSuccess("Order updated successfully!",$order);
    }

}
