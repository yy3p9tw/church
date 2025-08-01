<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::orderBy('sort_order')->paginate(20);
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'title' => 'required',
            'photo' => 'nullable|image',
            'bio' => 'nullable',
            'sort_order' => 'nullable|integer',
            'status' => 'boolean',
        ]);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('staff', 'public');
        }
        Staff::create($data);
        return redirect()->route('admin.staff.index')->with('success', '同工已新增');
    }

    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $data = $request->validate([
            'name' => 'required',
            'title' => 'required',
            'photo' => 'nullable|image',
            'bio' => 'nullable',
            'sort_order' => 'nullable|integer',
            'status' => 'boolean',
        ]);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('staff', 'public');
        }
        $staff->update($data);
        return redirect()->route('admin.staff.index')->with('success', '同工已更新');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', '同工已刪除');
    }
}
