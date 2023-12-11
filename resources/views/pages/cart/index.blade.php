@extends('layouts.app')

@section('script')

<script>
    $(document).ready(function () {
        var url = "{{ env('APP_API_URL') }}"
        loadData();

        $(document).on('change', '.updateCart', function() {
            var id = this.id;
            var qty = $(this).val();
            
            $.ajax({
                url: url + '/api/update-cart',
                type: 'post',
                dataType: 'json',
                data: {id:id,qty:qty},
                success: function(response){
                    if (response.status = true) {
                        loadData();
                    }
                }
            });
        });

        function loadData() {
            var user_id = "{{ auth()->user()->id }}";
            var asset = "{{ asset('assets/img/product') }}";
            $.ajax({
                url: url + '/api/cart',
                type: 'post',
                dataType: 'json',
                data: {user_id:user_id},
                success: function(response){
                    if (response.status == true) {
                        $('#tbody').html('');
                        var total = 0;
                        $.each(response.data, function(index, val){ 
                            total = (val.qty * val.product.price) + total;
                            var img = asset + '/' + JSON.parse(val.product.images)[0];
                            var col = "<tr><td><div class='media'><div class='d-flex'><img src='"+img+"' alt='' height='64'/></div><div class='media-body'><p>"+val.product.name+"</p></div></div></td><td><h5>"+val.product.price+"</h5></td><td><div class='product_count'><input type='number' min='1' max='"+val.product.stock+"' value='"+val.qty+"' id='"+val.id+"' class='updateCart'/></div></td><td><h5>"+ (val.qty * val.product.price) +"</h5></td></tr>";
                            $('#tbody').append(col);
                        });
                        var tfooter = "<tr><td></td><td></td><td><h5>Subtotal</h5></td><td><h5>"+total+"</h5></td><td></td></tr>";
                        $('#tbody').append(tfooter);

                        var tfooter2 = "<tr class='out_button_area'><td></td><td></td><td></td><td><h5>Subtotal</h5></td><td><div class='checkout_btn_inner d-flex align-items-center'><a href='/shop' class='gray_btn'>Continue Shopping</a><a href='#' class='primary-btn'>Proceed to checkout</a></div></td></tr>";
                        $('#tbody').append(tfooter2);
                    }
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    });
</script>

@endsection

@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shopping Cart</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="category.html">Cart</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!--================End Cart Area =================-->
@endsection