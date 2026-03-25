<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RecipePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Recipe $recipe)
    {
        return $user->id === $recipe->user_id; // Только автор может обновить
        // Или return $user->id === $recipe->user_id || $user->is_admin; для админа
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Recipe $recipe)
    {
        return $user->id === $recipe->user_id; // Только автор может удалить
        // Или return $user->id === $recipe->user_id || $user->is_admin; для админа
    }

    // Перехват всех проверок для администраторов
    public function before(User $user, string $ability)
    {
        if ($user->is_admin) { // Предполагаем, что у модели User есть поле is_admin
            return true;
        }
    }
}
