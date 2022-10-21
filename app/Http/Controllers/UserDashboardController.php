<?php

namespace App\Http\Controllers;

use App\Events\NewBooking;
use App\Models\Booking;
use App\Models\Cart;
use App\Models\Centre;
use App\Models\Doctor;
use App\Models\Product;
use App\Models\Slots;
use App\Models\StaticAsset;
use App\Models\Visits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserDashboardController extends Controller
{
    //

    public function index(Request $request){
        $data['ice_creams'] = Product::where("category","ice cream")->get();
        
        $data['fast_foods'] = Product::where("category","fast food")->get();
        
        
      return view('userpanel.home-page',$data);
    }
     public function loginView()
    {
        return view('userpanel.login');
    }
    public function registerView()
    {
        return view('userpanel.register');
    }
    public function dashboardView()
    {
        return view('userpanel.dashboard');
    }

    public function doctorView()
    {
        $doctor_list = Slots::groupBy('doctor_id')->get()->pluck('doctor_id');
        $doctors = [];
        $doctors = Doctor::whereIn('id',$doctor_list)->paginate(5);
        return view('userpanel.doctor-list',['doctors'=>$doctors]);
    }
    public function doctorProfile($doctor_id){       
        $doctor = Doctor::find($doctor_id);
        return view('userpanel.doctor-profile',['doctor'=>$doctor]);
    }
    public function profileEdit()
    {
        $user = Auth::User();
     //   $user = User::find($id);
        $profile_checked = "";
        $address_checked = "";
        if (!empty($user->profile())) {
            $profile_checked = "checked";
        }
        if (!empty($user->address())) {
            $address_checked = "checked";
        }
      //  $booking = Booking::find(1);
       
        return view("userpanel.profilepassword",['user'=>$user,'profile_checked'=>$profile_checked,'address_checked'=>$address_checked]);
    }
    public function productView(Request $request=null){
        $user_id = null;
        if(Auth::check()){
            $user_id = Auth::User()->id;
        }
        else{
            $user_id = Session::getId();
        }
       $categories = StaticAsset::getAssetsByTitle("product_categories");
       $subcategories =  StaticAsset::getAssetsByTitle("product_sub_categories");
        $products = Product::where('status',1);
        if (isset($request->search) && !empty($request->search)) {
           $products = $products->where("title","LIKE","%".$request->search."%")->orWhere("tags_json","LIKE","%".$request->search."%");
        }
        if (isset($request->category) && !empty($request->category)) 
        $products = $products->where("category",$request->category);

        $products = $products->paginate(9);
        return view('userpanel.product-list',['products'=>$products,'categories'=>$categories,'subcategories'=>$subcategories,'user_id'=>$user_id]);
    }
    public function myBookingList()
    {
        $bookings = Booking::where('user_id',Auth::User()->id)->orderBy('id','desc')->get();
        foreach ($bookings as $key => $booking) {
           $booking->doctor = Doctor::find($booking->doctor_id);
           $booking->centre = Centre::find($booking->centre_id);

        }
        return view('userpanel.booking_list',['bookings'=>$bookings]);
    }
    public function cartView()
    {
        if (Auth::check()) {
           $user_id = Auth::User()->id;
        }
        else 
        $user_id = Session::getId();
        $items = Cart::where('user_id',$user_id)->get();
        $subtotal = 0;
        $subtotal_total = 0;
        $discount = 0;
        foreach ($items as $key => $value) {
            $subtotal_total += ($value->product->pre_price * $value->quantity);
            $discount += ((!empty($value->product->on_offer) ?( $value->product->pre_price-$value->product->price) : 0 )* $value->quantity);      
            $subtotal += ((!empty($value->product->on_offer) ? $value->product->price : $value->product->pre_price )* $value->quantity);
        }
        return view('userpanel.cart',['items'=>$items,'subtotal'=>$subtotal,"subtotal_total" =>$subtotal_total, "discount" => $discount]);
    }
    public function checkout($subtotal=0){
        if (Auth::check()) {
               $user_id=Auth::User()->id;
              
          }
          else{
            $user_id = Session::getId();
          }
              if (Cart::where('user_id',$user_id)->count() > 0) {
                  # code...
              //  $user = \App\User::find($user_id);
    
              $items = Cart::where('user_id',$user_id)->get();
              $subtotal = 0;
              $subtotal_total = 0;
              $discount = 0;
              foreach ($items as $key => $value) {
                  $subtotal_total += ($value->product->pre_price * $value->quantity);
                  $discount += ((!empty($value->product->on_offer) ?( $value->product->pre_price-$value->product->price) : 0 )* $value->quantity);      
                  $subtotal += ((!empty($value->product->on_offer) ? $value->product->price : $value->product->pre_price )* $value->quantity);
              }
            $item_html = view('userpanel.components.checkoutcart',['cart_items'=>$items])->render();
           //  $charges = \App\charges::find(1);
    
            return view('userpanel.newcheckout',[
              'user_id' => $user_id,
                'subtotal' => $subtotal,
                "subtotal_total" => $subtotal_total,
                "discount" => $discount,
                'charges' => "",
                'item_html'=>$item_html
            ]);
              }
              
        }
    public function myBookingView($booking_id){
        $booking_id = Booking::where('booking_id',$booking_id)->first()->id;
        $appointment = new AppointmentController($booking_id);
        // $appointment = $appointment->appointment;
        //  dd($appointment);
        return view('userpanel.mybookings',['app_log'=>$appointment]);
    }

}
