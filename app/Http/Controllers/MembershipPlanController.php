<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembershipPlanController extends Controller
{
    public function silver()
    {
        return view('silver');
    }

    public function gold()
    {
        return view('gold');
    }
}
