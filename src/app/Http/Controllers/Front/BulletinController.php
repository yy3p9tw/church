<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Bulletin;

class BulletinController extends Controller
{
    public function index()
    {
        $bulletins = Bulletin::orderByDesc('publish_date')->paginate(20);
        return view('front.bulletins.index', compact('bulletins'));
    }

    public function show($id)
    {
        $bulletin = Bulletin::findOrFail($id);
        return view('front.bulletins.show', compact('bulletin'));
    }
}
