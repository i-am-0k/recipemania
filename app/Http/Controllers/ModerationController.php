<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ModerationController extends Controller
{
    public function index()
    {
        try {
            // Проверяем права (хотя middleware уже должен это сделать)
            if (!auth()->check()) {
                return redirect()->route('login');
            }

            Log::info('User role: ' . auth()->user()->role);

            $unpublishedRecipes = Recipe::with('user')
                ->where('is_published', 0)
                ->latest()
                ->get()
                ->map(function ($recipe) {
                    return [
                        'id' => $recipe->id,
                        'title' => $recipe->title,
                        'description' => $recipe->description,
                        'mainPhotoUrl' => $recipe->main_photo
                            ? asset('public/storage/' . $recipe->main_photo)
                            : null,
                        'timeInMinutes' => $recipe->preparation_time,
                        'user' => [
                            'id' => $recipe->user->id ?? 0,
                            'name' => $recipe->user->name ?? 'Аноним',
                        ],
                        'created_at' => $recipe->created_at->format('d.m.Y H:i'),
                    ];
                });

            Log::info('Unpublished recipes count: ' . $unpublishedRecipes->count());

            return Inertia::render('Moderation', [
                'recipes' => $unpublishedRecipes
            ]);

        } catch (\Exception $e) {
            Log::error('Moderation error: ' . $e->getMessage());
            return Inertia::render('Errors/500', [
                'message' => 'Ошибка при загрузке страницы модерации'
            ]);
        }
    }

    /**
     * Показать отдельный рецепт
     */
    public function show($id)
    {
        $recipe = Recipe::with([
            'user',
            'ingredients.ingredient',
            'steps',
            'comments' => function($query) {
                $query->with('user')
                    ->latest()
                    ->limit(50);
            }
        ])->findOrFail($id);

        // Проверяем права доступа к неопубликованному рецепту
        $user = auth()->user();
        $isOwner = $user && $user->id === $recipe->user_id;
        $isAdmin = $user && $user->role === 'admin';

        if (!$recipe->is_published) {
            if (!$user || (!$isAdmin && !$isOwner)) {
                if (request()->header('X-Inertia')) {
                    return Inertia::render('Errors/404', [
                        'message' => 'Рецепт не найден или еще не опубликован'
                    ]);
                }
                abort(404, 'Рецепт не найден');
            }
        }

        // Получаем информацию о лайках
        $isLiked = false;
        $likesCount = $recipe->savedByUsers()->count();

        if ($user) {
            $isLiked = \App\Models\SavedRecipe::where('user_id', $user->id)
                ->where('recipe_id', $id)
                ->exists();
        }

        $formattedRecipe = [
            'id' => $recipe->id,
            'title' => $recipe->title,
            'description' => $recipe->description,
            'mainPhotoUrl' => $recipe->main_photo
                            ? asset('public/storage/' . $recipe->main_photo)
                            : null,
            'timeInMinutes' => $recipe->preparation_time,
            'portion' => $recipe->portion,
            'type' => $recipe->type,
            'dish_category' => $recipe->dish_category,
            'is_alcoholic' => $recipe->is_alcoholic,
            'avgRating' => round($recipe->average_rating ?? 0, 1),
            'totalReviews' => $recipe->ratings_count ?? 0,
            'user' => [
                'id' => $recipe->user->id ?? 0,
                'name' => $recipe->user->name ?? 'Аноним',
                'avatar' => $recipe->user->avatar,
            ],
            'ingredients' => $recipe->ingredients->map(function($ing) {
                return [
                    'id' => $ing->ingredient->id,
                    'name' => $ing->ingredient->name,
                    'quantity' => $ing->quantity,
                    'unit' => $ing->unit,
                ];
            }),
            'steps' => $recipe->steps->map(function($step) {
                return [
                    'step_number' => $step->step_number,
                    'text' => $step->text,
                    'photoUrl' => $step->photo_url
                        ? asset('public/storage/' . $step->photo_url)
                        : null,
                ];
            }),
            'comments' => !$recipe->is_published ? [] : $recipe->comments->map(function($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'avatar' => $comment->user->avatar,
                    ],
                    'user_rating' => $comment->user_rating ?? null,
                ];
            }),
            'created_at' => $recipe->created_at->format('d.m.Y'),
            'isLiked' => $isLiked,
            'likesCount' => $likesCount,
            'is_published' => $recipe->is_published,
            'can_comment' => $recipe->is_published,
        ];

        return Inertia::render('Recipe/Show', [
            'recipe' => $formattedRecipe,
            'backTo' => 'moderation',
            'backTitle' => 'Назад к модерации'
        ]);
    }

    public function approve($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->is_published = 1;
        $recipe->save();

        return redirect()->back()->with('success', 'Рецепт опубликован');
    }

    // Метод для отклонения рецепта
    public function reject($id)
    {
        $recipe = Recipe::findOrFail($id);
        // Можно удалить или отметить как отклоненный
        $recipe->delete(); // или добавить поле rejected

        return redirect()->back()->with('success', 'Рецепт отклонен');
    }
}
