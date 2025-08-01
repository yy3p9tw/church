<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();
        if ($q = $request->input('q')) {
            $query->where(function($q1) use ($q) {
                $q1->where('title', 'like', "%$q%")
                   ->orWhere('location', 'like', "%$q%")
                   ->orWhere('content', 'like', "%$q%") ;
            });
        }
        $sort = $request->input('sort', 'start_time');
        $order = $request->input('order', 'desc');
        $events = $query->orderBy($sort, $order)->paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $events
        ]);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $event
        ]);
    }
}
