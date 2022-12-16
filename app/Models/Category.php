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

    const INGREDIENT_MAP = [
        'Baking' => 'Baking',
        'Health Foods' => 'Health Foods',
        'Spices and Seasonings' => 'Spices',
        'Pasta and Rice' => 'Pasta & Rice',
        'Bakery/Bread' => 'Bakery',
        'Refrigerated' => 'Fridge',
        'Canned and Jarred' => 'Cans & Jars',
        'Frozen' => 'Frozen',
        'Nut butters, Jams, and Honey' => 'Spreads',
        'Oil, Vinegar, Salad Dressing' => 'Condiments',
        'Condiments' => 'Condiments',
        'Savory Snacks' => 'Snacks',
        'Milk, Eggs, Other Dairy' => 'Dairy',
        'Ethnic Foods' => 'Ethnic Foods',
        'Tea and Coffee' => 'Tea & Coffee',
        'Meat' => 'Meat & Fish',
        'Gourmet' => 'Gourmet',
        'Sweet Snacks' => 'Confectionary',
        'Gluten Free' => 'Gluten Free',
        'Alcoholic Beverages' => 'Drinks',
        'Cereal' => 'Cereal',
        'Nuts' => 'Baking',
        'Beverages' => 'Drinks',
        'Produce' => 'Produce',
        'Not in Grocery Store/Homemade' => 'Miscellaneous',
        'Seafood' => 'Meat & Fish',
        'Cheese' => 'Dairy',
        'Dried Fruits' => 'Baking',
        'Online' => 'Miscellaneous',
        'Grilling Supplies' => 'Miscellaneous',
        'Bread' => 'Bakery',
        'Unknown' => 'Unknown'
    ];

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
     * Get all of the category's recipeIngredients.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipeIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
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
