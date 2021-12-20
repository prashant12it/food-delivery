<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    function index(){
        View::share('title', 'Home');
        $categories = Category::where('parent_category',0)->get(['category_name','slug']);
        $brands = Brand::all();
        $products = Products::where('is_featured',1)->get('*');
        return view('frontend.home',compact('categories','brands','products'));
    }

    function categories($slug){
        $categories = Category::join('categories as ct1', 'categories.id', '=', 'ct1.parent_category')
            ->where('categories.slug',$slug)
            ->select('ct1.id as sub_cat_id','ct1.category_name as sub_cat_name','ct1.slug as sub_cat_slug', 'categories.category_name', 'categories.id as category_id')->get();
        dd($categories[0]);

    }

    public function shop()
    {
        return view('frontend.shop-grid');
    }
}
