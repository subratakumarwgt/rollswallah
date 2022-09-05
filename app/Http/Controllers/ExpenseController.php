<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    //


    public function viewDailyExpense(){
        return view("adminpanel.expenses.addDailyExpense");
    }
    public function viewQuickOrder(){
        return view("adminpanel.expenses.addQuickOrder");
    }
   

}
