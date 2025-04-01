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
  # This is Activity Log Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\ActivityLog;
use App\Model\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $type = request()->get('activity_type');
        $user = request()->get('user');
        $start_date = !empty(request()->get('start_date'))? date('Y-m-d', strtotime(request()->get('start_date'))):null;
        $end_date = !empty(request()->get('end_date'))? date('Y-m-d', strtotime(request()->get('end_date'))):null;

        $obj = ActivityLog::query();
        $obj->live();
        if(!empty($type)){
            $obj->where('type', 'LIKE', $type);
        }
        if(!empty($user)){
            $obj->where('user_id', $user);
        }
        if(isset($start_date)){
            $obj->whereDate('created_at', '>=', $start_date);
        }
        if(isset($end_date)){
            $obj->whereDate('created_at', '<=', $end_date);
        }

        $obj = $obj->orderBy('id', 'DESC')->paginate(100);

        $all_users = User::where('role_id','!=',3)->live()->get();
        $user_id = $user;
        return view('activity-log.index', compact('obj', 'all_users','type','user_id','start_date','end_date'));
    }
}
