<?php

namespace App\Libraries\Spoonacular\Responses;

abstract class SpoonacularResponse
{
    /**
     * The response body
     */
    public $body;

    /**
     * Constructor
     *
     * @param  array  $body
     */
    public function __construct(array $body)
    {
        $this->body = $body;
    }
}
