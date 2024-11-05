<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        if ($request->is('opticien/*')) {
            return route('opticien.login'); // Route pour les optométristes
        }
        if ($request->is('admin/*')) {
            return route('admin.login'); // Route pour les optométristes
        }

        return route('default');
    }
}
