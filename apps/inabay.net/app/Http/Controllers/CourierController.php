<?php

namespace App\Http\Controllers;

use App\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourierController extends Controller
{

    public function index()
    {
        $this->authorize('admin');
        $couriers = Courier::paginate(15);
        return view('inabay.couriers.index', compact('couriers'));
    }

    public function create()
    {
        $this->authorize('admin');
        return view('inabay.couriers.create');
    }

    public function store(Request $request)
    {
        $this->authorize('admin');
        $request->validate([
            'name'      => 'required'
        ]);

        $courier = new Courier();
        $courier->name = $request->name;
        $courier->status = 1;
        $courier->save();

        return redirect("/couriers");
    }

    public function edit($id)
    {
        $this->authorize('admin');
        $courier = Courier::find($id);
        return view('inabay.couriers.edit', compact('courier'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin');
        $request->validate([
            'name'      => 'required'
        ]);

        $courier = Courier::find($id);
        $courier->name = $request->name;
        $courier->save();

        return redirect("/couriers");
    }

    public function deactivate($id){
        $this->authorize('admin');
        $courier = Courier::find($id);
        $courier->status = 0;
        $courier->save();

        return redirect("/couriers");
    }

    public function activate($id){
        $this->authorize('admin');
        $courier = Courier::find($id);
        $courier->status = 1;
        $courier->save();

        return redirect("/couriers");
    }

    public function destroy($id)
    {
        //
    }
}
