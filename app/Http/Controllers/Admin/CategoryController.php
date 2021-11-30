<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    public function add_category(){
        View::share('title', 'Add Category');
        return view('admin.category_action');
    }

    public function store_category(Request $request){

        $validator = Validator::make($request->all(),[
           'category_name' => 'required|string|max:150|unique:categories',
           'slug' => 'required|string|max:100|unique:categories',
           'parent_category' => 'numeric',
           'levels' => 'numeric|between:1,4',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $cateory = new Category();
            $cateory->category_name = $request->category_name;
            $cateory->slug = $request->slug;
            $cateory->parent_category = 0;
            $cateory->levels = 'ABCDE';
            $cateory->save();
            session()->flash('success','Category saved successfully');
            return redirect(url('/admin/dashboard'));
        }catch(Exception $e){
            $error = 'Opps! something goes wrong. Please try later';
            return redirect()->back()->with('error',$error)->withInput();
        }
    }
}
