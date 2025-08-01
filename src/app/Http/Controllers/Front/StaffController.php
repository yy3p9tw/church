<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::where('status', 1)->orderBy('sort_order')->get();
        return view('front.staff', compact('staff'));
    }
}
