<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpecialFeatureController extends Controller
{
    public function index()
    {
        return view('special_feature');
    }
}
