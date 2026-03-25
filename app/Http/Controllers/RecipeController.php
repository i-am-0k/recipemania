<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\SavedRecipe;
use App\Models\Ingredient;
use App\Models\RecipeIngredient;
use App\Models\RecipeStep;
use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        // Проверка лимита рецептов на проверке
        $pendingCount = Recipe::where('user_id', $user->id)
            ->where('is_published', 0)
            ->count();

        $maxPendingRecipes = $user->max_pending_recipes ?? 10;

        if ($pendingCount >= $maxPendingRecipes) {
            return redirect()->route('recipe-book.created')
                ->with('error', "Вы достигли лимита в {$maxPendingRecipes} рецептов на проверке. Дождитесь модерации существующих.");
        }

        $ingredients = Ingredient::select('id', 'name')->get();

        return Inertia::render('Recipe/CreateRecipe', [
            'ingredients' => $ingredients,
        ]);
    }

    /**
     * Сохранить новый рецепт
     */
    public function store(Request $request)
    {
        \Log::info('=== НАЧАЛО СОХРАНЕНИЯ РЕЦЕПТА ===');
        \Log::info('User ID:', ['id' => auth()->id()]);
        \Log::info('Request method:', ['method' => $request->method()]);
        \Log::info('Request all:', $request->all());
        \Log::info('Request files:', array_keys($request->allFiles()));

        $userId = auth()->id();
        if (!$userId) {
            \Log::error('Попытка сохранения рецепта без аутентифицированного пользователя');
            return response()->json([
                'success' => false,
                'message' => 'Необходимо войти в систему для создания рецепта.'
            ], 401);
        }

        // Валидация общих полей
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:food,drink',
            'dish_category' => 'nullable|string|max:100',
            'is_alcoholic' => 'nullable|boolean',
            'preparation_time' => 'required|integer|min:1',
            'portion' => 'required|integer|min:1|max:50',
            'main_photo' => 'required|image|max:10240',
            'ingredients' => 'required|array|min:2',
            'ingredients.*.ingredient_id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|string|max:50',
            'ingredients.*.unit' => 'required|string|max:50',
            'steps' => 'required|array|min:3',
            'steps.*.text' => 'required|string',
            'steps.*.photo' => 'nullable|image|max:10240',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());

            // Для Inertia запросов возвращаем редирект с ошибками
            if ($request->header('X-Inertia')) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            \Log::info('Validation passed, creating recipe...');

            // Сохраняем рецепт
            $recipe = new Recipe();
            $recipe->title = $request->input('title');
            $recipe->description = $request->input('description');
            $recipe->type = $request->input('type');
            $recipe->dish_category = $request->input('dish_category');
            $recipe->is_alcoholic = $request->boolean('is_alcoholic');
            $recipe->preparation_time = $request->input('preparation_time');
            $recipe->portion = $request->input('portion');
            $recipe->user_id = auth()->id();
            $recipe->is_published = 0; // Новые рецепты не опубликованы
            $recipe->average_rating = 0;
            $recipe->ratings_count = 0;

            // Сохраняем главное фото
            if ($request->hasFile('main_photo')) {
                \Log::info('Saving main photo...');
                $file = $request->file('main_photo');
                $filename = Str::uuid() . '.' . $file->extension();
                $file->storeAs('recipes/photos', $filename, 'public');
                $recipe->main_photo = 'recipes/photos/' . $filename;
            }

            $recipe->save();
            \Log::info('Recipe saved with ID: ' . $recipe->id);

            // Сохраняем ингредиенты
            $ingredients = $request->input('ingredients');
            \Log::info('Processing ingredients:', ['count' => count($ingredients)]);

            foreach ($ingredients as $index => $ingData) {
                \Log::info('Saving ingredient ' . $index, $ingData);

                RecipeIngredient::create([
                    'recipe_id' => $recipe->id,
                    'ingredient_id' => $ingData['ingredient_id'],
                    'quantity' => $ingData['quantity'],
                    'unit' => $ingData['unit'],
                ]);
            }
            \Log::info('Ingredients saved');

            // Сохраняем шаги
            $steps = $request->input('steps');
            \Log::info('Processing steps:', ['count' => count($steps)]);

            foreach ($steps as $index => $stepData) {
                \Log::info('Saving step ' . $index, ['text' => $stepData['text'] ?? '']);

                $step = new RecipeStep();
                $step->recipe_id = $recipe->id;
                $step->step_number = $index + 1;
                $step->text = $stepData['text'];

                // Сохраняем фото шага (если есть)
                if ($request->hasFile("steps.{$index}.photo")) {
                    \Log::info('Saving step photo for step ' . $index);
                    $file = $request->file("steps.{$index}.photo");
                    $filename = Str::uuid() . '.' . $file->extension();
                    $file->storeAs('recipes/steps', $filename, 'public');
                    $step->photo = 'recipes/steps/' . $filename;
                }

                $step->save();
            }
            \Log::info('Steps saved');

            \Log::info('=== РЕЦЕПТ УСПЕШНО СОХРАНЕН ===');

            // Для Inertia запросов возвращаем редирект
            if ($request->header('X-Inertia')) {
                return redirect()->route('recipe-book.created')
                    ->with('success', 'Рецепт успешно создан и отправлен на модерацию!');
            }

            return response()->json([
                'success' => true,
                'message' => 'Рецепт успешно создан!',
                'data' => [
                    'id' => $recipe->id,
                    'title' => $recipe->title,
                ]
            ], 201);

        } catch (\Exception $e) {
            \Log::error('ОШИБКА сохранения рецепта: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            if ($request->header('X-Inertia')) {
                return redirect()->back()
                    ->with('error', 'Произошла ошибка при сохранении рецепта: ' . $e->getMessage())
                    ->withInput();
            }

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при сохранении рецепта: ' . $e->getMessage()
            ], 500);
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

        // Проверяем, опубликован ли рецепт
        if (!$recipe->is_published) {
            $user = auth()->user();

            if (!$user || ($user->role !== 'admin' && $user->id !== $recipe->user_id)) {
                if (request()->header('X-Inertia')) {
                    return Inertia::render('Errors/404', [
                        'message' => 'Рецепт не найден или еще не опубликован'
                    ]);
                }
                abort(404, 'Рецепт не найден');
            }
        }

        // Проверяем, сохранен ли рецепт текущим пользователем
        $isLiked = false;
        $userRating = null;  // Изменено: по умолчанию null, а не 0
        $user = auth()->user();

        if ($user) {
            $isLiked = SavedRecipe::where('user_id', $user->id)
                ->where('recipe_id', $id)
                ->exists();

            // Исправлено: используем rating_value
            $rating = Rating::where('user_id', $user->id)
                ->where('recipe_id', $id)
                ->first();
            $userRating = $rating ? $rating->rating_value : null;  // Исправлено: rating -> rating_value

            // Добавляем оценку пользователя к каждому комментарию
            foreach ($recipe->comments as $comment) {
                $commentRating = Rating::where('user_id', $comment->user_id)
                    ->where('recipe_id', $id)
                    ->first();
                $comment->user_rating = $commentRating ? $commentRating->rating_value : null;  // Исправлено
            }
        }

        $formattedRecipe = $this->formatRecipe($recipe, $isLiked, $userRating);

        return Inertia::render('Recipe/Show', [
            'recipe' => $formattedRecipe,
            'backTo' => request('backTo', 'recipes'),
            'backTitle' => request('backTitle')
        ]);
    }

    public function formatRecipe($recipe, $isLiked, $userRating)
    {
        return [
            'id' => $recipe->id,
            'title' => $recipe->title,
            'description' => $recipe->description,
            'mainPhotoUrl' => $recipe->main_photo
                            ? asset('storage/' . $recipe->main_photo)
                            : null,
            'timeInMinutes' => $recipe->preparation_time,
            'portion' => $recipe->portion,
            'type' => $recipe->type,
            'dish_category' => $recipe->dish_category,
            'is_alcoholic' => $recipe->is_alcoholic,
            'avgRating' => round($recipe->average_rating ?? 0, 1),
            'totalReviews' => $recipe->ratings_count ?? 0,
            'is_published' => $recipe->is_published,
            'user' => [
                'id' => $recipe->user->id ?? 0,
                'name' => $recipe->user->name ?? 'Аноним',
                'avatar' => $recipe->user->avatar ?? null,
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
                        ? asset('storage/' . $step->photo_url)
                        : null,
                ];
            }),
            'can_comment' => $recipe->is_published,
            'comments' => $recipe->comments->map(function($comment) {
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
            'likesCount' => $recipe->savedByUsers()->count(),
            'userRating' => $userRating,  // Теперь может быть null, если пользователь не оценивал
        ];
    }

    /**
     * Добавить рецепт в избранное
     */
    public function like($id)
    {
        $user = auth()->user();

        if (!$user) {
            if (request()->header('X-Inertia')) {
                return redirect()->back()->with('error', 'Необходимо войти в систему');
            }
            return response()->json(['error' => 'Не авторизован'], 401);
        }

        try {
            $exists = SavedRecipe::where('user_id', $user->id)
                ->where('recipe_id', $id)
                ->exists();

            if (!$exists) {
                SavedRecipe::create([
                    'user_id' => $user->id,
                    'recipe_id' => $id
                ]);

                return redirect()->back()->with('success', 'Рецепт добавлен в избранное');
            }

            return redirect()->back()->with('info', 'Рецепт уже в избранном');

        } catch (\Exception $e) {
            \Log::error('Error liking recipe: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ошибка при добавлении в избранное');
        }
    }

    /**
     * Удалить рецепт из избранного
     */
    public function unlike($id)
    {
        $user = auth()->user();

        if (!$user) {
            if (request()->header('X-Inertia')) {
                return redirect()->back()->with('error', 'Необходимо войти в систему');
            }
            return response()->json(['error' => 'Не авторизован'], 401);
        }

        try {
            SavedRecipe::where('user_id', $user->id)
                ->where('recipe_id', $id)
                ->delete();

            return redirect()->back()->with('success', 'Рецепт удален из избранного');

        } catch (\Exception $e) {
            \Log::error('Error unliking recipe: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ошибка при удалении из избранного');
        }
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);

        // Проверка прав (только админ или автор)
        if (auth()->user()->role !== 'admin' && auth()->id() !== $recipe->user_id) {
            if (request()->header('X-Inertia')) {
                return redirect()->back()->with('error', 'Нет прав для удаления');
            }
            return response()->json(['error' => 'Нет прав для удаления'], 403);
        }

        try {
            // Удаляем связанные файлы (фото)
            if ($recipe->main_photo) {
                Storage::disk('public')->delete($recipe->main_photo);
            }

            foreach ($recipe->steps as $step) {
                if ($step->photo) {
                    Storage::disk('public')->delete($step->photo);
                }
            }

            // Удаляем рецепт (связанные записи удалятся каскадно)
            $recipe->delete();

            if (request()->wantsJson()) {
                return response()->json(['success' => true]);
            }

            return redirect()->back()->with('success', 'Рецепт удален');

        } catch (\Exception $e) {
            \Log::error('Error deleting recipe: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ошибка при удалении рецепта');
        }
    }


    public function rate(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user) {
            if (request()->header('X-Inertia')) {
                return redirect()->back()->with('error', 'Необходимо войти в систему');
            }
            return response()->json(['error' => 'Не авторизован'], 401);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        try {
            $ratingValue = $request->input('rating');

            // Обновляем или создаем оценку
            // Модель Rating автоматически обновит рейтинг рецепта через booted()
            Rating::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'recipe_id' => $id
                ],
                [
                    'rating_value' => $ratingValue
                ]
            );

            // Получаем обновленный рецепт с актуальными данными
            $recipe = Recipe::findOrFail($id);

            if (request()->header('X-Inertia')) {
                return redirect()->back()->with('success', 'Спасибо за оценку!');
            }

            return response()->json([
                'success' => true,
                'average_rating' => $recipe->average_rating,
                'ratings_count' => $recipe->ratings_count,
                'user_rating' => $ratingValue
            ]);

        } catch (\Exception $e) {
            \Log::error('Error rating recipe: ' . $e->getMessage());

            if (request()->header('X-Inertia')) {
                return redirect()->back()->with('error', 'Ошибка при сохранении оценки');
            }

            return response()->json(['error' => 'Ошибка при сохранении оценки'], 500);
        }
    }
}
