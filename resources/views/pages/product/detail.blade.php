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
        $('#addCart').on('click', function (){
            var qty = $('#sst').val();
            var product_id = $(this).data('idproduct');
            var user_id = "{{ auth()->user() ? auth()->user()->id : '' }}";
            var url = "{{ env('APP_API_URL') }}";
            if (user_id == null || user_id == '') {
                window.location.href = '/login';
            }else{
                $.ajax({
                    url: url + '/api/add-cart',
                    type: 'post',
                    dataType: 'json',
                    data: {user_id:user_id, product_id:product_id, qty:qty},
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
                <h1>Product Details Page</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Shop<span class="lnr lnr-arrow-right"></span></a>
                    <a href="single-product.html">product-details</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Single Product Area =================-->
<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="s_Product_carousel">
                    @foreach (json_decode($product->images) as $item)
                    <div class="single-prd-item">
                        <img class="img-fluid" src="{{ asset('assets/img/product/' . $item) }}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3>{{ $product->name }}</h3>
                    <h2>Rp. {{ $product->price }}</h2>
                    <ul class="list">
                        <li><a class="active" href="#"><span>Category</span> : {{ $product->category_product->name
                                }}</a></li>
                        <li><a href="#"><span>Stock</span> : {{ $product->stock }}</a></li>
                    </ul>
                    <p>{{ $product->description }}</p>
                    <div class="product_count">
                        <label for="qty">Quantity:</label>
                        <input type="text" name="qty" id="sst" maxlength="{{ $product->stock }}" value="1"
                            title="Quantity:" class="input-text qty">
                        <button
                            onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) && result.value < {{ $product->stock }}) result.value++;return false;"
                            class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                        <button
                            onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;return false;"
                            class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                    </div>
                    <div class="card_area d-flex align-items-center">
                        <button type="button" class="primary-btn" id="addCart" data-idProduct="{{ $product->id }}">Add
                            to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--================End Single Product Area =================-->


<!--================Product Description Area =================-->
<section class="product_description_area">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">Description</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="false">Specification</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <p>{{ $product->description }}</p>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            @foreach (json_decode($product->spesification) as $key => $item)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $item }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Product Description Area =================-->
@endsection