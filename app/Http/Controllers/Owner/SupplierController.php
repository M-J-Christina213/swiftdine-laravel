<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    // List all suppliers
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();
        return view('owner.suppliers.index', compact('suppliers'));
    }

    // Show form to create a supplier
    public function create()
    {
        return view('owner.suppliers.create');
    }

    // Store new supplier
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        Supplier::create([
            'name' => $request->name,
            'contact_email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('owner.suppliers.index')->with('success', 'Supplier added successfully!');
    }

    // Show form to edit
    public function edit(Supplier $supplier)
    {
        return view('owner.suppliers.edit', compact('supplier'));
    }

    // Update supplier
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        $supplier->update([
            'name' => $request->name,
            'contact_email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('owner.suppliers.index')->with('success', 'Supplier updated successfully!');
    }

    // Delete supplier
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('owner.suppliers.index')->with('success', 'Supplier deleted successfully!');
    }
}
