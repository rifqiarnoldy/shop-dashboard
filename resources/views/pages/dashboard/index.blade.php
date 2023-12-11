@extends('layouts.app')

@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Dashboard</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.html">Dashboard<span class="lnr lnr-arrow-right"></span></a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->


<!--================Blog Area =================-->
<section class="blog_area mt-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-3">
                <x-sidebar active="dashboard" />
            </div>
            <div class="col-lg-9">
                <div class="blog_left_sidebar">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Card</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <th scope="col">#</th>
                                    <th scope="col">Col 1</th>
                                </thead>
                                <tbody>
                                    <th scope="row">1</th>
                                    <td>Satu</td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================Blog Area =================-->
@endsection