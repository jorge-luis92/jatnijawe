<?php

namespace App\Http\Middleware;

use Closure;

class UsuarioAcademico
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next)
     {
           $usuario_actual=\Auth::user();
           if($usuario_actual->tipo_usuario=='4'){
              return $next($request);
         }
         else{
           return redirect()->back();
         }
     }
}
