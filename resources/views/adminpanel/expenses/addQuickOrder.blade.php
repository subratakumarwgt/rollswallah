@extends('adminpanel.master')
@section('title', 'Sample Page')

@section('css')
<style type="text/css">
  .float {
    position: absolute;
    right: 5px;
    top: 0px;
    margin: 1px;
  }

  .action_label {
    cursor: pointer;
  }

  .cursor-pointer {
    cursor: pointer;
  }

  .cursor-pointer:hover {
    color: black
  }
</style>
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Quick Order</h3>


@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Sales</li>
<li class="breadcrumb-item active">Make Order</li>
@endsection

@section('content')

<input type="hidden" id="created_by" value="{{Auth::User()->id}}">
<input type="hidden" id="type" name="type" value="0">
<input type="hidden" id="order_id" value="{{$order_id}}">
<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="" id="add_item_form" onsubmit="return addItemForm(event,this)">
        <div class="modal-header">
          <h5> <i class="fa fa-plus-square"></i> Add Product
          </h5>
        </div>
        <div class="modal-body">

          <div class="form-group p-1 mt-2">
            <label for="view_type">
              Item name
            </label>
            <input type="text" class="form-control" id="item_name" required name="name">
          </div>
          <div class="form-group p-1 mt-2">
            <label for="view_type">
              Unit
            </label>
            <input type="text" class="form-control" id="item_unit" required name="unit">
          </div>
          <div class="form-group p-1 mt-2">
            <label for="view_type">
              Price
            </label>
            <input type="number" class="form-control" id="item_price" required name="price">
          </div>


        </div>
        <div class="modal-footer">
          <button class="btn btn-outline-dark shadow-sm btn-block" type="submit"> Add <i class="fa fa-plus-square"></i> </button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="billModal" tabindex="-1" role="dialog" aria-labelledby="billModal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="" id="bill_form" onsubmit="">
        <div class="modal-header">
          <h5> 
          </h5>
        </div>
        <div class="modal-body" id="bill">        

        </div>
        <div class="modal-footer">
        <div class="col-sm-12 text-center mt-3">
                     <button class="btn btn btn-primary me-2" type="button" onclick="myFunction()">Print</button>
                     <button class="btn btn-secondary" type="button">Cancel</button>
                  </div>  </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="chargeModal" tabindex="-1" role="dialog" aria-labelledby="chargeModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="" id="add_item_form" onsubmit="return addItemForm(event,this)">
        <div class="modal-header">
          <h5> <i class="fa fa-plus-square"></i> Add Charges
          </h5>
        </div>
        <div class="modal-body">

          <div class="form-group p-1 mt-2">
            <label for="view_type">
             Charge Type
            </label>
            <input type="text" class="form-control" id="charge_type" required name="name">
          </div>
          <div class="form-group p-1 mt-2">
            <label for="view_type">
              Variation
            </label>
            <input type="text" class="form-control" id="variation" required name="unit">
          </div>
          <div class="form-group p-1 mt-2">
            <label for="view_type">
              Amount
            </label>
            <input type="number" class="form-control" id="amount" required name="price">
          </div>


        </div>
        <div class="modal-footer">
          <button class="btn btn-success shadow-sm btn-block" type="submit"> Add <i class="fa fa-plus-square"></i> </button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">

        
        <div class="card-body table-responsive">
        <div class="row"> 
        <div class="col-md-6  border-right"><button class="btn btn-outline-dark  ml-1" id="add_new_item" onclick="add_item()"><i class="fa fa-plus-circle"></i> New Product</button>
<button class="btn btn-outline-dark  ml-1" id="add_new_charge" onclick="add_charge()"><i class="fa fa-plus-circle"></i> New Charges</button>
<button class="btn btn-outline-dark border-success ml-1" id="add_new_order" onclick='newOrder()'><i class="fa fa-plus-circle"></i> New Order</button>
</div>
<div class="col-md-3 mb-3">
  <div class="input-group">
<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone"></i>  </span></div>
<input class="form-control" type="text" minlength="10" max="9999999999" placeholder="(+91) Contact number" data-bs-original-title="" title="" id="user_contact" value="{{@$order->user_contact}}" required>
</div>
        </div>
        <div class="col-md-3 mb-3">
  <div class="input-group">
