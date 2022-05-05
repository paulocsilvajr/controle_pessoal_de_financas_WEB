<?php

namespace App\Http\Middleware;

use App\Services\Token;
use Closure;

class VerificacaoToken
{
    public function handle($request, Closure $next) {
        $token = new Token($request);
        if ($token->valido()) {
            return $next($request);
        }
        return redirect()->route('login');
    }
}
