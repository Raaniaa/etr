<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Blogger;
use App\Models\Boutiques;
use App\Models\Banner;
use App\Models\Category;
class ProductController extends Controller

{   public function uploadsImage(Request $request){
    $hospitalRequest = $request->file;
    $image = $request->file('fileName');
    if($request->fileName){
        $input = $hospitalRequest = $image->getClientOriginalName();
        $destinationPath = public_path('uploads/');
        $image->move($destinationPath, $input);
        return response()->json([
            'data' => asset('public/uploads/'.$input),
            'status' => true,
            'message' => 'success Message'
        ]);
    }
    return response()->json([
        'status' => false,
        'message' => 'error message',
    ]);
    }
    // public function createProduct(Request $request){
    //     $product = Product::create([
    //         'name' => $request->name,
    //         'price' => $request->price,
    //         'discount' => $request->discount,
    //         'discription' => $request->discription,
    //         'image' => $request->image,
    //         'type' => $request->type,
    //         'boutique_id' =>$request->boutique_id,
    //         'category_id'=>$request->category_id,
    //         'subcategory_id'=>$request->subcategory_id
    //     ]);
    //         return response()->json([
    //             'data' => $product,
    //         ]);
    // }
    public function bestWoman(){
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
    
    public function bestMan(){
        $product = Product::where('type','man')->count();
        if($product){
            $products = Product::where('type','man')->get(); 
            return response()->json([
             'date' =>$products,
             'message' =>'success',
            ],200);
        }
        return response()->json([
            'message' =>'no products available',
           ],500);
    }
    
    public function bestBlogger(){
        $product = Blogger::count();
        if($product){
            $products = Blogger::get(); 
            return response()->json([
             'date' =>$products,
             'message' =>'success',
            ],200);
        }
        return response()->json([
            'message' =>'no Blogger available',
           ],500);
    }

    public function categorySubProduct(Request $request){
        $product = Product::where('category_id',$request->categoryId)->where('subcategory_id',$request->subId)->count();
        if($product){
            $product = Product::where('category_id',$request->categoryId)->where('subcategory_id',$request->subId)->get();
            return response()->json([
                'date' =>$product,
                'message' =>'success',
               ],200);
        } 
        return response()->json([
            'message' =>'no Blogger available',
           ],500);
    }
    public function getProduct(Request $request){
        $product = Product::where('id',$request->id)->count();
        if($product){
            $product = Product::where('id',$request->id)->get();
            return response()->json([
                'date' =>$product,
                'message' =>'success',
               ],200);
        }
        return response()->json([
            'message' =>'no Product available',
           ],500);
    }
    public function getBanner(){
        $product = Banner::count();
        if($product){
            $product = Banner::get();
            return response()->json([
                'date' =>$product,
                'message' =>'success',
               ],200);
        }
        return response()->json([
            'message' =>'no Banner available',
           ],500);
    }
    public function AllBoutique(){
        $product = Boutiques::count();
        if($product){
            $product = Boutiques::get();
            return response()->json([
                'date' =>$product,
                'message' =>'success',
               ],200);
        }
        return response()->json([
            'message' =>'no Boutiques available',
           ],500);
    }
    public function Allcategory(){
        $product = Category::count();
        if($product){
            $product = Category::has('sub')->with('sub')->get();
            return response()->json([
                'date' =>$product,
                'message' =>'success',
               ],200);
        }
        return response()->json([
            'message' =>'no Categories available',
           ],500);
    }
    public function favouriteBlogger(Request $request){
        $product = favouriteBlogger::where('blogger_id',$request->blooger_id)->count();
        if($product){
            $product =favouriteBlogger::where('blogger_id',$request->blooger_id)->has('product')->with('product')->get();
            return response()->json([
                'date' =>$product,
                'message' =>'success',
               ],200);
        }
        return response()->json([
            'message' =>'no blogger available',
           ],500);
    }

}
