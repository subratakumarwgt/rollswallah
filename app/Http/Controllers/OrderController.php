<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Centre;
use App\Models\Doctor;
use App\Models\Order;
use App\Models\orderLog;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public $order;
    public $steps;

    private $current_status;

    private $current_step;


    public function __construct($id){
    	$this->order = Order::find($id);
        
        $this->steps =  $this->order->logs;
        // dd($this->steps);
        // $this->setConfirmation();
        // $this->setVisitInfo();
        // $this->setFeedback();
        $this->getCurrentStatus();
    }
    public function getCurrentStatus(){
        try {
            $this->current_status = @$this->order->logs->last()->status_name;
            $this->current_step = @$this->order->logs->last()->step_no;
            return @$this->order->logs->last();
        } catch (\Throwable $th) {
            $this->logger("get_order_current_status_error",json_encode(["error"=>$th->getMessage(),"data"=>$this->order]));
            return false;
        }      

    }
    public function getDetailsByStep($step_no){
        return @$this->order->logs->where('step_no',$step_no)->first();
    }
  

    public function setOrderDetails(){
        try {
           
            $log = new orderLog();
            $log->order_id = $this->order->id;
            $log->update_message = "Order has been recieved.";
            $log->status_name = "requested";
            $log->section_title = "Order Details";
            $log->section_content_json = json_encode([
                'order_id' => $this->order->order_id,
                'order_for'=>$this->order->booking_type,
                'order_details'=>$this->order->orderDetails,
                'recieved_on'=>$this->order->created_at
            ]);
            $log->step_no = 1;
            $log->icon = 'fa fa-pencil';
            $log->class = 'success';
            if ($log->save()) {
                return true;
            }
            else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->logger("set_booking_details_error",json_encode(["error"=>$th->getMessage(),"data"=>$this->order]));
            return false;
        }
      
    }
    public function getOrderDetails(){
        try {
         return $this->order->logs->where('step_no',1)->first();
           
        } catch (\Throwable $th) {
            $this->logger("get_booking_details_error",json_encode(["error"=>$th->getMessage()]));
            return false;
        }
      
    }
    public function setConfirmation($time = ""){
        try {
           
            $log = new orderLog();
            $log->order_id = $this->order->id;
            $log->update_message = "Order has been confirmed.";
            $log->status_name = "confirmed";
            $log->section_title = "Confirmation";
            $log->section_content_json = json_encode([
                'order_id' => $this->order->order_id,
                'confirmed_on'=>date("Y-m-d H:i:s"),
                'estimated_delivery'=>""
            ]);
            $log->step_no = 2;
            $log->icon = 'fa fa-check';
            $log->class = 'success';
            if ($log->save()) {
                return true;
            }
            else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->logger("set_booking_details_error",json_encode(["error"=>$th->getMessage()]));
            return false;
        }
      
    }
    public function setCancel(){
        try {
            $log = new orderLog();
            $log->order_id = $this->order->id;
            $log->update_message = "Booking has been cancelled.";
            $log->status_name = "cancelled";
            $log->section_title = "Confirmation";
            $log->section_content_json = json_encode([
                'order_id' => $this->order->order_id,
                'cancelled_on'=>date("Y-m-d H:i:s"),
                'refund'=>'processing'
            ]);
            $log->step_no = 2;
            $log->icon = 'fa fa-close';
            $log->class = 'danger';
            if ($log->save()) {
                return true;
            }
            else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->logger("set_booking_details_error",json_encode(["error"=>$th->getMessage()]));
            return false;
        }
      
    }
    public function setVisitInfo(){
        try {
            $doctor =  Doctor::find($this->order->doctor_id);
            $centre =  Centre::find($this->order->centre_id);
            if ($this->order->booking_type != "check_up") {
             // $diagnosis = null;
            }
            $log = new orderLog();
            $log->order_id = $this->order->id;
            $log->update_message = "Visit info set.";
            $log->status_name = "visit info";
            $log->section_title = "Visit Info";
            $log->section_content_json = json_encode([
                'order_id' => $this->order->order_id,
                'timming'=> $this->order->booking_time,
                'doctor' => $doctor->name,
                'centre' => $centre->name,
                'fees'=>$doctor->full_charge,
                'address'=>$centre->address,
            ]);
            $log->step_no = 3;
            $log->icon = 'fa fa-calendar';
            $log->class = 'success';
            if ($log->save()) {
                return true;
            }
            else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->logger("set_booking_details_error",json_encode(["error"=>$th->getMessage()]));
            return false;
        }
      
    }
     public function setFeedback($feedback=""){
        try {
            $log = new orderLog();
            $log->order_id = $this->order->id;
            $log->update_message = "Feedback submited.";
            $log->status_name = "feedback";
            $log->section_title = "Get well soon!";
            $log->section_content_json = json_encode([
                'order_id' => $this->order->order_id,
                'visited_on'=>date("Y-m-d H:i:s"),
                'feedback'=>$feedback
            ]);
            $log->step_no = 4;
            $log->icon = 'fa fa fa-comments-o';
            $log->class = 'success';
            if ($log->save()) {
                $this->order->review = $feedback;
                return true;
            }
            else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->logger("set_booking_details_error",json_encode(["error"=>$th->getMessage()]));
            return false;
        }
      
    }
    public function getFeedback(){
        try {
            return $this->order->logs->where('step_no',4)->first();
              
           } 
        catch (\Throwable $th) {
               $this->logger("get_feed_details_error",json_encode(["error"=>$th->getMessage()]));
               return false;
           }
      
    }
    public function getConfirmation(){
        try {
            return $this->order->logs->where('step_no',2)->first();
              
           } 
        catch (\Throwable $th) {
               $this->logger("get_confirm_details_error",json_encode(["error"=>$th->getMessage()]));
               return false;
           }
      
    }
    public function getVisitInfo(){
        try {
            return $this->order->logs->where('step_no',3)->first();
              
           } 
        catch (\Throwable $th) {
               $this->logger("get_visit_details_error",json_encode(["error"=>$th->getMessage()]));
               return false;
           }
      
    }
    private function getEstimatedDeliveryTime($minutes = 40){
        return date("Y-m-d H:i:s",strtotime("+".$minutes." minutes"));
    }
}
