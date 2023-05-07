<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->header('Authorization');

            if (!$token) {
                throw new UnauthorizedHttpException('Bearer');
            }

            $token = str_replace('Bearer ', '', $token);

            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();
        } catch (Exception $e) {
            if ($e instanceof UnauthorizedHttpException) {
                return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
