@extends('userpanel.master')
@section('title', 'Dashboard')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')

@endsection

@section('breadcrumb-items')

@endsection
@section('banner')
<div class="" style="height: 200px;position:fixed;filter: blur(12px);-webkit-filter: blur(12px);"><img src="{{asset('assets/images/bg_3-33.jpg')}}" alt="" style="min-width: 1000px;"></div>
@endsection
@section('content')
<input type="hidden" id="user_id" value="{{$user_id}}">
<div class="row justify-content-center">
         <div class="col-12">
        <div class="knowledgebase-bg"><img class="bg-img-cover bg-center" src="{{asset('assets/images/product-search.png')}}" alt="looginpage" style="width: 500px;"></div>
        <div class="knowledgebase-search">
            <div>
                <h3>Search your product here</h3>
                <form class="form-inline" action="#" method="get">
                    <div class="mb-3 w-100"><i data-feather="search"></i>
                        <input class="form-control w-100" type="text" placeholder="Search by Name, Clinic, Specialist etc." title="" id="search_product">
                    </div>
                </form>
            </div>
        </div>
    </div>
  
        <div class="col-md-12">
            <div class="card-header h4 text-primary">Categories</div>
            <div class="card-body">
                <div class="owl-carousel owl-theme" id="owl-carousel-13">
                    @foreach($categories as $category)
                    <div class="item">
         <div class="card-body bg-white shadow-sm text-primary border-bottom border-danger rounded"> <a href="/"><i class="fa fa-dot-circle-o text-dark" aria-hidden="true"></i> {{strtoupper($category)}} </a></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card-header h5 text-primary">Collections</div>
            <div class="card-body">
                <div class="owl-carousel owl-theme" id="owl-carousel-13-1">
                    @foreach($subcategories as $category)
                    <div class="item">                                   
        <div class="card-body bg-white shadow-sm text-dark border-bottom  border-primary rounded "> <a href="/"><i class="fa fa-heart text-danger" aria-hidden="true"></i> {{strtoupper($category)}}  </a></div>
                     </div>
                    @endforeach
                </div>
            </div>
        </div>
         </div>
<div class="container-fluid product-wrapper mt-4">
   <div class="product-grid">
      <div class="feature-products">
         
       
         <div class="product-wrapper-grid">
         <div class="row justify-content-center">
             <div class="col-md-12">
                 <div class="row">
                 <div class="card-header card-header h5 text-primary mb-2">Items</div>
        @if($products->count() > 0)
       
        @foreach($products as $product)
      
            <div class="col-xl-3 col-md-3 col-sm-6 xl-3">
             
                  <div class="product-box">
                  
               <div class="card">
               <div class="row">
                    <div class="col-md-12 col-sm-12 col-5">
                     <div class="product-img">
                        <img class="img-fluid" src="/{{$product->image}}" alt="" height="180px">
                        @if(!empty($product->on_offer))
                        <div class="ribbon ribbon-danger text-white border-danger ribbon-bottom-left ">offer!</div>
                        @endif
                        <div class="product-hover">
                           <ul>
                              <li>
                                 <button class="btn add-to-cart" type="button" data-product = "{{$product->id}}"><i class="icon-shopping-cart"></i></button>
                              </li>
                              <li>
                                 <button class="btn" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter_{{$product->id}}"><i class="icon-eye"></i></button>
                              </li>
                              <!-- <li>
                                 <button class="btn" type="button"><i class="icofont icofont-law-alt-2"></i></button>
                              </li> -->
                           </ul>
                        </div>
                     </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-7">
                     <div class="modal fade" id="exampleModalCenter_{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter_{{$product->id}}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                           <div class="modal-content" id="modal_content_{{$product->id}}">
                              <div class="modal-header">
                                 <div class="product-box row">
                                    <div class="product-img col-lg-6"><img class="img-fluid" src="/{{$product->image}}" alt="" id="img_{{$product->id}}"></div>
                                    <div class="product-details col-lg-6 text-start">
                                       <h4 id="title_{{$product->id}}" class="">{{$product->title}}</h4>
                                       <div class="product-price" id="price_{{$product->id}}"><i class="fa fa-inr"></i>{{$product->price}}
                            <del class="text-danger" id="pre_price_{{$product->id}}"> MRP: <i class="fa fa-inr"></i>{{$product->pre_price}}</del>
                                       </div>
                                     
                                      
                                          <div class="product-qnty">
                                          <h6 class="f-w-600">Quantity</h6>
                                          <fieldset>
                                             <div class="input-group">
                                                <input class="touchspin text-center" type="text" value="1" id="product_qty_{{$product->id}}" readonly="">
                                             </div>
                                          </fieldset>
                                          <div class="addcart-btn">
                                             <button class="btn btn-dark btn-pill add-to-cart" type="button" data-quantity="{{$product->id}}" data-product = "{{$product->id}}" id="addBtn_{{$product->id}}">Add to Cart</button>
                                             
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="product-details">                       
                        <strong class="h6 product_title_1" > {{$product->title}}</strong>
                        <div class="product-price text-success "><i class="fa fa-inr"></i> {{$product->price}}
                           <del class="text-danger"><small><i class="fa fa-inr"></i> {{$product->pre_price}}   </small> </del>
                        </div>
                     </div>
                    </div>
                  </div>
               </div>
            </div>
            </div>
        @endforeach
        </div>
         </div>
        @else
        <div class="alert alert-danger">Sorry! We could not load more products</div>
        @endif
        @if($products->hasMorePages())
        <div class="col-md-10 pull-right bg-white rounded"><a class="nav-link" href=" {{$products->nextPageUrl()}}">See More...</a></div>
        @endif
        <div class="col-md-12 bg-white mt-3">
               <div class="card-body">
                  <div class="collection-filter-block">
                     <div class="row p-4">
                        <div class="col-md-4 ">
                           <div class="media ">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                              <div class="media-body">
                                 <h5>Free Shipping Above <i class="fa fa-inr small"></i>500</h5>
                                 <p>Free Shipping World Wide</p>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4 ">
                           <div class="media">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                              <div class="media-body">
                                 <h5>24 X 7 Service                                    </h5>
                                 <p>Online Booking Service For Patients</p>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4 ">
                           <div class="media">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                              <div class="media-body">
                                 <h5>Festival Offer                                 </h5>
                                 <p>Offers & Savings all time</p>
                              </div>
                           </div>
                        </div>
                       
                     </div>
                  </div>
               </div>
               <!-- silde-bar colleps block end here-->
            </div>
        </div>
        </div>
    </div>
