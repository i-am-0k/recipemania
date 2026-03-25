<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\RecipeBookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Models\Recipe;
use Illuminate\Http\Request;

// ==================== ПУБЛИЧНЫЕ МАРШРУТЫ ====================

// Главная
Route::get('/', [HomeController::class, 'index'])->name('home');

// API для ингредиентов (один маршрут для всего)
Route::get('/api/ingredients', [IngredientController::class, 'index'])->name('api.ingredients');

// Просмотр профиля другого пользователя
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

// ==================== МАРШРУТЫ ДЛЯ ПОИСКА ====================

// API для поиска (AJAX) - отдельный маршрут вне префикса search
Route::get('/api/search', [SearchController::class, 'api'])->name('api.search');

// Страница результатов поиска
Route::get('/search', [SearchController::class, 'results'])->name('search');

// ==================== МАРШРУТЫ ДЛЯ АВТОРИЗОВАННЫХ ПОЛЬЗОВАТЕЛЕЙ ====================

Route::middleware(['auth'])->group(function () {
    // Создание рецепта
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');

    // Действия с рецептами
    Route::post('/recipes/{id}/like', [RecipeController::class, 'like'])->name('recipes.like');
    Route::post('/recipes/{id}/unlike', [RecipeController::class, 'unlike'])->name('recipes.unlike');
    Route::post('/recipes/{id}/rate', [RecipeController::class, 'rate'])->name('recipes.rate');

    // Комментарии
    Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('recipes.comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Книга рецептов
    Route::prefix('recipe-book')->name('recipe-book.')->group(function () {
        Route::get('/favorites', [RecipeBookController::class, 'favorites'])->name('favorites');
        Route::get('/favorites/{id}', [RecipeBookController::class, 'showFavorite'])->name('favorites.show');
        Route::get('/created', [RecipeBookController::class, 'created'])->name('created');
        Route::get('/created/{id}', [RecipeBookController::class, 'showCreated'])->name('created.show');
        Route::get('/rated', [RecipeBookController::class, 'rated'])->name('rated');
        Route::get('/rated/{id}', [RecipeBookController::class, 'showRated'])->name('rated.show');
    });
});

// ==================== ПУБЛИЧНЫЙ МАРШРУТ ДЛЯ ПРОСМОТРА РЕЦЕПТА ====================

Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('recipes.show');

// ==================== МАРШРУТЫ ДЛЯ АДМИНИСТРАТОРОВ ====================

Route::middleware(['auth', 'admin'])->group(function () {
    // Удаление рецептов
    Route::delete('/recipes/{id}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

    // Модерация
    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation');
    Route::get('/moderation/{id}', [ModerationController::class, 'show'])->name('moderation.show');
    Route::post('/moderation/approve/{id}', [ModerationController::class, 'approve'])->name('moderation.approve');
    Route::post('/moderation/reject/{id}', [ModerationController::class, 'reject'])->name('moderation.reject');

    // Управление ингредиентами
    Route::prefix('admin/ingredients')->name('admin.ingredients.')->group(function () {
        Route::get('/', [IngredientController::class, 'adminIndex'])->name('index');
        Route::post('/', [IngredientController::class, 'store'])->name('store');
        Route::put('/{id}', [IngredientController::class, 'update'])->name('update');
        Route::delete('/{id}', [IngredientController::class, 'destroy'])->name('destroy');
    });
});

Route::get('/refresh-csrf', function() {
    return response()->json(['token' => csrf_token()]);
})->middleware('web')->name('csrf.refresh');

require __DIR__.'/settings.php';
