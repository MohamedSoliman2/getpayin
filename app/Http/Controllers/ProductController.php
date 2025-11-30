<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;
    public function show(string $id){
$product=Product::where('id',$id)->first();
if($product){
return $this->successResponse($product,'the product data');
}else{
    return $this->errorResponse('the product not exist');
}
    }
}
