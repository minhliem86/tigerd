<?php

namespace App\Modules\Client\Middlewares;

use Closure;
use Auth;
class RedirectIfLogined
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
        if($this->auth->check()){
            return redirect()->back()->with('error', 'Bạn đã đăng nhập.');
        }
        return $next($request);
    }
}
