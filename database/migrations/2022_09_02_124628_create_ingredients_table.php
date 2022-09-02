<?php

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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('default_measure')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('optional')->nullable();
            $table->timestamps();
        });

        Schema::create('ingredientables', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('ingredient_id');
            $table->morphs('ingredientable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredientables');
        Schema::dropIfExists('ingredients');
    }
};
