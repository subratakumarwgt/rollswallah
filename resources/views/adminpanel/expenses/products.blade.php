@extends('adminpanel.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Products  <i class="fas fa-file"></i></h3>



@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Sales</li>
<li class="breadcrumb-item active">Products</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row m-0">
                        <div class="col-md-4 p-3 border-right-sm">
                            <label class="p-2">From Date</label>
                            <input type="date" name="" id="from_date" class="form-control" >

                        </div>
                        <div class="col-md-4 p-3 border-right-sm">
                            <label class="p-2">To Date</label>
                            <input type="date" name="" id="to_date" class="form-control" >

                        </div>

                        <!-- <div class="col-md-4 p-3">
                            <label class="p-2">Group by Sales</label>
                            <select class="form-control" id="category">
                            <option  selected="" value="" disabled>--Select--</option>
                          
                                <option value="items">items</option>
                                <option value="date">date</option>
                                <option value="product_type">product_type</option>
                                <option value="payment_type">payment_type</option>
                          
                            </select>
                            </select>


                        </div> -->
                        <div class="col-md-4 p-3">
                            <label class="p-2">Filter by Product Type</label>
                            <select class="form-control" id="product_type">
                            <option  selected="" value="" disabled>--Select--</option>
                            <option value="ice_cream" >Ice Cream</option>
                            <option  value="fast_food" >Fast Food</option>                                        
                            </select>
                            </select>


                        </div>
                       
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                                <tr><th>Product Id</th>
                                    <th>Title</th>
                                    <th>Product Type</th>
                                    <th>Price</th>
                                    <th>Unit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>

                                </tr>
                            </tfoot>
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
<script src="https://cdn.datatables.net/plug-ins/1.12.1/api/sum().js"></script>
<script>
    jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
        if ( typeof a === 'string' ) {
            a = a.replace(/[^\d.-]/g, '') * 1;
        }
        if ( typeof b === 'string' ) {
            b = b.replace(/[^\d.-]/g, '') * 1;
        }
 
        return a + b;
    }, 0 );
} );
    $(function() {
       
        var dataTable = $('#datatable').DataTable({
            'processing': true,
            serverSide: true,
            drawCallback: function () {
                var api = this.api();
                $( api.table().footer() ).html("<td colspan='3'>Total</td><td colspan='7'><i class='fas fa-inr'></i>"+
                 (  0 - parseInt(api.column( 3, {page:'current'} ).data().sum()))
                    +"</td>");
            },
            language: {
                processing: '<div class="loader-box"><div class="loader-2"></div></div>'
            },
            ajax: {
                'url': '/management/sales/products/bind',
                'data': function(data) {
                    // Read values
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var product_type = $('#product_type').val();
                    var type = "product"

                    // Append to data
                    data.from_date = from_date;
                    data.to_date = to_date;
                    data.product_type = product_type;
                    data.type = type

                }
            },
            columns: [{
                    data: 'Product Id',
                    Orderable: true
                },
                {
                    data: 'Title',
                    Orderable: false
                },
                {
                    data: 'Product Type',
                    Orderable: false
                },                
                {
                    data: 'Price',
                    Orderable: false
                },
                {
                    data: 'Unit',
                    Orderable: false
                },              
                {
                    data: 'Action',
                    Orderable: false
                },
            ],
        });



        $('#from_date').on('change', function() {
            dataTable.draw();
        });
        $('#to_date').on('change', function() {
            dataTable.draw();
        });
        $('#product_type').on('change', function() {
            dataTable.draw();
        });


    });
</script>


<!-- <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script> -->
@endsection