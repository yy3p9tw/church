<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventAdminController extends Controller
{
    // 活動後台列表
    public function index(Request $request)
    {
        $events = Event::orderBy('start_time', 'desc')->paginate(20);
        return view('admin.events.index', compact('events'));
    }

    // 建立表單
    public function create()
    {
        return view('admin.events.create');
    }

    // 儲存新資料
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'location' => 'nullable',
            'content' => 'nullable',
            'cover' => 'nullable',
        ]);
        Event::create($data);
        return redirect()->route('admin.events.index')->with('success', '新增成功');
    }

    // 編輯表單
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    // 更新資料
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $data = $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'location' => 'nullable',
            'content' => 'nullable',
            'cover' => 'nullable',
        ]);
        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', '更新成功');
    }

    // 刪除
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', '已刪除');
    }
}
