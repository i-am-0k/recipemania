<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe;
use App\Models\SavedRecipe;
use App\Models\Rating;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function show($id)
    {
        try {
            Log::info('=== Profile show method called ===');
            Log::info('Profile ID: ' . $id);

            $user = User::withCount(['recipes', 'ratings'])
                ->find($id);

            if (!$user) {
                Log::error('User not found with ID: ' . $id);
                return Inertia::render('Errors/404', [
                    'message' => 'Пользователь не найден'
                ]);
            }

            Log::info('User found:', [
                'id' => $user->id,
                'name' => $user->name,
                'recipes_count' => $user->recipes_count,
                'ratings_count' => $user->ratings_count
            ]);

            // Получаем рецепты пользователя
            $recipesQuery = Recipe::where('user_id', $user->id)
                ->with('user')
                ->withCount('savedByUsers as likes_count')
                // Используем правильные отношения для рейтинга
                ->withAvg('ratings as avg_rating', 'rating_value')
                ->withCount('ratings as total_reviews');

            $currentUser = auth()->user();

            // Если просматривает не админ и не сам пользователь, показываем только опубликованные
            if (!$currentUser || ($currentUser->id !== $user->id && $currentUser->role !== 'admin')) {
                $recipesQuery->where('is_published', 1);
            }

            $recipes = $recipesQuery->latest()->get();
            Log::info('Recipes found: ' . $recipes->count());

            // Форматируем рецепты
            $formattedRecipes = $recipes->map(function ($recipe) use ($currentUser) {
                $isLiked = false;
                if ($currentUser) {
                    $isLiked = SavedRecipe::where('user_id', $currentUser->id)
                        ->where('recipe_id', $recipe->id)
                        ->exists();
                }

                return [
                    'id' => $recipe->id,
                    'title' => $recipe->title,
                    'mainPhotoUrl' => $recipe->main_photo
                        ? asset('storage/' . $recipe->main_photo)
                        : null,
                    'timeInMinutes' => $recipe->preparation_time,
                    'avgRating' => round($recipe->avg_rating ?? 0, 1),
                    'totalReviews' => $recipe->total_reviews ?? 0,
                    'isLiked' => $isLiked,
                    'likesCount' => $recipe->likes_count ?? 0,
                    'is_published' => $recipe->is_published,
                    'user' => [
                        'id' => $recipe->user->id,
                        'name' => $recipe->user->name,
                        'avatar' => $recipe->user->avatar,
                    ],
                ];
            });

            // Получаем рейтинги пользователя
            $ratings = Rating::where('user_id', $user->id)
                ->with('recipe')
                ->latest()
                ->take(10)
                ->get();

            Log::info('Ratings found: ' . $ratings->count());

            $formattedRatings = $ratings->map(function ($rating) {
                return [
                    'id' => $rating->id,
                    'recipe_id' => $rating->recipe_id,
                    'recipe_title' => $rating->recipe->title ?? 'Рецепт удален',
                    'rating_value' => $rating->rating_value,
                    'created_at' => $rating->created_at->format('d.m.Y'),
                ];
            });

            $response = [
                'profileUser' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                    'gender' => $user->gender ?? 'Не указан',
                    'role' => $user->role,
                    'created_at' => $user->created_at->format('d.m.Y'),
                    'recipes_count' => $user->recipes_count,
                    'ratings_count' => $user->ratings_count,
                ],
                'recipes' => $formattedRecipes,
                'recentRatings' => $formattedRatings,
                'isOwnProfile' => $currentUser ? $currentUser->id === $user->id : false,
                'isAdmin' => $currentUser ? $currentUser->role === 'admin' : false,
            ];

            Log::info('Response prepared successfully');

            return Inertia::render('Profile/Show', $response);

        } catch (\Exception $e) {
            Log::error('Error in profile show: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return Inertia::render('Errors/404', [
                'message' => 'Произошла ошибка при загрузке профиля'
            ]);
        }
    }
}
