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
  # This is Set Locale Middleware
  ##############################################################################
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SetLocale
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
        app()->setLocale(getUserLanguage());
        $url = request()->segment(1);
        if($url!="set-security-question" && $url!="save-security-question" && $url!="change-password"){
            if(Auth::user()->registered_from == 'social') {
                app()->setLocale(getUserLanguage());
                return $next($request);
            } elseif (Auth::user()->registered_from == 'web' && Auth::user()->question == Null) {
                return redirect()->route('set-security-question')->with('error','Set security question to continue');
           }

           if(Auth::user()->need_change_password == true){
                return redirect()->route('change-password')->with('error','Change your default password to continue'); 
            }
        } 
        return $next($request);
    }
}
