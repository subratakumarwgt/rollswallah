
<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/animate.css')); ?>">

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/owlcarousel.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
<style>
    .product_img_wrapper{
        height: 260px;
        overflow: hidden;
    }
    @media(max-width:600px) {
        .product_img_wrapper{
        height: 120px;
        overflow: hidden;
    }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-title'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-items'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('banner'); ?>
<div class="" style="height: 200px;position:fixed;filter: blur(12px);-webkit-filter: blur(12px);"><img src="<?php echo e(asset('assets/images/bg_3-33.jpg')); ?>" alt="" style="min-width: 1000px;"></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<input type="hidden" id="user_id" value="<?php echo e($user_id); ?>">
<div class="row justify-content-center">    
    <!-- <div class="col-md-12">
        <img src="<?php echo e(asset('assets/images/icecreambg1.png')); ?>" alt="" width="100%" >
    </div>  -->
  
        <div class="col-md-12">
            <div class="card-header h6 text-primary">Categories</div>
            <div class="card-body">
                <div class="owl-carousel owl-theme" id="owl-carousel-13">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="item border border-success shadow">
                    <div class="card-body  shadow-sm <?php if(isset($_GET['category']) && $category != $_GET['category']): ?> text-light bg-dark <?php else: ?> text-primary bg-light <?php endif; ?> rounded"> <a href="/"><i class="fa fa-dot-circle-o text-light" aria-hidden="true"></i> <?php echo e(strtoupper($category)); ?> </a></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="item">                                   
                     <div class="card-body bg-dark text-white shadow-sm  border-bottom  border-primary rounded "> <a href="/"><i class="fa fa-heart text-danger" aria-hidden="true"></i> <?php echo e(strtoupper($category)); ?>  </a></div>
                     </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-12">
            <div class="card-header h5 text-primary">Collections</div>
            <div class="card-body">
                <div class="owl-carousel owl-theme" id="owl-carousel-13-1">
                    <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="item">                                   
                     <div class="card-body bg-white shadow-sm text-dark border-bottom  border-primary rounded "> <a href="/"><i class="fa fa-heart text-danger" aria-hidden="true"></i> <?php echo e(strtoupper($category)); ?>  </a></div>
                     </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div> -->
         </div>
<div class="container-fluid product-wrapper mt-4">
   <div class="product-grid">
      <div class="feature-products">
         
       
         <div class="product-wrapper-grid">
         <div class="row justify-content-center">
             <div class="col-md-12">
                 <div class="row">
                 <div class="card-header card-header h6 text-primary mb-2">Menu <i class="fa fa-cutlery"></i></div>
        <?php if($products->count() > 0): ?>
       
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      
            <div class="col-xl-3 col-md-3 col-sm-6 xl-3">
             
                  <div class="product-box">
                  
               <div class="card">
               <div class="row">
                    <div class="col-md-12 col-sm-12 col-5">
                     <div class="product-img  product_img_wrapper" >
                        <img class="img-fluid" src="/<?php echo e($product->image); ?>" alt="" >
                        <?php if(!empty($product->on_offer)): ?>
                        <div class="ribbon ribbon-danger text-white border-danger ribbon-bottom-left ">offer!</div>
                        <?php endif; ?>
                        <div class="product-hover">
                           <ul>
                              <li>
                                 <button class="btn add-to-cart" type="button" data-product = "<?php echo e($product->id); ?>"><i class="icon-shopping-cart"></i></button>
                              </li>
                              <li>
                                 <button class="btn" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter_<?php echo e($product->id); ?>"><i class="icon-eye"></i></button>
                              </li>
                              <!-- <li>
                                 <button class="btn" type="button"><i class="icofont icofont-law-alt-2"></i></button>
                              </li> -->
                           </ul>
                        </div>
                     </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-7">
                     <div class="modal fade" id="exampleModalCenter_<?php echo e($product->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter_<?php echo e($product->id); ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                           <div class="modal-content" id="modal_content_<?php echo e($product->id); ?>">
                              <div class="modal-header">
                                 <div class="product-box row">
                                    <div class="product-img col-lg-6"><img class="img-fluid" src="/<?php echo e($product->image); ?>" alt="" id="img_<?php echo e($product->id); ?>"></div>
                                    <div class="product-details col-lg-6 text-start">
                                       <h4 id="title_<?php echo e($product->id); ?>" class=""><?php echo e($product->title); ?></h4>
                                       <div class="product-price" id="price_<?php echo e($product->id); ?>"><i class="fa fa-inr"></i><?php echo e($product->price); ?>

                                        <del class="text-danger" id="pre_price_<?php echo e($product->id); ?>"> MRP: <i class="fa fa-inr"></i><?php echo e($product->pre_price); ?></del>
                                       </div>
                                     
                                      
                                          <div class="product-qnty">
                                          <h6 class="f-w-600">Quantity</h6>
                                          <fieldset>
                                             <div class="input-group">
                                                <input class="touchspin text-center" type="text" value="1" id="product_qty_<?php echo e($product->id); ?>" readonly="">
                                             </div>
                                          </fieldset>
                                          <div class="addcart-btn">
                                             <button class="btn btn-dark btn-pill add-to-cart" type="button" data-quantity="<?php echo e($product->id); ?>" data-product = "<?php echo e($product->id); ?>" id="addBtn_<?php echo e($product->id); ?>">Add to Cart</button>
                                             
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
                        <strong class="h6 product_title_1" > <?php echo e($product->title); ?></strong>
                        <div class="product-price text-success "><i class="fa fa-inr"></i> <?php echo e($product->price); ?>

                           <del class="text-danger"><small><i class="fa fa-inr"></i> <?php echo e($product->pre_price); ?>   </small> </del>
                        </div>
                        <div class="addcart-btn">
                            <button class="btn btn-dark btn-pill add-to-cart" type="button" data-quantity="<?php echo e($product->id); ?>" data-product = "<?php echo e($product->id); ?>" id="addBtn_<?php echo e($product->id); ?>">Add <i class="fa fa-shopping-cart"></i></button>
                        </div>
                     </div>
                    </div>
                  </div>
               </div>
            </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
         </div>
        <?php else: ?>
        <div class="alert alert-danger">Sorry! We could not load more products</div>
        <?php endif; ?>
        <?php if($products->hasMorePages()): ?>
        <div class="col-md-10 pull-right bg-white rounded"><a class="nav-link" href=" <?php echo e($products->nextPageUrl()); ?>">See More...</a></div>
        <?php endif; ?>
      
        </div>
        </div>
    </div>
</div>
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>


<script src="<?php echo e(asset('assets/js/touchspin/touchspin.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/touchspin/input-groups.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/owlcarousel/owl.carousel.js')); ?>"></script>

<script src="<?php echo e(asset('assets/js/product-tab.js')); ?>"></script>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('userpanel.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\subra\Documents\projects\rollswallah\resources\views/userpanel/product-list.blade.php ENDPATH**/ ?>