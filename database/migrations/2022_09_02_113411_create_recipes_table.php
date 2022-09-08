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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('author', 100);
            $table->string('source', 100);
            $table->text('description')->nullable();
            $table->text('steps');
            $table->tinyInteger('yield');
            $table->tinyText('preparation_time')->nullable();
            $table->tinyText('cooking_time')->nullable();
            $table->float('rating')->nullable();
            $table->smallInteger('calories')->nullable();
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
        Schema::dropIfExists('recipes');
    }
};
