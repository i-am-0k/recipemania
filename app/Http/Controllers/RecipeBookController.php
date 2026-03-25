<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\SavedRecipe;
use App\Models\Rating;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\RecipeController;

class RecipeBookController extends Controller
{
    /**
     * Любимые рецепты пользователя
     */
    public function favorites()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return redirect()->route('login');
            }

            // Получаем ID рецептов, которые лайкнул пользователь
            $savedRecipeIds = SavedRecipe::where('user_id', $user->id)
                ->pluck('recipe_id')
                ->toArray();

            // Получаем сами рецепты
            $recipes = Recipe::whereIn('id', $savedRecipeIds)
                ->with('user')
                ->where('is_published', 1)
                ->latest()
                ->get()
                ->map(function ($recipe) use ($user) {
                    // Проверяем, оценил ли пользователь этот рецепт
                    $userRating = Rating::where('user_id', $user->id)
                        ->where('recipe_id', $recipe->id)
                        ->value('rating_value');

                    return [
                        'id' => $recipe->id,
                        'title' => $recipe->title,
                        'mainPhotoUrl' => $recipe->main_photo
                                        ? asset('storage/' . $recipe->main_photo)
                                        : null,
                        'timeInMinutes' => $recipe->preparation_time ?? 0,
                        'avgRating' => round($recipe->average_rating ?? 0, 1),
                        'totalReviews' => $recipe->ratings_count ?? 0,
                        'user' => [
                            'id' => $recipe->user->id ?? 0,
                            'name' => $recipe->user->name ?? 'Аноним',
                            'avatar' => $recipe->user->avatar ?? null,
                        ],
                        'isLiked' => true, // В избранном они все лайкнуты
                        'likesCount' => $recipe->savedByUsers()->count(),
                        'userRating' => $userRating ?? 0,
                        'context' => 'favorites'
                    ];
                });

            return Inertia::render('recipe-book/favorites', [
                'recipes' => $recipes
            ]);

        } catch (\Exception $e) {
            Log::error('Error in favorites: ' . $e->getMessage());

            return Inertia::render('recipe-book/favorites', [
                'recipes' => [],
                'error' => 'Не удалось загрузить любимые рецепты'
            ]);
        }
    }

    /**
     * Рецепты, созданные пользователем
     */
    public function created()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return redirect()->route('login');
            }

            // Получаем ID рецептов, которые лайкнул пользователь
            $savedRecipeIds = SavedRecipe::where('user_id', $user->id)
                ->pluck('recipe_id')
                ->toArray();

            $recipes = Recipe::where('user_id', $user->id)
                ->with('user')
                ->latest()
                ->get()
                ->map(function ($recipe) use ($user, $savedRecipeIds) {
                    $isLiked = in_array($recipe->id, $savedRecipeIds);

                    $userRating = Rating::where('user_id', $user->id)
                        ->where('recipe_id', $recipe->id)
                        ->value('rating_value');

                    return [
                        'id' => $recipe->id,
                        'title' => $recipe->title,
                        'mainPhotoUrl' => $recipe->main_photo
                                        ? asset('storage/' . $recipe->main_photo)
                                        : null,
                        'timeInMinutes' => $recipe->preparation_time ?? 0,
                        'avgRating' => round($recipe->average_rating ?? 0, 1),
                        'totalReviews' => $recipe->ratings_count ?? 0,
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'avatar' => $user->avatar ?? null,
                        ],
                        'isLiked' => $isLiked,
                        'likesCount' => $recipe->savedByUsers()->count(),
                        'userRating' => $userRating ?? 0,
                        'context' => 'created',
                        'is_published' => $recipe->is_published,
                        'can_comment' => $recipe->is_published,
                    ];
                });

            return Inertia::render('recipe-book/created', [
                'recipes' => $recipes
            ]);

        } catch (\Exception $e) {
            Log::error('Error in created: ' . $e->getMessage());

            return Inertia::render('recipe-book/created', [
                'recipes' => [],
                'error' => 'Не удалось загрузить созданные рецепты'
            ]);
        }
    }

    /**
     * Рецепты, оцененные пользователем
     */
    public function rated()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return redirect()->route('login');
            }

            // Получаем ID рецептов, которые лайкнул пользователь
            $savedRecipeIds = SavedRecipe::where('user_id', $user->id)
                ->pluck('recipe_id')
                ->toArray();

            // Получаем рецепты, которые оценил пользователь
            $ratedRecipeIds = Rating::where('user_id', $user->id)
                ->pluck('recipe_id')
                ->toArray();

            $recipes = Recipe::whereIn('id', $ratedRecipeIds)
                ->with('user')
                ->where('is_published', 1)
                ->latest()
                ->get()
                ->map(function ($recipe) use ($user, $savedRecipeIds) {
                    // Проверяем, лайкнут ли рецепт текущим пользователем
                    $isLiked = in_array($recipe->id, $savedRecipeIds);

                    // Получаем оценку пользователя
                    $userRating = Rating::where('user_id', $user->id)
                        ->where('recipe_id', $recipe->id)
                        ->value('rating_value');

                    return [
                        'id' => $recipe->id,
                        'title' => $recipe->title,
                        'mainPhotoUrl' => $recipe->main_photo
                            ? asset('storage/' . $recipe->main_photo)
                            : null,
                        'timeInMinutes' => $recipe->preparation_time ?? 0,
                        'avgRating' => round($recipe->average_rating ?? 0, 1),
                        'totalReviews' => $recipe->ratings_count ?? 0,
                        'user' => [
                            'id' => $recipe->user->id ?? 0,
                            'name' => $recipe->user->name ?? 'Аноним',
                            'avatar' => $recipe->user->avatar ?? null,
                        ],
                        'isLiked' => $isLiked,
                        'likesCount' => $recipe->savedByUsers()->count(),
                        'userRating' => $userRating ?? 0,
                        'context' => 'rated'
                    ];
                });

            return Inertia::render('recipe-book/rated', [
                'recipes' => $recipes
            ]);

        } catch (\Exception $e) {
            Log::error('Error in rated: ' . $e->getMessage());

            return Inertia::render('recipe-book/rated', [
                'recipes' => [],
                'error' => 'Не удалось загрузить оцененные рецепты'
            ]);
        }
    }

    /**
     * Показать рецепт из избранного
     */
    public function showFavorite($id)
    {
        return $this->showRecipe($id, 'favorites', 'Назад к любимому');
    }

    /**
     * Показать созданный рецепт
     */
    public function showCreated($id)
    {
        return $this->showRecipe($id, 'created', 'Назад к созданным');
    }

    /**
     * Показать оценённый рецепт
     */
    public function showRated($id)
    {
        return $this->showRecipe($id, 'rated', 'Назад к оценённым');
    }

    /**
     * Общий метод для показа рецепта из книги рецептов
     */
    private function showRecipe($id, $backTo, $backTitle = null)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return redirect()->route('login');
            }

            $recipe = Recipe::with(['user', 'ingredients.ingredient', 'steps'])
                ->findOrFail($id);

            // Проверяем, лайкнут ли рецепт
            $isLiked = SavedRecipe::where('user_id', $user->id)
                ->where('recipe_id', $id)
                ->exists();

            // Получаем оценку пользователя
            $userRating = Rating::where('user_id', $user->id)
                ->where('recipe_id', $id)
                ->value('rating_value') ?? 0;

            // Используем метод форматирования из RecipeController
            $recipeController = new RecipeController();
            $formattedRecipe = $recipeController->formatRecipe($recipe, $isLiked, $userRating);

            return Inertia::render('Recipe/Show', [
                'recipe' => $formattedRecipe,
                'backTo' => $backTo,
                'backTitle' => $backTitle
            ]);

        } catch (\Exception $e) {
            Log::error("Error showing recipe from {$backTo}: " . $e->getMessage());

            return Inertia::render('Errors/404', [
                'message' => 'Рецепт не найден'
            ]);
        }
    }
}
