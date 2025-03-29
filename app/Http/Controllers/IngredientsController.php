<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;

class IngredientsController extends Controller {

    public function show($uuid)
    {
        $ingredient = Ingredient::where('uuid', $uuid)->firstOrFail();
        $recipes = $ingredient->recipes()->limit(8)->get();

        return view('ingredients.show', compact('ingredient', 'recipes'));
    }

}
