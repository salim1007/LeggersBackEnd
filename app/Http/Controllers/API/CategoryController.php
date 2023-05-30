<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function add(Request $request){
        $validator = Validator::make($request->all(),[
            'category'=>'required|string',
            'origin'=>'required|string',
            'brandName'=>'required|string',
            'section'=>'required|string',
            'description'=>'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>$validator->messages(),
            ]);
        }else{
            $category = new Category();

            $category->category = $request->input('category');
            $category->origin = $request->input('origin');
            $category->brandName =$request->input('brandName');
            $category->section =$request->input('section');
            $category->description =$request->input('description');
            $category->status = $request->input('status');
            $category->save();

            return response()->json([
                'status'=>200,
                'message'=>'Category Added Successfully'
            ]);
            
        }
    }
    public function getCategory(){
        $category = Category::where('status','0')->get();
        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);
    }

    public function edit($id){
        $category = Category::find($id);
        if($category){
            return response()->json([
                'status'=>200,
                'category'=>$category,
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'category'=>"No Category Found!",
            ]);
        }
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'category'=>'required|string',
            'origin'=>'required|string',
            'brandName'=>'required|string',
            'section'=>'required|string',
            'description'=>'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>$validator->messages(),
            ]);
        }else{
            $category = Category::find($id);

            if($category){

                $category->category = $request->input('category');
                $category->origin = $request->input('origin');
                $category->brandName =$request->input('brandName');
                $category->section =$request->input('section');
                $category->description =$request->input('description');
                $category->status = $request->input('status');
                $category->save();
    
                return response()->json([
                    'status'=>200,
                    'message'=>'Category Updated Successfully',
                ]);

            }else{

                return response()->json([
                    'status'=>404,
                    'message'=>'No Category Found!'
                ]);
            }

            
            
        }
    }
}
