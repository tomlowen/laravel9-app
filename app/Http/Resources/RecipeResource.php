<?php

namespace App\Http\Resources;

use App\Models\Ingredient;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'author' => $this->author,
            'source' => $this->source,
            'description' => $this->description,
            'steps' => unserialize($this->steps),
            'yield' => $this->yield,
            'prepTime' => $this->preparation_time,
            'cookTime' => $this->cooking_time,
            'totalTime' => $this->preparation_time + $this->cooking_time,
            'rating' => $this->rating,
            'calories' => $this->calories,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'ingredients' => RecipeIngredientResource::collection($this->whenLoaded('recipeIngredients')),
            'images' => ImageResource::collection($this->whenLoaded('images'))
        ];
    }
}
