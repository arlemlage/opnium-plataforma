<?php
/*
  ##############################################################################
  # AI Powered Customer Support Portal and Knowledgebase System
  ##############################################################################
  # AUTHOR:		Door Soft
  ##############################################################################
  # EMAIL:		info@doorsoft.co
  ##############################################################################
  # COPYRIGHT:		RESERVED BY Door Soft
  ##############################################################################
  # WEBSITE:		https://www.doorsoft.co
  ##############################################################################
  # This is Admin Middleware
  ##############################################################################
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        $check_user = Auth::user();
        $url = request()->segment(2);
        if($url!="change-password" && $check_user->need_change_password == true) {
            return redirect()->route('admin.change-password')->with('error','Change your default password to continue');
        } elseif (!empty($check_user) && ($check_user->role_id == 1)){
            return $next($request);
        } else{
            return redirect()->route('admin.login');
        }
    }
}
