<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Stripe\Charge;
use Stripe\Stripe;

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
            $cartArr = Cart::where(['user_id'=>session('user_id'),'product_id'=>$request->product_id])->get('id');
            if(!empty($cartArr) && isset($cartArr[0]->id) && $cartArr[0]->id>0){
                $cart = Cart::find($cartArr[0]->id);
                /*$cart->product_id = $request->product_id;
                $cart->user_id = session('user_id');*/
                $cart->quantity = ($cart->quantity)+($request->quantity);
            }else{
                $cart = new Cart();
                $cart->product_id = $request->product_id;
                $cart->user_id = session('user_id');
                $cart->quantity = $request->quantity;
            }
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
    function update_cart(Request $request){
        $validator = Validator::make($request->all(),[
            'cart_id' => 'required|numeric|integer|min:1',
            'product_id' => 'required|numeric|integer|min:1',
            'quantity' => 'required|numeric|integer|min:1'
        ],
            [
                'cart_id.required'=>'Invalid request',
                'cart_id.numeric'=>'Invalid request',
                'cart_id.integer'=>'Invalid request',
                'cart_id.min'=>'Invalid request',
                'product_id.required'=>'Invalid request',
                'product_id.numeric'=>'Invalid request',
                'product_id.integer'=>'Invalid request',
                'product_id.min'=>'Invalid request',
                'quantity.required'=>'Invalid quantity',
                'quantity.numeric'=>'Invalid quantity',
                'quantity.integer'=>'Invalid quantity',
                'quantity.min'=>'Invalid quantity'
            ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors(),'code'=>400]);
        }else{
            Cart::where(['id'=>$request->cart_id,'product_id'=>$request->product_id])->update(['quantity'=>$request->quantity]);
            return response()->json(['message'=>'Cart updated successfully','code'=>200]);
        }
    }

    public function checkout()
    {
        View::share('title', 'Checkout');
        $categories = Category::where('parent_category',0)->get(['category_name','slug']);
        $productArr = Cart::join('products as pd', 'carts.product_id', '=', 'pd.id')
            ->where('carts.user_id',session('user_id'))->get(['pd.*','carts.quantity','carts.id as cart_id']);
        return view('frontend.cart-checkout',compact('categories','productArr'));
    }


    function myCart(){
        View::share('title', 'My Cart');
        $total = 0;
        $categories = Category::where('parent_category',0)->get(['category_name','slug']);
        $productArr = Cart::join('products as pd', 'carts.product_id', '=', 'pd.id')
            ->join('brands as br','pd.brand_id','=','br.id')
            ->where('carts.user_id',session('user_id'))->get(['pd.*','br.brand_name','carts.quantity','carts.id as cart_id']);
        /*$subcategories = Category::join('categories as ct1', 'categories.id', '=', 'ct1.parent_category')
            ->select('ct1.id as sub_cat_id','ct1.category_name as sub_cat_name','ct1.slug as sub_cat_slug', 'categories.category_name', 'categories.id as category_id')->get();*/
//        $products = Products::all();
        return view('frontend.cart',compact('categories','productArr','total'));
    }

    function logout(){
        Session::flush();
        return redirect(url('/'));
    }

    function place_order(Request $request){
        $input = $request->all();
        $validator = Validator::make($request->all(),[
            'fname' => 'required|string|max:150',
            'lname' => 'string|max:150',
            'address1' => 'required|string|max:255',
            'address2' => 'string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'phone' => 'required|string|max:10',
            'zipcode' => 'required|string|max:10',
            'notes' => 'string|max:500'
        ],
            [
                'fname.required'=>'First name required',
                'fname.string'=>'Enter valid first name',
                'fname.max'=>'Enter valid first name',
                'lname.string'=>'Enter valid last name',
                'lname.max'=>'Enter valid last name',
                'address1.required'=>'Street address required',
                'address1.string'=>'Enter valid street address',
                'address1.max'=>'Enter valid street address',
                'address2.string'=>'Enter valid Apartment, suite, locality',
                'address2.max'=>'Enter valid Apartment, suite, locality',
                'city.required'=>'City required',
                'city.string'=>'Enter valid city',
                'city.max'=>'Enter valid city',
                'state.required'=>'State  required',
                'state.string'=>'Enter valid state',
                'state.max'=>'Enter valid state',
                'country.required'=>'Country required',
                'country.string'=>'Enter valid country',
                'country.max'=>'Enter valid country',
                'phone.required'=>'Phone number required',
                'phone.string'=>'Enter valid phone number',
                'phone.max'=>'Enter valid phone number',
                'zipcode.required'=>'Zipcode required',
                'zipcode.string'=>'Enter valid zipcode',
                'zipcode.max'=>'Enter valid zipcode',
                'notes.string'=>'Enter valid notes',
                'notes.max'=>'Enter valid notes',
            ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            View::share('title', 'Payment');
            $categories = Category::where('parent_category',0)->get(['category_name','slug']);
            $productArr = Cart::join('products as pd', 'carts.product_id', '=', 'pd.id')
                ->join('brands as br','pd.brand_id','=','br.id')
                ->where('carts.user_id',session('user_id'))->get(['pd.*','br.brand_name','carts.quantity','carts.id as cart_id']);

            $userID = session('user_id');

            $cartArr = Cart::join('products as pd','carts.product_id','pd.id')
                ->where(['carts.user_id'=>$userID])
                ->get(['carts.product_id','carts.quantity','pd.price']);
            $total = 0;
            if(!empty($cartArr) && !empty($cartArr[0]->product_id)){
                foreach ($cartArr as $cItem){
                    $total = $total + ($cItem->quantity*$cItem->price);
                }
            }

            $order = new Order();
            $order->user_id = $userID;
            $order->name = $input['fname'].(!empty($input['lname'])?' '.$input['lname']:'');
            $order->address1 = $input['address1'];
            $order->address2 = $input['address2'];
            $order->city = $input['city'];
            $order->state = $input['state'];
            $order->zipcode = $input['zipcode'];
            $order->country = $input['country'];
            $order->phone = $input['phone'];
            $order->notes = $input['notes'];
            $order->total_price = $total;
            $order->save();
            $orderID = $order->id;

            if($orderID>0){
                foreach ($cartArr as $cItem){
                    $orderProducts = new OrderProducts();
                    $orderProducts->order_id = $orderID;
                    $orderProducts->product_id = $cItem->product_id;
                    $orderProducts->quantity = $cItem->quantity;
                    $orderProducts->price = $cItem->price;
                    $orderProducts->save();
                }
            }
            return view('frontend.payment',compact('categories','productArr','order'));
        }
    }
    public function payment(Request $request)
    {
        $orderDet = Order::find($request->order_id);
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $res = Charge::create ([
            "amount" => $orderDet->total_price * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "This payment is from food delivery"
        ]);
        if(!empty($res) && isset($res->status) && $res->status == 'succeeded'){
            $orderDet->transaction_id = $res->balance_transaction;
            $orderDet->status = 1;
        }else{
            $orderDet->status = 4;
        }
        $orderDet->save();
        Cart::where('user_id',session('user_id'))->delete();
        Session::put('order_id',$orderDet->id);
        Session::flash('success', 'Payment successful!');

        return redirect(url('/thanks'));
    }
    function thanks()
    {
        View::share('title', 'Thanks');
        $data = Order::join('order_products as op','orders.id','op.order_id')
            ->join('products as pd','op.product_id','pd.id')
            ->where(['orders.id'=>session('order_id')])
            ->get(['op.quantity','op.price','pd.product_name']);
        $orderDet = Order::find(session('order_id'));
        /*$data = DB::table('products')
            ->join('order_products','products.id','=','order_products.product_id')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->where('orders.user_id', $userID)
            ->get(['products.product_name','products.price']);*/
        return view('frontend.thanks',compact('data','orderDet'));
    }
}
