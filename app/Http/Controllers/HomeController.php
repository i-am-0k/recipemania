<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\SavedRecipe;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $savedRecipeIds = [];

        if ($user) {
            $savedRecipeIds = SavedRecipe::where('user_id', $user->id)
                ->pluck('recipe_id')
                ->toArray();
        }

        $recipes = Recipe::with(['user', 'ingredients.ingredient'])
            ->where('is_published', 1)
            ->latest()
            ->get()
            ->map(function ($recipe) use ($savedRecipeIds) {
                return [
                    'id' => $recipe->id,
                    'title' => $recipe->title,
                    'mainPhotoUrl' => $recipe->main_photo
                        ? asset('public/storage/' . $recipe->main_photo)
                        : null,
                    'timeInMinutes' => $recipe->preparation_time ?? 0,
                    'avgRating' => round($recipe->average_rating ?? 0, 1),
                    'totalReviews' => $recipe->ratings_count ?? 0,
                    'user' => [
                        'id' => $recipe->user->id ?? 0,
                        'name' => $recipe->user->name ?? 'Аноним',
                        'avatar' => $recipe->user->avatar ?? null,
                    ],
                    'isLiked' => in_array($recipe->id, $savedRecipeIds),
                    'likesCount' => $recipe->savedByUsers()->count(),
                    'type' => $recipe->type, // Добавляем тип
                    'dish_category' => $recipe->dish_category, // Добавляем категорию
                    'is_alcoholic' => $recipe->is_alcoholic, // Добавляем алкогольность
                    'ingredients' => $recipe->ingredients->map(function($ing) {
                        return [
                            'id' => $ing->ingredient->id,
                            'name' => $ing->ingredient->name,
                            'quantity' => $ing->quantity,
                            'unit' => $ing->unit,
                        ];
                    }),
                    'created_at' => $recipe->created_at->format('Y-m-d H:i:s'),
                ];
            });

        return Inertia::render('Home', [
            'recipes' => $recipes
        ]);
    }
}
