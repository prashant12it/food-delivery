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
        $categories = Category::where('parent_category',0)->paginate(5);
        return view('admin.category_action',compact('categories'));

    }

    public function edit_category($id){
        View::share('title', 'Edit Category');
        $categories = Category::paginate(5);
        $edit_category = Category::find($id);               
        return view('admin.category_action',compact('categories','edit_category','id'));
    }

    public function add_subcategory($id){
        View::share('title', 'Add Category');
        $categories = Category::where('parent_category',$id)->paginate(5);
        $Parentcategory = Category::find($id);
        return view('admin.category_action',compact('categories','Parentcategory','id'));
    }

    public function store_category(Request $request,$id=0){

        if($id>0){
            $validator = Validator::make($request->all(),[
                'category_name' => 'required|string|max:150|unique:categories,category_name,'.$id,
                'slug' => 'required|string|max:100|unique:categories,slug,'.$id,
            ]);
        }else{
            $validator = Validator::make($request->all(),[
                'category_name' => 'required|string|max:150|unique:categories',
                'slug' => 'required|string|max:100|unique:categories',
            ]);
        }

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            if($id>0){
                $cateory = Category::find($id);
            }else{
                $cateory = new Category();
            }
            $cateory->category_name = $request->category_name;
            $cateory->slug = $request->slug;
            $cateory->parent_category = $request->parent_category;
            $cateory->levels = ($request->parent_category>0?2:1);

            $cateory->save();
            session()->flash('success','Category saved successfully');
            return redirect(url('/admin/add_category'));
        }catch(Exception $e){
            $error = 'Opps! something goes wrong. Please try later';
            return redirect()->back()->with('error',$error)->withInput();
        }
    }

    function delete_category($id){
        $res = Category::destroy($id);
        if($res>0){
            session()->flash('success','Category deleted successfully');
            return redirect(url('/admin/add_category'));
        }else{
            session()->flash('error','Opps! something goes wrong. Please try later');
            return redirect(url('/admin/add_category'));
        }
    }

    
}
