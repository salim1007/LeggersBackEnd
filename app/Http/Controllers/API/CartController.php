<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function add(Request $request){

        if(auth('sanctum')->check()){


            $user_id = auth('sanctum')->user()->id;


            $product_id = $request->product_id;
            $product_name = $request->product_name;
            $product_brand=$request->product_brand;
            $product_image = $request->product_image;
            $product_size = $request->product_size;
            $product_colour = $request->product_colour;
            $product_sellPrice = $request->product_sellPrice;

         $productCheck = Product::where('id', $product_id)->first();

         if($productCheck) {
            //if(cart::where('column name in cart-table', column value- in specific table)).......format of code below 
            if(Cart::where('product_id', $product_id)->where('user_id', $user_id)->exists()) {

                return response()->json([
                    'status' => 409,
                    'message' => $productCheck->name.' is Already Added To Cart',
                ]);
            } else {
                $cartItem =  new Cart;
                $cartItem->user_id = $user_id;
                $cartItem->product_id = $product_id;
                $cartItem->product_brand = $product_brand;
                $cartItem->product_image = $product_image;
                $cartItem->product_size = $product_size;
                $cartItem->product_colour = $product_colour;
                $cartItem->product_sellPrice = $product_sellPrice;
                $cartItem->product_name = $product_name;
                $cartItem->save();

                return response()->json([
                    'status' => 201,
                    'message' => 'Added To Cart'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Product Not Found'
            ]);
        }
        }else{
            return response()->json([
                'status' => 401,
                'message' => 'Login to Add Cart'
            ]);
        }
    }

    public function viewCart(){
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $cartItems = Cart::where('user_id', $user_id)->get();

            return response()->json([
                'status'=>200,
                'cart'=>$cartItems,
            ]);

        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Login to View to Cart Data',
            ]);
        }
    }
   
    
}
