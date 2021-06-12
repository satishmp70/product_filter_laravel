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
               $product_detail->whereBetween('product_price',[$request->minimum_price,$request->maximum_price]);
            }
            
            if($request->brand){
                $brand_filter=implode("','",$request->brand);
               $product_detail->whereIn('product_brand',$brand_filter);

            }
            if($request->storage){
                $storage_filter=implode("','",$request->storage);
               $product_detail->whereIn('product_storage',$storage_filter);

            }
            if($request->ram){
                $ram_filter=implode("','",$request->ram);
               $product_detail->whereIn('product_ram',$ram_filter);

            }
        }
        dd($product_detail);
    }
    
}
