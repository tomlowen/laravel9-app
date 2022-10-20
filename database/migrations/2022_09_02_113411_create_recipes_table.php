<?php

use App\Models\User;
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
            $table->foreignIdFor(User::class);
            $table->string('name', 100);
            $table->string('author', 100)->nullable();
            $table->string('source', 100);
            $table->text('description')->nullable();
            $table->text('steps');
            $table->tinyInteger('yield');
            $table->smallInteger('preparation_time')->default(0);
            $table->smallInteger('cooking_time')->default(0);
            $table->smallInteger('total_time')->default(0);
            $table->float('rating')->nullable();
            $table->string('calories')->nullable();
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
