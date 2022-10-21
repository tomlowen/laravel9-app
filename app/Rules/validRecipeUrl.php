<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Str;

class validRecipeUrl implements InvokableRule
{
    /**
     * Indicates whether the rule should be implicit.
     *
     * @var bool
     */
    public $implicit = true;

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $recipePage = file_get_contents($value);

        if (! Str::contains($recipePage, [
            '"@type":"Recipe"',
            '"@type":"Ingredient"',
            '"@type": "Recipe"',
            '"@type": "Ingredient"',
        ])) {
            $fail('Cannot find a recipe to import from this url');
        }
    }
}
