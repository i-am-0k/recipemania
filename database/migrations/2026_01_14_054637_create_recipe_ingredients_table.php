<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('ingredient_id');
            $table->string('quantity'); // Количество ингредиента
            $table->enum('unit', ['г', 'кг', 'стакан', 'ст. л.', 'ч. л.', 'шт.', 'мл', 'л', 'по вкусу', 'по желанию', 'зубчик', 'лист', 'пучок', 'головка', 'щепотка', 'кочан', 'долька', 'капля']); // Единица измерения ингредиента
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredients');
    }
};
