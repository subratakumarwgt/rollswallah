
<?php $__env->startSection('title', 'Track Order'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/animate.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
<style>
	.rating{
  position: relative;
  display: flex;
  margin: 10px 0;
  flex-direction: row-reverse ;
}
.rating input{
  position: relative;
  width: 20px;
  height: 35px;
  display: flex;
  justify-content: center;
  align-items: center;
  -webkit-appearance: none;
  appearance: none;
  overflow: hidden;
}
.rating input::before{
  content: '\f005';
  position: absolute;
  font-family: fontAwesome;
  font-size: 28px;
  position: absolute;
  left: 4px;
  color: #030b0f;
  transition: 0.5s;
}
.rating input:nth-child(2n + 1)::before{
  right: 4px;
  left: initial;
}
.rating input:hover ~ input::before,
.rating input:hover::before,
.rating input:checked ~ input::before,
.rating input:checked::before{
  color: #1f9cff;
}	
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb-title'); ?>
<h5>Order Log</h5>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-items'); ?>
<li class="breadcrumb-item">Orders</li>
<li class="breadcrumb-item active">Track Order </li>
<li class="breadcrumb-item active"><?php echo e(@$order->order_id); ?> </li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('banner'); ?>
<div class="" style="height: 200px;position:fixed;filter: blur(12px);-webkit-filter: blur(12px);"><img src="<?php echo e(asset('assets/images/bg_3-33.jpg')); ?>" alt="" style="min-width: 1000px;"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="">

				<div class=" pt-3 pb-3 row text-ark">

					<input type="hidden" value="<?php echo e($order_log->order); ?>" id="booking">
					<input type="hidden" value="<?php echo e($order); ?>" id="order">
					<!-- cd-timeline Start-->
					<section class="cd-container" id="cd-timeline">
						<?php $__currentLoopData = $order_log->steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<input type="hidden" value="<?php echo e($log); ?>" class="steps">
						<div class="cd-timeline-block text-center" id="loader_<?php echo e($log->id); ?>">
							<div class="cd-timeline-content">
								<div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</div>
						</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




					</section>
					<!-- cd-timeline Ends-->
					<!-- Container-fluid ends                    -->
				</div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('assets/js/timeline/timeline-v-1/main.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/modernizr.js')); ?>"></script>
