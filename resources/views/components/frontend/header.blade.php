<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="{{URL::asset('frontend/img/logo.png')}}" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
        </ul>
        <div class="header__cart__price">item: <span>$150.00</span></div>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__language">
            <img src="{{URL::asset('frontend/img/language.png')}}" alt="">
            <div>English</div>
            <span class="arrow_carrot-down"></span>
            <ul>
                <li><a href="#">Spanis</a></li>
                <li><a href="#">English</a></li>
            </ul>
        </div>
        <div class="header__top__right__auth">
            <a href="/login"><i class="fa fa-user"></i> Login</a>
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="/">Home</a></li>
            <li><a href="/shop-grid">Shop</a></li>
            <li><a href="#">Pages</a>
                <ul class="header__menu__dropdown">
                    <li><a href="/shop-details">Shop Details</a></li>
                    <li><a href="/shoping-cart">Shoping Cart</a></li>
                    <li><a href="/checkout">Check Out</a></li>
                    <li><a href="/blog-details">Blog Details</a></li>
                </ul>
            </li>
            <li><a href="/blog">Blog</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
            <li>Free Shipping for all Order of $99</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                            <li>Free Shipping for all Order of $99</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                        </div>
                        <div class="header__top__right__language">
                            <img src="{{URL::asset('frontend/img/language.png')}}" alt="">
                            <div>English</div>
                            <span class="arrow_carrot-down"></span>
                            <ul>
                                <li><a href="#">Spanis</a></li>
                                <li><a href="#">English</a></li>
                            </ul>
                        </div>
                        <div class="header__top__right__auth">
                            @if(session('user_id'))
                                <a class="" href="{{route('frontLogout')}}"><i class="fa fa-user"></i> Logout</a>
                            @else
                            <a rel="tooltip" href="javascript:void(0)" class="" onclick="login()" title="" data-toggle="modal" data-target="#loginModal">
                                <i class="fa fa-user"></i> Login</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="./index.html"><img src="{{URL::asset('frontend/img/logo.png')}}" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li class="active"><a href="/">Home</a></li>
                        <li><a href="/shop-grid">Shop</a></li>
                        <li><a href="#">Pages</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="/shop-details">Shop Details</a></li>
                                <li><a href="/shoping-cart">Shoping Cart</a></li>
                                <li><a href="/checkout">Check Out</a></li>
                                <li><a href="/blog-details">Blog Details</a></li>
                            </ul>
                        </li>
                        <li><a href="./blog.html">Blog</a></li>
                        <li><a href="./contact.html">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                        <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
                    </ul>
                    <div class="header__cart__price">item: <span>$150.00</span></div>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>

<!-- Login form start -->
<form method="post" action="/login">
    @csrf
    <div id="loginModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        @if(session('success'))
                <div class="alert alert-success">
                    <p class="m-auto">{{ session('success') }}</p>
                </div>
        @endif
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Login</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <div class="row">
                                <div class="form-check col-sm-5">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck2">Remember me</label>
                                </div>
                                <div class="form-check col-sm">
                                    <a rel="tooltip" href="javascript:void(0)" class="btn btn-link" onclick="" title="" data-toggle="modal" data-target="#forgotpwdModal">Forgot password?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="offset-4 col-sm-4">
                        <a rel="tooltip" href="javascript:void(0)" class="btn btn-link" onclick="signup()" title="" data-toggle="modal" data-target="#signupModal">Sign Up</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Sign In</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Login End -->

<!-- Signup form start -->
<form method="post" action="/store_user">
    @csrf
    <div id="signupModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        @if(session('success'))
                <div class="alert alert-success">
                    <p class="m-auto">{{ session('success') }}</p>
                </div>
        @endif
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sign up</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="inputname" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputname" placeholder="Name" name="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail2" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail2" placeholder="Email" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword4" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword4" placeholder="Confirm Password" name="cpassword">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                <label class="form-check-label" for="exampleCheck2">Remember me</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Signup End -->
