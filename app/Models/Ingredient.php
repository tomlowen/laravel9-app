<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    const MORPH_KEY = 'ingredient';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'default_measure',
        'notes',
        'optional'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'optional' => 'bool',
    ];

    /**
     * Get all of the recipes for the ingredient.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function recipes()
    {
        return $this->morphedByMany(Recipe::class, 'ingredientable');
    }
}
