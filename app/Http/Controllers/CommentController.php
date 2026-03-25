<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, $recipeId)
{
    $user = auth()->user();

    if (!$user) {
        return response()->json(['error' => 'Не авторизован'], 401);
    }

    $validator = Validator::make($request->all(), [
        'comment' => 'required|string|max:1000',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        $comment = Comment::create([
            'user_id' => $user->id,
            'recipe_id' => $recipeId,
            'comment' => $request->comment,
        ]);

        // Загружаем пользователя с аватаром
        $comment->load('user');

        // Для Inertia запросов возвращаем редирект с данными
        if (request()->header('X-Inertia')) {
            return redirect()->back()->with([
                'success' => 'Комментарий успешно добавлен',
                'comment' => [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'created_at' => $comment->created_at->toISOString(),
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'avatar' => $comment->user->avatar,
                    ],
                    'user_rating' => null,
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'created_at' => $comment->created_at->toISOString(),
                'user' => [
                    'id' => $comment->user->id,
                    'name' => $comment->user->name,
                    'avatar' => $comment->user->avatar,
                ],
                'user_rating' => null,
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Ошибка при сохранении комментария'
        ], 500);
    }
}
    /**
     * Remove the specified comment.
     */
    public function destroy($id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Не авторизован'], 401);
        }

        try {
            $comment = Comment::findOrFail($id);

            // Проверка прав (админ или автор комментария)
            if ($user->role !== 'admin' && $comment->user_id !== $user->id) {
                return response()->json(['error' => 'Нет прав для удаления'], 403);
            }

            $comment->delete();

            if (request()->header('X-Inertia')) {
                return redirect()->back()->with('success', 'Комментарий успешно удален');
            }

            return response()->json([
                'success' => true,
                'message' => 'Комментарий успешно удален'
            ]);

        } catch (\Exception $e) {
            if (request()->header('X-Inertia')) {
                return redirect()->back()->with('error', 'Ошибка при удалении комментария');
            }

            return response()->json([
                'success' => false,
                'error' => 'Ошибка при удалении комментария'
            ], 500);
        }
    }
}
