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
                    <li class="breadcrumb-item active">Add Brand</li>
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
                        <h3 class="card-title">Brand List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Brand Image</th>
                                    <th>Brand Name</th>
                                    <th>Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($brand as $key=>$brd)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td><img src="/uploads/brands/{{$brd->brand_image}}" style="width:80px; height:80px">
                                    </td>
                                    <td>{{$brd->brand_name}}</td>
                                    <td>{{$brd->slug}}</td>
                                    <td>
                                        <div class="btn btn-group">
                                            <a class="btn btn-primary" href="/admin/edit_brand/{{$key+1}}" title="edit"><i class="fas fa-pen"></i></a>
                                            <a class="btn btn-danger" href="/admin/delete_brand/{{$key+1}}" title="delete"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">No brand found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- small box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Brand</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" action="{{route('brand.store')}}" enctype="multipart/form-data">
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
                                <label for="brand_name">Brand Name</label>
                                <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Enter category name">
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug">
                            </div>
                            <div class="form-group">
                                <label for="brand_image">Brand Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="brand_image" class="custom-file-input" id="brand_image">
                                        <label class="custom-file-label" for="brand_image">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
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
    $(function() {
        bsCustomFileInput.init();
    });
</script>
@endsection