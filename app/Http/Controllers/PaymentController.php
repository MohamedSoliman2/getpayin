<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebhookRequest;
use App\Models\Order;
use App\Models\webhook;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use ApiResponseTrait;
    public function webhook(WebhookRequest $request){

$order=Order::where('idempotency_key','=',$request->idempotency_key)->first();
if($order){
return $this->errorResponse('the order is changed before');
}else{
    $order=Order::where('id',$request->order_id)->first();
    if($order){
    if($request->status=="success"){
      $order->update(['idempotency_key'=>$request->idempotency_key,'status'=>'completed']);
     }else{
        $order->product->increment('available_stock', $order->hold->stock);
       $order->update(['idempotency_key'=>$request->idempotency_key,'status'=>'closed']); 
    }
    return $this->successResponse($order);
}else{
 $webhook_check=webhook::where('idempotency_key',$request->idempotency_key)->first();
    if(!$webhook_check){
        webhook::create(['idempotency_key'=>$request->idempotency_key,'status'=>$request->status,'order_id'=>$request->order_id]);
     }
     return $this->successMessageResponse('the order not exist but we stored the webhook to use it when order created');
}
    
}
    }
}
