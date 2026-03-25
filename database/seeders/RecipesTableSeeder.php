<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Получаем ID пользователей из базы
        $users = DB::table('users')->get();
        $varvaraId = $users->where('email', 'm9539646789@gmail.com')->first()->id;
        $elenaId = $users->where('email', 'elena.kyznedeleva@example.com')->first()->id;
        $annaId = $users->where('email', 'anna.kozlov@example.com')->first()->id;
        $dmitryId = $users->where('email', 'dmitry.ivanov@example.com')->first()->id;
        $alexanderId = $users->where('email', 'alexandr.tishin@example.com')->first()->id;

        // Получаем ID ингредиентов для быстрого доступа
        $ingredients = DB::table('ingredients')->get()->keyBy('name');

        // ==================== РЕЦЕПТ 1 ====================
        // Классический борщ (от Анны)
        $recipe1Id = DB::table('recipes')->insertGetId([
            'title' => 'Классический борщ',
            'main_photo' => 'recipes/photos/borscht.jpg',
            'description' => 'Наваристый борщ с говядиной, свеклой и сметаной. Традиционное блюдо, которое согреет в холодный день.',
            'type' => 'food',
            'dish_category' => 'Первые блюда',
            'is_alcoholic' => null,
            'preparation_time' => 120,
            'portion' => 6,
            'user_id' => $annaId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Ингредиенты для борща
        DB::table('recipe_ingredients')->insert([
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Говядина']->id,
                'quantity' => "500",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Свекла']->id,
                'quantity' => "300",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Капуста белокочанная']->id ?? $ingredients['Капуста цветная']->id,
                'quantity' => "400",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Картофель']->id,
                'quantity' => "400",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Морковь']->id,
                'quantity' => "150",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Лук репчатый']->id,
                'quantity' => "150",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Томатная паста']->id,
                'quantity' => "50",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Чеснок']->id,
                'quantity' => "3",
                'unit' => 'зубчик',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Масло растительное']->id,
                'quantity' => "50",
                'unit' => 'мл',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Уксус']->id,
                'quantity' => "10",
                'unit' => 'мл',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Соль']->id,
                'quantity' => "10",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Перец черный']->id,
                'quantity' => "5",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Лавровый лист']->id,
                'quantity' => "2",
                'unit' => 'шт.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'ingredient_id' => $ingredients['Сметана']->id,
                'quantity' => "200",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Шаги для борща
        DB::table('recipe_steps')->insert([
            [
                'recipe_id' => $recipe1Id,
                'step_number' => 1,
                'text' => 'Говядину промойте, залейте 3 литрами холодной воды и варите на медленном огне 1.5 часа, снимая пену.',
                'photo_url' => null,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'step_number' => 2,
                'text' => 'Свеклу натрите на крупной терке, обжарьте на растительном масле, добавьте уксус и тушите 10 минут.',
                'photo_url' => null,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'step_number' => 3,
                'text' => 'Лук и морковь мелко нарежьте, обжарьте до золотистого цвета, добавьте томатную пасту и тушите 5 минут.',
                'photo_url' => null,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'step_number' => 4,
                'text' => 'Достаньте мясо из бульона, нарежьте кусочками и верните обратно. Добавьте нарезанный кубиками картофель и варите 10 минут.',
                'photo_url' => null,
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'step_number' => 5,
                'text' => 'Добавьте нашинкованную капусту и варите 10 минут.',
                'photo_url' => null,
                'sort_order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'step_number' => 6,
                'text' => 'Добавьте тушеную свеклу, зажарку, соль, перец, лавровый лист. Варите еще 10 минут.',
                'photo_url' => null,
                'sort_order' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'step_number' => 7,
                'text' => 'Добавьте измельченный чеснок, дайте настояться 20 минут. Подавайте со сметаной и зеленью.',
                'photo_url' => null,
                'sort_order' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // ==================== РЕЦЕПТ 2 ====================
        // Курица в сливочном соусе (от Варвары)
        $recipe2Id = DB::table('recipes')->insertGetId([
            'title' => 'Куриное филе в сливочном соусе с грибами',
            'main_photo' => 'recipes/photos/chicken_cream.jpg',
            'description' => 'Нежнейшее куриное филе в ароматном сливочном соусе с шампиньонами. Идеально сочетается с пастой или рисом.',
            'type' => 'food',
            'dish_category' => 'Вторые блюда',
            'is_alcoholic' => null,
            'preparation_time' => 40,
            'portion' => 4,
            'user_id' => $varvaraId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            [
                'recipe_id' => $recipe2Id,
                'ingredient_id' => $ingredients['Куриное филе']->id,
                'quantity' => "600",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'ingredient_id' => $ingredients['Шампиньоны']->id,
                'quantity' => "300",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'ingredient_id' => $ingredients['Сливки 20%']->id ?? $ingredients['Сливки']->id,
                'quantity' => "200",
                'unit' => 'мл',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'ingredient_id' => $ingredients['Лук репчатый']->id,
                'quantity' => "100",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'ingredient_id' => $ingredients['Масло сливочное']->id,
                'quantity' => "50",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'ingredient_id' => $ingredients['Масло растительное']->id,
                'quantity' => "30",
                'unit' => 'мл',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'ingredient_id' => $ingredients['Чеснок']->id,
                'quantity' => "3",
                'unit' => 'зубчик',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'ingredient_id' => $ingredients['Соль']->id,
                'quantity' => "5",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'ingredient_id' => $ingredients['Перец черный']->id,
                'quantity' => "5",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'ingredient_id' => $ingredients['Петрушка']->id,
                'quantity' => "10",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('recipe_steps')->insert([
            [
                'recipe_id' => $recipe2Id,
                'step_number' => 1,
                'text' => 'Куриное филе нарежьте небольшими кусочками, посолите и поперчите. Обжарьте на растительном масле до золотистой корочки (5-7 минут).',
                'photo_url' => null,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'step_number' => 2,
                'text' => 'Шампиньоны нарежьте пластинками, лук - мелким кубиком. На отдельной сковороде обжарьте лук на сливочном масле до прозрачности.',
                'photo_url' => null,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'step_number' => 3,
                'text' => 'Добавьте грибы к луку и жарьте до испарения жидкости (10 минут).',
                'photo_url' => null,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'step_number' => 4,
                'text' => 'Соедините курицу с грибами, добавьте измельченный чеснок и сливки. Тушите на медленном огне 10-15 минут.',
                'photo_url' => null,
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'step_number' => 5,
                'text' => 'Подавайте с пастой или рисом, посыпав свежей петрушкой.',
                'photo_url' => null,
                'sort_order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // ==================== РЕЦЕПТ 3 ====================
        // Тирамису (от Анны)
        $recipe3Id = DB::table('recipes')->insertGetId([
            'title' => 'Классический итальянский тирамису',
            'main_photo' => 'recipes/photos/tiramisu.jpg',
            'description' => 'Нежнейший десерт с кофе, маскарпоне и какао. Знаменитый итальянский тирамису, который тает во рту.',
            'type' => 'food',
            'dish_category' => 'Десерты',
            'is_alcoholic' => null,
            'preparation_time' => 60,
            'portion' => 6,
            'user_id' => $annaId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            [
                'recipe_id' => $recipe3Id,
                'ingredient_id' => $ingredients['Сыр маскарпоне']->id,
                'quantity' => "500",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'ingredient_id' => $ingredients['Яйца куриные']->id,
                'quantity' => "4",
                'unit' => 'шт.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'ingredient_id' => $ingredients['Сахар']->id,
                'quantity' => "100",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'ingredient_id' => $ingredients['Печенье савоярди']->id,
                'quantity' => "200",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'ingredient_id' => $ingredients['Кофе']->id,
                'quantity' => "300",
                'unit' => 'мл',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'ingredient_id' => $ingredients['Какао-порошок']->id,
                'quantity' => "30",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'ingredient_id' => $ingredients['Ром']->id,
                'quantity' => "30",
                'unit' => 'мл',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('recipe_steps')->insert([
            [
                'recipe_id' => $recipe3Id,
                'step_number' => 1,
                'text' => 'Сварите крепкий кофе, добавьте ром и дайте остыть.',
                'photo_url' => null,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'step_number' => 2,
                'text' => 'Отделите белки от желтков. Желтки взбейте с половиной сахара до пышной светлой массы.',
                'photo_url' => null,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'step_number' => 3,
                'text' => 'Добавьте маскарпоне к желткам и аккуратно перемешайте до однородности.',
                'photo_url' => null,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'step_number' => 4,
                'text' => 'Белки взбейте с оставшимся сахаром до устойчивых пиков. Аккуратно вмешайте в сырную массу.',
                'photo_url' => null,
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'step_number' => 5,
                'text' => 'Обмакните печенье савоярди в остывший кофе (на 1-2 секунды) и выложите слой в форму.',
                'photo_url' => null,
                'sort_order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'step_number' => 6,
                'text' => 'Сверху выложите половину крема. Повторите слой печенья и оставшегося крема.',
                'photo_url' => null,
                'sort_order' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'step_number' => 7,
                'text' => 'Уберите в холодильник минимум на 4 часа. Перед подачей посыпьте какао-порошком.',
                'photo_url' => null,
                'sort_order' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // ==================== РЕЦЕПТ 4 ====================
        // Цезарь с курицей (от Варвары)
        $recipe4Id = DB::table('recipes')->insertGetId([
            'title' => 'Салат Цезарь с курицей',
            'main_photo' => 'recipes/photos/caesar.jpg',
            'description' => 'Классический салат Цезарь с хрустящими гренками, сочной курицей и фирменным соусом.',
            'type' => 'food',
            'dish_category' => 'Салаты',
            'is_alcoholic' => null,
            'preparation_time' => 30,
            'portion' => 4,
            'user_id' => $varvaraId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            [
                'recipe_id' => $recipe4Id,
                'ingredient_id' => $ingredients['Куриная грудка']->id,
                'quantity' => "400",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'ingredient_id' => $ingredients['Салат Романо']->id ?? $ingredients['Салат Айсберг']->id,
                'quantity' => "1",
                'unit' => 'пучок',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'ingredient_id' => $ingredients['Помидоры черри']->id,
                'quantity' => "200",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'ingredient_id' => $ingredients['Сыр пармезан']->id ?? $ingredients['Сыр']->id,
                'quantity' => "50",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'ingredient_id' => $ingredients['Батон']->id ?? $ingredients['Хлеб']->id,
                'quantity' => "200",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'ingredient_id' => $ingredients['Майонез']->id,
                'quantity' => "100",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'ingredient_id' => $ingredients['Чеснок']->id,
                'quantity' => "2",
                'unit' => 'зубчик',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'ingredient_id' => $ingredients['Лимон']->id,
                'quantity' => "0.5",
                'unit' => 'шт.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'ingredient_id' => $ingredients['Масло оливковое']->id,
                'quantity' => "50",
                'unit' => 'мл',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('recipe_steps')->insert([
            [
                'recipe_id' => $recipe4Id,
                'step_number' => 1,
                'text' => 'Куриную грудку посолите, поперчите и обжарьте на гриле или сковороде до готовности. Нарежьте ломтиками.',
                'photo_url' => null,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'step_number' => 2,
                'text' => 'Хлеб нарежьте кубиками, обжарьте с измельченным чесноком до золотистого цвета.',
                'photo_url' => null,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'step_number' => 3,
                'text' => 'Для соуса смешайте майонез, сок лимона, измельченный чеснок, соль и перец.',
                'photo_url' => null,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'step_number' => 4,
                'text' => 'Листья салата порвите руками, выложите на тарелку. Сверху положите курицу, помидоры черри (разрезанные пополам) и гренки.',
                'photo_url' => null,
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'step_number' => 5,
                'text' => 'Полейте соусом, посыпьте тертым пармезаном. Подавайте сразу.',
                'photo_url' => null,
                'sort_order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // ==================== РЕЦЕПТ 5 ====================
        // Молочный коктейль (от Александра)
        $recipe5Id = DB::table('recipes')->insertGetId([
            'title' => 'Классический молочный коктейль',
            'main_photo' => 'recipes/photos/milkshake.jpg',
            'description' => 'Густой и вкусный молочный коктейль с мороженым. Простой рецепт для сладкого удовольствия.',
            'type' => 'drink',
            'dish_category' => null,
            'is_alcoholic' => false,
            'preparation_time' => 10,
            'portion' => 2,
            'user_id' => $alexanderId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            [
                'recipe_id' => $recipe5Id,
                'ingredient_id' => $ingredients['Молоко']->id,
                'quantity' => "300",
                'unit' => 'мл',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe5Id,
                'ingredient_id' => $ingredients['Мороженое']->id,
                'quantity' => "200",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe5Id,
                'ingredient_id' => $ingredients['Сахар']->id,
                'quantity' => "20",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe5Id,
                'ingredient_id' => $ingredients['Ванилин']->id,
                'quantity' => "1",
                'unit' => 'щепотка',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('recipe_steps')->insert([
            [
                'recipe_id' => $recipe5Id,
                'step_number' => 1,
                'text' => 'Все ингредиенты должны быть хорошо охлаждены.',
                'photo_url' => null,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe5Id,
                'step_number' => 2,
                'text' => 'Поместите молоко, мороженое, сахар и ванилин в блендер.',
                'photo_url' => null,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe5Id,
                'step_number' => 3,
                'text' => 'Взбивайте на высокой скорости 30-40 секунд до образования пены.',
                'photo_url' => null,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe5Id,
                'step_number' => 4,
                'text' => 'Разлейте по высоким стаканам. Подавайте с трубочкой.',
                'photo_url' => null,
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // ==================== РЕЦЕПТ 6 ====================
        // Паста Карбонара (от Варвары)
        $recipe6Id = DB::table('recipes')->insertGetId([
            'title' => 'Паста Карбонара',
            'main_photo' => 'recipes/photos/carbonara.jpg',
            'description' => 'Итальянская паста с беконом и сливочным соусом. Простой и невероятно вкусный ужин за 20 минут.',
            'type' => 'food',
            'dish_category' => 'Вторые блюда',
            'is_alcoholic' => null,
            'preparation_time' => 25,
            'portion' => 3,
            'user_id' => $varvaraId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            [
                'recipe_id' => $recipe6Id,
                'ingredient_id' => $ingredients['Макароны']->id,
                'quantity' => "300",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe6Id,
                'ingredient_id' => $ingredients['Бекон']->id,
                'quantity' => "150",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe6Id,
                'ingredient_id' => $ingredients['Яйца куриные']->id,
                'quantity' => "2",
                'unit' => 'шт.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe6Id,
                'ingredient_id' => $ingredients['Сыр пармезан']->id ?? $ingredients['Сыр']->id,
                'quantity' => "50",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe6Id,
                'ingredient_id' => $ingredients['Сливки']->id,
                'quantity' => "100",
                'unit' => 'мл',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe6Id,
                'ingredient_id' => $ingredients['Чеснок']->id,
                'quantity' => "2",
                'unit' => 'зубчик',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe6Id,
                'ingredient_id' => $ingredients['Масло оливковое']->id,
                'quantity' => "20",
                'unit' => 'мл',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('recipe_steps')->insert([
            [
                'recipe_id' => $recipe6Id,
                'step_number' => 1,
                'text' => 'Отварите пасту в подсоленной воде до состояния аль денте согласно инструкции.',
                'photo_url' => null,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe6Id,
                'step_number' => 2,
                'text' => 'Бекон нарежьте полосками, обжарьте на оливковом масле с чесноком до хруста. Чеснок удалите.',
                'photo_url' => null,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe6Id,
                'step_number' => 3,
                'text' => 'В миске смешайте яйца, сливки и тертый сыр. Посолите и поперчите.',
                'photo_url' => null,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe6Id,
                'step_number' => 4,
                'text' => 'Снимите пасту с огня, добавьте бекон. Влейте яичную смесь и быстро перемешайте (яйца должны загустеть от тепла пасты).',
                'photo_url' => null,
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe6Id,
                'step_number' => 5,
                'text' => 'Подавайте сразу, посыпав дополнительным сыром и черным перцем.',
                'photo_url' => null,
                'sort_order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // ==================== РЕЦЕПТ 7 ====================
        // Овощной суп-пюре (от Дмитрий)
        $recipe7Id = DB::table('recipes')->insertGetId([
            'title' => 'Тыквенный суп-пюре',
            'main_photo' => 'recipes/photos/pumpkin_soup.jpg',
            'description' => 'Нежный и полезный тыквенный суп-пюре со сливками и тыквенными семечками. Идеально для осеннего меню.',
            'type' => 'food',
            'dish_category' => 'Первые блюда',
            'is_alcoholic' => null,
            'preparation_time' => 45,
            'portion' => 4,
            'user_id' => $dmitryId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            [
                'recipe_id' => $recipe7Id,
                'ingredient_id' => $ingredients['Тыква']->id,
                'quantity' => "800",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe7Id,
                'ingredient_id' => $ingredients['Морковь']->id,
                'quantity' => "100",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe7Id,
                'ingredient_id' => $ingredients['Лук репчатый']->id,
                'quantity' => "100",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe7Id,
                'ingredient_id' => $ingredients['Сливки']->id,
                'quantity' => "100",
                'unit' => 'мл',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe7Id,
                'ingredient_id' => $ingredients['Масло сливочное']->id,
                'quantity' => "30",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe7Id,
                'ingredient_id' => $ingredients['Семена тыквы']->id,
                'quantity' => "30",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe7Id,
                'ingredient_id' => $ingredients['Соль']->id,
                'quantity' => "5",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe7Id,
                'ingredient_id' => $ingredients['Перец черный']->id,
                'quantity' => "3",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('recipe_steps')->insert([
            [
                'recipe_id' => $recipe7Id,
                'step_number' => 1,
                'text' => 'Тыкву, морковь и лук нарежьте кубиками.',
                'photo_url' => null,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe7Id,
                'step_number' => 2,
                'text' => 'В кастрюле растопите сливочное масло, обжарьте лук до прозрачности. Добавьте морковь и тыкву, обжаривайте 5 минут.',
                'photo_url' => null,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe7Id,
                'step_number' => 3,
                'text' => 'Залейте водой (около 600 мл) так, чтобы она покрыла овощи. Варите 20 минут до мягкости тыквы.',
                'photo_url' => null,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe7Id,
                'step_number' => 4,
                'text' => 'Измельчите суп блендером до однородного пюре. Добавьте сливки, соль, перец и прогрейте.',
                'photo_url' => null,
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe7Id,
                'step_number' => 5,
                'text' => 'Подавайте с тыквенными семечками и веточкой зелени.',
                'photo_url' => null,
                'sort_order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // ==================== РЕЦЕПТ 8 ====================
        // Шоколадный брауни (от Анны)
        $recipe8Id = DB::table('recipes')->insertGetId([
            'title' => 'Шоколадный брауни с орехами',
            'main_photo' => 'recipes/photos/brownie.jpg',
            'description' => 'Влажный шоколадный десерт с хрустящей корочкой и мягкой серединкой. Добавьте грецкие орехи для текстуры.',
            'type' => 'food',
            'dish_category' => 'Десерты',
            'is_alcoholic' => null,
            'preparation_time' => 50,
            'portion' => 8,
            'user_id' => $annaId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            [
                'recipe_id' => $recipe8Id,
                'ingredient_id' => $ingredients['Шоколад темный']->id,
                'quantity' => "200",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe8Id,
                'ingredient_id' => $ingredients['Масло сливочное']->id,
                'quantity' => "100",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe8Id,
                'ingredient_id' => $ingredients['Яйца куриные']->id,
                'quantity' => "3",
                'unit' => 'шт.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe8Id,
                'ingredient_id' => $ingredients['Сахар']->id,
                'quantity' => "150",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe8Id,
                'ingredient_id' => $ingredients['Мука']->id,
                'quantity' => "80",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe8Id,
                'ingredient_id' => $ingredients['Грецкие орехи']->id,
                'quantity' => "100",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe8Id,
                'ingredient_id' => $ingredients['Какао-порошок']->id,
                'quantity' => "20",
                'unit' => 'г',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('recipe_steps')->insert([
            [
                'recipe_id' => $recipe8Id,
                'step_number' => 1,
                'text' => 'Разогрейте духовку до 180°C. Форму для выпечки застелите пергаментом.',
                'photo_url' => null,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe8Id,
                'step_number' => 2,
                'text' => 'Растопите шоколад со сливочным маслом на водяной бане. Дайте немного остыть.',
                'photo_url' => null,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe8Id,
                'step_number' => 3,
                'text' => 'Яйца взбейте с сахаром до пышной светлой массы (5-7 минут).',
                'photo_url' => null,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe8Id,
                'step_number' => 4,
                'text' => 'Влейте шоколадную смесь в яйца, аккуратно перемешайте. Добавьте просеянную муку с какао и снова перемешайте.',
                'photo_url' => null,
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe8Id,
                'step_number' => 5,
                'text' => 'Добавьте рубленые орехи, перемешайте. Вылейте тесто в форму.',
                'photo_url' => null,
                'sort_order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe8Id,
                'step_number' => 6,
                'text' => 'Выпекайте 25-30 минут. Брауни должен быть с влажной серединкой. Остудите перед нарезкой.',
                'photo_url' => null,
                'sort_order' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // РЕЦЕПТ 9: Окрошка
        $recipe9Id = DB::table('recipes')->insertGetId([
            'title' => 'Классическая окрошка на квасе',
            'main_photo' => 'recipes/photos/okroshka.jpg',
            'description' => 'Освежающий летний суп на квасе с колбасой, свежими овощами и зеленью. Идеальное блюдо для жаркого дня.',
            'type' => 'food',
            'dish_category' => 'Первые блюда',
            'is_alcoholic' => null,
            'preparation_time' => 90,
            'portion' => 8,
            'user_id' => $elenaId,
            'is_published' => true,
            'average_rating' => 0,
            'ratings_count' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe9Id, 'ingredient_id' => $ingredients['Укроп']->id, 'quantity' => '50', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'ingredient_id' => $ingredients['Лук зеленый']->id, 'quantity' => '200', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'ingredient_id' => $ingredients['Картофель']->id, 'quantity' => '6', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'ingredient_id' => $ingredients['Яйца куриные']->id, 'quantity' => '5', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'ingredient_id' => $ingredients['Огурцы']->id, 'quantity' => '4', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'ingredient_id' => $ingredients['Редис']->id, 'quantity' => '500', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'ingredient_id' => $ingredients['Колбаса вареная']->id, 'quantity' => '500', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'ingredient_id' => $ingredients['Квас']->id, 'quantity' => '2', 'unit' => 'л', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'ingredient_id' => $ingredients['Перец черный']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe9Id, 'step_number' => 1, 'text' => 'Отварить картофель и яйца.', 'photo_url' => 'recipes/steps/okroshka1.jpg', 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'step_number' => 2, 'text' => 'Укроп и лук мелко нарезать.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'step_number' => 3, 'text' => 'Картофель, яйца, огурцы и редис натереть на крупной терке.', 'photo_url' => 'recipes/steps/okroshka3.jpg', 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'step_number' => 4, 'text' => 'Колбасу нарезать кубиками.', 'photo_url' => 'recipes/steps/okroshka4.jpg', 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe9Id, 'step_number' => 5, 'text' => 'Посолить и поперчить по вкусу, добавить квас и перемешать.', 'photo_url' => null, 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 10: Плов
        $recipe10Id = DB::table('recipes')->insertGetId([
            'title' => 'Узбекский плов',
            'main_photo' => 'recipes/photos/plov.jpg',
            'description' => 'Ароматный узбекский плов с говядиной, морковью и зирой. Традиционное блюдо восточной кухни.',
            'type' => 'food',
            'dish_category' => 'Вторые блюда',
            'is_alcoholic' => null,
            'preparation_time' => 180,
            'portion' => 8,
            'user_id' => $elenaId,
            'is_published' => true,
            'average_rating' => 0,
            'ratings_count' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe10Id, 'ingredient_id' => $ingredients['Говядина']->id, 'quantity' => '1000', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'ingredient_id' => $ingredients['Лук репчатый']->id, 'quantity' => '1000', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'ingredient_id' => $ingredients['Морковь']->id, 'quantity' => '1000', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'ingredient_id' => $ingredients['Рис']->id, 'quantity' => '1000', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'ingredient_id' => $ingredients['Специи для плова']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => '1', 'unit' => 'ст. л.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'ingredient_id' => $ingredients['Масло растительное']->id, 'quantity' => '400', 'unit' => 'мл', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe10Id, 'step_number' => 1, 'text' => 'Рис промыть несколько раз и замочить в тёплой воде на 1 час.', 'photo_url' => 'recipes/steps/plov1.jpg', 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'step_number' => 2, 'text' => 'Очистить морковь и лук, промыть. Лук нарезать полукольцами.', 'photo_url' => 'recipes/steps/plov2.jpg', 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'step_number' => 3, 'text' => 'Морковь нарезать соломкой.', 'photo_url' => 'recipes/steps/plov3.jpg', 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'step_number' => 4, 'text' => 'Мясо нарезать ломтиками по 50–90 г.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'step_number' => 5, 'text' => 'Поставить на огонь казан и оставить разогреваться.', 'photo_url' => null, 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'step_number' => 6, 'text' => 'В разогретый казан влить масло, когда оно прогреется выложить нарезанное мясо и прожарить его в течение десяти минут.', 'photo_url' => null, 'sort_order' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'step_number' => 7, 'text' => 'Затем мясо переложить в чашку, а в масле обжарить лук в течение пяти минут. Далее к луку добавить морковь и обжаривать ещё минут десять.', 'photo_url' => null, 'sort_order' => 7, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'step_number' => 8, 'text' => 'После положить мясо обратно в казан, добавить специи, соль и залить зервак горячей водой так, чтобы она полностью покрыла овощи и мясо. На большом огне довести до кипения, уменьшить огонь и оставить тушиться на 30 минут.', 'photo_url' => 'recipes/steps/plov8.jpg', 'sort_order' => 8, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'step_number' => 9, 'text' => 'Взять миску с замоченным рисом, слить воду. Равномерным слоем выложить рис в казан по всей поверхности приготовленных продуктов. Слегка прижать рис с помощью шумовки.', 'photo_url' => null, 'sort_order' => 9, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'step_number' => 10, 'text' => 'Налить в казан воду: в центр казана уложить шумовку и на неё лить воду. Количество воды должно быть таким, чтобы уровень воды превышал уровень риса на 2–3 сантиметра.', 'photo_url' => 'recipes/steps/plov10.jpg', 'sort_order' => 10, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'step_number' => 11, 'text' => 'Накрыть казан крышкой и ставить томиться на медленном огне до готовности.', 'photo_url' => null, 'sort_order' => 11, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'step_number' => 12, 'text' => 'Готовый плов подержать под крышкой ещё 15–20 минут, после аккуратно перемешать и можно подавать к столу.', 'photo_url' => null, 'sort_order' => 12, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 11: Сельдь под шубой
        $recipe11Id = DB::table('recipes')->insertGetId([
            'title' => 'Сельдь под шубой',
            'main_photo' => 'recipes/photos/shuba.jpg',
            'description' => 'Классический слоеный салат с селедкой, овощами и майонезом. Любимое праздничное блюдо.',
            'type' => 'food',
            'dish_category' => 'Салаты',
            'is_alcoholic' => null,
            'preparation_time' => 120,
            'portion' => 8,
            'user_id' => $elenaId,
            'is_published' => true,
            'average_rating' => 0,
            'ratings_count' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe11Id, 'ingredient_id' => $ingredients['Картофель']->id, 'quantity' => '6', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'ingredient_id' => $ingredients['Сельдь соленая']->id, 'quantity' => '2', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'ingredient_id' => $ingredients['Лук репчатый']->id, 'quantity' => '1-2', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'ingredient_id' => $ingredients['Яйца куриные']->id, 'quantity' => '5', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'ingredient_id' => $ingredients['Морковь']->id, 'quantity' => '3', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'ingredient_id' => $ingredients['Свекла']->id, 'quantity' => '2-3', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'ingredient_id' => $ingredients['Майонез']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe11Id, 'step_number' => 1, 'text' => 'Отварить картофель, морковь, свёклу и яйца до готовности. Остудить, очистить и натереть каждый ингредиент на крупной тёрке, распределяя по отдельным тарелкам.', 'photo_url' => 'recipes/steps/shuba1.jpg', 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'step_number' => 2, 'text' => 'Нарезать филе селёдки на небольшие кубики.', 'photo_url' => 'recipes/steps/shuba2.jpg', 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'step_number' => 3, 'text' => 'Лук нарезать мелко. Чтобы убрать горечь, обдать его кипятком и дать стечь воде.', 'photo_url' => 'recipes/steps/shuba3.jpg', 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'step_number' => 4, 'text' => 'На блюде выложить слои в следующем порядке: сначала слой картофеля, затем сельдь, лук, яйца, морковь и завершить слоем свёклы.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'step_number' => 5, 'text' => 'Промазывать каждый слой майонезом (кроме селёдки и лука). При необходимости добавить соль.', 'photo_url' => 'recipes/steps/shuba5.jpg', 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'step_number' => 6, 'text' => 'Поставить салат в холодильник для пропитки на 2–3 часа.', 'photo_url' => null, 'sort_order' => 6, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 12: Творожная запеканка
        $recipe12Id = DB::table('recipes')->insertGetId([
            'title' => 'Творожная запеканка',
            'main_photo' => 'recipes/photos/zapekanka.jpg',
            'description' => 'Нежная и воздушная творожная запеканка, которая идеально подходит для завтрака или полдника.',
            'type' => 'food',
            'dish_category' => 'Выпечка',
            'is_alcoholic' => null,
            'preparation_time' => 60,
            'portion' => 4,
            'user_id' => $elenaId,
            'is_published' => true,
            'average_rating' => 0,
            'ratings_count' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe12Id, 'ingredient_id' => $ingredients['Манная крупа']->id, 'quantity' => '50', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe12Id, 'ingredient_id' => $ingredients['Молоко']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe12Id, 'ingredient_id' => $ingredients['Творог']->id, 'quantity' => '500', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe12Id, 'ingredient_id' => $ingredients['Яйца куриные']->id, 'quantity' => '2', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe12Id, 'ingredient_id' => $ingredients['Сахар']->id, 'quantity' => '3', 'unit' => 'ст. л.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe12Id, 'ingredient_id' => $ingredients['Ванилин']->id, 'quantity' => '1', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe12Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => 'щепотка', 'unit' => 'щепотка', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe12Id, 'step_number' => 1, 'text' => 'В теплом молоке замочить манку для набухания.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe12Id, 'step_number' => 2, 'text' => 'Творог размять вилкой.', 'photo_url' => 'recipes/steps/zapekanka2.jpg', 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe12Id, 'step_number' => 3, 'text' => 'Добавить к творогу яйца, сахар, ванилин, соль и молоко с манкой.', 'photo_url' => 'recipes/steps/zapekanka3.jpg', 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe12Id, 'step_number' => 4, 'text' => 'Перемешать блендером и переложить в форму для запекания.', 'photo_url' => 'recipes/steps/zapekanka4.jpg', 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe12Id, 'step_number' => 5, 'text' => 'Выпекать 40 минут при 160°.', 'photo_url' => null, 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 13: Салат "Нежность"
        $recipe13Id = DB::table('recipes')->insertGetId([
            'title' => 'Салат "Нежность"',
            'main_photo' => 'recipes/photos/neznost.jpg',
            'description' => 'Изысканный слоеный салат с курицей, черносливом, орехами и огурцом. Нежное сочетание вкусов.',
            'type' => 'food',
            'dish_category' => 'Салаты',
            'is_alcoholic' => null,
            'preparation_time' => 90,
            'portion' => 8,
            'user_id' => $elenaId,
            'is_published' => true,
            'average_rating' => 0,
            'ratings_count' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe13Id, 'ingredient_id' => $ingredients['Куриное филе']->id, 'quantity' => '600', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe13Id, 'ingredient_id' => $ingredients['Огурцы']->id, 'quantity' => '2-3', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe13Id, 'ingredient_id' => $ingredients['Чернослив']->id, 'quantity' => '250', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe13Id, 'ingredient_id' => $ingredients['Яйца куриные']->id, 'quantity' => '4', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe13Id, 'ingredient_id' => $ingredients['Грецкие орехи']->id, 'quantity' => '200', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe13Id, 'ingredient_id' => $ingredients['Майонез']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe13Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe13Id, 'step_number' => 1, 'text' => 'Куриное филе заранее отварить в подсоленной воде до готовности (около 30 минут), остудить и нарезать.', 'photo_url' => 'recipes/steps/neznost1.jpg', 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe13Id, 'step_number' => 2, 'text' => 'Яйца также варить около 7 минут, затем залить холодной водой, остудить и очистить от скорлупы и нарезать.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe13Id, 'step_number' => 3, 'text' => 'Свежий огурец промыть в проточной воде, обсушить и нарезать.', 'photo_url' => 'recipes/steps/neznost3.jpg', 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe13Id, 'step_number' => 4, 'text' => 'Чернослив распарить: выложить в кружку и залить горячей водой, оставить на 5 минут, затем воду слить и промыть сухофрукты холодной водой. Чернослив нарезать небольшими кубиками.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe13Id, 'step_number' => 5, 'text' => 'Грецкие орехи выложить на разогретую сковороду и немного подсушить (должен появиться характерный аромат), затем измельчить их в ступке или нарезать ножом.', 'photo_url' => 'recipes/steps/neznost5.jpg', 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe13Id, 'step_number' => 6, 'text' => 'Салат выкладывать слоями (можно использовать специальное кольцо): Первым слоем разложить куриное филе и утрамбовать его ложкой, смазать небольшим количеством майонеза. Затем вторым слоем распределить на курицу рубленный чернослив, а на него - нарезанный кубиками огурец, грецкие орехи. Все слои смазывать тонким слоем майонеза. Последний слой - тёртые на тёрке яйца.', 'photo_url' => 'recipes/steps/neznost6.jpg', 'sort_order' => 6, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 14: Хачапури на сковороде
        $recipe14Id = DB::table('recipes')->insertGetId([
            'title' => 'Хачапури на сковороде',
            'main_photo' => 'recipes/photos/hachapuri.jpg',
            'description' => 'Быстрые и сытные хачапури с сыром, приготовленные на сковороде. Хрустящая корочка и тягучая начинка.',
            'type' => 'food',
            'dish_category' => 'Выпечка',
            'is_alcoholic' => null,
            'preparation_time' => 60,
            'portion' => 8,
            'user_id' => $elenaId,
            'is_published' => true,
            'average_rating' => 0,
            'ratings_count' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe14Id, 'ingredient_id' => $ingredients['Кефир']->id, 'quantity' => '300', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe14Id, 'ingredient_id' => $ingredients['Яйца куриные']->id, 'quantity' => '2', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe14Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => '1', 'unit' => 'ч. л.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe14Id, 'ingredient_id' => $ingredients['Сыр сулугуни']->id, 'quantity' => '200', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe14Id, 'ingredient_id' => $ingredients['Сыр адыгейский']->id, 'quantity' => '200', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe14Id, 'ingredient_id' => $ingredients['Мука']->id, 'quantity' => '220', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe14Id, 'ingredient_id' => $ingredients['Разрыхлитель теста']->id, 'quantity' => '1', 'unit' => 'ч. л.', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe14Id, 'step_number' => 1, 'text' => 'Сыр натереть на крупной терке.', 'photo_url' => 'recipes/steps/hachapuri1.jpg', 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe14Id, 'step_number' => 2, 'text' => 'Добавить яйца, кефир, соль и разрыхлитель.', 'photo_url' => 'recipes/steps/hachapuri2.jpg', 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe14Id, 'step_number' => 3, 'text' => 'Затем добавить муку и перемешать.', 'photo_url' => 'recipes/steps/hachapuri3.jpg', 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe14Id, 'step_number' => 4, 'text' => 'Разделить тесто на две части. Жарить на сковороде на маленьком огне по 10 минут с каждой стороны.', 'photo_url' => 'recipes/steps/hachapuri4.jpg', 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 15: Мясная сборная солянка
        $recipe15Id = DB::table('recipes')->insertGetId([
            'title' => 'Мясная сборная солянка',
            'main_photo' => 'recipes/photos/solyanka.jpg',
            'description' => 'Насыщенный, ароматный суп с копченостями, солеными огурцами и маслинами. Согревающее блюдо для холодного дня.',
            'type' => 'food',
            'dish_category' => 'Первые блюда',
            'is_alcoholic' => null,
            'preparation_time' => 150,
            'portion' => 10,
            'user_id' => $elenaId,
            'is_published' => true,
            'average_rating' => 0,
            'ratings_count' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Копченые ребра']->id ?? $ingredients['Свинина']->id, 'quantity' => '300', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Сосиски']->id, 'quantity' => '300', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Колбаса копченая']->id, 'quantity' => '300', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Ветчина']->id, 'quantity' => '300', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Картофель']->id, 'quantity' => '3', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Лук репчатый']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Огурцы маринованные']->id, 'quantity' => '4', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Рассол огуречный']->id ?? $ingredients['Уксус']->id, 'quantity' => '200', 'unit' => 'мл', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Маслины']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Томатная паста']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Вода']->id, 'quantity' => '1.5', 'unit' => 'л', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Лимон']->id, 'quantity' => '0.5', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Масло растительное']->id, 'quantity' => '50', 'unit' => 'мл', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'ingredient_id' => $ingredients['Перец черный']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe15Id, 'step_number' => 1, 'text' => 'Подготовить бульон. В кастрюлю налить 1,5 л воды, довести до кипения и опустить рёбрышки. Варить на медленном огне 40–50 минут, снимая пену. Готовые рёбрышки вынуть и отделить мясо от кости, нарезать его небольшими кусочками. Бульон процедить.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'step_number' => 2, 'text' => 'Сделать зажарку. Поджарить мелко нарезанный лук. Добавить натёртые или мелко нарезанные солёные огурцы, тушить 3–4 минуты. Вмешать томатное пюре, прогреть смесь ещё пару минут.', 'photo_url' => 'recipes/steps/solyanka2.jpg', 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'step_number' => 3, 'text' => 'Нарезать мясные деликатесы — ветчину, колбасу, буженину — одинаковыми небольшими кусочками. Разогреть сковороду и обжарить мясные деликатесы.', 'photo_url' => 'recipes/steps/solyanka3.jpg', 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'step_number' => 4, 'text' => 'Подготовить картофель. Очистить и нарезать картофель кубиками. Опустить его в кипящий бульон и варить 10–12 минут до полуготовности. Слегка посолить.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'step_number' => 5, 'text' => 'Открыть банку маслин и нарезать их кружочками или половинками.', 'photo_url' => 'recipes/steps/solyanka5.jpg', 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'step_number' => 6, 'text' => 'Переложить луково-огуречную поджарку и мясное ассорти в кастрюлю с бульоном и картофелем, добавить маслины, немного чёрного перца и влить огуречный рассол. По желанию добавить 1–2 ч. л. лимонного сока за пару минут до окончания варки.', 'photo_url' => 'recipes/steps/solyanka6.jpg', 'sort_order' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'step_number' => 7, 'text' => 'Снять солянку с огня, дать настояться под крышкой 5–10 минут. Разлить по тарелкам. По желанию можно положить сметану.', 'photo_url' => null, 'sort_order' => 7, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 16: Картофельное пюре (Гарнир)
        $recipe16Id = DB::table('recipes')->insertGetId([
            'title' => 'Воздушное картофельное пюре',
            'main_photo' => 'recipes/photos/mashed_potatoes.jpg',
            'description' => 'Нежнейшее картофельное пюре с маслом и молоком. Идеальный гарнир к любому мясному блюду.',
            'type' => 'food',
            'dish_category' => 'Гарниры',
            'is_alcoholic' => null,
            'preparation_time' => 30,
            'portion' => 4,
            'user_id' => $varvaraId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe16Id, 'ingredient_id' => $ingredients['Картофель']->id, 'quantity' => '1', 'unit' => 'кг', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe16Id, 'ingredient_id' => $ingredients['Молоко']->id, 'quantity' => '150', 'unit' => 'мл', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe16Id, 'ingredient_id' => $ingredients['Масло сливочное']->id, 'quantity' => '80', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe16Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe16Id, 'ingredient_id' => $ingredients['Перец черный']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe16Id, 'step_number' => 1, 'text' => 'Картофель очистить, нарезать крупными кусками и отварить в подсоленной воде до готовности (20-25 минут).', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe16Id, 'step_number' => 2, 'text' => 'Слить воду, картофель размять толкушкой.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe16Id, 'step_number' => 3, 'text' => 'Молоко подогреть, сливочное масло растопить.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe16Id, 'step_number' => 4, 'text' => 'Добавить молоко и масло в картофель, взбить миксером до пышной консистенции.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe16Id, 'step_number' => 5, 'text' => 'Посолить, поперчить по вкусу. Подавать горячим.', 'photo_url' => null, 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 17: Рис с овощами (Гарнир)
        $recipe17Id = DB::table('recipes')->insertGetId([
            'title' => 'Рис с овощами',
            'main_photo' => 'recipes/photos/rice_vegetables.jpg',
            'description' => 'Ароматный рассыпчатый рис с морковью, кукурузой и зеленым горошком. Универсальный гарнир.',
            'type' => 'food',
            'dish_category' => 'Гарниры',
            'is_alcoholic' => null,
            'preparation_time' => 35,
            'portion' => 4,
            'user_id' => $dmitryId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe17Id, 'ingredient_id' => $ingredients['Рис']->id, 'quantity' => '300', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe17Id, 'ingredient_id' => $ingredients['Морковь']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe17Id, 'ingredient_id' => $ingredients['Кукуруза консервированная']->id ?? $ingredients['Кукуруза']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe17Id, 'ingredient_id' => $ingredients['Горошек зеленый']->id ?? $ingredients['Горох сушеный']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe17Id, 'ingredient_id' => $ingredients['Лук репчатый']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe17Id, 'ingredient_id' => $ingredients['Масло сливочное']->id, 'quantity' => '30', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe17Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe17Id, 'step_number' => 1, 'text' => 'Рис промыть до прозрачной воды, залить водой (1:2) и варить под крышкой 15 минут.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe17Id, 'step_number' => 2, 'text' => 'Лук и морковь мелко нарезать, обжарить на сливочном масле до мягкости.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe17Id, 'step_number' => 3, 'text' => 'Добавить кукурузу и горошек, прогревать 2-3 минуты.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe17Id, 'step_number' => 4, 'text' => 'Смешать готовый рис с овощами, посолить, перемешать.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 18: Брускетты с томатами (Закуска)
        $recipe18Id = DB::table('recipes')->insertGetId([
            'title' => 'Брускетты с томатами и базиликом',
            'main_photo' => 'recipes/photos/bruschetta.jpg',
            'description' => 'Итальянская закуска из хрустящего хлеба с сочными томатами, чесноком и ароматным базиликом.',
            'type' => 'food',
            'dish_category' => 'Закуски',
            'is_alcoholic' => null,
            'preparation_time' => 20,
            'portion' => 6,
            'user_id' => $annaId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe18Id, 'ingredient_id' => $ingredients['Хлеб']->id, 'quantity' => '6', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe18Id, 'ingredient_id' => $ingredients['Помидоры']->id, 'quantity' => '3', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe18Id, 'ingredient_id' => $ingredients['Чеснок']->id, 'quantity' => '2', 'unit' => 'зубчик', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe18Id, 'ingredient_id' => $ingredients['Базилик']->id, 'quantity' => '1', 'unit' => 'пучок', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe18Id, 'ingredient_id' => $ingredients['Масло оливковое']->id, 'quantity' => '3', 'unit' => 'ст. л.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe18Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe18Id, 'ingredient_id' => $ingredients['Перец черный']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe18Id, 'step_number' => 1, 'text' => 'Хлеб подсушить на гриле или в духовке до хрустящей корочки.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe18Id, 'step_number' => 2, 'text' => 'Помидоры нарезать мелкими кубиками, чеснок измельчить, базилик нарезать.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe18Id, 'step_number' => 3, 'text' => 'Смешать помидоры, чеснок, базилик, оливковое масло, соль и перец.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe18Id, 'step_number' => 4, 'text' => 'Натереть хлеб чесноком, выложить томатную начинку. Подавать сразу.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 19: Сырная тарелка (Закуска)
        $recipe19Id = DB::table('recipes')->insertGetId([
            'title' => 'Сырная тарелка с медом и орехами',
            'main_photo' => 'recipes/photos/cheese_plate.jpg',
            'description' => 'Изысканная закуска из различных сортов сыра с медом, грецкими орехами и виноградом.',
            'type' => 'food',
            'dish_category' => 'Закуски',
            'is_alcoholic' => null,
            'preparation_time' => 15,
            'portion' => 4,
            'user_id' => $elenaId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe19Id, 'ingredient_id' => $ingredients['Сыр пармезан']->id ?? $ingredients['Сыр']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe19Id, 'ingredient_id' => $ingredients['Сыр дорблю']->id ?? $ingredients['Сыр']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe19Id, 'ingredient_id' => $ingredients['Сыр чеддер']->id ?? $ingredients['Сыр']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe19Id, 'ingredient_id' => $ingredients['Мед']->id, 'quantity' => '50', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe19Id, 'ingredient_id' => $ingredients['Грецкие орехи']->id, 'quantity' => '50', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe19Id, 'ingredient_id' => $ingredients['Виноград']->id ?? $ingredients['Изюм']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe19Id, 'step_number' => 1, 'text' => 'Сыры нарезать ломтиками или кубиками.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe19Id, 'step_number' => 2, 'text' => 'Выложить сыры на деревянную доску.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe19Id, 'step_number' => 3, 'text' => 'Добавить мед в отдельной пиале, орехи и виноград.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe19Id, 'step_number' => 4, 'text' => 'Подавать с крекерами или багетом.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 20: Песто (Соус)
        $recipe20Id = DB::table('recipes')->insertGetId([
            'title' => 'Классический соус Песто',
            'main_photo' => 'recipes/photos/pesto.jpg',
            'description' => 'Ароматный итальянский соус из базилика, кедровых орехов и пармезана. Идеален для пасты и мяса.',
            'type' => 'food',
            'dish_category' => 'Соусы',
            'is_alcoholic' => null,
            'preparation_time' => 10,
            'portion' => 4,
            'user_id' => $varvaraId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe20Id, 'ingredient_id' => $ingredients['Базилик']->id, 'quantity' => '50', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe20Id, 'ingredient_id' => $ingredients['Кедровые орехи']->id ?? $ingredients['Грецкие орехи']->id, 'quantity' => '30', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe20Id, 'ingredient_id' => $ingredients['Сыр пармезан']->id ?? $ingredients['Сыр']->id, 'quantity' => '50', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe20Id, 'ingredient_id' => $ingredients['Чеснок']->id, 'quantity' => '1', 'unit' => 'зубчик', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe20Id, 'ingredient_id' => $ingredients['Масло оливковое']->id, 'quantity' => '100', 'unit' => 'мл', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe20Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe20Id, 'step_number' => 1, 'text' => 'Базилик промыть и обсушить.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe20Id, 'step_number' => 2, 'text' => 'В блендер сложить базилик, орехи, чеснок, сыр.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe20Id, 'step_number' => 3, 'text' => 'Измельчить, постепенно вливая оливковое масло.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe20Id, 'step_number' => 4, 'text' => 'Посолить по вкусу. Хранить в холодильнике.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 21: Цезарь соус (Соус)
        $recipe21Id = DB::table('recipes')->insertGetId([
            'title' => 'Домашний соус Цезарь',
            'main_photo' => 'recipes/photos/caesar_sauce.jpg',
            'description' => 'Классический соус для салата Цезарь. Нежный, сливочный с пикантными нотками анчоусов.',
            'type' => 'food',
            'dish_category' => 'Соусы',
            'is_alcoholic' => null,
            'preparation_time' => 15,
            'portion' => 6,
            'user_id' => $dmitryId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe21Id, 'ingredient_id' => $ingredients['Майонез']->id, 'quantity' => '150', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe21Id, 'ingredient_id' => $ingredients['Сыр пармезан']->id ?? $ingredients['Сыр']->id, 'quantity' => '30', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe21Id, 'ingredient_id' => $ingredients['Чеснок']->id, 'quantity' => '1', 'unit' => 'зубчик', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe21Id, 'ingredient_id' => $ingredients['Анчоусы']->id, 'quantity' => '4', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe21Id, 'ingredient_id' => $ingredients['Лимон']->id, 'quantity' => '0.5', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe21Id, 'ingredient_id' => $ingredients['Горчица дижонская']->id ?? $ingredients['Горчица']->id, 'quantity' => '1', 'unit' => 'ч. л.', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe21Id, 'step_number' => 1, 'text' => 'Чеснок измельчить, анчоусы размять вилкой.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe21Id, 'step_number' => 2, 'text' => 'Смешать майонез, горчицу, сок лимона, чеснок и анчоусы.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe21Id, 'step_number' => 3, 'text' => 'Добавить тертый пармезан, перемешать.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe21Id, 'step_number' => 4, 'text' => 'Поставить в холодильник на 30 минут для настоя.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 22: Мохито (Напиток безалкогольный)
        $recipe22Id = DB::table('recipes')->insertGetId([
            'title' => 'Мохито безалкогольный',
            'main_photo' => 'recipes/photos/mojito.jpg',
            'description' => 'Освежающий напиток с мятой, лаймом и содовой. Идеальный летний коктейль без алкоголя.',
            'type' => 'drink',
            'dish_category' => null,
            'is_alcoholic' => false,
            'preparation_time' => 10,
            'portion' => 1,
            'user_id' => $alexanderId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe22Id, 'ingredient_id' => $ingredients['Лайм']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe22Id, 'ingredient_id' => $ingredients['Мята']->id, 'quantity' => '10', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe22Id, 'ingredient_id' => $ingredients['Сахар']->id, 'quantity' => '2', 'unit' => 'ч. л.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe22Id, 'ingredient_id' => $ingredients['Газированная вода']->id ?? $ingredients['Вода']->id, 'quantity' => '150', 'unit' => 'мл', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe22Id, 'ingredient_id' => $ingredients['Лед']->id ?? $ingredients['Вода']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe22Id, 'step_number' => 1, 'text' => 'Лайм разрезать на дольки, мяту промыть.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe22Id, 'step_number' => 2, 'text' => 'В стакан положить мяту, лайм, сахар и слегка подавить мадлером.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe22Id, 'step_number' => 3, 'text' => 'Наполнить стакан льдом, залить газированной водой.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe22Id, 'step_number' => 4, 'text' => 'Аккуратно перемешать, украсить мятой и долькой лайма.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 23: Глинтвейн (Напиток алкогольный)
        $recipe23Id = DB::table('recipes')->insertGetId([
            'title' => 'Классический глинтвейн',
            'main_photo' => 'recipes/photos/gluhwein.jpg',
            'description' => 'Ароматный горячий напиток с красным вином, специями и цитрусами. Согревает в холодный вечер.',
            'type' => 'drink',
            'dish_category' => null,
            'is_alcoholic' => true,
            'preparation_time' => 20,
            'portion' => 4,
            'user_id' => $annaId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe23Id, 'ingredient_id' => $ingredients['Вино красное сухое']->id, 'quantity' => '750', 'unit' => 'мл', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe23Id, 'ingredient_id' => $ingredients['Апельсины']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe23Id, 'ingredient_id' => $ingredients['Лимон']->id, 'quantity' => '0.5', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe23Id, 'ingredient_id' => $ingredients['Сахар']->id, 'quantity' => '80', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe23Id, 'ingredient_id' => $ingredients['Корица целая']->id, 'quantity' => '2', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe23Id, 'ingredient_id' => $ingredients['Гвоздика']->id, 'quantity' => '5', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe23Id, 'ingredient_id' => $ingredients['Бадьян']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe23Id, 'step_number' => 1, 'text' => 'Апельсин и лимон нарезать кружочками.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe23Id, 'step_number' => 2, 'text' => 'В кастрюлю налить вино, добавить специи, сахар и цитрусы.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe23Id, 'step_number' => 3, 'text' => 'Нагреть на медленном огне до 70-80°C, не доводя до кипения.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe23Id, 'step_number' => 4, 'text' => 'Снять с огня, дать настояться 10 минут, процедить.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe23Id, 'step_number' => 5, 'text' => 'Разлить по бокалам, подавать горячим.', 'photo_url' => null, 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 24: Смузи ягодный (Напиток безалкогольный)
        $recipe24Id = DB::table('recipes')->insertGetId([
            'title' => 'Ягодный смузи',
            'main_photo' => 'recipes/photos/smoothie.jpg',
            'description' => 'Полезный и вкусный смузи из замороженных ягод, банана и йогурта. Отличный завтрак или перекус.',
            'type' => 'drink',
            'dish_category' => null,
            'is_alcoholic' => false,
            'preparation_time' => 10,
            'portion' => 2,
            'user_id' => $elenaId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe24Id, 'ingredient_id' => $ingredients['Клубника']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe24Id, 'ingredient_id' => $ingredients['Черника']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe24Id, 'ingredient_id' => $ingredients['Бананы']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe24Id, 'ingredient_id' => $ingredients['Йогурт']->id, 'quantity' => '200', 'unit' => 'мл', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe24Id, 'ingredient_id' => $ingredients['Мед']->id, 'quantity' => '1', 'unit' => 'ст. л.', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe24Id, 'step_number' => 1, 'text' => 'Все ингредиенты поместить в блендер.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe24Id, 'step_number' => 2, 'text' => 'Взбивать до однородной консистенции.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe24Id, 'step_number' => 3, 'text' => 'Разлить по стаканам, украсить свежими ягодами.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 25: Кровавая Мэри (Напиток алкогольный)
        $recipe25Id = DB::table('recipes')->insertGetId([
            'title' => 'Коктейль Кровавая Мэри',
            'main_photo' => 'recipes/photos/bloody_mary.jpg',
            'description' => 'Знаменитый коктейль с водкой, томатным соком и специями. Пикантный и бодрящий напиток.',
            'type' => 'drink',
            'dish_category' => null,
            'is_alcoholic' => true,
            'preparation_time' => 5,
            'portion' => 1,
            'user_id' => $dmitryId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe25Id, 'ingredient_id' => $ingredients['Водка']->id ?? $ingredients['Ром']->id, 'quantity' => '50', 'unit' => 'мл', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe25Id, 'ingredient_id' => $ingredients['Сок томатный']->id ?? $ingredients['Томатная паста']->id, 'quantity' => '100', 'unit' => 'мл', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe25Id, 'ingredient_id' => $ingredients['Лимон']->id, 'quantity' => '0.25', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe25Id, 'ingredient_id' => $ingredients['Соус Табаско']->id ?? $ingredients['Перец чили']->id, 'quantity' => '2', 'unit' => 'капля', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe25Id, 'ingredient_id' => $ingredients['Соус Вустершир']->id ?? $ingredients['Соевый соус']->id, 'quantity' => '2', 'unit' => 'капля', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe25Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe25Id, 'ingredient_id' => $ingredients['Перец черный']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe25Id, 'step_number' => 1, 'text' => 'Наполнить стакан льдом.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe25Id, 'step_number' => 2, 'text' => 'Налить водку, томатный сок, добавить соусы и сок лимона.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe25Id, 'step_number' => 3, 'text' => 'Посолить, поперчить, аккуратно перемешать.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe25Id, 'step_number' => 4, 'text' => 'Украсить стеблем сельдерея и долькой лимона.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 26: Лазанья (Второе блюдо)
        $recipe26Id = DB::table('recipes')->insertGetId([
            'title' => 'Классическая лазанья с мясом',
            'main_photo' => 'recipes/photos/lasagna.jpg',
            'description' => 'Итальянская лазанья с мясным соусом болоньезе, бешамелью и тягучим сыром.',
            'type' => 'food',
            'dish_category' => 'Вторые блюда',
            'is_alcoholic' => null,
            'preparation_time' => 90,
            'portion' => 6,
            'user_id' => $varvaraId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe26Id, 'ingredient_id' => $ingredients['Листы для лазаньи']->id ?? $ingredients['Макароны']->id, 'quantity' => '250', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe26Id, 'ingredient_id' => $ingredients['Фарш мясной']->id, 'quantity' => '500', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe26Id, 'ingredient_id' => $ingredients['Томатная паста']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe26Id, 'ingredient_id' => $ingredients['Лук репчатый']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe26Id, 'ingredient_id' => $ingredients['Молоко']->id, 'quantity' => '500', 'unit' => 'мл', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe26Id, 'ingredient_id' => $ingredients['Мука']->id, 'quantity' => '50', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe26Id, 'ingredient_id' => $ingredients['Масло сливочное']->id, 'quantity' => '50', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe26Id, 'ingredient_id' => $ingredients['Сыр моцарелла']->id, 'quantity' => '200', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe26Id, 'ingredient_id' => $ingredients['Сыр пармезан']->id ?? $ingredients['Сыр']->id, 'quantity' => '50', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe26Id, 'step_number' => 1, 'text' => 'Для соуса болоньезе обжарить лук, добавить фарш, томатную пасту, тушить 20 минут.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe26Id, 'step_number' => 2, 'text' => 'Для соуса бешамель растопить масло, добавить муку, затем молоко, варить до загустения.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe26Id, 'step_number' => 3, 'text' => 'В форму выложить слой соуса болоньезе, листы лазаньи, бешамель и сыр. Повторить слои.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe26Id, 'step_number' => 4, 'text' => 'Запекать 40 минут при 180°C.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe26Id, 'step_number' => 5, 'text' => 'Дать отдохнуть 10 минут перед подачей.', 'photo_url' => null, 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 27: Греческий салат (Салат)
        $recipe27Id = DB::table('recipes')->insertGetId([
            'title' => 'Греческий салат',
            'main_photo' => 'recipes/photos/greek_salad.jpg',
            'description' => 'Свежий салат с овощами, оливками и сыром фета. Заправляется оливковым маслом и орегано.',
            'type' => 'food',
            'dish_category' => 'Салаты',
            'is_alcoholic' => null,
            'preparation_time' => 15,
            'portion' => 4,
            'user_id' => $alexanderId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe27Id, 'ingredient_id' => $ingredients['Помидоры']->id, 'quantity' => '3', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe27Id, 'ingredient_id' => $ingredients['Огурцы']->id, 'quantity' => '2', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe27Id, 'ingredient_id' => $ingredients['Перец болгарский']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe27Id, 'ingredient_id' => $ingredients['Лук красный']->id ?? $ingredients['Лук репчатый']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe27Id, 'ingredient_id' => $ingredients['Сыр фета']->id, 'quantity' => '200', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe27Id, 'ingredient_id' => $ingredients['Маслины']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe27Id, 'ingredient_id' => $ingredients['Масло оливковое']->id, 'quantity' => '3', 'unit' => 'ст. л.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe27Id, 'ingredient_id' => $ingredients['Орегано']->id, 'quantity' => '1', 'unit' => 'ч. л.', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe27Id, 'step_number' => 1, 'text' => 'Овощи нарезать крупными кусками.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe27Id, 'step_number' => 2, 'text' => 'Сыр фета нарезать кубиками.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe27Id, 'step_number' => 3, 'text' => 'Смешать овощи, добавить маслины.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe27Id, 'step_number' => 4, 'text' => 'Полить оливковым маслом, посыпать орегано, добавить сыр.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 28: Омлет с сыром (Завтрак)
        $recipe28Id = DB::table('recipes')->insertGetId([
            'title' => 'Пышный омлет с сыром',
            'main_photo' => 'recipes/photos/omelette.jpg',
            'description' => 'Нежный и пышный омлет с расплавленным сыром. Идеальный завтрак для всей семьи.',
            'type' => 'food',
            'dish_category' => 'Вторые блюда',
            'is_alcoholic' => null,
            'preparation_time' => 15,
            'portion' => 2,
            'user_id' => $elenaId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe28Id, 'ingredient_id' => $ingredients['Яйца куриные']->id, 'quantity' => '4', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe28Id, 'ingredient_id' => $ingredients['Молоко']->id, 'quantity' => '50', 'unit' => 'мл', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe28Id, 'ingredient_id' => $ingredients['Сыр']->id, 'quantity' => '50', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe28Id, 'ingredient_id' => $ingredients['Масло сливочное']->id, 'quantity' => '20', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe28Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe28Id, 'ingredient_id' => $ingredients['Перец черный']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe28Id, 'step_number' => 1, 'text' => 'Яйца взбить с молоком, солью и перцем.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe28Id, 'step_number' => 2, 'text' => 'Сыр натереть на терке.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe28Id, 'step_number' => 3, 'text' => 'На сковороде растопить масло, вылить яичную смесь.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe28Id, 'step_number' => 4, 'text' => 'Жарить на среднем огне, пока омлет не схватится, посыпать сыром и сложить пополам.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 29: Шарлотка с яблоками (Выпечка)
        $recipe29Id = DB::table('recipes')->insertGetId([
            'title' => 'Классическая шарлотка с яблоками',
            'main_photo' => 'recipes/photos/charlotte.jpg',
            'description' => 'Пышный и ароматный яблочный пирог. Простой рецепт, который всегда получается.',
            'type' => 'food',
            'dish_category' => 'Выпечка',
            'is_alcoholic' => null,
            'preparation_time' => 60,
            'portion' => 6,
            'user_id' => $annaId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe29Id, 'ingredient_id' => $ingredients['Яйца куриные']->id, 'quantity' => '4', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe29Id, 'ingredient_id' => $ingredients['Сахар']->id, 'quantity' => '200', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe29Id, 'ingredient_id' => $ingredients['Мука']->id, 'quantity' => '200', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe29Id, 'ingredient_id' => $ingredients['Яблоки']->id, 'quantity' => '4', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe29Id, 'ingredient_id' => $ingredients['Разрыхлитель теста']->id, 'quantity' => '1', 'unit' => 'ч. л.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe29Id, 'ingredient_id' => $ingredients['Ванилин']->id, 'quantity' => '1', 'unit' => 'щепотка', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe29Id, 'step_number' => 1, 'text' => 'Яйца взбить с сахаром до пышной пены.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe29Id, 'step_number' => 2, 'text' => 'Добавить муку с разрыхлителем и ванилином, аккуратно перемешать.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe29Id, 'step_number' => 3, 'text' => 'Яблоки очистить, нарезать дольками.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe29Id, 'step_number' => 4, 'text' => 'Форму смазать маслом, выложить яблоки, залить тестом.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe29Id, 'step_number' => 5, 'text' => 'Выпекать 40 минут при 180°C.', 'photo_url' => null, 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // РЕЦЕПТ 30: Куриный бульон (Первое блюдо)
        $recipe30Id = DB::table('recipes')->insertGetId([
            'title' => 'Куриный бульон с лапшой',
            'main_photo' => 'recipes/photos/chicken_broth.jpg',
            'description' => 'Легкий и прозрачный куриный бульон с домашней лапшой. Лучшее средство для восстановления сил.',
            'type' => 'food',
            'dish_category' => 'Первые блюда',
            'is_alcoholic' => null,
            'preparation_time' => 90,
            'portion' => 6,
            'user_id' => $varvaraId,
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('recipe_ingredients')->insert([
            ['recipe_id' => $recipe30Id, 'ingredient_id' => $ingredients['Курица']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe30Id, 'ingredient_id' => $ingredients['Морковь']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe30Id, 'ingredient_id' => $ingredients['Лук репчатый']->id, 'quantity' => '1', 'unit' => 'шт.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe30Id, 'ingredient_id' => $ingredients['Лапша яичная']->id ?? $ingredients['Макароны']->id, 'quantity' => '100', 'unit' => 'г', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe30Id, 'ingredient_id' => $ingredients['Соль']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe30Id, 'ingredient_id' => $ingredients['Перец черный']->id, 'quantity' => 'по вкусу', 'unit' => 'по вкусу', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe30Id, 'ingredient_id' => $ingredients['Укроп']->id, 'quantity' => '1', 'unit' => 'пучок', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('recipe_steps')->insert([
            ['recipe_id' => $recipe30Id, 'step_number' => 1, 'text' => 'Курицу залить водой, довести до кипения, снять пену.', 'photo_url' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe30Id, 'step_number' => 2, 'text' => 'Добавить целую морковь и луковицу, варить 1 час.', 'photo_url' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe30Id, 'step_number' => 3, 'text' => 'Достать курицу и овощи, бульон процедить.', 'photo_url' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe30Id, 'step_number' => 4, 'text' => 'Довести бульон до кипения, добавить лапшу, варить 5-7 минут.', 'photo_url' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe30Id, 'step_number' => 5, 'text' => 'Подавать с зеленью и кусочками курицы.', 'photo_url' => null, 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Добавляем рейтинги для рецептов
        $ratings = [
            ['recipe_id' => $recipe1Id, 'user_id' => $varvaraId, 'rating_value' => 5],
            ['recipe_id' => $recipe1Id, 'user_id' => $dmitryId, 'rating_value' => 4],
            ['recipe_id' => $recipe2Id, 'user_id' => $elenaId, 'rating_value' => 5],
            ['recipe_id' => $recipe2Id, 'user_id' => $annaId, 'rating_value' => 5],
            ['recipe_id' => $recipe3Id, 'user_id' => $varvaraId, 'rating_value' => 5],
            ['recipe_id' => $recipe3Id, 'user_id' => $elenaId, 'rating_value' => 5],
            ['recipe_id' => $recipe4Id, 'user_id' => $alexanderId, 'rating_value' => 4],
            ['recipe_id' => $recipe4Id, 'user_id' => $elenaId, 'rating_value' => 4],
            ['recipe_id' => $recipe5Id, 'user_id' => $dmitryId, 'rating_value' => 5],
            ['recipe_id' => $recipe6Id, 'user_id' => $annaId, 'rating_value' => 5],
            ['recipe_id' => $recipe7Id, 'user_id' => $varvaraId, 'rating_value' => 5],
            ['recipe_id' => $recipe8Id, 'user_id' => $elenaId, 'rating_value' => 5],
            ['recipe_id' => $recipe9Id, 'user_id' => $varvaraId, 'rating_value' => 5],
            ['recipe_id' => $recipe9Id, 'user_id' => $dmitryId, 'rating_value' => 4],
            ['recipe_id' => $recipe10Id, 'user_id' => $varvaraId, 'rating_value' => 5],
            ['recipe_id' => $recipe10Id, 'user_id' => $alexanderId, 'rating_value' => 5],
            ['recipe_id' => $recipe11Id, 'user_id' => $varvaraId, 'rating_value' => 5],
            ['recipe_id' => $recipe11Id, 'user_id' => $annaId, 'rating_value' => 5],
            ['recipe_id' => $recipe12Id, 'user_id' => $annaId, 'rating_value' => 4],
            ['recipe_id' => $recipe12Id, 'user_id' => $varvaraId, 'rating_value' => 5],
            ['recipe_id' => $recipe12Id, 'user_id' => $dmitryId, 'rating_value' => 5],
            ['recipe_id' => $recipe13Id, 'user_id' => $annaId, 'rating_value' => 5],
            ['recipe_id' => $recipe13Id, 'user_id' => $varvaraId, 'rating_value' => 5],
            ['recipe_id' => $recipe14Id, 'user_id' => $dmitryId, 'rating_value' => 5],
            ['recipe_id' => $recipe14Id, 'user_id' => $varvaraId, 'rating_value' => 5],
            ['recipe_id' => $recipe14Id, 'user_id' => $alexanderId, 'rating_value' => 5],
            ['recipe_id' => $recipe15Id, 'user_id' => $varvaraId, 'rating_value' => 5],
            ['recipe_id' => $recipe15Id, 'user_id' => $annaId, 'rating_value' => 5],
            ];

        foreach ($ratings as $rating) {
            DB::table('ratings')->insert([
                'recipe_id' => $rating['recipe_id'],
                'user_id' => $rating['user_id'],
                'rating_value' => $rating['rating_value'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Добавляем сохраненные рецепты
        $savedRecipes = [
            ['user_id' => $varvaraId, 'recipe_id' => $recipe5Id],
            ['user_id' => $varvaraId, 'recipe_id' => $recipe12Id],
            ['user_id' => $varvaraId, 'recipe_id' => $recipe14Id],
            ['user_id' => $elenaId, 'recipe_id' => $recipe2Id],
            ['user_id' => $elenaId, 'recipe_id' => $recipe6Id],
            ['user_id' => $annaId, 'recipe_id' => $recipe4Id],
            ['user_id' => $annaId, 'recipe_id' => $recipe15Id],
            ['user_id' => $dmitryId, 'recipe_id' => $recipe5Id],
            ['user_id' => $dmitryId, 'recipe_id' => $recipe8Id],
            ['user_id' => $dmitryId, 'recipe_id' => $recipe12Id],
            ['user_id' => $alexanderId, 'recipe_id' => $recipe2Id],
            ['user_id' => $alexanderId, 'recipe_id' => $recipe4Id],
            ['user_id' => $alexanderId, 'recipe_id' => $recipe5Id],
            ['user_id' => $alexanderId, 'recipe_id' => $recipe11Id],
        ];

        foreach ($savedRecipes as $saved) {
            DB::table('saved_recipes')->insert([
                'user_id' => $saved['user_id'],
                'recipe_id' => $saved['recipe_id'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Добавляем комментарии
        $comments = [
            [
                'recipe_id' => $recipe1Id,
                'user_id' => $varvaraId,
                'comment' => 'Отличный рецепт! Борщ получился наваристым и ароматным. Спасибо!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe1Id,
                'user_id' => $dmitryId,
                'comment' => 'Добавил еще немного укропа, получилось еще вкуснее.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe2Id,
                'user_id' => $elenaId,
                'comment' => 'Нежнейшее блюдо! Готовила с пастой, семья была в восторге.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe3Id,
                'user_id' => $varvaraId,
                'comment' => 'Лучший тирамису! Получился как в итальянском ресторане.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe4Id,
                'user_id' => $annaId,
                'comment' => 'Вместо майонеза сделала соус из йогурта и горчицы, получилось легче.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe6Id,
                'user_id' => $alexanderId,
                'comment' => 'Быстро и вкусно! Идеальный рецепт для быстрого ужина.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'recipe_id' => $recipe8Id,
                'user_id' => $elenaId,
                'comment' => 'Добавила вишню сверху, получилось празднично!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            ['recipe_id' => $recipe9Id, 'user_id' => $varvaraId, 'comment' => 'Летний супчик! Очень освежает в жару.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe10Id, 'user_id' => $alexanderId, 'comment' => 'Лучший рецепт плова! Получилось очень вкусно.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe11Id, 'user_id' => $annaId, 'comment' => 'Классика! Всегда получается отлично.', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe12Id, 'user_id' => $annaId, 'comment' => 'Нежная запеканка, дети в восторге!', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe13Id, 'user_id' => $varvaraId, 'comment' => 'Потрясающее сочетание вкусов!', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe14Id, 'user_id' => $dmitryId, 'comment' => 'Быстро и сытно. Отличный завтрак!', 'created_at' => $now, 'updated_at' => $now],
            ['recipe_id' => $recipe15Id, 'user_id' => $annaId, 'comment' => 'Мой любимый рецепт!', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($comments as $comment) {
            DB::table('comments')->insert($comment);
        }

        $this->command->info('Рецепты успешно добавлены!');
        \App\Models\Recipe::recalculateRatings();
    }
}