<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-map-marker"></i>  </span></div>
<input class="form-control" type="text" minlength="10" max="9999999999" placeholder="customer address" data-bs-original-title="" title="" id="user_address" value="{{@$order->user->user_contact}}" required>
</div>
        </div>
      </div>
           
          <div class="row justify-content-center">
          <div class="col-md-3 mb-1 ">
              <div class="border p-2 text-center rounded border-primary bg-light text-primary shadow-sm">
                <strong>Order ID</strong> : <span class="text-dark editable_value editable_date">{{$order_id}}</span> 
              
              </div>
            </div>
            <div class="col-md-3 mb-1 ">
              <div class="border p-2 text-center rounded border-primary bg-light text-primary shadow-sm">
                <strong>Date</strong> : <span class="text-dark editable_value editable_date">{{date("Y-m-d")}}</span> <i class="fa fa-pencil small text-danger cursor-pointer link" onclick="editHandler(this)"></i>
                <div class="p-1 hide_input d-none"> <input type="date" class="form-control editable" value='{{date("d.m.Y")}}' id="date"></div>
              </div>
            </div>
            <div class="col-md-3 mb-1 ">
              <div class="border p-2 text-center rounded border-primary bg-light text-primary shadow-sm">
                <strong>Order Type</strong> : <span class="text-dark editable_value editable_expense_type">dine_in</span> <i class="fa fa-pencil small text-danger cursor-pointer link" onclick="editHandler(this)"></i>
                <div class="p-1 hide_input d-none"> <select name="" id="order_type" class="form-control editable">
                    <option value="on_call">on_call</option>
                    <option value="dine_in" default>dine_in</option>
                    <option value="take_away">take_away</option>
                    <option value="swiggy">swiggy</option>
                    <option value="zomato">zomato</option>
                  </select></div>
              </div>
            </div>
            <div class="col-md-3 mb-1 ">
              <div class="border p-2 text-center rounded border-primary bg-light text-primary shadow-sm">
                <strong>Payment Type</strong> : <span class="text-dark editable_value editable_expense_category">cash</span> <i class="fa fa-pencil small text-danger cursor-pointer link" onclick="editHandler(this)"></i>
                <div class="p-1 hide_input d-none"> <select name="" id="payment_category" class="form-control editable">
                    <option value="cash">cash</option>
                    <option value="online">online</option>
                    <option value="credit">credit</option>
                  </select>
                </div>

              </div>
            </div>

          </div>
          <table class="table">
            <thead class="">
              <tr>
                <th>
                  Item
                </th>
                <th>
                  Qty
                </th>
                <th>
                  Unit
                </th>
                <th>
                  Price
                </th>
                <th>
                  Subtotal
                </th>
                <th>
                  Action
                </th>
              </tr>
            </thead>

            <tbody id="expense_body">
              @if(!empty(count($order->orderDetails)))
              @foreach($order->orderDetails as $key => $order_detail)
              <tr>

                <td colspan="">
                  <select name="item" id="" class="form-control item_name">
                    <option value="{{$order_detail->item->id}}">{{$order_detail->item->name}}</option>
                  </select>
                </td>
                <td>
                  <!-- <span><i class="fa fa-times"></i></span><input type="number" class=" qty" name="qty" value="1" min="1"> -->
                
                 <input class="form-control qty" type="number" name="qty" value="{{$order_detail->quantity}}" min="1" >
                                           
                </td>
                <td>
                  <input type="text" class="form-control unit" name="unit" value="{{$order_detail->item->unit}}" readonly>
                </td>
                <td>
                  <input type="number" class="form-control price" name="price" value="{{$order_detail->price}}" min="1">
                </td>
                <td>
                  <input type="number" class="form-control subtotal" name="subtotal" value="{{$order_detail->subtotal}}" min="1">
                </td>
                <td>
                  @if($key == 0)
                  <button class="btn btn-sm btn-outline-success" id="add_row" onclick="add_row()">
                    <i class="fa fa-plus-square"></i>
                  </button>
                  @else
                  <button class="btn btn-sm btn-outline-danger remove_row" id="" onclick="remove_row()">
                    <i class="fa fa-minus-square"></i>
                  </button>
                  @endif
                </td>

              </tr>
              @endforeach
              @else
              <tr>
                <td colspan="">
                  <select name="item" id="" class="form-control item_name">
                    <option value="0">Select New Item</option>
                  </select>
                </td>
                <td>
                  <!-- <span><i class="fa fa-times"></i></span><input type="number" class=" qty" name="qty" value="1" min="1"> -->
                
                                            <input class="form-control qty" type="number" name="qty" value="1" min="1" >
                                           
                </td>
                <td>
                  <input type="text" class="form-control unit" name="unit" value="unit" readonly>
                </td>
                <td>
                  <input type="number" class="form-control price" name="price" value="1" min="1">
                </td>
                <td>
                  <input type="number" class="form-control subtotal" name="subtotal" value="1" min="1">
                </td>
                <td>
                  <button class="btn btn-sm btn-outline-success" id="add_row" onclick="add_row()">
                    <i class="fa fa-plus-square"></i>
                  </button>
                </td>

              </tr>
            
              @endif
            </tbody>

            <tbody id="charge_body">
                <tr>
                    <td colspan="7" class="text-secondary p-3">
                     Add Charges  <i class="fa fa-arrow-down"></i>
                    </td>
                    
                </tr>
                <tr id="charge_row">
                <td colspan="2">
                  <select name="charges" id="" class="form-control charges">
                    <option value="1">Packing Charge</option>
                  </select>
                </td>
                <td>
                  <input type="number" class="form-control qty" value="1" >
                </td>    
                <td>
                  <input type="number" class="form-control price" value="0" >
                </td>                
                <td>
                  <input type="number" class="form-control subtotal" name="subtotal" value="0" min="1">
                </td>
                <td>
                  <button class="btn btn-sm btn-outline-success" id="add_charge_row" onclick="add_charge_row()">
                    <i class="fa fa-plus-square"></i>
                  </button>
                </td>

                </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2"></td>
                <td colspan="2" class="text-center"></td>
                <td>Total Payable Rs. <span id="total">0</span> </td>
                <td> </td>
              </tr>
            </tfoot>
          </table>
          <button class="btn btn-dark btn-sm m-2" onclick="setAllData()"> <i class="fa fa-send"></i> Place Order </button>
          <button class="btn btn-success btn-sm m-2" onclick="createBill()"> <i class="fa fa-inr"></i> Create Bill </button>
          <button class="btn btn-primary btn-sm m-2" onclick="saveDraft()"> <i class="fa fa-save"></i> Save Draft </button>
          <button class="btn btn-danger btn-sm m-2" onclick="cancelOrder()"> <i class="fa fa-times"></i> Cancel Order </button>
       
        </div>
      </div>
    </div>
  </div>
