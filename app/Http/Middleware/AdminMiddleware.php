<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Проверяем, авторизован ли пользователь
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Проверяем роль
        if ($request->user()->role !== 'admin') {
            // Для Inertia запросов
            if ($request->header('X-Inertia')) {
                return Inertia::render('Errors/403', [
                    'message' => 'Доступ запрещен. Требуются права администратора.'
                ])->toResponse($request);
            }

            // Для обычных запросов
            abort(403, 'Доступ запрещен. Требуются права администратора.');
        }

        return $next($request);
    }
}
