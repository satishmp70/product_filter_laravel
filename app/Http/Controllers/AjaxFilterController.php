<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;

class AjaxFilterController extends Controller
{

    public function  index(Request $request){
        if($request->action){
            $product_detail=Product::where('product_status','1')->get(); 
            if( 
                 $request->minimum_price ||
                 $request->maximum_price 
                 && (!empty($request->minimum_price ))
                 && (!empty($request->maximum_price ))
                 )
                 {
               $product_detail=Product::whereBetween('product_price',[$request->minimum_price,$request->maximum_price])->get();
            }
            
            if($request->brand){
                $brand_filter=implode("','",$request->brand);
               $product_detail=Product::whereIn('product_brand',[$brand_filter])->get();

            }
            if($request->storage){
                $storage_filter=implode("','",$request->storage);
               $product_detail=Product::whereIn('product_storage',[$storage_filter])->get();
            }
            if($request->ram){
                $ram_filter=implode("','",$request->ram);
               $product_detail=Product::whereIn('product_ram',[$ram_filter])->get();

            }
        }
        return view('fetch',compact('product_detail'));
        
    }
    
}
