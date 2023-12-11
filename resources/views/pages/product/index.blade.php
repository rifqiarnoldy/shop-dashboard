@extends('layouts.app')

@section('script')
<script>
    $(document).ready(function () {
        var url = "{{ env('APP_API_URL') }}";
        loadProduct();

        function loadProduct() {
            var url = "{{ env('APP_API_URL') }}";
            var asset = "{{ asset('assets/img/product/') }}";
            var user_id = "{{ auth()->user()->id }}";
            $.ajax({
                url: url + '/api/product/get-product/' + user_id,
                type: 'get',
                dataType: 'json',
                success: function(response){
                    if (response.status == true) {
                        $('#single-product').html('');
                        $.each(response.data, function(index, val){
                            var img = asset + '/' + JSON.parse(val.images)[0];
                            var col = "<div class='col-lg-4 col-md-6'><div class='single-product'><img src='"+img+"' /><div class='product-details'><h6><a href='/product/"+val.id+"' style='text-decoration: none;color: black;'>"+val.name+"</a></h6><div class='d-flex justify-content-between mt-3'><h6>Rp. "+val.price+"</h6><h6>"+val.category_product.name+"</h6></div><div class='d-flex justify-content-between mt-3'><a href='/dashboard/product/edit/"+val.id+"' id='"+val.id+"'class='genric-btn info circle small editProduct'><span class='ti-pencil'></span> Edit</a><button type='button' id='delete-"+val.id+"'class='genric-btn danger circle small deleteProduct'><span class='ti-trash'></span> Delete</button></div></div></div></div>";
                            $('#single-product').append(col);
                        });
                    }
                },
            });
        }   
        
        $(document).on('click', '.deleteProduct' , function() {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = this.id;
                    $.ajax({
                        url: url + '/api/product/' + id.replace('delete-', ''),
                        type: 'delete',
                        dataType: 'json',
                        success: function(response){
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success"
                            });
                            loadProduct();
                        }
                    });
                }else{
                    loadProduct();
                }
            });
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
                <h1>Product</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.html">Dashboard<span class="lnr lnr-arrow-right"></span></a>
                    <a href="category.html">Product</a>
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
                <x-sidebar active="product" />
            </div>
            <div class="col-lg-9">
                <div class="blog_left_sidebar">
                    <!-- Start Filter Bar -->
                    <div class="filter-bar d-flex flex-wrap align-items-center">
                        <div class="sorting">
                            <a href="/dashboard/product/add" class="genric-btn primary radius">Add Product</a>
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
    </div>
</section>
<!--================Blog Area =================-->

@endsection