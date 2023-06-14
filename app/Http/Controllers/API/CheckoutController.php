<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function placeorder(Request $request){
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $validator = Validator::make($request->all(),[
                'firstname'=>'required|max:191',
                'lastname'=>'required|max:191',
                'email'=>'email|required|max:191',
                'phone'=>'required|max:191',
                'country'=>'required|max:191',
                'city'=>'required|max:191',
                'state'=>'required|max:191',
                'zip'=>'required|max:191',
                'postalcode'=>'required|max:191'
            ]);

            if($validator->fails()){
                return response()->json([
                    'status'=>422,
                    'errors'=>$validator->messages(),
                ]);
            }else{
                $user_id = auth('sanctum')->user()->id;

                $order = new Order();
                $order->user_id = $user_id;

                $order->firstname = $request->input("firstname");
                $order->lastname = $request->input("lastname");
                $order->email = $request->input("email");
                $order->phone = $request->input("phone");
                $order->country = $request->input("country");
                $order->city = $request->input("city");
                $order->state = $request->input("state");
                $order->zip = $request->input("zip");
                $order->postalcode = $request->input("postalcode");

                $order->payment_mode = "COD";
                $order->tracking_no = "leggerzcom".rand(1111,9999);
                $order->save();

                $cart = Cart::where('user_id', $user_id)->get();
                $orderItems = [];

                foreach($cart as $item){
                    //item->product->{......} === relation to product found in carts model.....allows to access products table..
                    $orderItems[]=[
                        'product_id'=>$item->product_id,
                        'qty'=>$item->product_qty,
                        'price'=>$item->product->sellingPrice,
                    ];

                    $item->product->update([
                        'qty'=>$item->product->qty - $item->product_qty
                    ]);
                }

                $order->orderitems()->createMany($orderItems);
                Cart::destroy($cart);



                return response()->json([
                    'status'=>200,
                    'message'=>'Order Placed Successfully!',
                ]);

            }

        }else{
            return response()->json([
                'status' => 401,
                'message' => 'Login to Continue',
            ]);
        }
    }
}
