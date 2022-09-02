<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Category;
use App\Models\IngredientAmount;
use App\Models\Image;
use App\Models\Recipe;


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
     * @return Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function recipes(): MorphToMany
    {
        return $this->morphedByMany(Recipe::class, 'ingredientable');
    }

    /**
     * Get the ingredient categories.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphToMany
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

    /**
     * Get the ingredient amount.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function amount(): HasOne
    {
        return $this->hasOne(IngredientAmount::class);
    }
}
