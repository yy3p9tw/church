<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sermon;
use Illuminate\Http\Request;

class SermonApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Sermon::query();
        if ($q = $request->input('q')) {
            $query->where(function($q1) use ($q) {
                $q1->where('title', 'like', "%$q%")
                   ->orWhere('speaker', 'like', "%$q%")
                   ->orWhere('content', 'like', "%$q%") ;
            });
        }
        $sort = $request->input('sort', 'sermon_date');
        $order = $request->input('order', 'desc');
        $sermons = $query->orderBy($sort, $order)->paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $sermons
        ]);
    }

    public function show($id)
    {
        $sermon = Sermon::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $sermon
        ]);
    }
}
