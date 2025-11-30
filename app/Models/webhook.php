<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class webhook extends Model
{
protected $fillable = ['idempotency_key','status','order_id'];
}
