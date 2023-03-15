<?php

namespace App\Http\Controllers;

use App\Sales;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PaymentController extends Controller
{

    public function index_unpaid()
    {
        $this->authorize('finance');
        $user = Auth::user();
        $search_words = null;
        $search = false;
        $per_page = 25;
        $sales_s = Sales::where('status', '<>', 3)->where('is_paid', false)->orderBy('created_at', 'desc')->paginate($per_page);
        $mode = 'is_paid_false';
        return view('inabay.payments.index', compact('sales_s', 'mode', 'per_page', 'search', 'search_words', 'user'));
    }

    public function index_paid() {
        $this->authorize('finance');
        $user = Auth::user();
        $search_words = null;
        $search = false;
        $per_page = 25;
        $sales_s = Sales::where('status', '<>', 3)->where('is_paid', true)->orderBy('created_at', 'desc')->paginate($per_page);
        $mode = 'is_paid_true';
        return view('inabay.payments.index', compact('sales_s', 'mode', 'per_page', 'search', 'search_words', 'user'));
    }

    public function index() {
        $this->authorize('finance');
        $user = Auth::user();
        $search_words = null;
        $search = false;
        $per_page = 25;
        $sales_s = Sales::where('status', '<>', 3)->orderBy('created_at', 'desc')->paginate($per_page);
        $mode = 'all';
        return view('inabay.payments.index', compact('sales_s', 'mode', 'per_page', 'search', 'search_words', 'user'));
    }

    public function status_update(Request $request) {
        $this->authorize('finance');
        $sales = Sales::find($request->sales_id);
        $is_paid['old'] = $sales->is_paid;
        $sales->is_paid = $request->is_paid;
        $is_paid['new'] = $sales->is_paid;
        $sales->save();
        return $is_paid;
    }

    public function search_unpaid() {
        $this->authorize('finance');
        $user = Auth::user();
        $search = true;
        $mode = 'is_paid_false';
        $search_words = Input::get('q', '');
        $search_term = "%" . $search_words . "%";

        $sales_s = Sales::where('status', '<>', 3)
            ->where('is_paid', false)
            ->whereHas('user', function(Builder $query){
                $query->where('name', 'like', '%' . Input::get('q', '') . '%')
                    ->orWhere('shop_name', 'like', '%' . Input::get('q', '') . '%');
            })->orderBy('created_at', 'desc')->paginate(25);

        $sales_s->appends(['q' => $search_words]);

        return view('inabay.payments.index', compact('sales_s', 'mode', 'search', 'search_words', 'user'));
    }

    public function search_paid() {
        $this->authorize('finance');
        $user = Auth::user();
        $search = true;
        $mode = 'is_paid_true';
        $search_words = Input::get('q', '');
        $search_term = "%" . $search_words . "%";

        $sales_s = Sales::where('status', '<>', 3)
            ->where('is_paid', true)
            ->whereHas('user', function(Builder $query){
                $query->where('name', 'like', '%' . Input::get('q', '') . '%')
                    ->orWhere('shop_name', 'like', '%' . Input::get('q', '') . '%');
            })->orderBy('created_at', 'desc')->paginate(25);

        $sales_s->appends(['q' => $search_words]);

        return view('inabay.payments.index', compact('sales_s', 'mode', 'search', 'search_words', 'user'));
    }

    public function search() {
        $this->authorize('finance');
        $user = Auth::user();
        $search = true;
        $mode = 'all';
        $search_words = Input::get('q', '');
        $search_term = "%" . $search_words . "%";

        $sales_s = Sales::where('status', '<>', 3)
            ->whereHas('user', function(Builder $query){
                $query->where('name', 'like', '%' . Input::get('q', '') . '%')
                    ->orWhere('shop_name', 'like', '%' . Input::get('q', '') . '%');
            })->orderBy('created_at', 'desc')->paginate(25);

        $sales_s->appends(['q' => $search_words]);

        return view('inabay.payments.index', compact('sales_s', 'mode', 'search', 'search_words', 'user'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
