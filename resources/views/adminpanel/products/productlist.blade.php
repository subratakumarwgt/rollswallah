@extends('adminpanel.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Product List  <i class="fas fa-cookie-bite"></i></h3>



@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Products</li>
<li class="breadcrumb-item active">List</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
       
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                <div class="col-md-12 mb-3"><a href="import" class="btn btn-primary btn-sm mr-3"><i class="fas fa-plus-square"></i> New Product</a>
<a href="import/excel" class="btn btn-primary btn-sm mr-3"><i class="fas fa-plus-square"></i> Mass Import</a></div>
                    <div class="row m-0">
                        <div class="col-md-4 p-3 border-right-sm">
                            <label class="p-2">Filter by Sub Category</label>
                            <select class="form-control" id="sub_category">
                                <option value="" default>__Select__</option>
                                @foreach($sub_categories as $sub_category)
                                <option value="{{$sub_category}}">{{$sub_category}}</option>
                             @endforeach   
                            </select>

                        </div>

                        <div class="col-md-4 p-3">
                            <label class="p-2">Filter by Category</label>
                            <select class="form-control" id="category">
                            <option  selected="" value="" disabled>--Select--</option>
                            @foreach($categories as $category)
                                <option value="{{$category}}">{{$category}}</option>
                             @endforeach   
                            </select>
                            </select>


                        </div>
                        <div class="col-md-4 p-3">
                            <label class="p-2">Filter by Status</label>
                            <select class="form-control" id="status">
                            <option  selected="" value="" disabled>--Select--</option>
                            <option value="1" >Active</option>
                            <option  value="0" >Inactive</option>
                          
                            </select>
                            </select>


                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                                <tr><th>Image</th>
                                    <th>Title</th>
                                    <th>MRP</th>
                                    <th>Brand</th>
                                    <th>Stocks</th>
                                    <th>Categories</th>
                                    <th>Sub Categories</th>
                                    <th>Search Tags</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('script')

<script>
    $(function() {
       
        var dataTable = $('#datatable').DataTable({
            'processing': true,
            serverSide: true,
            language: {
                processing: '<div class="loader-box"><div class="loader-2"></div></div>'
            },
            ajax: {
                'url': '/management/product/bind',
                'data': function(data) {
                    // Read values
                    var category = $('#category').val();
                    var sub_category = $('#sub_category').val();
                    var status = $('#status').val();

                    // Append to data
                    data.category = category;
                    data.sub_category = sub_category;
                    data.status = status;

                }
            },
            columns: [{
                    data: 'Image',
                    Orderable: false
                },
                {
                    data: 'Title',
                    Orderable: false
                },
                {
                    data: 'MRP',
                    Orderable: false
                },                
                {
                    data: 'Brand',
                    Orderable: false
                },
                {
                    data: 'Stocks',
                    Orderable: false
                },
                {
                    data: 'Categories',
                    Orderable: false
                },
                {
                    data: 'Sub Categories',
                    Orderable: false
                },
                {
                    data: 'Search Tags',
                    Orderable: false
                },
                {
                    data: 'Action',
                    Orderable: false
                },
            ],
        });



        $('#category').on('change', function() {
            dataTable.draw();
        });
        $('#sub_category').on('change', function() {
            dataTable.draw();
        });
        $('#status').on('change', function() {
            dataTable.draw();
        });


    });
</script>


<!-- <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script> -->
@endsection