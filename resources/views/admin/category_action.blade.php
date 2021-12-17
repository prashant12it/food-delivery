@extends('layouts.admin')
@section('title')
    {{$title}}
@endsection
@section('css')
    <style>
        .invalidInput {
            border: 1px solid red
        }
    </style>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Category</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Category</li>
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
                            <h3 class="card-title">{{((isset($id) && $id>0?'Sub ':''))}}Category List</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($categories as $key=>$cat)
                                    <tr>
                                        <td>{{(!isset($_GET['page']) || $_GET['page'] == 1?$key+1:(($_GET['page']-1)*5)+($key+1))}}</td>
                                        <td>{{$cat->category_name}}</td>
                                        <td>{{$cat->slug}}</td>
                                        <td>
                                            <div class="btn btn-group">
                                                <a class="btn btn-warning" href="/admin/add_subcategory/{{$cat->id}}"
                                                   title="edit"><i class="fas fa-code-branch"></i></a>
                                                <a class="btn btn-primary" href="/admin/edit_category/{{$cat->id}}"
                                                   title="edit"><i class="fas fa-pen"></i></a>
                                                <a class="btn btn-danger" href="javascript:void(0)"
                                                   onclick="deleteCategoryConfirmation('/admin/delete_category/{{$cat->id}}')"
                                                   title="delete"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No category found</td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                            {{$categories->links()}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- small box -->
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if($title=='Add Category')
                            <div class="card-header">
                                <h3 class="card-title">Add {{((isset($id) && $id>0?'Sub':''))}} Category</h3>
                            </div>
                            <form method="post" action="{{route('category.store',array('id'=>0))}}">
                                @csrf
                                <div class="card-body">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach($errors->all() as $err)
                                                <p class="m-auto">{{ $err }}</p>
                                            @endforeach

                                        </div>
                                    @endif
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            <p class="m-auto">{{ session('error') }}</p>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="category_name">Category Name</label>
                                        <input type="text"
                                               class="form-control @error('category_name') invalidInput @enderror"
                                               value="{{old('category_name')}}" name="category_name" id="category_name"
                                               placeholder="Enter category">
                                        @error('category_name')
                                        <p class="text-danger">
                                            {{ $errors->first('category_name') }}
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" class="form-control @error('slug') invalidInput @enderror"
                                               value="{{old('slug')}}" name="slug" id="slug"
                                               placeholder="Enter category slug">
                                        @error('slug')
                                        <p class="text-danger">
                                            {{ $errors->first('slug') }}
                                        </p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <input type="hidden" name="parent_category" value="{{(isset($id) && $id>0?$id:0)}}" />
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        @else
                            <form method="post" action="{{route('category.store',array('id'=>$id))}}">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Category</h3>
                                </div>
                                @csrf
                                <div class="card-body">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach($errors->all() as $err)
                                                <p class="m-auto">{{ $err }}</p>
                                            @endforeach

                                        </div>
                                    @endif
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            <p class="m-auto">{{ session('error') }}</p>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="category_name">Category Name</label>
                                        <input type="text"
                                               class="form-control @error('category_name') invalidInput @enderror"
                                               value="{{$edit_category->category_name}}" name="category_name"
                                               id="category_name" placeholder="Enter category">
                                        @error('category_name')
                                        <p class="text-danger">
                                            {{ $errors->first('category_name') }}
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" class="form-control @error('slug') invalidInput @enderror"
                                               value="{{$edit_category->slug}}" name="slug" id="slug"
                                               placeholder="Enter category slug">
                                        @error('slug')
                                        <p class="text-danger">
                                            {{ $errors->first('slug') }}
                                        </p>
                                        @enderror
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
                    <p>Are you sure, you want to delete this category?</p>
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
    <script>
        function deleteCategoryConfirmation(urlval) {
            $('#delUrl').attr('href', urlval);
            $('#modal-default').modal('show');
        }
    </script>
@endsection
