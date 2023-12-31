<?php

namespace App\Http\Controllers;

use App\Actions\Recipe\getAllReciepes;
use App\Actions\Recipe\storeNewRecipe;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Resources\Recipe\ReciepeCollection;
use App\Models\Recipe;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    /**
     * @param getAllReciepes $reciepes
     * @return ReciepeCollection
     */
    public function index(getAllReciepes $reciepes): ReciepeCollection
    {
        return ReciepeCollection::make($reciepes->execute());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request, storeNewRecipe $newRecipe, Recipe $recipe): JsonResponse
    {
        DB::beginTransaction();
        try {
            $recipe = Recipe::query()->findOrFail($recipe);
            $productIds = $request->validated()->input('product_ids');
            if ($recipe) {
                $newRecipe->execute($productIds);
            }
            DB::commit();

            return response()->json(['message' => 'created successfully'], 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'an error happened while creating recipe'], 500);
        }

    }
}