<script>
	function formatDate(date) {
  let diff = new Date() - date; // the difference in milliseconds

  if (diff < 1000) { // less than 1 second
    return 'right now';
  }

  let sec = Math.floor(diff / 1000); // convert diff to seconds

  if (sec < 60) {
    return sec + ' sec. ago';
  }

  let min = Math.floor(diff / 60000); // convert diff to minutes
  if (min < 60) {
    return min + ' min. ago';
  }

  // format the date
  // add leading zeroes to single-digit day/month/hours/minutes
  let d = date;
  d = [
    '0' + d.getDate(),
    '0' + (d.getMonth() + 1),
    '' + d.getFullYear(),
    '0' + d.getHours(),
    '0' + d.getMinutes()
  ].map(component => component.slice(-2)); // take last 2 digits of every component

  // join the components into date
  return d.slice(0, 3).join('.') + ' ' + d.slice(3).join(':');
}

	var booking = document.getElementById("booking");
	var order = document.getElementById("order");
	booking = JSON.parse(booking.value);
	 order = JSON.parse(order.value);
	const step_one = (data, dataJson,order) => $(`<div class="cd-timeline-block" >
							<div class="cd-timeline-img cd-picture bg-${data.class}"><i class="fa fa-check-square"></i></div>
							<div class="cd-timeline-content border-bottom border-top border-${data.class}">
								<h5 class="text-primary  p-2">${data.section_title}</h5>
								<p class="m-0  border-bottom">Order ID: <strong class="badge badge-warning text-dark pull-right">ID: ${dataJson.order_id}</strong></p>
								${JSON.parse(JSON.stringify(order.orderDetails)).map((value)=>{
									return (`<p class="m-0 border-bottom"><strong class="text-${data.class}"> ${value.quantity}x ${value.product.title} </strong>   <strong class="pull-right"> ₹ ${value.subtotal}</strong></p>`)
								}).join('')}								
								<p class="m-0 border-bottom">Total: <strong class="pull-right  text-${data.class}"><i class="fa fa-inr small"></i> ${order.total}.00</strong></p>
								<p class="m-0  text-right border-bottom"> Recieved on:<strong class="small pull-right"> ${formatDate(new Date(order.created_at))}</strong></p>
								<p class="m-0 text-success text-center">${data.update_message}</strong></p>
							</div>
						</div>`);
	const step_one_append = (data, dataJson) => $(`<div class="cd-timeline-block ">
							<div class="cd-timeline-img cd-movie bg-${data.class}"><i class="fa fa-check-square"></i></div>
							<div class="cd-timeline-content border-bottom border-top border-${data.class}">
								<h5 class="text-primary  p-2">${data.section_title}</h5>
								<h6 class="p-1">Your Order is <span class="text-${data.class}"> ${data.status_name} <i class="fa fa-check-square"></i> .</span></h6>
								<p class="m-0 text-success text-center">${data.update_message}</strong></p>
							</div>
						</div>`);

	const step_two = (data, dataJson) => $(`<div class="cd-timeline-block ">
							<div class="cd-timeline-img cd-movie bg-${data.class}"><i class="fa fa-check-square"></i></div>
							<div class="cd-timeline-content border-bottom border-top border-${data.class}">
								<h5 class="text-primary  p-2">${data.section_title} <i class="fa fa-check-circle"></i>  | <small>${formatDate(new Date(dataJson.confirmed_on))}</small></h5>
								<h6 class="p-1">Your Order is <span class="text-${data.class}"> ${data.status_name} <i class="fa fa-check-circle"></i> .</span></h6>		
								<p class="m-0 text-success text-center">${data.update_message}</strong></p>					
							</div>
						</div>`);

	const step_three = (data, dataJson,order) => {
		return $(`<div class="cd-timeline-block ">
		               <div class="cd-timeline-img cd-movie bg-${data.class} "><i class="fa fa-check-square"></i></div>
							<div class="cd-timeline-content border-bottom border-top border-${data.class}">
								<h5 class="text-primary  p-2">Ready <i class="fa fa-check-circle"></i>  | <small>${new Date(Date.parse(dataJson.ready_on)).toDateString()}</small></h5>
								${order.orderDetails.map((value,index)=>{
									return (`<p class="m-0 border-bottom"><strong class=""> ${value.quantity}x ${value.product.title}</strong>   <strong class="pull-right"> ₹ ${value.subtotal}</strong></p>`)
								}).join('')}						
								<p class="m-0 text-success text-center">${data.update_message}</strong></p>
							</div>
							
						</div>`);

	}
	const step_four = (data, dataJson) => {
		return $(`<div class="cd-timeline-block border-bottom-${data.class}">
							<div class="cd-timeline-img cd-location bg-${data.class}"> <i class="fa fa-check-square"></i></div>
							<div class="cd-timeline-content">
							
								<h5 class="bg-light text-success p-3">How was the food ?<i class="fa fa-smile-o" aria-hidden="true"></i></h5>
								<div class="form-group">
								
									<div class="rating">
									<input type="radio" name="html" class="rating_radio" value="5.0">
									<input type="radio" name="html" class="rating_radio" value="4.5">
									<input type="radio" name="html" class="rating_radio" value="4.0">
									<input type="radio" name="html" class="rating_radio" value="3.5">
									<input type="radio" name="html" class="rating_radio" value="3.0">
									<input type="radio" name="html" class="rating_radio" value="2.5">
									<input type="radio" name="html" class="rating_radio" value="2.0">
									<input type="radio" name="html" class="rating_radio" value="1.5">
									<input type="radio" name="html" class="rating_radio" value="1.0">
									<input type="radio" name="html" class="rating_radio" value="0.5">
									
									</div>	
									<label>Please share your feedback</label>
								</div>
								
							</div>
						</div>`)
	}

	const step_five = (data, dataJson) => {
		return $(`<div class="cd-timeline-block border-bottom-${data.class}">
							<div class="cd-timeline-img cd-location bg-${data.class}"><i class="fa fa-check-square"></i></div>
							<div class="cd-timeline-content">
								<h5 class="bg-light text-primary p-3">Delivered <i class="fa fa-check-circle" aria-hidden="true"></i> | <small>${formatDate(new Date(dataJson.delivered_on))}</small></h5>
								<p class="m-0 text-success text-center">${data.update_message}</strong></p>
								
							</div>
						</div>`)
	}
	
	const step_six = (data, dataJson,order) => {
		return $(`<div class="cd-timeline-block border-bottom-${data.class}">
							<div class="cd-timeline-img cd-location bg-${data.class}"><i class="fa fa-check-square"></i></div>
							<div class="cd-timeline-content">
								<h5 class="bg-light text-primary p-3">Packed & Handed Over <i class="fa fa-check-circle" aria-hidden="true"></i> | <small>${formatDate(new Date(dataJson.packed_on))}</small></h5>
								<p class="m-0 text-success text-center">${data.update_message}</strong></p>
								<p class="m-0 text-success text-center">
                                ${order.status != "complited" ? `<button class="btn btn-success" onclick="deliverOrder(${order.order_id},this)">Order recieved</button>` : "" } </strong></p>
							</div>
						</div>`)
	}
	var steps = document.getElementsByClassName("steps");
	const setNodes = async () => {
		// let order = $("#order").val();
		await steps.forEach(element => {
			let data = JSON.parse(element.value);
			let dataJson = JSON.parse(data.section_content_json)
			var container = document.getElementById("cd-timeline");
			$("#loader_" + data.id).remove();

			switch (parseInt(data.step_no)) {

				case 1:

					$("#cd-timeline").append(step_one(data, dataJson,order));
					break;
				case 2:
					$("#cd-timeline").append(step_two(data, dataJson));

					break;
				case 3:
					$("#cd-timeline").append(step_three(data, dataJson,order));				

					break;
				case 4:
				
					$("#cd-timeline").append(step_six(data, dataJson,order));
				
					
					break;
				case 5:
					$("#cd-timeline").append(step_five(data, dataJson));
					if (dataJson.feedback !== "") {
					$("#cd-timeline").append(step_four(data, dataJson));
				} else {
					
					
				}


					break;

				default:

					break;
			}
		})
	}

	setTimeout(() => {
		setNodes()
	}, 100);
	const deliverOrder = async (order_id,form) => {
    
        loadoverlay($(form))
        let packOrder =await $.post("/api/deliver-order/"+order_id)
                            .then((data)=>{
                                hideoverlay($(form))
                                $.notify({
									message: "Order marked as delivered"
								}, {
									type: 'success',
									z_index: 10000,
									timer: 2000,
								})
                            })
                            .error(error =>{
                                hideoverlay($(form))
                                // getOrderHistory(order_id)
                            })
    }
	
	$("#cd-timeline").on("change",".rating_radio",function(){
          
		 
		 alert($(this).val())
	  })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('userpanel.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\subra\Documents\projects\rollswallah\resources\views/userpanel/trackOrder.blade.php ENDPATH**/ ?>