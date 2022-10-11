<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($recipe) {
            $recipe->update([
                'total_time' => $recipe->preparation_time + $recipe->cooking_time
            ]);
        });
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


    /**
     * Get all of the ingredients for the recipe.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipeIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    /**
     * Get the recipe tags.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
