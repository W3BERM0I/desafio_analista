<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\Privileges;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar se o usuário está autenticado
        if(auth()->check()) {
            info('admin: ', [auth()->user()->privileges]);
            // Verificar se o usuário é um administrador
            if(auth()->user()->privileges === Privileges::SUPER_ADMIN->value || auth()->user()->privileges === Privileges::ADMIN->value  ) {
                return $next($request);
            }
        }

        // Redirecionar ou retornar uma resposta de não autorizado
        return redirect('/home')->with('error', 'Você não tem permissão para acessar esta página.');
    }
}
