<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColumnController extends Controller
{
    public function index()
    {
        return view('column');
    }
}
