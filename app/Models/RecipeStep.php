<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeStep extends Model
{
    protected $fillable = [
        'recipe_id',
        'step_number',
        'text',
        'photo_url',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
