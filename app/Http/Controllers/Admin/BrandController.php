<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BrandController extends Controller
{

    public function add_brand()
    {
        View::share('title', 'Add Brand');
        return view('admin.brand_action');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|string|max:150|unique:brands',
            'slug' => 'required|string|max:150|unique:brands',
            'brand_image' => 'sometimes|image|mimes:jpg,jpeg,png|min:20|max:5120',
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
            ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {

            if ($request->hasFile('brand_image')) {
                $imageuploaded = request()->file('brand_image');
                $imagename = time() . '.' . $imageuploaded->getClientOriginalExtension();
                $imagepath = public_path('/uploads/brands/');
                $imageuploaded->move($imagepath, $imagename);

                /*if ($university->image !== NULL) {
                    unlink(public_path($university->image));
                }*/

//                $image = URL::to('/uploads/brands/' . $imagename);
            }

            $brand = new Brand();
            $brand->brand_name = $request->brand_name;
            $brand->slug = $request->slug;
            $brand->brand_image = $imagename;
            $brand->save();
            session()->flash('success', 'Brand saved successfully');
            return redirect(url('/admin/dashboard'));
        } catch (Exception $e) {
            $error = 'Opps! something goes wrong. Please try later';
            return redirect()->back()->with('error', $error)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
