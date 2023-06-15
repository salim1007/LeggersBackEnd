<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    //Product Types.......
    public function boykids()
    {
        $boykids = Product::where('prSection', 'Boys')->get();
        return response()->json([
            'status' => 200,
            'boykids' => $boykids,
        ]);
    }
    public function girlkids()
    {
        $girlkids = Product::where('prSection', 'Girls')->get();
        return response()->json([
            'status' => 200,
            'girlkids' => $girlkids,
        ]);
    }
    public function menOfficial()
    {
        $menOfficial = Product::where('prSection', 'Official (M)')->get();
        return response()->json([
            'status' => 200,
            'menOfficial' => $menOfficial,
        ]);
    }
    public function menCasual()
    {
        $menCasual = Product::where('prSection', 'Casual (M)')->get();
        return response()->json([
            'status' => 200,
            'menCasual' => $menCasual,
        ]);
    }
    public function womenOfficial()
    {
        $womenOfficial = Product::where('prSection', 'Official (W)')->get();
        return response()->json([
            'status' => 200,
            'womenOfficial' => $womenOfficial,
        ]);
    }
    public function womenCasual()
    {
        $womenCasual = Product::where('prSection', 'Casual (W)')->get();
        return response()->json([
            'status' => 200,
            'womenCasual' => $womenCasual,
        ]);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product,
            ]);
        }
    }



    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|string',
            'brand_id' => 'required|string',
            'originalPrice' => 'required|integer',
            'sellingPrice' => 'required|integer',
            'name' => 'required|string',
            'colour' => 'required|string',
            'qty' => 'required|integer',
            'size' => 'required|string',
            'prSection' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg,bmp,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages(),
            ]);
        } else {
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|string',
            'brand_id' => 'required|string',
            'originalPrice' => 'required|integer',
            'sellingPrice' => 'required|integer',
            'name' => 'required|string',
            'colour' => 'required|string',
            'qty' => 'required|integer',
            'size' => 'required|string',
            'prSection' => 'required|string',
            'description' => 'required|string',



        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages(),
            ]);
        } else {
            $product = Product::find($id);

            if ($product) {

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
                    $path =  $product->image;

                    if (File::exists($path)) {
                        File::delete($path);
                    }

                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/product/', $filename);
                    $product->image = 'uploads/product/' . $filename;
                }

                $product->featured = $request->input('featured') == true ? '1' : '0';
                $product->popular = $request->input('popular') == true ? '1' : '0';
                $product->status = $request->input('status') == true ? '1' : '0';
                $product->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Product Updated Successfully'
                ]);
            } else {

                return response()->json([
                    'status' => 404,
                    'message' => 'Product Not Found!'
                ]);
            }
        }
    }
    public function allproducts()
    {
        $products = Product::all();
        return response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }
    public function getProductDetails($categoryid, $section, $namee)
    {


        $product = Product::where('category_id', $categoryid)->where('prSection', $section)->where('name', $namee)->where('status', '1')->get();
        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product,


            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'No Product Available',
            ]);
        }
    }
    public function getAllProducts(){
        $product = Product::where('status', '1')->get();
        if($product){
            return response()->json([
                'status'=>200,
                'product'=>$product,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Product Not Found!',
            ]);

        }
    }
}
