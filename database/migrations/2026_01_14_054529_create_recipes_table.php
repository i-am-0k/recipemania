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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название
            $table->string('main_photo')->nullable(); // Главная фотография
            $table->text('description'); // Текст рецепта
            $table->enum('type', ['food', 'drink']); // Тип рецепта: блюдо или напиток
            $table->enum('dish_category', ['Первые блюда', 'Вторые блюда', 'Гарниры', 'Салаты', 'Закуски', 'Десерты', 'Выпечка', 'Соусы', 'Другое'])->nullable();
            $table->boolean('is_alcoholic')->nullable(); // Алкогольный/безалкогольный - для 'drink'
            $table->integer('preparation_time'); // Время приготовления в минутах
            $table->smallinteger('portion'); // Количество порций
            $table->unsignedBigInteger('user_id'); // Автор рецепта
            $table->boolean('is_published')->default(false); // Опубликован или нет
            $table->decimal('average_rating', 2, 1)->default(0.0); // Средняя оценка
            $table->integer('ratings_count')->default(0); // Количество оценок
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
