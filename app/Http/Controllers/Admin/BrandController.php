<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BrandController extends Controller
{

    public function add_brand()
    {
        View::share('title', 'Add Brand');
        $brand = Brand::paginate(5);
        return view('admin.brand_action', compact('brand'));
    }

    public function edit_brand($id)
    {
        // dd($id);
        View::share('title', 'Edit Brand');
        $brand = Brand::paginate(5);
        $edit_brand = Brand::find($id);  
                   
        return view('admin.brand_action',compact('brand','edit_brand','id'));
    }

    public function store(Request $request, $id = 0)
    {
        // dd($id);
        if ($id > 0) {
            $validator = Validator::make(
                $request->all(),
                [
                    'brand_name' => 'required|string|max:150|unique:brands,brand_name,'.$id,
                    'slug' => 'required|string|max:150|unique:brands,slug,'.$id,
                    'brand_image' => 'sometimes|image|mimes:jpg,jpeg,png|min:1|max:5120',
                ],
                [
                    'brand_name.required' => 'Brand name is required',
                    'brand_name.string' => 'Enter valid brand name',
                    'brand_name.max' => 'Brand name must be of maximum 150 characters',
                    'slug.required' => 'Brand URL is required',
                    'slug.string' => 'Enter valid brand URL',
                    'slug.max' => 'Brand URL must be of maximum 150 characters',
                    'brand_image.image' => 'Brand Image must be a valid image',
                    'brand_image.mimes' => 'Brand Image must be either of jpg, jpeg, png format'
                ]
            );
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'brand_name' => 'required|string|max:150|unique:brands',
                    'slug' => 'required|string|max:150|unique:brands',
                    'brand_image' => 'sometimes|image|mimes:jpg,jpeg,png|min:1|max:5120',
                ],
                [
                    'brand_name.required' => 'Brand name is required',
                    'brand_name.string' => 'Enter valid brand name',
                    'brand_name.max' => 'Brand name must be of maximum 150 characters',
                    'slug.required' => 'Brand URL is required',
                    'slug.string' => 'Enter valid brand URL',
                    'slug.max' => 'Brand URL must be of maximum 150 characters',
                    'brand_image.image' => 'Brand Image must be a valid image',
                    'brand_image.mimes' => 'Brand Image must be either of jpg, jpeg, png format'
                ]
            );
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            if($id>0){
                $brand = Brand::find($id);
                $imagename=$brand->brand_image;
            }else{
                $brand = new Brand();
            }

            if ($request->hasFile('brand_image')) {
                $imageuploaded = request()->file('brand_image');
                $imagename = time() . '.' . $imageuploaded->getClientOriginalExtension();
                $imagepath = public_path('/uploads/brands/');
                $imageuploaded->move($imagepath, $imagename);
            }

            $brand->brand_name = $request->brand_name;
            $brand->slug = $request->slug;
            $brand->brand_image = $imagename;
            $brand->save();
            session()->flash('success', 'Brand saved successfully');
            return redirect(url('/admin/add_brand'));
        } catch (Exception $e) {
            $error = 'Opps! something goes wrong. Please try later';
            return redirect()->back()->with('error', $error)->withInput();
        }
    }


    function delete_brand($id){
        $res = Brand::destroy($id);
        if($res>0){
            session()->flash('success','Brand deleted successfully');
            return redirect(url('/admin/add_brand'));
        }else{
            session()->flash('error','Opps! something goes wrong. Please try later');
            return redirect(url('/admin/add_brand'));
        }
    }
}
