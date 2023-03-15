<?php

namespace App\Http\Controllers;

use App\Sales;
use App\SalesDetail;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    //
    public function bulk_invoice(Request $request){
        $this->authorize('admin');
        $sales_s = Sales::whereBetween('id', [$request->start, $request->end])->where('status', 1)->get();
        $date = new DateTime();
        $current_date = $date->format('d/m/Y');
        $pdf = PDF::loadView('inabay.prints.bulk_invoice', compact('sales_s', 'current_date'))->setPaper('a6', 'potrait');
        return $pdf->stream();
    }

    public function bulk_delivery_label(Request $request){
        $this->authorize('admin');
        $sales_s = Sales::whereBetween('id', [$request->start, $request->end])->where('status', 1)->get();
        $date = new DateTime();
        $current_date = $date->format('d/m/Y');
        $pdf = PDF::loadView('inabay.prints.bulk_delivery_label', compact('sales_s', 'current_date'))
            ->setPaper('a6', 'potrait')
            ->setOptions(['isRemoteEnabled' => true]);
        return $pdf->stream();
    }
}
