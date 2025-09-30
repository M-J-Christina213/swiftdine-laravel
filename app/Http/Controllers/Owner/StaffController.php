<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::orderBy('created_at', 'desc')->get();
        return view('owner.staff.index', compact('staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'role' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);

        Staff::create($request->all());

        return redirect()->route('owner.staff')->with('success', 'Staff added successfully.');
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'role' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);

        $staff->update($request->all());

        return redirect()->route('owner.staff')->with('success', 'Staff updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('owner.staff')->with('success', 'Staff deleted successfully.');
    }
}
