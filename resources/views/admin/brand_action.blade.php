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
        @if(session('success'))
        <div class="alert alert-success">
            <p class="m-auto">{{ session('success') }}</p>
        </div>
        @endif
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
                                    <td>{{(!isset($_GET['page']) || $_GET['page'] == 1?$key+1:(($_GET['page']-1)*5)+($key+1))}}</td>
                                    <td><img src="/uploads/brands/{{$brd->brand_image}}" style="width:80px; height:80px">
                                    </td>
                                    <td>{{$brd->brand_name}}</td>
                                    <td>{{$brd->slug}}</td>
                                    <td>
                                        <div class="btn btn-group">
                                            <a class="btn btn-primary" href="/admin/edit_brand/{{$brd->id}}" title="edit"><i class="fas fa-pen"></i></a>
                                            <a class="btn btn-danger" href="javascript:void(0)"
                                                   onclick="deleteCategoryConfirmation('/admin/delete_brand/{{$brd->id}}')" title="delete"><i class="fas fa-trash"></i></a>
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
                        {{$brand->links()}}
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- small box -->
                <div class="card card-primary">

                    <!-- /.card-header -->
                    <!-- form start -->
                    @if($title=='Add Brand')
                    <div class="card-header">
                        <h3 class="card-title">Add Brand</h3>
                    </div>
                    <form method="post" action="{{route('brand.store',array('id'=>0))}}" enctype="multipart/form-data">
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
                                <input type="text" class="form-control @error('brand_name') invalidInput @enderror" value="{{old('brand_name')}}" name="brand_name" id="brand_name" placeholder="Enter brand name">
                                @error('brand_name')
                                <p class="text-danger">
                                    {{ $errors->first('brand_name') }}
                                </p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control @error('slug') invalidInput @enderror" value="{{old('slug')}}" name="slug" id="slug" placeholder="Slug">
                                @error('slug')
                                <p class="text-danger">
                                    {{ $errors->first('slug') }}
                                </p>
                                @enderror
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
                    @else
                    <div class="card-header">
                        <h3 class="card-title">Edit Brand</h3>
                    </div>
                    <form method="post" action="{{route('brand.store',array('id'=>$id))}}" enctype="multipart/form-data">
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
                                <input type="text" class="form-control" value="{{$edit_brand->brand_name}}" name="brand_name" id="brand_name" placeholder="Enter brand name">
                                @error('brand_name')
                                <p class="text-danger">
                                    {{ $errors->first('brand_name') }}
                                </p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" value="{{$edit_brand->slug}}" name="slug" id="slug" placeholder="Slug">
                                @error('slug')
                                <p class="text-danger">
                                    {{ $errors->first('slug') }}
                                </p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="brand_image">Brand Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="brand_image" value="{{$edit_brand->brand_image}}" class="custom-file-input" id="brand_image">
                                        <label class="custom-file-label" for="brand_image">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <img src="/uploads/brands/{{$edit_brand->brand_image}}" style="width:80px; height:80px" />
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    @endif
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<div class="modal fade show" id="modal-default" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to delete this brand?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <div class="btn btn-group">
                        <button type="button" data-dismiss="modal" class="btn btn-primary">No</button>
                        <a id="delUrl" href="" class="btn btn-danger">Yes</a>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('scripts')

<script src="{{URL::asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>
<script>
        function deleteCategoryConfirmation(urlval) {
            $('#delUrl').attr('href', urlval);
            $('#modal-default').modal('show');
        }
    </script>
@endsection