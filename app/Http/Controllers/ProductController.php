<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{   public function uploadsImage(Request $request){
    $hospitalRequest = $request->file;
    $image = $request->file('fileName');
    if($request->fileName){
        $input = $hospitalRequest = $image->getClientOriginalName();
        $destinationPath = public_path('uploads/');
        $image->move($destinationPath, $input);
        return response()->json([
            'data' => asset('uploads/'.$input),
            'status' => true,
            'message' => 'success Message'
        ]);
    }
    return response()->json([
        'status' => false,
        'message' => 'error message',
    ]);
    }
    public function createProduct(Request $request){
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'discount' => $request->discount,
            'discription' => $request->discription,
            'image' => $request->image,
            'type' => $request->type,
        ]);
            return response()->json([
                'data' => $product,
            ]);
    }
    public function bestWoman(Request $request){
        $product = Product::where('type','woman')->count();
        if($product){
            $products = Product::where('type','woman')->get(); 
            return response()->json([
             'date' =>$products,
             'message' =>'success',
            ],200);
        }
        return response()->json([
            'message' =>'no products available',
           ],500);
    }
}
