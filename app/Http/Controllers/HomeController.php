<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

        $all_categories = Category::where('parent_category',0)->get(['category_name','slug']);

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
        $Featproducts = Products::where('is_featured',1)->get('*');

        View::share('title', (isset($categoryProds[0]) && !empty($categoryProds[0])?$categoryProds[0]->category_name:'Category'));
        return view('frontend.shop-grid',compact('all_categories','categories','categoryProds','SubcategoryProds','Featproducts'));
    }

    public function shop()
    {
        View::share('title', 'Shop');
        $categories = Category::where('parent_category',0)->get(['category_name','slug']);
        $subcategories = Category::join('categories as ct1', 'categories.id', '=', 'ct1.parent_category')
            ->select('ct1.id as sub_cat_id','ct1.category_name as sub_cat_name','ct1.slug as sub_cat_slug', 'categories.category_name', 'categories.id as category_id')->get();
        $products = Products::all();
        return view('frontend.shop-grid1',compact('categories','subcategories','products'));        
    }

    public function shopDetails()
    {
        View::share('title', 'Shop');
        $categories = Category::where('parent_category',0)->get(['category_name','slug']);
        
        return view('frontend.shop-details',compact('categories'));        
    }


    function productDetails($slug){

        $prod_brd = Products::join('brands','products.brand_id','=','brands.id')
        ->where('products.slug',$slug)->get(['brands.brand_name']);
        $categories = Category::where('parent_category',0)->get(['category_name','slug']);
        $productArr = Products::join('categories as ct', 'products.category_id', '=', 'ct.id')
            ->join('brands as br','products.brand_id','=','br.id')
            ->where('products.slug',$slug)->get(['products.*','ct.id as category_id','ct.category_name','ct.parent_category','ct.slug as category_slug','ct.levels','br.brand_name','br.slug as brand_slug','br.brand_image']);
        $product = $productArr[0];
        if(isset($productArr[0]) && !empty($productArr[0]) && $productArr[0]->levels>1){
            $subcategories = Category::where('id', $productArr[0]->parent_category)->get(['category_name as parent_category_name','slug as parent_category_slug']);
            $product['parent_category_name'] = $subcategories[0]->parent_category_name;
            $product->parent_category_slug = $subcategories[0]->parent_category_slug;
        }
        View::share('title', (isset($product->product_name) && !empty($product->product_name)?$product->product_name:'Product details'));
        return view('frontend.shop-details',compact('prod_brd','product','categories'));
    }

    function subcategories(Request $request){
        $validator = Validator::make($request->all(),[
            'category_id' => 'required|numeric|integer|min:1',
        ],
            [
                'category_id.required'=>'Select a category',
                'category_id.numeric'=>'Select a valid category',
                'category_id.integer'=>'Select a valid category',
                'category_id.min'=>'Select a valid category',
            ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors(),'code'=>400]);
        }else{
            $cateories = Category::where('parent_category',$request->category_id)->get();
            return response()->json(['data'=>$cateories,'code'=>200]);
        }
    }

    function add_to_cart(Request $request){
        $validator = Validator::make($request->all(),[
            'product_id' => 'required|numeric|integer|min:1',
            'user_id' => 'required|numeric|integer|min:1',
            'quantity' => 'required|numeric|integer|min:1',
        ],
            [
                'product_id.required'=>'Choose a product',
                'product_id.numeric'=>'Choose a valid product',
                'product_id.integer'=>'Choose a valid product',
                'product_id.min'=>'Choose a valid product',
                'quantity.required'=>'Provide a valid quantity',
                'quantity.numeric'=>'Provide a valid quantity',
                'quantity.integer'=>'Provide a valid quantity',
                'quantity.min'=>'Provide a valid quantity',
            ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors(),'code'=>400]);
        }else{
            $cart = new Cart();
            $cart->product_id = $request->product_id;
            $cart->user_id = $request->user_id;
            $cart->quantity = $request->quantity;
            $cart->save();
            $cartData = Cart::find($cart->id);
            return response()->json(['data'=>$cartData,'code'=>200]);
        }
    }
    function removeCartItem(Request $request){
        $validator = Validator::make($request->all(),[
            'cart_id' => 'required|numeric|integer|min:1'
        ],
            [
                'cart_id.required'=>'Invalid request',
                'cart_id.numeric'=>'Invalid request',
                'cart_id.integer'=>'Invalid request',
                'cart_id.min'=>'Invalid request'
            ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors(),'code'=>400]);
        }else{
            Cart::destroy($request->cart_id);
            return response()->json(['data'=>'Product successfully removed from the cart','code'=>200]);
        }
    }
    function myCart(){
        View::share('title', 'My Cart');
        $total = 0;
        $categories = Category::where('parent_category',0)->get(['category_name','slug']);
        $productArr = Cart::join('products as pd', 'carts.product_id', '=', 'pd.id')
            ->join('brands as br','pd.brand_id','=','br.id')
            ->where('carts.user_id',2)->get(['pd.*','br.brand_name','carts.quantity','carts.id as cart_id']);
        /*$subcategories = Category::join('categories as ct1', 'categories.id', '=', 'ct1.parent_category')
            ->select('ct1.id as sub_cat_id','ct1.category_name as sub_cat_name','ct1.slug as sub_cat_slug', 'categories.category_name', 'categories.id as category_id')->get();*/
//        $products = Products::all();
        return view('frontend.cart',compact('categories','productArr','total'));
    }
}
