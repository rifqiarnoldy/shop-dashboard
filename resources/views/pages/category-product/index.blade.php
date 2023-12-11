@extends('layouts.app')

@section('script')
<script>
    $(document).ready(function() {
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
        var url = "{{ env('APP_API_URL') }}";
        loadData();

        $('#btnClose').on("click", function() {
            loadData();
        });

        $('#formAdd').on('submit', function(e){
            e.preventDefault();
            let name = $('#categoryProductName').val();
            $.ajax({
                url: url + '/api/category_product',
                type: 'post',
                dataType: 'json',
                data: {name:name},
                success: function(response) {
                    if (response.status == true) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        });
                        loadData();
                        $('#exampleModal').modal('hide');
                    }else{
                        var title = "";
                        $.each(response.errors, function(index, val){
                            title = title + val;
                        });
                        Toast.fire({
                            icon: "error",
                            title: response.message,
                            text: title
                        });
                    }
                },
                error: function(response){
                    Toast.fire({
                        icon: "error",
                        title: response.message
                    });
                }
            });
        });

        $('#formEdit').on('submit', function(e){
            e.preventDefault();
                let name = $('#categoryProductNameEdit').val();
                let id = $('#id').val();
            $.ajax({
                url: url + '/api/category_product/' + id,
                type: 'put',
                dataType: 'json',
                data: {name:name},
                success: function(response) {
                    if (response.status == true) {
                        $('#exampleModalEdit').modal('hide');
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        });
                        loadData();
                    }else{
                        var title = "";
                        $.each(response.errors, function(index, val){
                            title = title + val;
                        });
                        Toast.fire({
                            icon: "error",
                            title: response.message,
                            text: title
                        });
                    }
                },
                error: function(response){
                    var title = "";
                    $.each(response.errors, function(index, val){
                    title = title + val;
                    });
                    Toast.fire({
                        icon: "error",
                        title: response.message,
                        text: title
                    });
                }
            });
        });

        $(document).on('click', '.btnEdit', function() {
            var id = this.id;
            $.ajax({
                url: url + '/api/category_product/' + id.replace('edit-', ''),
                type: 'get',
                dataType: 'json',
                success: function(response){
                    $('#exampleModalEdit').modal('show');
                    $('#categoryProductNameEdit').val(response.data.name);
                    $('#id').val(response.data.id);
                }
            });
        });

        $(document).on('click', '.btnDelete' , function() {
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
                        url: url + '/api/category_product/' + id.replace('delete-', ''),
                        type: 'delete',
                        dataType: 'json',
                        success: function(response){
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success"
                            }); 
                            loadData();
                        }
                    });
                }else{
                    loadData();
                }
            });
        });

        function loadData() {
            $('#data-category-product').html('');
            $.ajax({
                url: url + '/api/category_product',
                type: 'get',
                dataType: 'json',
                success: function(response){
                    if (response.status == true) {
                        $.each(response.data, function(index, val) {
                            var row = "<tr><td>"+(index + 1)+"</td><td>"+val.name+"</td><td> <button type='button' class='genric-btn info radius btnEdit' id='edit-"+val.id+"'>Edit</button> <button type='button' class='genric-btn danger radius btnDelete' id='delete-"+val.id+"'>Delete</button> </td></tr>";
                            $('#data-category-product').append(row);
                            $('#edit-'+val.id).addClass('btnEdit');
                        });
                    }
                },
                error: function(response){
                    alert(response.message);
                }
            });
        }
    })
</script>
@endsection

@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Category Product</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.html">Dashboard<span class="lnr lnr-arrow-right"></span></a>
                    <a href="category.html">Category Product</a>
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
                <x-sidebar active="category-product" />
            </div>
            <div class="col-lg-9">
                <div class="blog_left_sidebar">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Category Product</h3>
                                <button class="genric-btn primary radius" data-toggle="modal"
                                    data-target="#exampleModal">Add
                                    Data</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="data-category-product">
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

{{-- Modal Add --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formAdd">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="categoryProductName">Name</label>
                        <input type="text" class="form-control" id="categoryProductName" aria-describedby="emailHelp"
                            name="name" placeholder="Enter name" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnClose">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="exampleModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelEdit"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelEdit">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formEdit">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="categoryProductNameEdit">Name</label>
                        <input type="text" class="form-control" id="categoryProductNameEdit"
                            aria-describedby="emailHelp" name="name" placeholder="Enter name" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnClose">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection