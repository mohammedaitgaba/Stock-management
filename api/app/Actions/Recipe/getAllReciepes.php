<?php

namespace App\Actions\Recipe;

use App\Models\Recipe;

class getAllReciepes
{
    public function execute()
    {
        return Recipe::with('products')->get();
    }
}
