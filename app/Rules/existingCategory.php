<?php

namespace App\Rules;

use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\Validation\InvokableRule;

class existingCategory implements InvokableRule
{
    /**
     * Create a new rule instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

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
        if (! Category::where('slug', $value)->where('user_id', $this->user->id)->exists()) {
            $fail("A $attribute with the name $value doens't exist.");
        }
    }
}
