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
<h3>Add Daily Expense</h3>

<button class="btn btn-primary btn-sm" id="add_new_item" onclick="add_item()"><i class="fa fa-plus-circle"></i> New Item</button>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Expenses</li>
<li class="breadcrumb-item active">Daily Expense</li>
@endsection

@section('content')
<input type="hidden" id="created_by" value="{{Auth::User()->id}}">
<input type="hidden" id="type" name="type" value="0">
<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="" id="add_item_form" onsubmit="return addItemForm(event,this)">
        <div class="modal-header">
          <h5> <i class="fa fa-plus-square"></i> Add Item
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
              Type
            </label>
           <select name="type" id="type" class="form-control">
            <option value="raw_material">Raw Material</option>
            <option value="vegetable">Vegetable</option>
           </select>
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




<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">

        <div class="card-header">
          <div class="row justify-content-center">
            <div class="col-md-4 mb-2 ">
              <div class="border p-3 text-center rounded border-primary bg-light text-primary shadow-sm">
                <strong>Date</strong> : <span class="text-dark editable_value editable_date">{{date("Y-m-d")}}</span> <i class="fa fa-pencil small text-danger cursor-pointer link" onclick="editHandler(this)"></i>
                <div class="p-1 hide_input d-none"> <input type="date" class="form-control editable" value='{{date("d.m.Y")}}'></div>
              </div>
            </div>
            <div class="col-md-4 mb-2 ">
              <div class="border p-3 text-center rounded border-primary bg-light text-primary shadow-sm">
                <strong>Expense Type</strong> : <span class="text-dark editable_value editable_expense_type">Daily Expenses</span> <i class="fa fa-pencil small text-danger cursor-pointer link" onclick="editHandler(this)"></i>
                <div class="p-1 hide_input d-none"> <select name="" id="expense_type" class="form-control editable">
                    <option value="Daily Expenses">Daily Expenses</option>
                    <option value="Sallary" disabled>Sallary</option>
                  </select></div>
              </div>
            </div>
            <div class="col-md-4 mb-2 ">
              <div class="border p-3 text-center rounded border-primary bg-light text-primary shadow-sm">
                <strong>Expense Category</strong> : <span class="text-dark editable_value editable_expense_category">Vegetable</span> <i class="fa fa-pencil small text-danger cursor-pointer link" onclick="editHandler(this)"></i>
                <div class="p-1 hide_input d-none"> <select name="" id="expense_category" class="form-control editable">
                    <option value="Vegetables">Vegetables</option>
                    <option value="Raw Material">Raw Material</option>
                    <option value="Others">Others</option>
                  </select></div>

              </div>
            </div>

          </div>



        </div>
        <div class="card-body">
          <table class="table">
            <thead>
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
              <tr>
                <td>
                  <select name="item" id="" class="form-control item_name">
                    <option value="0">Select New Item</option>
                  </select>
                </td>
                <td>
                  <input type="number" class="form-control qty" name="qty" value="1" min="1">
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
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" class="text-center">Total</td>
                <td> RS. <span id="total"></span> </td>
                <td> </td>
              </tr>
            </tfoot>
          </table>
          <button class="btn btn-dark btn-sm m-3" onclick="setAllData()"> <i class="fa fa-send"></i> Add Expenses </button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('script')

<script>

</script>
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
            resource_type: "items"
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
    const setPrice = async (item_obj) => {
    items = await getItemDetails()
    console.log(items, "etProce")
    items = JSON.parse(items)
    let item = items.items.filter((value, key) => {
      return value.id == $(item_obj).val()
    })
    $(item_obj).closest("tr").find(".price").val(item[0].price).trigger("change")
    $(item_obj).closest("tr").find(".unit").val(item[0].unit).trigger("change")
  }

  const expense_row = (id) => $(`<tr id="new_row_${id}">
                        <td>
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


  $("#expense_body").on("change", ".qty, .price", function() {

    let price = $(this).closest("tr").find(".price").val()
    let qty = $(this).closest("tr").find(".qty").val()


    $(this).closest("tr").find(".subtotal").val(qty * price)

    countTotal()

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



  const addItemForm = (e, form) => {
    e.preventDefault()
    loadoverlay($("#add_item_form"))
    var form = new FormData();
    form.append("table_name", "items");
    form.append("name", $("#item_name").val());
    form.append("unit", $("#item_unit").val());
    form.append("type", $("#type").val());
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
    form.append("table_name", "expenses");
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
</script>

<!-- <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script> -->
@endsection