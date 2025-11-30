<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Http\Requests\OrderRequest;
use App\Models\Hold;
use App\Models\Order;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
     use ApiResponseTrait;

    
    public function create(OrderRequest $request){
  $hold=Hold::where('id',$request->hold_id)->where('expires_at','>=',now())->first();
   if($hold){
        try {
         DB::beginTransaction();
         $hold->update(['status'=>'completed']);
         $order=Order::create(['product_id'=>$hold->product_id,'hold_id'=>$hold->id]);
         DB::commit();
         event(new OrderCreated($order->id));
         $data=['order_id'=>$order->id,"status"=>"pending_payment"];
        return $this->successResponse($data);
       } catch (\Exception $e) {
         DB::rollback();
         return $this->errorResponse('try again');
       }
  }else{
   return $this->errorResponse('the hold is expired');
  }

    }
}
