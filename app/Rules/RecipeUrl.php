<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class RecipeUrl implements Rule
{
    /**
     * The recipe URL to import from
     */
    protected $recipeUrl;

    /**
     * Create a new rule instance.
     *
     * @param  string  $recipeUrl
     * @return void
     */
    public function __construct(string $recipeUrl)
    {
        $this->recipeUrl = $recipeUrl;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $recipePage = file_get_contents($this->recipeUrl);

        return Str::contains($recipePage, [
            'application/ld+json',
            '"@type": "Recipe"',
        ]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This URL does not have a recipe in a format that can be imported';
    }
}
