<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsApiController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query();
        if ($q = $request->input('q')) {
            $query->where(function($q1) use ($q) {
                $q1->where('title', 'like', "%$q%")
                   ->orWhere('content', 'like', "%$q%") ;
            });
        }
        $sort = $request->input('sort', 'news_date');
        $order = $request->input('order', 'desc');
        $news = $query->orderBy($sort, $order)->paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $news
        ]);
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $news
        ]);
    }
}
