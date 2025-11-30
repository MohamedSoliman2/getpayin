<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\webhook;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckOrderInWebhook
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
       $order=Order::where('id',$event->order_id)->first();
       $webhook=webhook::where('order_id',$event->order_id)->first();
       if($webhook){
if($webhook->status == "success"){
      $order->update(['idempotency_key'=>$webhook->idempotency_key,'status'=>'completed']);
     }else{
        $order->product->increment('available_stock', $order->hold->stock);
       $order->update(['idempotency_key'=>$webhook->idempotency_key,'status'=>'closed']); 
    }
       }
    }
}
