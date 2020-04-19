<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class CheckGoodsParameters
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
        switch ($uri) {
            case 'goodsList':
                $validator = Validator::make($request->json()->all(), [
                    "page" => "required|integer",
                    "count" => "required|integer",
                    "mode"  => "required|string",
                ]);

                if ($validator->fails()) {
                    return response(
                        $validator->errors(),
                        400
                    );
                }
                break;
            default: break;
        }
        return $next($request);
    }
}
