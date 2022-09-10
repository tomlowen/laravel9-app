<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory;

    const MORPH_KEY = 'tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get all of the recipes for the tag.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function recipes(): MorphToMany
    {
        return $this->morphedByMany(Recipe::class, 'taggable');
    }
}
