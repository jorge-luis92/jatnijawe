<?php

namespace App\Http\Middleware;

use Closure;

class UsuarioServicio
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
           if($usuario_actual->tipo_usuario=='3'){
              return $next($request);
         }
         else{
           return redirect()->back();
         }
     }
   }
   // 1= formacion 2=planeacion 3=servicios 4=auxiliar 5=admin
