<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'user_id',
        'comment'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    // Получить оценку пользователя для этого рецепта
    public function getUserRatingAttribute(): ?float
    {
        return $this->recipe->ratings()
            ->where('user_id', $this->user_id)
            ->value('rating_value');
    }

    // Проверка, может ли пользователь удалить комментарий
    public function canBeDeletedBy($user): bool
    {
        if (!$user) return false;

        return $user->id === $this->user_id || $user->role === 'admin';
    }
}
