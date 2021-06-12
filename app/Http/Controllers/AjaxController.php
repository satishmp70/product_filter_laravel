<?php

namespace App\Http\Controllers;
use App\Product;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
  
    public function index(){
    $brands=Product::select('product_brand')->groupBy('product_brand')->where('product_status','1')->get();
    $ram=Product::select('product_ram')->groupBy('product_ram')->where('product_status','1')->get();
    $storage=Product::select('product_storage')->groupBy('product_storage')->where('product_status','1')->get();
    return view('index',compact('brands','ram','storage'));
    }
}
