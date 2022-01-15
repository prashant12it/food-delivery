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
                    <h1 class="m-0">Order #{{$id}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Order Details</li>
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
                            <h3 class="card-title">Order Details</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Order ID</th>
                                    <td>#{{$data['id']}}</td>
                                </tr>
                                <tr>
                                    <th>Customer Name</th>
                                    <td>{{$data['name']}}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{$data['email']}}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{$data['phone']}}</td>
                                </tr>
                                <tr>
                                    <th>Street Address</th>
                                    <td>{{$data['address1']}}</td>
                                </tr>
                                <tr>
                                    <th>Locality</th>
                                    <td>{{(isset($data['address2']) && !empty($data['address2'])?$data['address2']:'')}}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{$data['city']}}</td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td>{{$data['state']}}</td>
                                </tr>
                                <tr>
                                    <th>Zipcode</th>
                                    <td>{{$data['zipcode']}}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{$data['country']}}</td>
                                </tr>
                                <tr>
                                    <th>Transaction ID</th>
                                    <td>{{$data['transaction_id']}}</td>
                                </tr>
                                <tr>
                                    <th>Total Price</th>
                                    <td>INR {{$data['total_price']}}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{date('d M Y',strtotime($data['updated_at']))}}</td>
                                </tr>
                                <tr>
                                    <th>Notes</th>
                                    <td>{{$data['notes']}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Ordered Products</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price/Qty</th>
                                    <th>Total Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orderProducts as $key=>$prod)
                                <tr>
                                    <td>{{($key+1)}}</td>
                                    <td>{{$prod['product_name']}}</td>
                                    <td>{{$prod['quantity']}}</td>
                                    <td>INR {{$prod['price']}}</td>
                                    <td>INR {{$prod['quantity']*$prod['price']}}</td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No product found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
