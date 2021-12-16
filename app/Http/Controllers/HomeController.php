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
        $categories = Category::all();
        $brands = Brand::all();
        $products = Products::where('is_featured',1)->get('*');
        return view('frontend.home',compact('categories','brands','products'));
    }
}
