<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function contact()
    {
        return view('front.contact');
    }
    public function groups(Request $request)
    {
        $query = \App\Models\SmallGroup::query();
        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }
        $groups = $query->orderByDesc('created_at')->paginate(10);
        return view('front.groups', compact('groups'));
    }

    public function groupShow($id)
    {
        $group = \App\Models\SmallGroup::findOrFail($id);
        return view('front.group_show', compact('group'));
    }
    public function index()
    {
        $sermons = \App\Models\Sermon::orderByDesc('sermon_date')->limit(5)->get();
        $news = \App\Models\News::orderByDesc('publish_date')->limit(5)->get();
        $groups = \App\Models\SmallGroup::orderByDesc('created_at')->limit(2)->get();
        $events = \App\Models\Event::orderByDesc('start_time')->limit(2)->get();
        $sliders = \App\Models\Slider::orderBy('sort_order')->get();
        return view('front.home', compact('sermons', 'news', 'groups', 'events', 'sliders'));
    }
    public function sermons(Request $request)
    {
        $query = \App\Models\Sermon::query();
        if ($request->filled('q')) {
            $query->where('title', 'like', '%'.$request->q.'%')
                  ->orWhere('speaker', 'like', '%'.$request->q.'%');
        }
        $sermons = $query->orderByDesc('sermon_date')->paginate(10);
        return view('front.sermons', compact('sermons'));
    }

    public function sermonShow($id)
    {
        $sermon = \App\Models\Sermon::findOrFail($id);
        return view('front.sermon_show', compact('sermon'));
    }
    public function news(Request $request)
    {
        $query = \App\Models\News::query();
        if ($request->filled('q')) {
            $query->where('title', 'like', '%'.$request->q.'%');
        }
        $news = $query->orderByDesc('publish_date')->paginate(10);
        return view('front.news', compact('news'));
    }

    public function newsShow($id)
    {
        $news = \App\Models\News::findOrFail($id);
        return view('front.news_show', compact('news'));
    }
    public function events(Request $request)
    {
        $query = \App\Models\Event::query();
        if ($request->filled('q')) {
            $query->where('title', 'like', '%'.$request->q.'%');
        }
        $events = $query->orderByDesc('start_time')->paginate(10);
        return view('front.events', compact('events'));
    }

    public function eventShow($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        return view('front.event_show', compact('event'));
    }
}
