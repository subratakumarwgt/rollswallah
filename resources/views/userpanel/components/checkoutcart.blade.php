@foreach($cart_items as $cart_item)
<li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <img src="/{{$cart_item->product->image}}" class="img-fluid" width="100px">
                        </div>
                        <div>
                            <h6 class="my-0">{{$cart_item->product->title}}</h6>
                            <small class="text-muted"><strong>X</strong>{{$cart_item->quantity}}</small>
                        </div>

                        <span class="text-muted"><i class="fa fa-inr"></i> {{$cart_item->quantity* $cart_item->product->price}}</span>
                    </li>
@endforeach