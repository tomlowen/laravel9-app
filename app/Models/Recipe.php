<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
        'total_time',
        'rating',
        'calories',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'preparation_time' => 'integer',
        'cooking_time' => 'integer',
        'total_time' => 'integer',
        'yield' => 'integer',
        'rating' => 'float',
        'calories' => 'integer',
    ];

    /**
     * The "boot" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($recipe) {
            $recipe->total_time = $recipe->preparation_time + $recipe->cooking_time;
        });

        static::updating(function ($recipe) {
            $recipe->total_time = $recipe->preparation_time + $recipe->cooking_time;
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
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
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
