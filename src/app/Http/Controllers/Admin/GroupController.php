<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function destroy($id)
    {
        $group = \App\Models\SmallGroup::findOrFail($id);
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', '已刪除');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'type' => 'nullable',
            'leader' => 'nullable',
            'description' => 'nullable',
            'contact_person' => 'nullable',
        ]);
        // 自動產生唯一 slug
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        \App\Models\SmallGroup::create($data);
        return redirect()->route('admin.groups.index')->with('success', '新增成功');
    }
    public function create()
    {
        return view('admin.groups.create');
    }
    public function index()
    {
        $groups = \App\Models\SmallGroup::orderByDesc('created_at')->paginate(20);
        return view('admin.groups.index', compact('groups'));
    }

    public function edit($id)
    {
        $group = \App\Models\SmallGroup::findOrFail($id);
        return view('admin.groups.edit', compact('group'));
    }
    public function update(Request $request, $id)
    {
        $group = \App\Models\SmallGroup::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'type' => 'nullable',
            'leader' => 'nullable',
            'description' => 'nullable',
            'contact_person' => 'nullable',
        ]);
        $group->update($data);
        return redirect()->route('admin.groups.index')->with('success', '更新成功');
    }
}
