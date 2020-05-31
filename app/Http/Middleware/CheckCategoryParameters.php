<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class CheckCategoryParameters
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
        $uri = $request->path();
        $validator = null;
        switch ($uri) {
            case 'api/category':
                $validator = Validator::make($request->json()->all(), [
                    "page"  => ["required","integer"],
                    "count" => ["required","integer"],
                    "category"  => ["string","nullable","exists:categories,slug"],
                ]);
                break;
            default: break;
        }
        if ($validator->fails()) {
            return response(
                $validator->errors(),
                400
            );
        }
        return $next($request);
    }
}
