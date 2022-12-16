<?php

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->smallInteger('quantity')->nullable();
            $table->tinyText('unit')->nullable();
            $table->foreignIdFor(Recipe::class)->cascadeOnDelete();
            $table->foreignIdFor(Category::class);
            $table->text('notes')->nullable();
            $table->boolean('optional')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_ingredients');
    }
};
