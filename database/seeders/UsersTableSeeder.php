<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $users = [
            // Админ (я)
            [
                'name' => 'Varvara',
                'email' => 'm9539646789@gmail.com',
                'email_verified_at' => $now,
                'password' => Hash::make('123Qwerty!'),
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'role' => 'admin',
                'gender' => 'female',
                'avatar' => 'avatar1.png',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Женщина 2
            [
                'name' => 'Chef Elena',
                'email' => 'elena.kyznedeleva@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'role' => 'user',
                'gender' => 'female',
                'avatar' => 'avatar2.png',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Женщина 3
            [
                'name' => 'Anna435',
                'email' => 'anna.kozlov@example.com',
                'email' => 'anna.kozlov@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'role' => 'user',
                'gender' => 'female',
                'avatar' => 'avatar3.png',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Мужчина 1
            [
                'name' => 'Шеф Дмитрий',
                'email' => 'dmitry.ivanov@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'role' => 'user',
                'gender' => 'male',
                'avatar' => 'avatar5.png',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Мужчина 2
            [
                'name' => 'Александр',
                'email' => 'alexandr.tishin@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'role' => 'user',
                'gender' => 'male',
                'avatar' => 'avatar6.png',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Вставка данных в таблицу users
        DB::table('users')->insert($users);

        $this->command->info('Пользователи успешно добавлены!');
        $this->command->info('Добавлено пользователей: ' . count($users));
        $this->command->info('Из них:');
        $this->command->info('  - Женщин: 3 (включая админа)');
        $this->command->info('  - Мужчин: 2');
        $this->command->info('  - Администратор: Варвара (m9539646789@gmail.com)');
    }
}
