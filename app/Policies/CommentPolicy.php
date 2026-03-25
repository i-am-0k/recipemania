<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function delete(User $user, Comment $comment): bool
    {
        // Админ или автор комментария
        return $user->role === 'admin' || $user->id === $comment->user_id;
    }
}
