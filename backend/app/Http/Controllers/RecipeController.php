<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::orderBy('id', 'desc')->get();
        return response()->json($recipes->load('ingredients'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $recipe = new Recipe;
        $recipe->name = $request->name;
        $recipe->save(); 


        if ($request->has('ingredients')) {
            foreach($request->ingredients as $item) {
                // Check if exist, if not -> create ingredient
                $ingredient = Ingredient::where('name', $item['name'])->first();
                if (!$ingredient) {
                    $ingredient = new Ingredient;
                    $ingredient->name = $request->name;
                    $ingredient->save();
                }

                $recipe->ingredients()->attach($ingredient->id, [
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit']
                ]);
            }
        } else {
            $message = "error : Ingredients missing.";
            return response()->json($message, 400);
        }
        return response()->json($recipe->load('ingredients'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recipe = Recipe::findOrFail($id);
        return response()->json($recipe->load('ingredients'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->name = $request->name;
        $recipe->save();

        if ($request->has('ingredients')) {
            $ingredientsData = [];

            foreach ($request->ingredients as $item) {

                $ingredient = Ingredient::where('name', $item['name'])->first();
                if (!$ingredient) {
                    $ingredient = new Ingredient;
                    $ingredient->name = $request->name;
                    $ingredient->save();
                }

                $ingredientsData[$ingredient->id] = [
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit']
                ];
            }

            $recipe->ingredients()->sync($ingredientsData);
        }
        return response()->json($recipe->load('ingredients'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();
        return response()->json($recipe, 204);
    }

    /**
     * Filter recipes based on what ingredient is used.
     * Not working.
     */
    public function filter(Request $request)
    {   
        $ingredient_filter = $request->ingredient;
        $recipes = Recipe::with('ingredients')
        ->whereHas('ingredients', function (Builder $query) use ($ingredient_filter) {
            $query->where('name', $ingredient_filter);
        })->get();
        return response()->json($recipe, 200);
    }
}
