<?php

namespace App\Actions\Recipe;

use App\Models\Recipe;

class storeNewRecipe
{
    public function execute(array $attributes)
    {
        return Recipe::query()->products()->attach($attributes);
    }
}
