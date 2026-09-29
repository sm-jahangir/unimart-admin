<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AuthGates
{
    /**
     * Define a Gate for every permission slug so controllers and Blade
     * can authorize with Gate::authorize('app.users.index') etc.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($user = $request->user()) {
            // Eager-load the role's permissions once; User::hasPermission()
            // then checks against the loaded collection instead of running
            // one query per gate check.
            $user->loadMissing('role.permissions');

            Permission::query()->pluck('slug')->each(
                fn (string $slug) => Gate::define($slug, fn (User $user) => $user->hasPermission($slug))
            );
        }

        return $next($request);
    }
}