</div>

</div>
@endsection

@section('script')

<script src="{{asset('assets/js/counter/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/js/counter/counter-custom.js')}}"></script>
<script src="{{asset('assets/js/print.js')}}"></script>
<script>
  $("#from_date").prop('max', $("#to_date").val());
  $("#to_date").change(function() {
    $("#from_date").prop('max', $("#to_date").val());
  });
  $("#from_date").change(function() {
    $("#to_date").prop('min', $("#from_date").val());
  });
</script>



<script>
  const isNew = {{$isNew}}

  if(isNew)
  window.history.replaceState(null, null, "{{url()->full()}}/{{$order_id}}");

  const getPackingCharge = () =>{
    return 5;
  }
 
  const getAllItems = (obj) => {
    $(obj).select2({
      tags: false,
      ajax: {
        "url": "/api/get-resources",
        "method": "get",
        delay: 600,
        minimumResultsForSearch: -1,
        data: function(params) {
          var query = {
            search: params.term,
            resource_type: "items",
            filters:{
                type:["product"]
            }
          }
          query.resource_type = "items"
          return query;
        },
        processResults: function(response) {
          response = JSON.parse(response);
          return {
            results: response.items
          };

        },

      },

    })
  }
  let items = []
  getItemDetails = async () => {
    items = await $.get("/api/get-resources?resource_type=items",(res)=>{
       res = JSON.parse(res)
      return res.items
    })
    return items    

  
  }
  
  getAllItems($(".item_name").bind("change", function() {
   
      if ($(".item_name").length > 1 && isDuplicateItem($(this).val())) {
        $.notify({
          message: "Item already exists in the list"
        }, {
          type: 'danger',
          z_index: 10000,
          timer: 2000,
        })
        $(this).find('option:selected').remove();
      } else
        setPrice(this)

    }))
  const setPrice =async (item_obj) => {
    items = await getItemDetails()
    console.log(items,"etProce")
    items = JSON.parse(items)
    let item = items.items.filter((value, key) => {
      return value.id == $(item_obj).val()
    })
    $(item_obj).closest("tr").find(".price").val(item[0].price).trigger("change")
    $(item_obj).closest("tr").find(".unit").val(item[0].unit).trigger("change")
  }

  const expense_row = (id) => $(`<tr id="new_row_${id}">
                        <td colspan="">
                         <select name="item" id=""  class="form-control item_name">
                          <option value="0">Select New Item</option>
                         </select>
                        </td>
                        <td>
                          <input type="number" class="form-control qty" name="qty" value="1" min="1" onchange="changeQuantity(this)">
                        </td>
                        <td>
                          <input type="text" class="form-control unit" name="unit" readonly>
                        </td>
                        <td>
                          <input type="number" class="form-control price" name="price" value="1" min="1">
                        </td>
                        <td>
                          <input type="number" class="form-control subtotal" name="subtotal"  value="1" min="1">
                        </td>
                        <td>
                         <button class="btn btn-sm btn-outline-danger remove_row">
                          <i class="fa fa-minus-square"></i>
                         </button>
                        </td>
                       
                      </tr>`)
  let id = 1;
  const remove_row = (e) => {
    id++;
    console.log("remove", e)
    $(e).closest("tr").remove()
    countTotal()

  }
  const add_row = () => {
    id++;
    let new_row = $("#expense_body").append(expense_row(id))
    new_row.find($(".remove_row")).bind("click", function() {
      remove_row(this)
    })
    getAllItems(new_row.find($(".item_name")))
    new_row.find(".item_name").bind("change", function() {
      if ($(".item_name").length > 1 && isDuplicateItem($(this).val())) {
        $.notify({
          message: "Item already exists in the list"
        }, {
          type: 'danger',
          z_index: 10000,
          timer: 2000,
        })
        $(this).find('option:selected').remove();
      } else
        setPrice(this)

    })
  }


  const changeQuantity = (obj) => {
    let quantity


  }


  $("#expense_body, #charge_body").on("change", ".qty, .price", function() {

    let price = $(this).closest("tr").find(".price").val()
    let qty = $(this).closest("tr").find(".qty").val()


    $(this).closest("tr").find(".subtotal").val(qty * price)

    countTotal()

  })
  $("#order_type").on("change",function(){
    if(this.value == "take_away")
    $("#charge_row").find(".price").val(getPackingCharge()).trigger("change")
    else
    $("#charge_row").find(".price").val(0).trigger("change")
  })
  const countTotal = () => {
    let total = 0
    $(".subtotal").each((index, elem) => {
      total = parseInt(total) + parseInt(elem.value)
    })
    $("#total").html(total)
  }

  const editHandler = (obj) => {
    let hide_input = $(obj).closest("div").find(".hide_input")
    if (hide_input.hasClass("d-none"))
      hide_input.removeClass("d-none")
    else
      hide_input.addClass("d-none")
  }

  $(".editable").on("change", function() {
    let value = this.value

    $(this).closest("div").parent("div").find(".editable_value").html(value)
    let elem = $(this).closest("div").parent("div").find(".editable_value")
    editHandler(elem)

  })

  const add_item = () => {
    $("#itemModal").modal("show")
  }
  const add_charge = () => {
    $("#chargeModal").modal("show")
  }



  const addItemForm = (e, form) => {
    e.preventDefault()
    loadoverlay($("#add_item_form"))
    var form = new FormData();
    form.append("table_name", "items");
    form.append("name", $("#item_name").val());
    form.append("unit", $("#item_unit").val());
    form.append("type","product");
    form.append("price", $("#item_price").val());
    form.append("table_model", "Item");

    var settings = {
      "url": "/api/create-data",
      "method": "POST",
      "timeout": 0,
      "processData": false,
      "mimeType": "multipart/form-data",
      "contentType": false,
      "data": form,
      statusCode: {
        400: function() {
          hideoverlay($("#add_item_form"))
          //  = JSON.parse();
          $.notify({
            message: "Something went wrong while inserting doctor!"
          }, {
            type: 'danger',
            z_index: 10000,
            timer: 2000,
          });
        },
        500: function() {
          hideoverlay($("#add_item_form"))
          // response = JSON.parse(response);
          $.notify({
            message: "Something went wrong while inserting doctor!"
          }, {
            type: 'danger',
            z_index: 10000,
            timer: 2000,
          })
        }
      }
    };

    $.ajax(settings).done(function(response) {
      var response2 = JSON.parse(response)
      hideoverlay($("#add_item_form"));
      $.notify({
        message: response2.message
      }, {
        type: 'success',
        z_index: 10000,
        timer: 2000,
      })



    }, function() {
      getItemDetails()
    });

  }


  const setAllData = async () => {
    loadoverlay($("#expense_body"))
    if (confirm("Are you sure you want to save expenses?")) {
      $.notify({
            message: "Expenses being added!"
          }, {
            type: 'warning',
            z_index: 10000,
            timer: 2000,
          });
      
      let data = {}
      let row_data = []
      data.expense_date = $(".editable_date").html()
      data.expense_type = $(".editable_expense_type").html()
      data.expense_category = $(".editable_expense_category").html()
      data.created_by = $("#created_by").val()
     

      data.total = $("#total").html()

      data.description = `Expense of RS ${data.total} as ${data.expense_type} for ${data.expense_category} is paid.`

    
    var form = new FormData();
    form.append("table_name", "orders");
    form.append("type", data.expense_type);
    form.append("category", data.expense_category);
    form.append("amount",  data.total);
    form.append("created_by", data.created_by);
    form.append("description",data.description);
    form.append("table_model", "Expense");

    var settings = {
      "url": "/api/create-data",
      "method": "POST",
      "timeout": 0,
      "processData": false,
      "mimeType": "multipart/form-data",
      "contentType": false,
      "data": form,
      statusCode: {
        400: function() {
          hideoverlay($("#expense_body"))
          //  = JSON.parse();
          $.notify({
            message: "Something went wrong while inserting doctor!"
          }, {
            type: 'danger',
            z_index: 10000,
            timer: 2000,
          });
        },
        500: function() {
          hideoverlay($("#expense_body"))
          // response = JSON.parse(response);
          $.notify({
            message: "Something went wrong while inserting doctor!"
          }, {
            type: 'danger',
            z_index: 10000,
            timer: 2000,
          })
        }
      }
    };

  await  $.ajax(settings).done(function(response) {
    
      var response2 = JSON.parse(response)
      row_data = $("#expense_body tr").map(function(index, elem) {
        let row = {};
        row.item_id = $(elem).find(".item_name").val()
        row.quantity = $(elem).find(".qty").val()
        row.price = $(elem).find(".price").val()
        row.subtotal = $(elem).find(".subtotal").val()
        row.expense_id = response2.data.id
        return row
      }).get()

      $.post("/api/save-daily-expenses",{row_data},function(res){
        alert(res.message+" Status Code")
        hideoverlay($("#expense_body"));
        $.notify({
        message: response2.message
      }, {
        type: 'success',
        z_index: 10000,
        timer: 2000,
      })
      })
    }, function() {
     
    });

 
   

    }



  }
  const isDuplicateItem = (value) => {
    let duplicate = $(".item_name").filter((num, elem) => {
      return $(elem).val() == value
    }).get()
    console.log("given", value, "all", duplicate)
    return duplicate.length > 1

  }
  const newOrder = () => {
    window.open("{{route('quick-order')}}","_blank")
  }
  const saveDraft =async () => {
    
    loadoverlay($("#expense_body"))
    let data = {}
    data.order_id = $("#order_id").val()
    data.total = $("#total").html()
    row_data = $("#expense_body tr").map(function(index, elem) {
        let row = {};
        row.order_id = data.order_id
        row.item_id = $(elem).find(".item_name").val()
        row.quantity = $(elem).find(".qty").val()
        row.price = $(elem).find(".price").val()
        row.subtotal = $(elem).find(".subtotal").val()
        return row
      }).get()
     await $.post("/api/save-order-details",{row_data,order_id:data.order_id,total:data.total},function(res){
       
        hideoverlay($("#expense_body"));
        $.notify({
        message: "Order saved successfully"
      }, {
        type: 'success',
        z_index: 10000,
        timer: 2000,
      })
      })



  }
  countTotal();
  document.onkeyup = function(e) {
    e.preventDefault()
    console.log(`${e.which} is value for  ${e.which ? String.fromCharCode(e.which) : e}`)
    //New Order ShortCut
  if (e.altKey && e.which == 79) {
    newOrder()
  }
  if (e.altKey && e.which == 83) {
    saveDraft()
  }
  if (e.shiftKey && e.which == 107) {
    add_row()
  }
  // else if (e.ctrlKey && e.which == 66) {
  //   alert("Ctrl + B shortcut combination was pressed");
  // } else if (e.ctrlKey && e.altKey && e.which == 89) {
  //   alert("Ctrl + Alt + Y shortcut combination was pressed");
  // } else if (e.ctrlKey && e.altKey && e.shiftKey && e.which == 85) {
  //   alert("Ctrl + Alt + Shift + U shortcut combination was pressed");
  // }
};
const generateBill = (order) => {
  return $(`<div class="container">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-body">
               <div class="invoice">
                  <div>
                     <div>
                        <div class="row">
                           <div class="col-sm-6">
                              <div class="media">
                                 <div class="media-left"><img class="media-object img-60" src="{{asset('assets/images/logo/rollswallah.png')}}" alt=""></div>
                                 <div class="media-body m-l-20 text-right">
                                    <h4 class="media-heading">ROLLSWALLAH</h4>
                                    <p>Have Some Rolls</p>
                                 </div>
                              </div>
                              <!-- End Info-->
                           </div>
                           <div class="col-sm-6">
                              <div class="text-md-end text-xs-center">
                                 <h3>ORDER_ID #<span class="counter">${order.order_id}</span></h3>
                                 <p>${new Date(order.created_at)}</span></p>
                              </div>
                              <!-- End Title-->
                           </div>
                        </div>
                     </div>
                     <hr>
                     <!-- End InvoiceTop-->
                     <div class="row">
                        <div class="col-md-4">
                           <div class="media">
                              <div class="media-left"><img class="media-object rounded-circle img-60" src="{{asset('assets/images/user/1.jpg')}}" alt=""></div>
                              <div class="media-body m-l-20">                               
                                 <p><span>${order.user_contact ?? "No contact given"}</span></p>
                              </div>
                           </div>
                        </div>
                        
                     </div>
                     <!-- End Invoice Mid-->
                     <div>
                        <div class="table-responsive invoice-table" id="table">
                           <table class="table table-bordered table-striped">
                              <tbody>
                                 <tr>
                                    <td class="item">
                                       <h6 class="p-2 mb-0">Item Description</h6>
                                    </td>
                                    <td class="Hours">
                                       <h6 class="p-2 mb-0">Quantity</h6>
                                    </td>
                                    <td class="Rate">
                                       <h6 class="p-2 mb-0">Price</h6>
                                    </td>
                                    <td class="subtotal">
                                       <h6 class="p-2 mb-0">Sub-total</h6>
                                    </td>
                                 </tr>
                                 ${order.order_details.map((order_row,key)=>{
                         
                                  return (`<tr>
                                    <td class="item">
                                      ${order_row.item.name}
                                    </td>
                                    <td class="Hours">
                                     x ${order_row.quantity}
                                    </td>
                                    <td class="Rate">
                                    <i class='fa fa-inr'></i> ${order_row.price}
                                    </td>
                                    <td class="subtotal">
                                    <i class='fa fa-inr'></i> ${order_row.subtotal}
                                    </td>
                                 </tr>`)
                                 })}
                                 <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="Rate">
                                       Packing Charge
                                    </td>
                                    <td class="payment">
                                       <i class='fa fa-inr'></i> 0.00
                                    </td>
                                 </tr>
                                 <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="Rate">
                                       Delivery Charge
                                    </td>
                                    <td class="payment">
                                       <i class='fa fa-inr'></i> 0.00
                                    </td>
                                 </tr>
                    
                                 <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="Rate">
                                       <h6 class="mb-0 p-2">Total</h6>
                                    </td>
                                    <td class="payment">
                                       <h6 class="mb-0 p-2"><i class='fa fa-inr'></i> ${order.total ?? 0}</h6>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <!-- End Table-->
        
                     </div>
                     <!-- End InvoiceBot-->
                  </div>
                  
                  <!-- End Invoice-->
                  <!-- End Invoice Holder-->
                  <!-- Container-fluid Ends-->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>`)
}

const createBill =async () => {
 let order = await $.get("/api/get-order/"+$("#order_id").val(),(data)=>{
  return data
 })
 console.log(order,"order")
 
  $("#bill").html(generateBill(order.data))
  $("#billModal").modal("show")
}
</script>


<!-- <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script> -->
@endsection