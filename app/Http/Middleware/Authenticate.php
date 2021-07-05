<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Handle an unauthenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $guards
     * @return \Illuminate\Http\JsonResponse
     *
     */
    protected function unauthenticated($request, array $guards)
    {
        return response()->json(['code' => -1, 'msg' => '登陆过期，请重新登陆~'])->setStatusCode(401);
    }
}
