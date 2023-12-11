@extends('layouts.app')

@section('script')
<script>
    $(document).ready(function () {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        loadCategory();

        loadProduct();

        function loadCategory(){
            var url = "{{ env('APP_API_URL') }}";   
            $.ajax({
                url: url + '/api/category_product',
                type: 'get',
                dataType: 'json',
                success: function(response){
                    if (response.status == true) {
                        $.each(response.data, function(index, val) {
                            var li = "<li class='main-nav-list'><a href='#'><span class=''></span>"+val.name+"</a></li>"
                            $('.main-categories').append(li);
                        });
                    }
                },
                error: function(response){
                    alert(response.message);
                }
            });
        }

        function loadProduct() {
            var url = "{{ env('APP_API_URL') }}";
            var asset = "{{ asset('assets/img/product/') }}";
            $.ajax({
                url: url + '/api/product',
                type: 'get',
                dataType: 'json',
                success: function(response){
                    if (response.status == true) {
                        $.each(response.data, function(index, val){
                            var img = asset + '/' + JSON.parse(val.images)[0];
                            var col = "<div class='col-lg-4 col-md-6'><div class='single-product'><img src='"+img+"' height='256'/><div class='product-details'><h6><a href='/product/"+val.id+"' style='text-decoration: none; color: black;'>"+val.name+"</a></h6><div class='price'><h6>Rp. "+val.price+"</h6></div><div class='prd-bottom'><button style='all: unset;' type='button' id='"+val.id+"' class='social-info addCart'><span class='ti-bag'></span><p class='hover-text'>add to bag</p></button></div></div></div></div>";
                            $('#single-product').append(col);
                        });
                    }
                },
            });
        }

        $(document).on('click', '.addCart', function() {
            var user_id = "{{ auth()->user() ? auth()->user()->id : '' }}";
            var id = this.id;
            var url = "{{ env('APP_API_URL') }}";
            if (user_id == null || user_id == '') {
                window.location.href = '/login';
            }else{
                $.ajax({
                    url: url + '/api/add-cart',
                    type: 'post',
                    dataType: 'json',
                    data: {user_id:user_id, product_id:id},
                    success: function(response){
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        });
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            }
        });
    });
</script>
@endsection

@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shop page</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Shop<span class="lnr"></span></a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<div class="container mb-5 mt-5">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
            <div class="sidebar-categories">
                <div class="head">Browse Categories</div>
                <ul class="main-categories">
                </ul>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
            <!-- Start Filter Bar -->
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="sorting">
                    <h3 style="color: #fff">Our Products</h3>
                </div>
            </div>
            <!-- End Filter Bar -->
            <!-- Start Best Seller -->
            <section class="lattest-product-area pb-40 category-list">
                <div class="row" id="single-product">
                </div>
            </section>
            <!-- End Best Seller -->
        </div>
    </div>
</div>
@endsection