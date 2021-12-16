<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Products;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ProductController extends Controller
{
    public function add_product(){
        View::share('title', 'Add Product');
        $products = Products::paginate(5);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product_action',compact('products','categories','brands'));
    }

    public function edit_product($id){
        View::share('title', 'Edit Product');
        $products = Products::paginate(5);
        $edit_product = Products::find($id);
        return view('admin.product_action',compact('products','edit_product','id'));
    }

    public function store(Request $request,$id=0){
        if($id>0){
            $validator = Validator::make($request->all(),[
                'product_name' => 'required|string|max:255|unique:categories,category_name,'.$id,
                'slug' => 'required|string|max:100|unique:categories,slug,'.$id,
            ]);
        }else{
            $validator = Validator::make($request->all(),[
                'product_name' => 'required|string|max:255|unique:products',
                'slug' => 'required|string|max:191|unique:products',
                'category_id' => 'required|numeric',
                'brand_id' => 'nullable|numeric',
                'description' => 'nullable|string|max:1000',
                'price' => 'required|numeric|max:999999.99',
                'quantity' => 'required|numeric|max:9999',
                'discount' => 'nullable|numeric|max:999999.99',
                'upsell_products' => 'nullable|string|max:255',
            ]);
        }

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            if($id>0){
                $product = Products::find($id);
                $discount = (!empty($request->discount)?$request->discount:(!empty($product->discount)?$product->discount:0));
            }else{
                $product = new Products();
                $discount = (!empty($request->discount)?$request->discount:0);
            }
            if(!empty($request->product_images)){
                $uploadedImages = '';
                foreach ($request->product_images as $key => $pimage){
                    $imagename = time() .$key. '.' . $pimage->getClientOriginalExtension();
                    $imagepath = public_path('/uploads/products/');
                    $pimage->move($imagepath, $imagename);
                    $uploadedImages .= ($key == 0?$imagename:','.$imagename);
                }
            }

            $product->product_name = $request->product_name;
            $product->slug = $request->slug;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->discount = $discount;
            $product->upsell_products = $request->upsell_products;
            $product->is_featured = $request->is_featured;
            $product->images = $uploadedImages;

            $product->save();
            session()->flash('success','Products saved successfully');
            return redirect(url('/admin/add_product'));
        }catch(Exception $e){
            $error = 'Opps! something goes wrong. Please try later';
            return redirect()->back()->with('error',$e->getMessage())->withInput();
        }
    }

    function delete_product($id){
        $res = Products::destroy($id);
        if($res>0){
            session()->flash('success','Products deleted successfully');
            return redirect(url('/admin/add_category'));
        }else{
            session()->flash('error','Opps! something goes wrong. Please try later');
            return redirect(url('/admin/add_products'));
        }
    }
}
