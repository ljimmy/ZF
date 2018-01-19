<?php

namespace SF\Http\Middlewares;

use SF\Http\Request;

interface MiddlewareInterface
{
    public function handle(Request $request, \Closure $next);
}
