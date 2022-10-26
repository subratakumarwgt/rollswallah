@extends('userpanel.master')
@section('title', 'Track Order')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css')}}">
@endsection

@section('style')
@endsection
@section('breadcrumb-title')
<h5>Order Log</h5>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Orders</li>
<li class="breadcrumb-item active">Track Order </li>
<li class="breadcrumb-item active">{{@$order->order_id}} </li>
@endsection

@section('banner')
<div class="" style="height: 200px;position:fixed;filter: blur(12px);-webkit-filter: blur(12px);"><img src="{{asset('assets/images/bg_3-33.jpg')}}" alt="" style="min-width: 1000px;"></div>
@endsection

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="">

				<div class=" pt-3 pb-3 row text-ark">

					<input type="hidden" value="{{$order_log->order}}" id="booking">
					<input type="hidden" value="{{$order}}" id="order">
					<!-- cd-timeline Start-->
					<section class="cd-container" id="cd-timeline">
						@foreach($order_log->steps as $log)
						<input type="hidden" value="{{$log}}" class="steps">
						<div class="cd-timeline-block text-center" id="loader_{{$log->id}}">
							<div class="cd-timeline-content">
								<div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</div>
						</div>
						@endforeach




					</section>
					<!-- cd-timeline Ends-->
					<!-- Container-fluid ends                    -->
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/timeline/timeline-v-1/main.js')}}"></script>
<script src="{{asset('assets/js/modernizr.js')}}"></script>
<script>
	var booking = document.getElementById("booking");
	var order = document.getElementById("order");
	booking = JSON.parse(booking.value);
	 order = JSON.parse(order.value);
	const step_one = (data, dataJson,order) => $(`<div class="cd-timeline-block" >
							<div class="cd-timeline-img cd-picture bg-${data.class}"><i class="${data.icon}"></i></div>
							<div class="cd-timeline-content border-bottom border-top border-${data.class}">
								<h5 class="text-primary  p-2">${data.section_title}</h5>
								<p class="m-0  border-bottom">Order ID: <strong class="badge badge-warning text-dark pull-right">ID: ${dataJson.order_id}</strong></p>
								${order.orderDetails.map((value)=>{
									return (`<p class="m-0 border-bottom"><strong class="text-${data.class}"> ${value.quantity}x ${value.product.title} </strong>   <strong class="pull-right"> ₹ ${value.subtotal}</strong></p>`)
								})}								
								<p class="m-0 border-bottom">Total: <strong class="pull-right  text-${data.class}"><i class="fa fa-inr small"></i> ${order.total}.00</strong></p>
								<p class="m-0  text-right border-bottom"> Recieved on:<strong class="small pull-right"> ${dataJson.recieved_on}</strong></p>
							
							</div>
						</div>`);
	const step_one_append = (data, dataJson) => $(`<div class="cd-timeline-block ">
							<div class="cd-timeline-img cd-movie bg-${data.class}"><i class="${data.icon}"></i></div>
							<div class="cd-timeline-content border-bottom border-top border-${data.class}">
								<h5 class="text-primary  p-2">${data.section_title}</h5>
								<h6 class="p-1">Your Order is <span class="text-${data.class}"> ${data.status_name} <i class="${data.icon}"></i> .</span></h6>
								
							
										</div>
						</div>`);

	const step_two = (data, dataJson) => $(`<div class="cd-timeline-block ">
							<div class="cd-timeline-img cd-movie bg-${data.class}"><i class="${data.icon}"></i></div>
							<div class="cd-timeline-content border-bottom border-top border-${data.class}">
								<h5 class="text-primary  p-2">${data.section_title}</h5>
								<h6 class="p-1">Your Order is <span class="text-${data.class}"> ${data.status_name} <i class="${data.icon}"></i> .</span></h6>
								
							
								 <span class="small pull-right text-secondary">${data.status_name} on: <strong>  ${dataJson.cancelled_on ?? dataJson.confirmed_on}</strong></span>
							</div>
						</div>`);

	const step_three = (data, dataJson,order) => {
		return $(`<div class="cd-timeline-block ">
		               <div class="cd-timeline-img cd-movie bg-${data.class} "><i class="${data.icon}"></i></div>
							<div class="cd-timeline-content border-bottom border-top border-${data.class}">
								<h5 class="text-primary  p-2">${data.section_title}</h5>
								${order.orderDetails.map((value,index)=>{
									return (`<p class="m-0 border-bottom"><strong class=""> ${value.quantity}x ${value.product.title}</strong>   <strong class="pull-right"> ₹ ${value.subtotal}</strong></p>`)
								})}						
							
							</div>
						</div>`);

	}
	const step_four = (data, dataJson) => {
		return $(`<div class="cd-timeline-block border-bottom-${data.class}">
							<div class="cd-timeline-img cd-location bg-${data.class}"><i class="fa fa-comments-o"></i></div>
							<div class="cd-timeline-content">
								<h5 class="bg-light text-primary p-3">How was the food! <i class="fa fa-smile-o" aria-hidden="true"></i></h5>
								<div class="form-group">
									<label>Please share your feedback</label>
									<input type="text" name="" class="form-control">
									<button class="btn btn-pill btn-outline-primary mt-3"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
								</div>
								
							</div>
						</div>`)
	}

	const step_five = (data, dataJson) => {
		return $(`<div class="cd-timeline-block border-bottom-${data.class}">
							<div class="cd-timeline-img cd-location bg-${data.class}"><i class="fa fa-comments-o"></i></div>
							<div class="cd-timeline-content">
								<h5 class="bg-light text-primary p-3">Order is delivered <i class="fa fa-smile-o" aria-hidden="true"></i></h5>
								<p class="m-0 text-success text-center">${data.update_message}</strong></p>
								
							</div>
						</div>`)
	}
	
	const step_six = (data, dataJson,order) => {
		return $(`<div class="cd-timeline-block border-bottom-${data.class}">
							<div class="cd-timeline-img cd-location bg-${data.class}"><i class="fa fa-comments-o"></i></div>
							<div class="cd-timeline-content">
								<h5 class="bg-light text-primary p-3">Order is out for delivery <i class="fa fa-smile-o" aria-hidden="true"></i></h5>
								<p class="m-0 text-success text-center">
                                 <button class="btn btn-success" onlick="orderRecieved(order.order_id)">Order recieved</button></strong></p>
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
					if (dataJson.feedback !== "") {
					$("#cd-timeline").append(step_four(data, dataJson));
				} else {
					$("#cd-timeline").append(step_five(data, dataJson));
					
				}


					break;

				default:

					break;
			}
		})
	}

	setTimeout(() => {
		setNodes()
	}, 800);
</script>
@endsection