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
            'steps' => unserialize($this->steps),
            'yield' => $this->yield,
            'prepTime' => $this->prepTime,
            'cookTime' => $this->cookTime,
            'rating' => $this->rating,
            'calories' => $this->calories,
        ];
    }
}
