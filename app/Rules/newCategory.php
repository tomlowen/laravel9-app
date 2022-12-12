<?php

namespace App\Rules;

use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Str;

class newCategory implements InvokableRule
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
        $slug = Str::slug($value);

        if (Category::where('slug', $slug)->where('user_id', $this->user->id)->exists()) {
            $fail('A category with this name already exists.');
        }
    }
}
