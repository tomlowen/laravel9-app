<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    use HasFactory;

    const MORPH_KEY = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug'
    ];

    /**
     * Get all of the recipes for the category.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function recipes(): MorphToMany
    {
        return $this->morphedByMany(Recipe::class, 'categorizable');
    }

    /**
     * Get all of the category's images.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function images(): MorphToMany
    {
        return $this->morphedByMany(Image::class, 'categorizable');
    }

    /**
     * Get all of the category's shoppingListIngredients.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shoppingListIngredients(): HasMany
    {
        return $this->hasMany(ShoppingListIngredient::class);
    }

    /**
     * Get the User for the recipe.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
