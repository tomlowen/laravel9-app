<?php

namespace App\Libraries\Spoonacular\Requests;

use GuzzleHttp\Client;

abstract class SpoonacularRequest
{
    /**
    * Get the Illuminate Client to execite the request
    *
    * @return \GuzzleHttp\Client
    */
    public function getClient()
    {
        return app()->makeWith(Client::class, [
            'config' => [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'x-api-key' => config('services.spoonacular.key')
                ]
            ]
        ]);
    }
}
