<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'recipe_id',
        'user_id',
        'rating_value'  // Убедитесь, что это поле существует в таблице
    ];

    // Связь с рецептом
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Автоматическое обновление среднего рейтинга при сохранении
    protected static function booted()
    {
        static::saved(function ($rating) {
            if ($rating->recipe) {
                $rating->recipe->updateAverageRating();
            }
        });

        static::deleted(function ($rating) {
            if ($rating->recipe) {
                $rating->recipe->updateAverageRating();
            }
        });
    }
}
