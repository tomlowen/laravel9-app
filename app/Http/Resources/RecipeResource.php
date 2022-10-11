<?php

namespace App\Http\Resources;

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
            'name' => $this->name,
            'author' => $this->author,
            'source' => $this->source,
            'description' => $this->description,
            'steps' => $this->steps,
            'yield' => $this->yield,
            'preparation_time' => $this->prepTime,
            'cooking_time' => $this->cookTime,
            'rating' => $this->rating,
            'calories' => $this->calories,
        ];
    }
}
