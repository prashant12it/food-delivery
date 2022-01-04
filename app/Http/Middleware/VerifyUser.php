<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->user()){
//            if($request->wantsJson()){
                return response()->json(['message','Not authorised, please login'],201);
            /*}
            abort(201,'Not authorised, please login/signup');*/
        }
        return $next($request);
    }
}
