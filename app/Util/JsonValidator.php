<?php

namespace App\Util;

class JsonValidator
{
    /**
     * Is json valid?
     *
     * @param  string  $json
     * @return bool
     */
    public static function isJsonValid($json): bool
    {
        json_decode($json);

        return json_last_error() === JSON_ERROR_NONE;
    }
}
