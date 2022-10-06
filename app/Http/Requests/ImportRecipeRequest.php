<?php

namespace App\Http\Requests;

use App\Rules\RecipeUrl;
use Illuminate\Foundation\Http\FormRequest;

class ImportRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'recipeUrl' => [
                'required',
                'url',
                new RecipeUrl(),
            ]
        ];
    }
}
