<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SermonController extends Controller
{
    public function index()
    {
        $sermons = \App\Models\Sermon::orderByDesc('sermon_date')->paginate(20);
        return view('admin.sermons.index', compact('sermons'));
    }
    public function edit($id)
    {
        $sermon = \App\Models\Sermon::findOrFail($id);
        return view('admin.sermons.edit', compact('sermon'));
    }
    public function update(Request $request, $id)
    {
        $sermon = \App\Models\Sermon::findOrFail($id);
        $data = $request->validate([
            'title' => 'required',
            'speaker' => 'required',
            'sermon_date' => 'required|date',
            'video_url' => 'nullable|string',
            'content' => 'nullable',
        ]);
        $sermon->update($data);
        return redirect()->route('admin.sermons.index')->with('success', '更新成功');
    }
    public function create()
    {
        return view('admin.sermons.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'speaker' => 'required',
            'sermon_date' => 'required|date',
            'video_url' => 'nullable|string',
            'content' => 'nullable',
        ]);
        // 自動產生唯一 slug
        if (!isset($data['slug']) || !$data['slug']) {
            $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
        }
        \App\Models\Sermon::create($data);
        return redirect()->route('admin.sermons.index')->with('success', '新增成功');
    }
    public function destroy($id)
    {
        $sermon = \App\Models\Sermon::findOrFail($id);
        $sermon->delete();
        return redirect()->route('admin.sermons.index')->with('success', '已刪除');
    }
}
