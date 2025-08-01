<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }
    public function create()
    {
        return view('admin.sliders.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable',
            'image_url' => 'required',
            'link_url' => 'nullable',
            'sort_order' => 'nullable|integer',
        ]);
        Slider::create($data);
        return redirect()->route('admin.sliders.index')->with('success', '新增成功');
    }
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);
        $data = $request->validate([
            'title' => 'nullable',
            'image_url' => 'required',
            'link_url' => 'nullable',
            'sort_order' => 'nullable|integer',
        ]);
        $slider->update($data);
        return redirect()->route('admin.sliders.index')->with('success', '更新成功');
    }
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', '已刪除');
    }
}
