<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bulletin;

class BulletinController extends Controller
{
    public function index()
    {
        $bulletins = Bulletin::orderByDesc('publish_date')->paginate(20);
        return view('admin.bulletins.index', compact('bulletins'));
    }

    public function create()
    {
        return view('admin.bulletins.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'image_url' => 'required',
            'publish_date' => 'nullable|date',
        ]);
        Bulletin::create($data);
        return redirect()->route('admin.bulletins.index')->with('success', '新增成功');
    }

    public function edit($id)
    {
        $bulletin = Bulletin::findOrFail($id);
        return view('admin.bulletins.edit', compact('bulletin'));
    }

    public function update(Request $request, $id)
    {
        $bulletin = Bulletin::findOrFail($id);
        $data = $request->validate([
            'title' => 'required',
            'image_url' => 'required',
            'publish_date' => 'nullable|date',
        ]);
        $bulletin->update($data);
        return redirect()->route('admin.bulletins.index')->with('success', '更新成功');
    }

    public function destroy($id)
    {
        $bulletin = Bulletin::findOrFail($id);
        $bulletin->delete();
        return redirect()->route('admin.bulletins.index')->with('success', '已刪除');
    }
}
