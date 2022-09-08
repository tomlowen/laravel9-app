<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Image;

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
        'author',
        'source',
        'description',
        'steps',
        'yield',
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
        'yield' => 'integer',
        'rating' => 'float',
        'calories' => 'integer',
    ];

    /**
     * Get all of the ingredients for the recipe.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ingredients(): MorphToMany
    {
        return $this->morphToMany(Ingredient::class, 'ingredientable');
    }

    /**
     * Get the recipe categories.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    /**
     * Get all of the category's images.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function images(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable');
    }
}
