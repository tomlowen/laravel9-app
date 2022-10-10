<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // 'recipe.name' => [
            //     'required',
            //     'string',
            //     'max:255'
            // ],
            // 'recipe.author' => [
            //     'sometimes',
            //     'string',
            //     'max:255'
            // ],
            // 'recipe.source' => [
            //     'sometimes',
            //     'url',
            //     'max:255'
            // ],
            // 'recipe.description' => [
            //     'sometimes',
            //     'string',
            //     'max:2000'
            // ],
            // 'recipe.steps' => [
            //     'required',
            //     'array',
            // ],
            // 'recipe.yield' => [
            //     'sometimes',
            //     'integer',
            // ],
            // 'recipe.prepTime' => [
            //     'sometimes',
            //     'integer',
            // ],
            // 'recipe.cookTime' => [
            //     'sometimes',
            //     'integer',
            // ],
            // 'recipe.rating' => [
            //     'sometimes',
            //     'integer',
            // ],
            // 'recipe.calories' => [
            //     'sometimes',
            //     'string',
            //     'max:255'
            // ],
            // 'recipe.ingredients' => [
            //     'required',
            //     'array',
            // ],
        ];
    }
}
