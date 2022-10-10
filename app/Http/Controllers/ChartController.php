<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    //

    public function getOrderBarChart(){
        $sales = new Order();
        $expenses = new Expense();

        $salesVsExpense = $sales
        ->where("orders.status","completed")
        ->select(DB::raw('sum(orders.total) as orderTotal'),DB::raw('sum(expenses.amount) as expenseTotal'),DB::raw('DATE(orders.created_at) as orderDate'),DB::raw('DATE(expenses.created_at) as expenseDate'))
        ->join('expenses', DB::raw('DATE("expenses.created_at")'), '=',  DB::raw('DATE("orders.created_at")'))
        ->groupBy('orderDate')
        ->get();
         $dataSets[0] = ["Year", "Sales","Expenses"];
        foreach ($salesVsExpense as $key => $sale) {
        $dataSet = [
            date("d M,Y",strtotime($sale->orderDate)),
           $sale->orderTotal,
           $sale->expenseTotal
        ];
        array_push($dataSets,$dataSet);
      }

        return response($dataSets,200);
    }
}
//    public function getOrderBarChart(){
//     $sales = new Order();
//     $expenses = new Expense();

//     $sales = $sales->where("status","completed")->select(DB::raw("SUM(total) as orderTotal"),DB::raw('DATE(created_at) as date'))->groupBy("date")->orderBy("date")->take(5)->get();
//     $expenses = $expenses->select(DB::raw("SUM(amount) as expenseTotal"),DB::raw('DATE(created_at) as date'))->groupBy("date")->take(5)->get();
//     $dataSets[0] = ["Year", "Sales"];
//       foreach ($sales as $key => $sale) {
//         $dataSet = [
//             date("d M,Y",strtotime($sale->date)),
//            $sale->orderTotal
//         ];
//         array_push($dataSets,$dataSet);
//       }

//     return response(
//         $dataSets
//       ,200);
// }