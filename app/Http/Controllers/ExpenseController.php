<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetails;

class ExpenseController extends Controller
{
    //


    public function viewDailyExpense(){
        return view("adminpanel.expenses.addDailyExpense");
    }
    public function viewQuickOrder($id = null){
        $data["isNew"] = "false";
        if(empty($id)){
            $data["order_id"] = Order::create([
                "status" => "draft",
                "order_type" =>"dine_in",
                "item_count" => 0
            ])->id;
            $order = Order::find($data["order_id"]);
            $order->order_id = time().$data["order_id"];
            $order->save();
            $data["isNew"] = "true";
            $data["order"] = $order;

        }
        else{
            $order = Order::where("order_id",$id)->first();
            if($order)
            $order->orderDetails = $order->orderDetails;
            // dd($order->chargeDetails->charge);
            $data["order"] = $order;
           
        }
        
        $data["order_id"] = $order->order_id;
        return view("adminpanel.expenses.addQuickOrder",$data);
    }
   

}
