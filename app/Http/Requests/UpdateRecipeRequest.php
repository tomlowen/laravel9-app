<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'author' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],
            'source' => [
                'sometimes',
                'nullable',
                'url',
                'max:255',
            ],
            'description' => [
                'sometimes',
                'nullable',
                'string',
                'max:2000',
            ],
            'steps' => [
                'required',
                'array',
            ],
            'yield' => [
                'required',
                'integer',
            ],
            'prepTime' => [
                'sometimes',
                'nullable',
                'integer',
            ],
            'cookTime' => [
                'sometimes',
                'nullable',
                'integer',
            ],
            'rating' => [
                'sometimes',
                'nullable',
                'integer',
            ],
            'calories' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],
            'ingredients' => [
                'required',
                'array',
            ],
            'image' => [
                'sometimes',
                'nullable',
                'image',
                'max:10240' //10 mb
            ],
            'imageUrl' => [
                'sometimes',
                'nullable',
                'string',
            ],
        ];
    }
}
