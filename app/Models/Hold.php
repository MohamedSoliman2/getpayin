<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hold extends Model
{
    protected $fillable = ['expires_at','product_id','status','stock'];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
