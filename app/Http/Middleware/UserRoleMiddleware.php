<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && !$user->isUserRole()) {
            $message = $user->role === UserRole::ADMIN ?
                'Brak dostępu do panelu użytkownika.' :
                'Brak dostępu.';

            Notification::make()
                ->title('Błąd!')
                ->body($message)
                ->danger()
                ->send();

            return $user->role === UserRole::ADMIN ?
                redirect('/admin') :
                redirect('/login');
        }

        return $next($request);
    }
}
