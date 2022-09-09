<?php

namespace App\Services;

class IngredientService
{
    const INGREDIENT_UNITS = [
        "teaspoon",
        "t",
        "tsp.",
        "tsp",
        "ounce",
        "oz",
        "oz.",
        "pounds",
        "lb",
        "lbs",
        "lb.",
        "lbs.",
        "tablespoon",
        "T",
        "tbl.",
        "tbs.",
        "tbsp.",
        "fluid ounce",
        "fl oz",
        "gill",
        "cup",
        "c",
        "c.",
        "pint",
        "p",
        "pt",
        "fl pt",
        "",
        "quart",
        "q",
        "qt",
        "fl",
        "qt",
        "gallon",
        "g",
        "gal",
        "ml",
        "milliliter",
        "millilitre",
        "cc",
        "mL",
        "l",
        "liter",
        "litre",
        "L",
    ];

    /**
     * Parse an ingredient string into an array of values
     *
     * @param string $string
     * @return array
     */
    public function parseIngredient($ingredientString){
        $ingredientData = array(
            'unit' => null,
            'quantity' => null,
            'name' => null,
            'info' => null
        );

        if (preg_match("/[0-9][\/][0-9]|[0-9]/", $ingredientString)) { //Check To See If The Ingredient contains a certain amount.
            preg_match('/[0-9][\/][0-9]|[0-9]/', $ingredientString, $matches);
            $ingredientData['quantity'] = trim($matches[0]);

            //Check To See If We Have a Matching Unit in our $ingredientString
            $units = self::INGREDIENT_UNITS;

            //Check To See If We Can Find a Matching Unit
            foreach($units as $unit){
                if (preg_match("/\s+".$unit."\s+/", $ingredientString)) {
                    preg_match("/\s+".$unit."\s+/", $ingredientString, $matches);
                    $ingredientData['unit'] = trim($matches[0]);
                    break;
                }
            }

            //Find The Name of The Item
            //Remove The Unit and Amount
            $FixedString = $ingredientString;
            $FixedString = $ingredientData['unit'] ? str_replace($ingredientData['unit'], "", $FixedString) : $FixedString;
            $FixedString = $ingredientData['quantity'] ? str_replace($ingredientData['quantity'], "", $FixedString)  : $FixedString;


            $ArrayString = explode(",", $FixedString);
            if(count($ArrayString) > 1){
                $ingredientData['info'] = trim($ArrayString[1]);
            }
            $ingredientData['name'] = trim($ArrayString[0]);

        } else {
            //We Dont a have an ingrident quanity thus we could only have an ingredient and possibly an info value
            //We Can spilt these two strings up by spilting on the ","
            $ArrayString = explode(",", $ingredientString);
            if(count($ArrayString) > 4){
                $ingredientData['info'] = $ArrayString[1];
            }
            $ingredientData['name'] = $ArrayString[0];
        }

        return $ingredientData;
    }
}
