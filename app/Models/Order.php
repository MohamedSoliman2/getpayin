<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
      protected $fillable = ['product_id','hold_id','status','idempotency_key'];
        public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
      public function hold(){
        return $this->belongsTo(Hold::class,'hold_id');
    }
}
