<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    public function add_category(){
        View::share('title', 'Add Category');
        return view('admin.category_action');
    }
    public function store_category(Request $request){
        $cateory = new Category();
        $cateory->category_name = $request->category_name;
        $cateory->slug = $request->slug;
        $cateory->parent_category = 0;
        $cateory->levels = 1;
        $cateory->save();
        return redirect(url('/admin/dashboard'));
    }
}
