<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function view(){
        $products = Product::all();
        return response()->json([
            'status'=>200,
            'products'=>$products,
        ]);

    }

    public function add(Request $request){
        $validator = Validator::make($request->all(),[
            'category_id'=>'required|string',
            'brand_id'=>'required|string',
            'originalPrice'=>'required|integer',
            'sellingPrice'=>'required|integer',
            'name'=>'required|string',
            'colour'=>'required|string',
            'qty'=>'required|integer',
            'size'=>'required|string',
            'prSection'=>'required|string',
            'description'=>'required|string',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg,bmp,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages(),
            ]);
    }else{
        $product = new Product();
        $product->category_id = $request->input('category_id');
        $product->brand_id = $request->input('brand_id');
        $product->originalPrice = $request->input('originalPrice');
        $product->sellingPrice = $request->input('sellingPrice');
        $product->name = $request->input('name');
        $product->colour = $request->input('colour');
        $product->qty = $request->input('qty');
        $product->size = $request->input('size');
        $product->prSection = $request->input('prSection');
        $product->description = $request->input('description');
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/product/', $filename);
            $product->image = 'uploads/product/' . $filename;
        }

        $product->featured = $request->input('featured') == true ? '1' : '0';
        $product->popular = $request->input('popular') == true ? '1' : '0';
        $product->status = $request->input('status') == true ? '1' : '0';
        $product->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product Added Successfully'
        ]);

    }
}

}