<?php

namespace App\Http\Controllers;

use App\Sales;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{

    public function index(){
        $this->authorize('admin');
        return view('inabay.reports.index');
    }

    public function sales(){
        $this->authorize('admin');
        $month = date('n');
        $year = date('Y');
        $users = User::where('role_id', 3)->get();

        $total_sales = 0;
        $total_delivery_cost = 0;
        $total_transaction = 0;
        foreach($users as $user){
            $total_sales += $user->monthlyTotalSales($month, $year);
            $total_delivery_cost += $user->monthlyTotalDeliveryCost($month, $year);
            $total_transaction += $user->monthlyNumOfTransaction($month, $year);
        }

        return view('inabay.reports.sales', compact('users', 'month', 'year', 'total_sales', 'total_delivery_cost', 'total_transaction'));
    }

    public function sales_pdf(Request $request){
        $this->authorize('admin');
        $month = $request->month;
        $year = $request->year;
        $users = User::where('role_id', 3)->get();

        $total_sales = 0;
        $total_delivery_cost = 0;
        $total_transaction = 0;
        foreach($users as $user){
            $total_sales += $user->monthlyTotalSales($month, $year);
            $total_delivery_cost += $user->monthlyTotalDeliveryCost($month, $year);
            $total_transaction += $user->monthlyNumOfTransaction($month, $year);
        }
        switch($month){
            case 1: $month_str = "Januari"; break;
            case 2: $month_str = "Februari"; break;
            case 3: $month_str = "Maret"; break;
            case 4: $month_str = "April"; break;
            case 5: $month_str = "Mei"; break;
            case 6: $month_str = "Juni"; break;
            case 7: $month_str = "Juli"; break;
            case 8: $month_str = "Agustus"; break;
            case 9: $month_str = "September"; break;
            case 10: $month_str = "Oktober"; break;
            case 11: $month_str = "November"; break;
            case 12: $month_str = "Desember"; break;
        }

        $pdf = PDF::loadView('inabay.reports.pdf.sales', compact('users', 'month', 'month_str', 'year', 'total_sales', 'total_delivery_cost', 'total_transaction'))->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public function monthly_sales(Request $request){
        $this->authorize('admin');
        $month = $request->month;
        $year = $request->year;

        $users = User::where('role_id', 3)->get();

        $total_sales = 0;
        $total_delivery_cost = 0;
        $total_transaction = 0;
        foreach($users as $user){
            $total_sales += $user->monthlyTotalSales($month, $year);
            $total_delivery_cost += $user->monthlyTotalDeliveryCost($month, $year);
            $total_transaction += $user->monthlyNumOfTransaction($month, $year);
        }

        return view('inabay.reports.sales', compact('users', 'month', 'year', 'total_sales', 'total_delivery_cost', 'total_transaction'));
    }
}
