<?php

namespace App\Services;

use App\Importers\RecipeImporter;
use DOMDocument;
use DOMXPath;

class ImportRecipeService
{
    /**
     * Import a recipe from a URL
     *
     * @param string $url
     * @return Exception|Recipe
     */
    public function import(string $url)
    {
        $recipePage = file_get_contents($url);

        // retrieve the JSON data
        $d = new DOMDocument();
        @$d->loadHTML($recipePage);

        // parse the HTML to retrieve the "ld+json" only
        $xp = new DOMXPath($d);
        $jsonScripts = $xp->query('//script[@type="application/ld+json"]');
        $json = trim($jsonScripts->item(0)->nodeValue); // get the first script only (it should be unique anyway)

        return app(RecipeImporter::class)->importRecipe($json);
    }
}
