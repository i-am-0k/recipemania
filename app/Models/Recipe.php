<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'title',
        'main_photo',
        'description',
        'type',
        'dish_category',
        'is_alcoholic',
        'preparation_time',
        'portion',
        'user_id',
        'is_published',
        'average_rating',
        'ratings_count'
    ];

    protected $casts = [
        'is_alcoholic' => 'boolean',
        'is_published' => 'boolean',
        'average_rating' => 'decimal:1',
        'ratings_count' => 'integer',
    ];

    // Связи
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ingredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    public function steps()
    {
        return $this->hasMany(RecipeStep::class)->orderBy('step_number');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_recipes');
    }

    /**
     * Обновить средний рейтинг рецепта
     */
    public function updateAverageRating()
    {
        $average = $this->ratings()->avg('rating_value');
        $count = $this->ratings()->count();

        $this->average_rating = $average ? round($average, 1) : 0;
        $this->ratings_count = $count;

        // Используем saveQuietly() чтобы избежать бесконечного цикла
        $this->saveQuietly();

        return $this;
    }

    /**
     * Получить рейтинг пользователя для этого рецепта
     */
    public function getUserRating($userId)
    {
        return $this->ratings()
            ->where('user_id', $userId)
            ->value('rating_value');
    }

    /**
     * Пересчитать рейтинг (статический метод для массовых операций)
     */
    public static function recalculateRatings()
    {
        $recipes = self::with('ratings')->get();

        foreach ($recipes as $recipe) {
            $recipe->updateAverageRating();
        }
    }
}
