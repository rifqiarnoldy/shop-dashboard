@extends('layouts.app')

@section('script')
<script>
    $(document).ready(function () {
        var url = "{{ env('APP_API_URL') }}";
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
       loadCategories();
        
        function loadCategories(){
            var url = "{{ env('APP_API_URL') }}";
            $.ajax({
                url: url + '/api/category_product',
                type: 'get',
                dataType: 'json',
                success: function(response){
                    if (response.status == true) {
                        $('#productCategories').html('');
                        var option = new Option("Select Categories", "");
                        $('#productCategories').append(option);
                        $.each(response.data, function(index, val) {
                            // var option = "<option value='"+val.id+"'>"+val.name+"</option>";
                            var option = new Option(val.name, val.id);
                            $('#productCategories').append(option);
                        });
                        
                        
                    }else{
                        console.log(response);
                    }
                },
                error: function(response){
                    console.log(response);
                }
            });
        }

        $('#formAddProduct').on('submit', function(e){
            e.preventDefault();
            let user_id = "{{ auth()->user()->id }}";
            let name = $('#productName').val();
            let description = $('#productDescription').val();
            let price = $('#productPrice').val();
            let stock = $('#productStock').val();
            let category_product_id = $('#productCategories').val();
            let spesification = {width: $('#productWidth').val(), height: $('#productHeight').val(),quality_checking: "Yes"};
            $.ajax({
                url: url + '/api/product',
                type: 'post',
                dataType: 'json',
                data: {
                    user_id:user_id, 
                    name:name, 
                    description:description, 
                    spesification:spesification, 
                    category_product_id:category_product_id,
                    price:price,
                    stock:stock
                },
                success: function(response) {
                    if (response.status == true) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        });
                        window.location.href = '/dashboard/product';
                    }else{
                        console.log(response);
                        var title = "";
                        $.each(response.errors, function(index, val){
                            title = title + "-" + val + "<br>";
                        });
                        Toast.fire({
                            icon: "error",
                            title: title
                        });
                    }
                },
                error: function(response){
                    console.log(response);
                    Toast.fire({
                        icon: "error",
                        title: response.message
                    });
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
                    <!-- Start Best Seller -->
                    <div class="card">
                        <form action="" method="post" id="formAddProduct">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Add Product</h3>
                                    <button type="submit" class="genric-btn info rounded">Save</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="productName">Name</label>
                                        <input type="text" class="form-control" id="productName" aria-describedby="name"
                                            name="name" placeholder="Enter name" autofocus required>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="productDescription">Description</label>
                                        <textarea name="description" id="productDescription" cols="30" rows="3"
                                            class="form-control"></textarea>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="productWidth">Width</label>
                                        <input type="number" class="form-control" id="productWidth" name="width" min="1"
                                            required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="productHeight">Height</label>
                                        <input type="number" class="form-control" id="productHeight" name="height"
                                            min="1" required>
                                    </div>
                                    <div class="form-select col-lg-4">
                                        <label for="productCategories">Category Product</label>
                                        <select class="form-control" id="productCategories">
                                            <option value="">Select Categories</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="productPrice">Price</label>
                                        <input type="number" class="form-control" id="productPrice" name="price" min="1"
                                            required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="productStock">Stock</label>
                                        <input type="number" class="form-control" id="productStock" name="stock" min="1"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End Best Seller -->
                </div>
            </div>
        </div>
    </div>
</section>
<!--================Blog Area =================-->
@endsection