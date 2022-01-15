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
                    <h1 class="m-0">Orders</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Orders List</li>
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
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Orders List</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">Order ID</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Price</th>
                                    <th>Phone</th>
                                    <th>Transaction ID</th>
                                    <th>Payment Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($data as $key=>$order)
                                    <tr>
                                        <td><a href="{{url('admin/order_details/'.$order->id)}}">#{{$order->id}}</a></td>
                                        <td>{{$order->name}}</td>
                                        <td>{{$order->email}}</td>
                                        <td>{{$order->total_price}}</td>
                                        <td>{{$order->phone}}</td>
                                        <td>{{$order->transaction_id}}</td>
                                        <td>{{date('d M Y',strtotime($order->updated_at))}}</td>
                                        <td>
                                            <select class="form-control" id="orderStatus{{$order->id}}" onchange="ChangeStatus({{$order->id}})">
                                                <option value="0" {{($order->status == 0?'selected':'')}}>Pending</option>
                                                <option value="1" {{($order->status == 1?'selected':'')}}>Paid</option>
                                                <option value="2" {{($order->status == 2?'selected':'')}}>Cancelled</option>
                                                <option value="3" {{($order->status == 3?'selected':'')}}>Delivered</option>
                                                <option value="4" {{($order->status == 4?'selected':'')}}>Dispute</option>
                                            </select>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">No order found</td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                            {{$data->links()}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