</div>
</div>



@endsection

@section('script')


<script src="{{asset('assets/js/touchspin/touchspin.js')}}"></script>
<script src="{{asset('assets/js/touchspin/input-groups.min.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>

<script src="{{asset('assets/js/product-tab.js')}}"></script>
<script>
    var owl_carousel_custom = {
        init: function() {
            var owl = $('#owl-carousel-13');
            owl.owlCarousel({
                items: 6,
                loop: true,
                margin: 30,
                autoplay: true,
                autoWidth:true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                nav: false,
                dots: false,

            });
            var owl = $('#owl-carousel-13-1');
            owl.owlCarousel({
                items: 6,
                loop: true,
                margin: 30,
                autoplay: true,
                autoWidth:true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                nav: false,
                dots: false,

            });
            var owl = $('.owl-carousel-15');
            owl.owlCarousel({
                items: 2,
                dots: false,
                loop: true,
                nav: false,
                autoplay: true,
                autoWidth:true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                margin: 30,
            }), owl.on('mousewheel', '.owl-stage', function(e) {
                if (e.deltaY > 0) {
                    owl.trigger('next.owl');
                } else {
                    owl.trigger('prev.owl');
                }
                e.preventDefault();
            });
        }
    };

    (function($) {
        "use strict";
        owl_carousel_custom.init();

    })(jQuery);

 
</script>
<script>
//  $(document).ready(function(){
    $(".add-to-cart").on('click',function(e){
    var product_id = $(this).data('product')
    var qty_id =  $(this).data('quantity');
    e.preventDefault();
  var  button = $(this);
loadoverlay(button);
var quantity = $("#product_qty_"+qty_id).val();
if (quantity) {}else quantity = 1;
var form = new FormData();
form.append("user_id", $('#user_id').val());
form.append("product_id", product_id);
form.append("quantity",quantity);

var settings = {
  "url": "/api/add-to-cart",
  "method": "POST",
  "timeout": 0,
  "processData": false,
  "mimeType": "multipart/form-data",
  "contentType": false,
  "data": form,
  statusCode: {
                400: function(res) {
                    hideoverlay(button)
                    res = JSON.parse(res.responseText)
                button.prop('disabled', false);
                if (res.duplicate) {
                    button.prop('disabled', true);
                   
                }
               
                $.notify({
                    message: res.message
                }, {
                    type: 'danger',
                    z_index: 10000,
                    timer: 5000,
                });
                },
                500: function() {
                    hideoverlay(button)
                button.prop('disabled', false);
                $.notify({
                    message: "Something went wrong! Please try again"
                }, {
                    type: 'danger',
                    z_index: 10000,
                    timer: 5000,
                })
                }
            }
};

$.ajax(settings).done(function (response) {
    response = JSON.parse(response)
  hideoverlay(button)
  button.prop('disabled', true);
 var count =  parseInt($("#cart_count").html())
 $("#cart_count").html(++count)
 var cartComponent = $(` <li class="mt-0">
              <div class="media">
              
                <div class="media-body">
                  <a class="text-secodary product_title" data-toggle="tooltip" title="${response.data.product.title}">${truncate(response.data.product.title,27)}</a>
                  <p><i class="fa fa-inr"></i>${response.data.product.price}</p>
                  <p>X ${response.data.quantity}</p>                  
                  <h6 class="text-end text-muted"><small>Subtotal:</small> <i class="fa fa-inr"></i> ${parseInt(response.data.product.price)*parseInt(response.data.quantity)}</h6>
                </div>
                <div class="close-circle"><a href="#"><i class="fa fa-trash text-danger"></i></a></div>
              </div>
            </li>`);
            $("#cart_row").after(cartComponent);

        $.notify({
            message: response.message
        }, {
            type: 'success',
            z_index: 10000,
            timer: 5000,
        });
});

 
})

//    })
$(".varient_type").on('click',async function(){
  var product_id = $(this).data('product');
  var varient_id = $(this).data('varient');
loadoverlay($("#modal_content_"+product_id))
        await   $.get("/api/product/get/"+varient_id, function(data, status){
          $("#title_"+product_id).html(data.data.title);
           $("#price_"+product_id).html(`<i class="fa fa-inr"></i>${data.data.price}`);
            $("#pre_price_"+product_id).html(`MRP: <i class="fa fa-inr"></i>${data.data.pre_price}`);
            $("#addBtn_"+product_id).data('product',data.data.id);
          $.each($(".varient_type"),function(){
          $(this).removeClass('active');
          })
          $(this).addClass('active');
         if(data.data.image)
          $("#img_"+product_id).attr('src','/'+data.data.image);
          //window.image_src = 
        
      });
 hideoverlay($("#modal_content_"+product_id));
})

    

</script>
<script>
$.each($(".product_title_1"),function(){
  $(this).html(truncate($(this).html(),35));
})
</script>

@endsection