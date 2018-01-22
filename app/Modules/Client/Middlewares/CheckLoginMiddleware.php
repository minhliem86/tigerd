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
            return redirect()->route('client.auth.login')->with('error','Vui lòng đăng nhập để hoàn tất thao tác');
        }
        return $next($request);
    }
}
