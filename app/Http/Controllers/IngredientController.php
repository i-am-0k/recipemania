<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class IngredientController extends Controller
{
    /**
     * Получить список ингредиентов
     * - Без параметров: возвращает все ингредиенты (для формы создания)
     * - С параметром q: поиск ингредиентов (для фильтра)
     */
    public function index(Request $request)
    {
        $query = $request->get('q');

        // Если есть поисковый запрос и он длиннее 2 символов
        if ($query && strlen($query) >= 3) {
            $ingredients = Ingredient::where('name', 'like', "%{$query}%")
                ->limit(5)
                ->get()
                ->map(function ($ingredient) {
                    return [
                        'id' => $ingredient->id,
                        'name' => $ingredient->name,
                    ];
                });

            return response()->json($ingredients);
        }

        // Если параметра q нет или он слишком короткий, возвращаем все ингредиенты
        // (для формы создания рецепта)
        $ingredients = Ingredient::select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($ingredients);
    }

    /**
     * Админ-панель для управления ингредиентами
     */
    public function adminIndex()
    {
        $ingredients = Ingredient::orderBy('name')
            ->paginate(20)
            ->through(fn ($ingredient) => [
                'id' => $ingredient->id,
                'name' => $ingredient->name,
                'created_at' => $ingredient->created_at?->format('d.m.Y'),
            ]);

        return Inertia::render('Ingredients/Index', [
            'ingredients' => $ingredients
        ]);
    }

    /**
     * Store a newly created ingredient.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:ingredients,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ingredient = Ingredient::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Ингредиент успешно создан');
    }

    /**
     * Update the specified ingredient.
     */
    public function update(Request $request, $id)
    {
        $ingredient = Ingredient::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:ingredients,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ingredient->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Ингредиент успешно обновлен');
    }

    /**
     * Remove the specified ingredient.
     */
    public function destroy($id)
    {
        $ingredient = Ingredient::findOrFail($id);

        // Проверяем, используется ли ингредиент в рецептах
        if ($ingredient->recipeIngredients()->count() > 0) {
            return redirect()->back()->with('error',
                'Невозможно удалить ингредиент, так как он используется в рецептах'
            );
        }

        $ingredient->delete();

        return redirect()->back()->with('success', 'Ингредиент успешно удален');
    }

    /**
     * Поиск ингредиентов для фильтра
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $ingredients = Ingredient::where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($ingredient) {
                return [
                    'id' => $ingredient->id,
                    'name' => $ingredient->name,
                ];
            });

        return response()->json($ingredients);
    }
}
