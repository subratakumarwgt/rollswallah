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
    public function viewSalesReport(){
        $data = [];
        
        return view("adminpanel.expenses.salesReport");
    }
    public function bindSales(Request $request)
    {
		$draw = $request->draw;

		$start = $request->start;
		$rowperpage = $request->length;

		$columnIndex_arr = $request->order;

		$columnName_arr = $request->columns;
		$order_arr = $request->order;
		$search_arr = $request->search;
		$columnIndex = $columnIndex_arr[0]['column'];
		$columnName = $columnName_arr[$columnIndex]['data'];
		$columnSortOrder = @$order_arr[0]['dir'];
		$searchValue = @$search_arr['value'];
		$recordsQuery = Order::where("status","completed");
		$sort = 0;
		if ($searchValue != "") {
			$sort = 1;
			$_SESSION['key'] = $searchValue;
			$recordsQuery = $recordsQuery->where('orders.note', 'LIKE', '%' . $_SESSION['key'] . '%')
				->orWhere('orders.user_contact', 'LIKE', '%' . $_SESSION['key'] . '%')->orWhere('orders.order_type', 'LIKE', '%' . $_SESSION['key'] . '%')->orWhere('orders.payment_type', 'LIKE', '%' . $_SESSION['key'] . '%')->orWhere('orders.id', 'LIKE', '%' . $_SESSION['key'] . '%');
		}
		if (isset($request->order_type) && !empty($request->order_type)) {
			$recordsQuery = $recordsQuery->where('order_type', $request->order_type);
		}
		if (isset($request->payment_type) && !empty($request->payment_type)) {
			$recordsQuery = $recordsQuery->where('payment_type', $request->payment_type);
		}
		//   if (isset($request->is_header) && !empty($request->is_header)) {
		// 	$recordsQuery = $recordsQuery->where('is_header',$request->is_header);
		// }
		if (isset($request->from_date) && !empty($request->from_date)) {
			$recordsQuery = $recordsQuery->whereDate('orders.created_at', '>=', $request->from_date);
		}
		if (isset($request->to_date) && !empty($request->to_date)) {
			$recordsQuery = $recordsQuery->whereDate('orders.created_at', '<=', $request->to_date);
		}
		$totalRecords = $recordsQuery->count();
		$totalRecordswithFilter = $recordsQuery->count();

		$records =  $recordsQuery->skip($start)
			->take($rowperpage)
			->get();

		$data_arr = array();
		$i = 1;
		foreach ($records as $record) {
          	$data_arr[] = array(
				// "Image"=>$image,
				"Order Id"     => $record->order_id,
				"Items Count"     => $record->orderDetails->count()." Items",
				"Order Type"        =>"<span class='badge badge-primary text-white'> $record->order_type</span>",
				"Payment"        => "<span class='badge badge-warning text-dark'>$record->payment_type</span>",
				"User Details"  => $record->user_contact,
				"Charges"      => '<i class="fa fa-inr"></i> '.$record->chargeDetails->sum("amount") ,
				"Amount"      => '<i class="fa fa-inr"></i> '. $record->total,
                "Date"        =>date("d M, Y",strtotime($record->created_at)),
                "Action"      =>'<button class="btn btn-sm btn-outline-success text-dark ml-1 viewDetails" data-order_details = "'.json_encode($record->orderDetails).'" ><i class="fa fa-eye"></i> </button><button class="btn btn-sm btn-outline-primary text-dark ml-1 viewCharges" data-order_details = "'.json_encode($record->chargeDetails).'" ><i class="fa fa-inr"></i> </button><button class="btn btn-sm btn-outline-primary viewDetails ml-1 text-dark" data-order_details = "'.json_encode($record->chargeDetails).'" ><i class="fa fa-file-text"></i> </button>',


			);
			$i++;
		}

		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordswithFilter,
			"aaData" => $data_arr
		);

		echo json_encode($response);
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
