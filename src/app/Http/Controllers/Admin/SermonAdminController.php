<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sermon;

class SermonAdminController extends Controller
{
    // 講道後台列表
    public function index(Request $request)
    {
        $sermons = Sermon::orderBy('date', 'desc')->paginate(20);
        return view('admin.sermons.index', compact('sermons'));
    }

    // 建立表單
    public function create()
    {
        return view('admin.sermons.create');
    }

    // 儲存新資料
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'preacher' => 'required',
            'date' => 'required|date',
            'content' => 'nullable',
            'cover' => 'nullable',
        ]);
        Sermon::create($data);
        return redirect()->route('admin.sermons.index')->with('success', '新增成功');
    }

    // 編輯表單
    public function edit($id)
    {
        $sermon = Sermon::findOrFail($id);
        return view('admin.sermons.edit', compact('sermon'));
    }

    // 更新資料
    public function update(Request $request, $id)
    {
        $sermon = Sermon::findOrFail($id);
        $data = $request->validate([
            'title' => 'required',
            'preacher' => 'required',
            'date' => 'required|date',
            'content' => 'nullable',
            'cover' => 'nullable',
        ]);
        $sermon->update($data);
        return redirect()->route('admin.sermons.index')->with('success', '更新成功');
    }

    // 刪除
    public function destroy($id)
    {
        $sermon = Sermon::findOrFail($id);
        $sermon->delete();
        return redirect()->route('admin.sermons.index')->with('success', '已刪除');
    }
}
