<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_if($user === null, 401, 'Silakan login terlebih dahulu.');
        abort_unless($user->isCustomer(), 403, 'Fitur ini khusus pelanggan.');

        return $next($request);
    }
}
