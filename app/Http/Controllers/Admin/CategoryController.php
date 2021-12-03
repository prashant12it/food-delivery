<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    public function add_category(){
        View::share('title', 'Add Category');
        $categories = Category::all();
        // dd($categories);
        return view('admin.category_action',compact('categories'));

    }

    public function edit_category($id){
        View::share('title', 'Edit Category');
        $categories = Category::all();
        $edit_category = Category::find($id);               
        return view('admin.category_action',compact('categories','edit_category','id'));
    }

    public function store_category(Request $request){

        $validator = Validator::make($request->all(),[
           'category_name' => 'required|string|max:150|unique:categories',
           'slug' => 'required|string|max:100|unique:categories',
        //    'parent_category' => 'numeric',
        //    'levels' => 'numeric|between:1,4',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $cateory = new Category();
            $cateory->category_name = $request->category_name;
            $cateory->slug = $request->slug;
            $cateory->parent_category = 0;
            $cateory->levels = 1;
            // if($cateory->input('id')) {
            
            //     $cateory->saveData($data,'foods', $request->input('id'));
            // } else {
            //     $res->saveData($data,'foods');
            // }
            $cateory->save();
            session()->flash('success','Category saved successfully');
            return redirect(url('/admin/add_category'));
        }catch(Exception $e){
            $error = 'Opps! something goes wrong. Please try later';
            return redirect()->back()->with('error',$error)->withInput();
        }
    }

    // public function update_category($id)
    // {
    //     $categories = Category::all();
    //     DB::table('categories')->where('id', $id)->update();
    //     return $id;
    // }

    
}
