<?php

namespace App\Libraries\Spoonacular\Responses;

class SpoonacularParseIngredientsResponse extends SpoonacularResponse
{
    /**
     * The response structure
     */
    public $structure;

    /**
     * Constructor
     *
     * @param array $body the Spoonacular response body
     */
    public function __construct(array $body)
    {
        $this->structure = [
            // tbc
        ];

        parent::__construct($body);
    }
}
