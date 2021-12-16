@extends('layouts.admin')
@section('title')
    {{$title}}
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Brand</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Product</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Products List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Price</th>
{{--                                        <th>Quantity</th>--}}
                                        <th>Featured</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($products as $key=>$data)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td><a href="{{url('product/'.$data->slug)}}"> {{$data->product_name}}</a></td>
                                            @php
                                                if(!empty($data->images)){
                                                $imageArr = explode(',',$data->images);

                                                }
                                            @endphp
                                            <td><img src="/uploads/products/{{$imageArr[0]}}" style="width:80px; height:80px"></td>
                                            <td>INR {{$data->price}}</td>
{{--                                            <td>{{$data->quantity}}</td>--}}
                                            <td>{{($data->is_featured == 1?'Yes':'No')}}</td>
                                            <td>
                                                <div class="btn btn-group">
                                                    <a class="btn btn-primary" href="/admin/edit_product/{{$data->id}}"
                                                       title="edit"><i class="fas fa-pen"></i></a>
                                                    <a class="btn btn-danger" href="/admin/delete_product/{{$data->id}}"
                                                       title="delete"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">No product found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- small box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Product</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach($errors->all() as $err)
                                            <p class="m-auto">{{ $err    }}</p>
                                        @endforeach
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        <p class="m-auto">{{ session('error') }}</p>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" id="product_name"
                                           placeholder="Enter product name">
                                </div>
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug">
                                </div>
                                <div class="form-group">
                                    <label for="product_images">Product Images</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="product_images[]" multiple
                                                   class="custom-file-input" id="product_images">
                                            <label class="custom-file-label" for="product_images">Choose files</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control" name="category_id" id="category_id">
                                        <option>Select Category</option>
                                        @forelse($categories as $key=>$cat)
                                            <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="brand_id">Brand</label>
                                    <select class="form-control" name="brand_id" id="brand_id">
                                        <option>Select Brand</option>
                                        @forelse($brands as $key=>$brd)
                                            <option value="{{$brd->id}}">{{$brd->brand_name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Available Quantity</label>
                                    <input type="number" class="form-control" min="0" max="99999" step="1" name="quantity" id="quantity" placeholder="Enter available product quantity">
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="tel" class="form-control" name="price" id="price" placeholder="Enter product price">
                                </div>
                                <div class="form-group">
                                    <label for="description">Product Description</label>
                                    <textarea maxlength="1000" class="form-control" name="description" id="description" placeholder="Enter product description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="discount">Discount</label>
                                    <input type="tel" class="form-control" name="discount" id="discount" placeholder="Enter discount">
                                </div>
                                <div class="form-group">
                                    <label for="discount">Featured Product</label>
                                    <div class="form-check">
                                        <input name="is_featured" class="form-check-input" value="1" type="radio" id="is_featured1">
                                        <label class="form-check-label" for="is_featured1">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="0" name="is_featured" id="is_featured2" checked="">
                                        <label class="form-check-label" for="is_featured2">No</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="upsell_products">Upsell Products</label>
                                    <select multiple="" class="custom-select" name="upsell_products" id="upsell_products">
                                        @forelse($products as $key=>$prd)
                                            <option value="{{$prd->id}}">{{$prd->product_name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')

    <script src="{{URL::asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection
