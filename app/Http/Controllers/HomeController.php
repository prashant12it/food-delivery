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
        $categoryProds = Products::join('categories as ct','products.category_id','=','ct.id')
            ->where('ct.slug',$slug)
            ->select('products.*','ct.category_name')->get();
        $SubcategoryProds = array();
        if(isset($categories[0]) && !empty($categories[0])){
            $SubcategoryProds = Products::join('categories as ct','products.category_id','=','ct.id')
                ->where('ct.parent_category',$categories[0]->category_id)
                ->select('products.*','ct.category_name')->get();
        }

        View::share('title', (isset($categoryProds[0]) && !empty($categoryProds[0])?$categoryProds[0]->category_name:'Category'));
        View::share('tempval', 1);
        return view('frontend.home',compact('categories','categoryProds','SubcategoryProds'));
    }

    public function shop()
    {
        View::share('title', 'Shop');
        return view('frontend.shop-grid');
    }
}
