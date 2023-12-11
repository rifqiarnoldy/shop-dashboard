@extends('layouts.app')

@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Register</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="category.html">Register</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Login Box Area =================-->
<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="{{ asset('assets/img/login.jpg') }}" alt="" />
                    <div class="hover">
                        <h4>Log in to enter</h4>
                        <p>
                            There are advances being made in science and technology
                            everyday, and a good example of this is the
                        </p>
                        <a class="primary-btn" href="/login">Log in</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">

                <div class="login_form_inner">
                    <h3>Regiter to our website</h3>
                    <form class="row login_form" action="/register" method="post" id="contactForm"
                        novalidate="novalidate">
                        @csrf
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Fullname"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Fullname'" />
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" />
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" onfocus="this.placeholder = ''"
                                onblur="this.placeholder = 'Password'" />
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Password Confirmation"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password Confirmation'" />
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" value="submit" class="primary-btn">
                                Sign Up
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Login Box Area =================-->
@endsection