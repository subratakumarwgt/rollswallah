@extends('adminpanel.master')
@section('title', 'Sample Page')

@section('css')
<style type="text/css">
  .float{
    position: absolute;
    right: 5px;
    top:0px;
    margin: 1px;
  }
  .action_label{
    cursor: pointer;
  }
  .cursor-pointer{
    cursor: pointer;
  }
  .cursor-pointer:hover {
    color:black
  }
</style>
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
@endsection

@section('breadcrumb-title')
<h3>Add Daily Expense</h3>

<button class="btn btn-primary btn-sm"  id="add_new_item" onclick="add_item()"><i class="fa fa-plus-circle"></i> New Item</button>
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
                         <h5>   <i class="fa fa-plus-square"></i> Add Item
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

                           

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
               
                <div class="card-header">
                  <div class="row justify-content-center"> 
                    <div class="col-md-4 mb-2 ">
                      <div class="border p-3 text-center rounded border-primary bg-light text-primary shadows-sm">
                        <strong>Date</strong> : <span class="text-dark editable_value"> {{date("Y-m-d")}} </span> <i class="fa fa-pencil small text-danger cursor-pointer link" onclick="editHandler(this)"></i>
                        <div class="p-1 hide_input d-none"> <input type="date" class="form-control editable" value='{{date("d.m.Y")}}'></div>
                      </div>
                    </div> 
                    <div class="col-md-4 mb-2 ">
                      <div class="border p-3 text-center rounded border-primary bg-light text-primary shadows-sm">
                        <strong>Expense Type</strong> :  <span class="text-dark editable_value"> Daily Expenses </span>  <i class="fa fa-pencil small text-danger cursor-pointer link" onclick="editHandler(this)"></i>
                        <div class="p-1 hide_input d-none"> <select name="" id="expense_type" class="form-control editable"><option value="Daily Expenses">Daily Expenses</option> <option value="Sallary" disabled>Sallary</option></select></div>
                      </div>
                    </div> 
                    <div class="col-md-4 mb-2 ">
                      <div class="border p-3 text-center rounded border-primary bg-light text-primary shadows-sm">
                        <strong>Expense Category</strong> :  <span class="text-dark editable_value"> Vegetable </span>  <i class="fa fa-pencil small text-danger cursor-pointer link" onclick="editHandler(this)"></i>
                        <div class="p-1 hide_input d-none"> <select name="" id="expense_category" class="form-control editable"><option value="Vegetables">Vegetables</option><option value="Raw Material">Raw Material</option><option value="Others">Others</option></select></div>

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
                         <select name="item" id=""  class="form-control">
                          <option value="0">Select New Item</option>
                         </select>
                        </td>
                        <td>
                          <input type="number" class="form-control qty" name="qty"  value="1" min="1">
                        </td>
                        <td>
                          <input type="number" class="form-control price" name="price" value="1" min="1">
                        </td>
                        <td>
                          <input type="number" class="form-control subtotal" name="subtotal"  value="1" min="1">
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
                  <button class="btn btn-dark btn-sm m-3"> <i class="fa fa-send"></i> Add Expenses </button>
		           		</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
    const deletes = (name) => {
      if (confirm("Do you want to delete this action?")) {
        $("#"+name).closest(".action_label").remove();
      }

      }

    const resetForm = (formObj) => {
      $(formObj)[0].reset();
      $(".actions").prop("checked",false).trigger("change")


  //    $('input').val('').removeAttr('checked').removeAttr('selected');

    }
    const add_module = ( ) => {
        resetForm(document.getElementById("contact-form"))
        $("#exampleModalLabel").html("Add Module")
        $("#module_id").val(null)
         $("#exampleModal").modal("show")
      }
      const edit_module = (obj) => {
        resetForm(document.getElementById("contact-form"))
        $("#exampleModalLabel").html("Edit Module")
        let actions = $(obj).data("actions_json")
   //     console.log(actions);

   $("#icon").val($(obj).data("icon")).trigger("change")
   $("#parent_id").val($(obj).data("parent_id")).trigger("change")
   $("#name").val($(obj).data("name")).trigger("change")
   $("#route_name").val($(obj).data("route_name")).trigger("change")
   $("#slug").val($(obj).data("slug")).trigger("change")
   $("#module_id").val($(obj).data("id")).trigger("change")

   $(".actions").filter(function(){
        return  actions.includes($(this).val())
        }).closest(".action_label").trigger("click")
        $("#exampleModal").modal("show")

        $(".has_child").filter(function(){
       //   console.log($(this).val(),"child?")
        return  $(obj).data("has_child") == $(this).val()
        }).prop("checked",true)
        $(".is_header").filter(function(){
        return  $(obj).data("is_header") == $(this).val()
        }).prop("checked",true)
     
        $(".has_parent").filter(function(){
        return  $(obj).data("has_parent") == $(this).val()
        }).prop("checked",true)
    let  pre_exist_actions = $(".actions").map(function(){
       $(this).val()
     }).get()

     actions.filter(elem => !pre_exist_actions.includes(elem)).forEach(element => {
      $("#action_name").val(element).trigger("keyup")
      $(".add_action").trigger("click")
     });

     //  console.log(actions,"hello")
      }
   //   let has_child = $()
    
    //  let extra_actions =  actions.filter(e => $(".actions"))

     
    const checkRoute =async (route_name) => {
      loadoverlay($("#contact-form"))
 var form = new FormData();
form.append("route_name", route_name);

var settings = {
  "url": "/management/check-route",
  "method": "POST",
  "timeout": 0,
  "processData": false,
  "mimeType": "multipart/form-data",
  "contentType": false,
  "data": form,
  statusCode: {
        400: function(response) {
           response = JSON.parse(response);
      $.notify({
      message:"Something went wrong"
   },{
    type:'danger',
    z_index:10000,
    timer:1000,
   });
        }
      }
};

await $.ajax(settings).done(function (response) {
    response = JSON.parse(response);
    $("#url").val(response.data)
     
});

hideoverlay($("#contact-form"))
}
       
 

     $(function() {
      
      //  $("#add_new_module").on("click",function(){
       
      //  })
 const action_elem = (action_name,action_slug) =>  $(`
                 <div class="col-3 p-4 shadow-sm rounded border action_label border-bottom-success border-success mb-3" data-for="${action_slug}">
              <input class="checkbox_animated actions" value="${action_slug}" id="${action_slug}" type="checkbox" data-bs-original-title="" title="" checked readonly>                                               ${action_name}
               <button class="btn btn-square btn-outline-danger btn-xs rounded float" onclick="deletes('${action_slug}')"><i class="fa fa-times"></i></button>
              </div>`);

 $("#icon").on("change",function(){
  $("#test_icon").prop("class","")
  $("#test_icon").addClass($(this).val())
 })
 

  $("#name").on("keyup",function(){
    let value = $(this).val();
        $("#slug").val(value.replace(" ","_").toLowerCase())
      })


      $("#action_row").on("click",".action_label",function(e){
        let action_label = $(this).data("for");
        console.log("action:",action_label)
        $("#"+action_label).prop("checked",!$("#"+action_label).prop("checked") );
       $("#"+action_label).prop("checked") ? $(this).addClass("border-success") : $(this).removeClass("border-success")
      })
      $(".action_label").on("change",".actions",function(e) {
        var box = $(this).closest(".action_label");
        $(this).prop("checked") ? box.addClass("border-success") : box.removeClass("border-success")
        // body...
      })
      $(".float").on("click",function(e){
        if (confirm("Do you want to delete this action?")) {
          $(this).closest(".action_label").remove();
        }
      })
      $("#action_name").on("keyup",function(){
        let value = $(this).val();
        //console.log("val",value.replace(" ","_").toLowerCase())

        $("#action_slug").val(value.replace(" ","_").toLowerCase())
      })
  //    let elems = 
      $(".add_action").on("click",function(e){
        e.preventDefault();
        let action_name = $("#action_name").val()
        let action_slug = $("#action_slug").val()
      

      if (action_name != "" && $(".actions").filter(function(){
            return $(this).val() === action_slug 
          }).length == 0) {
          $("#action_row").append(action_elem(action_name,action_slug))
        }
      })




      $('#addModule').on('click',async function(e){
     e.preventDefault();
     loadoverlay($("#exampleModal"))
     // if ($("#moduleForm").valid()) {

     // }
    
     let actions = $(".actions")
 actions = $.map(actions,function(elem){
  if ($(elem).prop("checked")) {
    return elem.value;
    }
  })

// console.log("actions",actions)
     var form = new FormData();
// form.append("table_name", "modules");
form.append("id", $("#module_id").val());
form.append("name", $("#name").val());
form.append("slug", $("#slug").val());
form.append("has_child", $("input[name='has_child']:checked").val());
form.append("has_parent",  $("input[name='has_parent']:checked").val());
form.append("is_header", $("input[name='is_header']:checked").val());
form.append("actions_json", JSON.stringify(actions));
form.append("url", $("#url").val());
form.append("parent_id", $("#parent_id").val());
form.append("icon", $("#icon").val());
form.append("route_name", $("#route_name").val());
form.append("status", $("#status").val());
form.append("created_by", $("#created_by").val());

// form.append("table_model", "Module");

var settings = {
  "url": "/management/module/create",
  "method": "POST",
  "timeout": 0,
  "processData": false,
  "mimeType": "multipart/form-data",
  "contentType": false,
  "data": form,
  statusCode: {
        400: function(response) {
           response = JSON.parse(response);
      $.notify({
      message:response.message
   },{
    type:'danger',
    z_index:10000,
    timer:2000,
   });
        },
      500: function(){
        hideoverlay($("#contact-form"))
        $.notify({
      message:"Something went wrong"
   },{
    type:'danger',
    z_index:10000,
    timer:2000,
   });

      }
      }
};

await $.ajax(settings).done(function (response) {
    response = JSON.parse(response);
    $.notify({
      message:response.message
   },{
      type:'success',
    z_index:10000,
    timer:2000,
   });
   dataTable.draw();
//  console.log(response);
});
hideoverlay($("#exampleModal"))




        });
        var dataTable = $('#datatable').DataTable({
         'processing': true,
        serverSide: true,
        language: {
      processing: '<div class="loader-box"><div class="loader-2"></div></div>'},
      ajax: {
            'url':'/management/module/bind',
            'data': function(data){
                // Read values
              var Featured = $('#status').val();
              var toDate = $('#to_date').val();
              var fromDate = $('#from_date').val();
              var region = $('#region').val();
    
                // Append to data
              data.status = Featured;
              data.region = region;
             
              data.toDate = toDate;
              data.fromDate = fromDate;
            }
        },
        columns: [
                {data:'Name'},
                {data:'Slug',Orderable:false},
                {data:'Route',Orderable:false},
                {data:'Icon',Orderable:false},
                {data:'Actions',Orderable:false},
                {data:'Sub Modules',Orderable:false},
                {data:'Action',Orderable:false},
                  ],
        });
      
     
        $('#status').on('change',function(){
          dataTable.draw();
        });
        $('#region').on('change',function(){
          dataTable.draw();
        });
        $('#to_date').on('change',function(){
          dataTable.draw();
        });
        $('#from_date').on('change',function(){
          dataTable.draw();
        });
       
    });
