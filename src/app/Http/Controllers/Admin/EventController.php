<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function destroy($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', '已刪除');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'location' => 'nullable',
            'content' => 'nullable',
        ]);
        // 自動產生唯一 slug
        $data['slug'] = \Illuminate\Support\Str::slug($data['title']) . '-' . uniqid();
        \App\Models\Event::create($data);
        return redirect()->route('admin.events.index')->with('success', '新增成功');
    }
    public function create()
    {
        return view('admin.events.create');
    }
    public function update(Request $request, $id)
    {
        $event = \App\Models\Event::findOrFail($id);
        $data = $request->validate([
            'title' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'location' => 'nullable',
            'content' => 'nullable',
        ]);
        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', '更新成功');
    }
    public function edit($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }
    public function index()
    {
        $events = \App\Models\Event::orderByDesc('start_time')->paginate(20);
        return view('admin.events.index', compact('events'));
    }
}
