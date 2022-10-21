<?php

namespace App\Http\Requests;

use App\Rules\validRecipeUrl;
use Illuminate\Foundation\Http\FormRequest;

class ImportRecipeRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
            'recipeUrl' => [
                'bail',
                'required',
                'active_url',
                new validRecipeUrl
            ],
        ];
    }
}
