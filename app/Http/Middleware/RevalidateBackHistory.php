<?php

namespace App\Http\Middleware;

use Closure;

class RevalidateBackHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*public function handle($request, Closure $next)
    {
        return $next($request);
    }*/

 public function handle($request, Closure $next)
 {
   header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
     header('Cache-Control: no-store, no-cache, must-revalidate');
     header('Cache-Control: post-check=0, pre-check=0',false);
     header('Pragma: no-cache');
     return $next($request);

}
