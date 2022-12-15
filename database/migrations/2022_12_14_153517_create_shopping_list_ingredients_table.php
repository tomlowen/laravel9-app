<?php

use App\Models\Category;
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
        Schema::create('shopping_list_ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->smallInteger('quantity')->nullable();
            $table->tinyText('unit')->nullable();
            $table->boolean('bought')->default(false);
            $table->foreignIdFor(User::class)->cascadeOnDelete();
            $table->foreignIdFor(Category::class);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('shopping_list_ingredients');
    }
};
