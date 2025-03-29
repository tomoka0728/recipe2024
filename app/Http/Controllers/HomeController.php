<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class HomeController extends Controller
{
    public function index()
    {
        $popularRecipes = Recipe::orderBy('favorite_count', 'desc')->take(3)->get();

        // 取得したレシピをビューに渡す
        return view('top', compact('popularRecipes'));
    }
}