</script>
<script>
    $("#from_date").prop('max',$("#to_date").val());
$("#to_date").change(function(){
  $("#from_date").prop('max',$("#to_date").val());
});
$("#from_date").change(function(){
  $("#to_date").prop('min',$("#from_date").val());
});
</script>



<script>
  const expense_row = (id) => $(`<tr id="new_row_${id}">
                        <td>
                         <select name="item" id=""  class="form-control">
                          <option value="0">Select New Item</option>
                         </select>
                        </td>
                        <td>
                          <input type="number" class="form-control qty" name="qty" value="1" min="1" onchange="changeQuantity(this)">
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
    console.log("remove",e)
    $(e).closest("tr").remove()

  }
  const add_row = () => {
    id++;
    $("#expense_body").append(expense_row(id)).find($(".remove_row")).bind("click", function(){
      remove_row(this)
    })
  }
  const changeQuantity = (obj) => {
    let quantity
      

     }


  $("#expense_body").on("change",".qty, .price",function(){
        
         let price = $(this).closest("tr").find(".price").val() 
         let qty = $(this).closest("tr").find(".qty").val() 


         $(this).closest("tr").find(".subtotal").val(qty*price)

         countTotal()

      })
  const countTotal = () => {
    let total = 0
    $(".subtotal").each((index,elem)=>{
         total = parseInt(total) + parseInt(elem.value)
    })
    $("#total").html(total)
  }

  const editHandler = (obj) => {
    let hide_input = $(obj).closest("div").find(".hide_input")
    if(hide_input.hasClass("d-none"))
    hide_input.removeClass("d-none")
    else
    hide_input.addClass("d-none")    
  }

  $(".editable").on("change",function() {
    let value = this.value

    $(this).closest("div").parent("div").find(".editable_value").html(value)
    let elem = $(this).closest("div").parent("div").find(".editable_value")
    editHandler(elem)

  })

  const add_item = () => {
    $("#itemModal").modal("show")
  }

  const addItemForm = (e,form) => {
    e.preventDefault()
    loadoverlay($("#add_item_form"))
    var form = new FormData();
					form.append("table_name", "items");
					form.append("name", $("#item_name").val());
					form.append("unit", $("#item_unit").val());
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
							400: function () {
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
							500: function () {
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

					$.ajax(settings).done(function (response) {
						var response2 = JSON.parse(response)
						hideoverlay($("#add_item_form"));
						$.notify({
							message: response2.message
						}, {
							type: 'success',
							z_index: 10000,
							timer: 2000,
						})

						

					},function(){
						window.open("/management/product/import","_self");
					});

      }

</script>

<!-- <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script> -->
@endsection