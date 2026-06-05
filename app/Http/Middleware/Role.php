<?php

/* =====================================================================
Role.php  ─  Middleware de comprobación de roles
---------------------------------------------------------------------
Comprueba si el usuario logueado tiene ALGUNO de los roles permitidos
para acceder a una ruta. Si NO los tiene, lo manda a /noPermitido.=====================================================================*/

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class Role
{

    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Recorremos los roles permitidos.
        // Si el usuario tiene cualquiera de ellos, le dejamos pasar.
        foreach ($roles as $role) {
            if ($request->user() && $request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        // Si no tiene ninguno = página de "No permitido"
        return redirect('/noPermitido');
    }
}
