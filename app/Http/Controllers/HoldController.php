<?php

namespace App\Http\Controllers;

use App\Http\Requests\HoldRequest;
use App\Models\Hold;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HoldController extends Controller
{
    use ApiResponseTrait;
    public function create(HoldRequest $request){
$product=Product::where('id',$request->product_id)->where('available_stock','>',0)->where('available_stock','>=',$request->qty)->first();
  if($product){
        try {
         $stock=$product->available_stock - $request->qty;
         $expires_at=now()->addMinutes(2);
         DB::beginTransaction();
         $hold=Hold::create(['expires_at'=>$expires_at,'product_id'=>$product->id,'stock'=>$request->qty]);
         $product->update(['available_stock'=>$stock]);
         DB::commit();
         $data=['hold_id'=> $hold->id , 'expires_at'=>$expires_at];
         return $this->successResponse($data);

       } catch (\Exception $e) {
         DB::rollback();
         return $this->errorResponse('try again');
    }
 }else{
   return $this->errorResponse('Quantity not available');
  }

    }
}
