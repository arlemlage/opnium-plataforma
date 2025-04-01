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
# This is Set Locale Middleware
##############################################################################
 */

namespace App\Http\Middleware;

use App\Model\SiteSetting;
use Closure;
use Illuminate\Support\Facades\DB;

class ThemeChangeMiddleware
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
        if ($request->has('theme')) {
            $theme = $request->theme;
            if ($theme == 'single') {
                $theme = 'single';
            } else {
                $theme = 'multiple';
            }

            $site_setting = DB::table('tbl_site_settings')->where('del_status', 'Live')->first();
            if (empty($site_setting)) {
                $site_setting = DB::table('tbl_site_settings')->insert(['theme_type' => $theme]);
            }
            DB::table('tbl_site_settings')->where('del_status', 'Live')->update(['theme_type' => $theme]);
        }

        return $next($request);

    }
}
