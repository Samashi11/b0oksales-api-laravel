<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_if($user === null, 401, 'Silakan login terlebih dahulu.');
        abort_unless($user->isAdmin(), 403, 'Hanya admin yang boleh melakukan ini.');

        return $next($request);
    }
}
