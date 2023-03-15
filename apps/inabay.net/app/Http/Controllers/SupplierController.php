<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $this->authorize('admin');
        $suppliers = Supplier::paginate(15);
        return view('inabay.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        $this->authorize('admin');
        return view('inabay.suppliers.create');
    }

    public function store(Request $request)
    {
        $this->authorize('admin');
        $request->validate([
            'name'      => 'required'
        ]);

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->save();

        return redirect("/suppliers");
    }

    public function edit($id)
    {
        $this->authorize('admin');
        $supplier = Supplier::find($id);
        return view('inabay.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin');
        $request->validate([
            'name'      => 'required'
        ]);

        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->save();

        return redirect("/suppliers");
    }

    public function destroy($id)
    {
        //
    }
}
