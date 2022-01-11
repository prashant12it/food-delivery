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
                        @forelse($all_categories as $allcat)
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
                        <a href="./index.html">Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">
                    <div class="sidebar__item">
                        <h4>Sub Categories</h4>
                        <ul>
                            @forelse($categories as $category)
                            <li><a href="{{url('category/'.$category->sub_cat_slug)}}">{{$category->sub_cat_name}}</a></li>
                            @empty
                            <li><a href="#">Opps! No Categories found</a></li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="sidebar__item">
                        <div class="latest-product__text">
                            <h4>Featured Product</h4>
                            <div class="latest-product__slider owl-carousel">
                                <div class="latest-prdouct__slider__item">
                                    @forelse($Featproducts as $feat)
                                    @php
                                    $FeatimageArr = explode(',',$feat->images);
                                    @endphp
                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic col-lg-6">
                                            <img style="height: auto; width: 200px" src="{{URL::asset('uploads/products/'.$FeatimageArr[0])}}" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>{{$feat->product_name}}</h6>
                                            <span>INR {{$feat->price}}</span>
                                        </div>
                                    </a>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-7">
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                    <span>Sort By</span>
                                    <select>
                                        <option value="0">Default</option>
                                        <option value="0">Default</option>
                                    </select>
                                </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                    <h6><span>16</span> Products found</h6>
                                </div>
                        </div>
                        <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                    <span class="icon_grid-2x2"></span>
                                    <span class="icon_ul"></span>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @forelse($categoryProds as $product)
                    @php
                    $imageArr = explode(',',$product->images);
                    @endphp
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{URL::asset('uploads/products/'.$imageArr[0])}}">
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="javascript:void(0)" onclick="add_to_cart({{$product->id}},1)"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{url('product/'.$product->slug)}}">{{$product->product_name}}</a></h6>
                                <h5>INR {{$product->price}}</h5>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                    @forelse($SubcategoryProds as $sproduct)
                    @php
                    $simageArr = explode(',',$sproduct->images);
                    @endphp
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{URL::asset('uploads/products/'.$simageArr[0])}}">
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="javascript:void(0)" onclick="add_to_cart({{$product->id}},1)"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{url('product/'.$sproduct->slug)}}">{{$sproduct->product_name}}</a></h6>
                                <h5>INR {{$sproduct->price}}</h5>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
                <div class="product__pagination">
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#"><i class="fa fa-long-arrow-right"></i></a>
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