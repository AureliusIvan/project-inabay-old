<?php

namespace App\Http\Controllers;

use App\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    //
    public function top_up(){
        $user = Auth::user();
        return view('inabay.top_ups.top_up', compact('user'));
    }

    public function index() {
        $top_ups = TopUp::orderBy('created_at', 'desc')->paginate(25);
        return view('inabay.top_ups.index', compact('top_ups'));
    }

    public function create() {
        $users = User::where('role_id', 3)->get();
        return view('inabay.top_ups.create', compact('users'));
    }

    public function store_member_top_up(Request $request) {
        $user = Auth::user();

        $top_up_num = TopUp::where('user_id', $user->id)->whereDate('created_at', date('Y-m-d'))->count();

        $uid = str_pad($user->id, 3, '0', STR_PAD_LEFT);
        $ddmmyy = date('dmy');
        $num = str_pad($top_up_num + 1, 3, '0', STR_PAD_LEFT);

        $top_up_code = $uid . $ddmmyy . $num;

        $top_up = new TopUp();
        $top_up->user_id = $user->id;
        $top_up->bank_name = $request->bank_name;
        $top_up->account_name = $request->account_name;
        $top_up->account_no = $request->account_no;
        $top_up->amount = $request->amount;
        $top_up->code = $top_up_code;
        $top_up->is_confirm = false;
        $top_up->is_cancel = false;
        $top_up->save();

        return redirect('/home');
    }

    public function status_update(Request $request) {
        $top_up = TopUp::find($request->top_up_id);
        $status['old'] = $top_up->status;
        $status['new'] = $request->top_up_status;

        switch($status['new']){
            case "Proses":
                $top_up->is_confirm = false;
                $top_up->is_cancel = false;
                break;
            case "Masuk":
                $top_up->is_confirm = true;
                $top_up->is_cancel = false;
                break;
            case "Batal":
                $top_up->is_confirm = false;
                $top_up->is_cancel = true;
                break;
        }

        $top_up->save();
        return $status;
    }
}
