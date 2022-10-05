<?php

namespace App\Libraries\Spoonacular\Requests;

use App\Libraries\Spoonacular\Responses\SpoonacularParseIngredientsResponse;

class SpoonacularParseIngredientsRequest extends SpoonacularRequest
{
    /**
     * The list of ingredients to parse.
     */
    protected array $ingredients;

    /**
     * Constructor
     *
     * @param array $ingredients
     */
    public function __construct(array $ingredients)
    {
        $this->ingredients = $ingredients;
    }

    /**
     * Parse the list of ingredients
     *
     * @return \App\Libraries\Spoonacular\Requests\SpoonacularParseIngredientsResponse
     */
    public function parse()
    {
        $response = $this->getClient()->post(
            config('services.spoonacular.url') . '/recipes/parseIngredients',
            [
                'form_params' => [
                    'servings' => 1,
                    'includeNutrition' => false,
                    'ingredientList' => implode("
                        ", $this->ingredients
                    )
                ]
            ]
        );

        $content = $response->getBody()->getContents();
        $data = json_decode($content);

        return new SpoonacularParseIngredientsResponse($data);
    }
}
