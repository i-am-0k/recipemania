<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\SavedRecipe;
use App\Models\Rating;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    /**
     * API для поиска рецептов (AJAX)
     */
    public function api(Request $request)
    {
        $query = $request->get('q');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $recipes = Recipe::where('is_published', 1)
            ->where('title', 'like', "%{$query}%")
            ->with('user')
            ->limit(10)
            ->get()
            ->map(function ($recipe) {
                return [
                    'id' => $recipe->id,
                    'title' => $recipe->title,
                    'mainPhotoUrl' => $recipe->main_photo
                        ? asset('storage/' . $recipe->main_photo)
                        : null,
                    'timeInMinutes' => $recipe->preparation_time,
                    'user' => [
                        'name' => $recipe->user->name ?? 'Аноним',
                    ],
                ];
            });

        return response()->json($recipes);
    }

    /**
     * Страница результатов поиска
     */
    public function results(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 3) {
            return redirect()->route('home');
        }

        $user = auth()->user();
        $savedRecipeIds = [];

        if ($user) {
            $savedRecipeIds = SavedRecipe::where('user_id', $user->id)
                ->pluck('recipe_id')
                ->toArray();
        }

        $recipes = Recipe::where('is_published', 1)
            ->where('title', 'like', "%{$query}%")
            ->with(['user', 'ingredients.ingredient'])
            ->latest()
            ->get()
            ->map(function ($recipe) use ($savedRecipeIds, $user) {
                $isLiked = in_array($recipe->id, $savedRecipeIds);

                $userRating = null;
                if ($user) {
                    $rating = Rating::where('user_id', $user->id)
                        ->where('recipe_id', $recipe->id)
                        ->first();
                    $userRating = $rating ? $rating->rating : null;
                }

                return [
                    'id' => $recipe->id,
                    'title' => $recipe->title,
                    'mainPhotoUrl' => $recipe->main_photo
                        ? asset('storage/' . $recipe->main_photo)
                        : null,
                    'timeInMinutes' => $recipe->preparation_time,
                    'avgRating' => round($recipe->average_rating ?? 0, 1),
                    'totalReviews' => $recipe->ratings_count ?? 0,
                    'type' => $recipe->type,
                    'dish_category' => $recipe->dish_category,
                    'is_alcoholic' => $recipe->is_alcoholic,
                    'created_at' => $recipe->created_at->format('Y-m-d H:i:s'),
                    'user' => [
                        'id' => $recipe->user->id ?? 0,
                        'name' => $recipe->user->name ?? 'Аноним',
                        'avatar' => $recipe->user->avatar ?? null,
                    ],
                    'isLiked' => $isLiked,
                    'likesCount' => $recipe->savedByUsers()->count(),
                    'ingredients' => $recipe->ingredients->map(function($ing) {
                        return [
                            'id' => $ing->ingredient->id,
                            'name' => $ing->ingredient->name,
                            'quantity' => $ing->quantity,
                            'unit' => $ing->unit,
                        ];
                    }),
                ];
            });

        return Inertia::render('SearchResults', [
            'query' => $query,
            'recipes' => $recipes,
            'total' => $recipes->count(),
        ]);
    }
}
