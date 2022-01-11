@extends('layouts.frontend')
@section('title')
{{$title}}
@endsection
@section('content')
<!-- Hero Section Begin -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All departments</span>
                    </div>
                    <ul>
                        @forelse($categories as $allcat)
                        <li><a href="{{url('category/'.$allcat->slug)}}">{{$allcat->category_name}}</a></li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                All Categories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="What do yo u need?">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+65 11.188.888</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{URL::asset('frontend/img/breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Organi Shop</h2>
                    <div class="breadcrumb__option">
                        <a href="{{url('/')}}">Home</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                        <tr>
                            <th class="shoping__product">Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($productArr as $key => $product)
                            @php
                                $total = $total + ($product->quantity * $product->price);
                                    if(!empty($product->images)){
                                        $imageArr = explode(',',$product->images);
                                    }
                            @endphp
                        <tr>
                            <td class="shoping__cart__item">
                                <img width="100" src="{{URL::asset('uploads/products/'.$imageArr[0])}}" alt="">
                                <h5>{{$product->product_name}}</h5>
                            </td>
                            <td class="shoping__cart__price">
                                INR {{$product->price}}
                            </td>
                            <td class="shoping__cart__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <span class="dec qtybtn" onclick="decQuantity({{$product->id}},{{$product->cart_id}})">-</span>
                                        <input  id="quantity{{$product->cart_id}}" type="text" value="{{$product->quantity}}">
                                        <span class="inc qtybtn" onclick="incQuantity({{$product->id}},{{$product->cart_id}})">+</span>
                                    </div>
                                </div>
                            </td>
                            <td class="shoping__cart__total">
                                INR {{$product->quantity * $product->price}}
                            </td>
                            <td class="shoping__cart__item__close">
                                <span onclick="removeCartItem({{$product->cart_id}})" class="icon_close"></span>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td class="shoping__cart__item" colspan="5">
                                    Your cart is empty. Add some products in your cart.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                    <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                        Upadate Cart</a>
                </div>
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <li>Subtotal <span>INR {{$total}}</span></li>
                        <li>Total <span>INR {{$total}}</span></li>
                    </ul>
                    <a href="/cart-checkout" class="primary-btn">PROCEED TO CHECKOUT</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Section End -->

@endsection
@section('scripts')
<script src="{{URL::asset('js/customfn.js')}}"></script>
@endsection
