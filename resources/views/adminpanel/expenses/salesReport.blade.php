@extends('adminpanel.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Sales Report<i class="fas fa-cookie-bite"></i></h3>



@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Sales</li>
<li class="breadcrumb-item active">Report</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="row">
            <div class="col-xl-6 xl-100 box-col-12">
         <div class="widget-joins card widget-arrow">
            <div class="row">
               <div class="col-sm-6 pe-0">
                  <div class="media border-after-xs">
                     <div class="align-self-center me-3 text-start">
                        <h6 class="mb-1">Sale</h6>
                        <h4 class="mb-0">Today</h4>
                     </div>
                     <div class="media-body align-self-center"><i class="font-primary" data-feather="arrow-down"></i></div>
                     <div class="media-body">
                        <h5 class="mb-0"> <i class="fa fa-inr"></i> <span class="counter">25698</span></h5>
                        <span class="mb-1">- <i class="fa fa-inr"></i> 2658(36%)</span>
                     </div>
                  </div>
               </div>
               <div class="col-sm-6 ps-0">
                  <div class="media">
                     <div class="align-self-center me-3 text-start">
                        <h6 class="mb-1">Sale</h6>
                        <h4 class="mb-0">Month</h4>
                     </div>
                     <div class="media-body align-self-center"><i class="font-primary" data-feather="arrow-up"></i></div>
                     <div class="media-body ps-2">
                        <h5 class="mb-0"> <i class="fa fa-inr"></i> <span class="counter">6954</span></h5>
                        <span class="mb-1">+ <i class="fa fa-inr"></i> 369(15%)</span>
                     </div>
                  </div>
               </div>
               <div class="col-sm-6 pe-0">
                  <div class="media border-after-xs">
                     <div class="align-self-center me-3 text-start">
                        <h6 class="mb-1">Sale</h6>
                        <h4 class="mb-0">Week</h4>
                     </div>
                     <div class="media-body align-self-center"><i class="font-primary" data-feather="arrow-up"></i></div>
                     <div class="media-body">
                        <h5 class="mb-0"> <i class="fa fa-inr"></i> <span class="counter">63147</span></h5>
                        <span class="mb-1">+ <i class="fa fa-inr"></i> 69(65%)</span>
                     </div>
                  </div>
               </div>
               <div class="col-sm-6 ps-0">
                  <div class="media">
                     <div class="align-self-center me-3 text-start">
                        <h6 class="mb-1">Sale</h6>
                        <h4 class="mb-0">Year</h4>
                     </div>
                     <div class="media-body align-self-center ps-3"><i class="font-primary" data-feather="arrow-up"></i></div>
                     <div class="media-body ps-2">
                        <h5 class="mb-0"> <i class="fa fa-inr"></i> <span class="counter">963198</span></h5>
                        <span class="mb-1">+ <i class="fa fa-inr"></i> 3654(90%)          </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
            </div>
        </div>
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
                                <option value="order_type">order_type</option>
                                <option value="payment_type">payment_type</option>
                          
                            </select>
                            </select>


                        </div> -->
                        <div class="col-md-4 p-3">
                            <label class="p-2">Filter by Order Type</label>
                            <select class="form-control" id="type">
                            <option  selected="" value="" disabled>--Select--</option>
                            <option value="dine_in" >Dine In</option>
                            <option  value="take_away" >Take Away</option>
                            <option  value="Online" >Online</option>
                            <option  value="On Call" >On Call</option>                          
                            </select>
                            </select>


                        </div>
                       
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                                <tr><th>Order Id</th>
                                    <th>Items Count</th>
                                    <th>Order Type</th>
                                    <th>Payment</th>
                                    <th>User Details</th>
                                    <th>Charges</th>
                                    <th>Date</th>
                                    <th>Amount</th>
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
                $( api.table().footer() ).html(
                    api.column( 8, {page:'current'} ).data().sum()
                );
            },
            language: {
                processing: '<div class="loader-box"><div class="loader-2"></div></div>'
            },
            ajax: {
                'url': '/management/sales/bind',
                'data': function(data) {
                    // Read values
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var type = $('#type').val();

                    // Append to data
                    data.from_date = from_date;
                    data.to_date = to_date;
                    data.type = type;

                }
            },
            columns: [{
                    data: 'Order Id',
                    Orderable: true
                },
                {
                    data: 'Items Count',
                    Orderable: false
                },
                {
                    data: 'Order Type',
                    Orderable: false
                },                
                {
                    data: 'Payment',
                    Orderable: false
                },
                {
                    data: 'User Details',
                    Orderable: false
                },
                {
                    data: 'Charges',
                    Orderable: false
                },
                {
                    data: 'Date',
                    Orderable: false
                },
                {
                    data: 'Amount',
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
        $('#type').on('change', function() {
            dataTable.draw();
        });


    });
</script>


<!-- <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script> -->
@endsection