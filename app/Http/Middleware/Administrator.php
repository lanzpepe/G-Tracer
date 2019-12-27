<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class Administrator
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
        if (Auth::check()) {
            $requestedAdminId = $request->route()->parameter('admin_id');
            $role = Admin::find(Auth::user()->admin_id)->roles->first();

            if ($role->name === config('constants.roles.admin') && Auth::user()->id == $requestedAdminId)
                return $next($request);
            else
                return redirect('dept');
            }
        else
            return redirect()->route('index');
    }
}
