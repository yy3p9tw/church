<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function destroy($id)
    {
        $news = \App\Models\News::findOrFail($id);
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', '已刪除');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'news_date' => 'required|date',
            'content' => 'nullable',
        ]);
        // 自動產生唯一 slug
        $data['slug'] = \Illuminate\Support\Str::slug($data['title']) . '-' . uniqid();
        \App\Models\News::create($data);
        return redirect()->route('admin.news.index')->with('success', '新增成功');
    }
    public function create()
    {
        return view('admin.news.create');
    }
    public function update(Request $request, $id)
    {
        $news = \App\Models\News::findOrFail($id);
        $data = $request->validate([
            'title' => 'required',
            'news_date' => 'required|date',
            'content' => 'nullable',
        ]);
        $news->update($data);
        return redirect()->route('admin.news.index')->with('success', '更新成功');
    }
    public function edit($id)
    {
        $news = \App\Models\News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }
    public function index()
    {
        $news = \App\Models\News::orderByDesc('publish_date')->paginate(20);
        return view('admin.news.index', compact('news'));
    }
}
