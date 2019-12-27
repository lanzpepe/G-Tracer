<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class Department
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
            $requestedDeptId = $request->route()->parameter('admin_id');
            $role = Admin::find(Auth::user()->admin_id)->roles->first();

            if ($role->name === config('constants.roles.dept') && Auth::user()->id == $requestedDeptId)
                return $next($request);
            else
                return redirect('admin');
        }
        else
            return redirect()->route('index');
    }
}
