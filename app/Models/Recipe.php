<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    const MORPH_KEY = 'recipe';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'steps',
        'serves',
        'preparation_time',
        'cooking_time',
        'rating',
        'calories',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'serves' => 'integer',
        'preparation_time' => 'integer',
        'cooking_time' => 'integer',
        'rating' => 'integer',
        'calories' => 'integer',
    ];

    /**
     * Get all of the ingredients for the recipe.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ingredients()
    {
        return $this->morphToMany(Ingredient::class, 'ingredientable');
    }
}
