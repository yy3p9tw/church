<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SmallGroup;
use Illuminate\Http\Request;

class GroupApiController extends Controller
{
    public function index(Request $request)
    {
        $query = SmallGroup::query();
        if ($q = $request->input('q')) {
            $query->where(function($q1) use ($q) {
                $q1->where('name', 'like', "%$q%")
                   ->orWhere('contact_person', 'like', "%$q%")
                   ->orWhere('description', 'like', "%$q%") ;
            });
        }
        $sort = $request->input('sort', 'name');
        $order = $request->input('order', 'asc');
        $groups = $query->orderBy($sort, $order)->paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $groups
        ]);
    }

    public function show($id)
    {
        $group = SmallGroup::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $group
        ]);
    }
}
