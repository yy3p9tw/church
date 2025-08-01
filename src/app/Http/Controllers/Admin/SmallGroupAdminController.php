<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmallGroup;

class SmallGroupAdminController extends Controller
{
    // 小組後台列表
    public function index(Request $request)
    {
        $groups = SmallGroup::orderBy('name')->paginate(20);
        return view('admin.groups.index', compact('groups'));
    }

    // 建立表單
    public function create()
    {
        return view('admin.groups.create');
    }

    // 儲存新資料
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'type' => 'nullable',
            'contact' => 'nullable',
            'description' => 'nullable',
            'cover' => 'nullable',
        ]);
        SmallGroup::create($data);
        return redirect()->route('admin.groups.index')->with('success', '新增成功');
    }

    // 編輯表單
    public function edit($id)
    {
        $group = SmallGroup::findOrFail($id);
        return view('admin.groups.edit', compact('group'));
    }

    // 更新資料
    public function update(Request $request, $id)
    {
        $group = SmallGroup::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'type' => 'nullable',
            'contact' => 'nullable',
            'description' => 'nullable',
            'cover' => 'nullable',
        ]);
        $group->update($data);
        return redirect()->route('admin.groups.index')->with('success', '更新成功');
    }

    // 刪除
    public function destroy($id)
    {
        $group = SmallGroup::findOrFail($id);
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', '已刪除');
    }
}
