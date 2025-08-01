<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsAdminController extends Controller
{
    // 消息後台列表
    public function index(Request $request)
    {
        $news = News::orderBy('date', 'desc')->paginate(20);
        return view('admin.news.index', compact('news'));
    }

    // 建立表單
    public function create()
    {
        return view('admin.news.create');
    }

    // 儲存新資料
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'content' => 'nullable',
            'cover' => 'nullable',
        ]);
        News::create($data);
        return redirect()->route('admin.news.index')->with('success', '新增成功');
    }

    // 編輯表單
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    // 更新資料
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $data = $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'content' => 'nullable',
            'cover' => 'nullable',
        ]);
        $news->update($data);
        return redirect()->route('admin.news.index')->with('success', '更新成功');
    }

    // 刪除
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', '已刪除');
    }
}
