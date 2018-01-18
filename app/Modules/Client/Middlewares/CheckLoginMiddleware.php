<?php

namespace App\Modules\Client\Middlewares;

use Closure;
use Auth;
class CheckLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct()
    {
        $this->auth = Auth::guard('customer');
    }

    public function handle($request, Closure $next)
    {
        if(!$this->auth->check()){
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('error_login','Vui lòng đăng nhập trước khi thực hiện thao tác');
            return route('client.auth.login')->with($errors);
        }
        return $next($request);
    }
}
