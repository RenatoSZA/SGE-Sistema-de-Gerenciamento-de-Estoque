<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminOrManager
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        $nivelAcesso = auth()->user()->nivel_acesso;

        if ($nivelAcesso !== 'Admin' && $nivelAcesso !== 'Gerente') {
            return redirect('/dashboard')->with('error', 'Acesso negado. Apenas administradores e gerentes podem acessar o cadastro de funcionários.');
        }

        return $next($request);
    }
}
