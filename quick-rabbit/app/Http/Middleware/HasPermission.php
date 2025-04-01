<?php
/*
##############################################################################
# AI Powered Customer Support Portal and Knowledgebase System
##############################################################################
# AUTHOR:        Door Soft
##############################################################################
# EMAIL:        info@doorsoft.co
##############################################################################
# COPYRIGHT:        RESERVED BY Door Soft
##############################################################################
# WEBSITE:        https://www.doorsoft.co
##############################################################################
# This is Has Permission Middleware
##############################################################################
 */

namespace App\Http\Middleware;

use App\Model\MenuActivity;
use App\Model\RolePermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasPermission
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
        if (authUserRole() == 2) {
            $request_route = \Request::route()->getName();
            $activity = MenuActivity::where('route_name', $request_route)->first();
            $user_role = Auth::user()->permission_role;
            if (isset($activity)) {
                $activity_id = $activity->id;
                $condition = [
                    'role_id' => $user_role,
                    'activity_id' => $activity_id,
                ];
                if (RolePermission::where($condition)->exists()) {
                    return $next($request);
                } else {
                    return redirect()->route('user-home')->with("error", __('index.no_permission'));
                }
            } else {
                return redirect()->route('user-home')->with("error", __('index.no_permission'));
            }
        } else {
            return $next($request);
        }
    }
}
