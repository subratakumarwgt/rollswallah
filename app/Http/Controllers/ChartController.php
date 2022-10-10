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
        ->select('expenses.*','orders.*',DB::raw('sum(orders.total) as orderTotal'),DB::raw('DATE(orders.created_at) as orderDate'),DB::raw('DATE(expenses.created_at) as expenseDate'))
        ->join('expenses', DB::raw(DATE("orders.created_at")), '=', DB::raw(DATE("expenses.created_at")))
        ->groupBy('orderDate')
        ->get();
          dd($salesVsExpense);

        return response([
            ["Year", "Sales", "Expenses", "Profit"],
            ["2018", 1e3, 900, 250],
            ["2019", 1170, 460, 300],
            ["2020", 660, 1120, 400],
            ["2021", 1030, 540, 450]
          ],200);
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