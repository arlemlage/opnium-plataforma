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
  # This is Attendance Model
  ##############################################################################
 */

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "tbl_attendances";
    /**
     * Define guard for table
     * @var string
     */
    protected $guarded = [];
    protected $appends = array('display_hours');

     /**
     * Display hours
     */
    public function getDisplayHoursAttribute() {
        return $this->work_hour.' Hour(s)';
    }

    /**
     * get in time
     */

    public function getInTimeAttribute($value) {
        if(isset($value)) {
            return date('h:i',strtotime($value));
        } else {
            return "N/A";
        }
    }

    /**
     * get out time
     */
    public function getOutTimeAttribute($value) {
        if(isset($value)) {
            return date('h:i',strtotime($value));
        } else {
            return "N/A";
        }
    }

    /**
     * Handle login attendance request
     */
    public static function inAttendance(){
        $count = Attendance::count();
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        $in_time =  Carbon::now()->format('Y-m-d H:i');
        $data = new  Attendance();
        $data->reference = $code;
        $data->user_id = Auth::id();
        $data->in_time = $in_time;
        $data->added_by = Auth::id();
        if($data->save()){
            return true;
        } else{
            return false;
        }
    }

    /**
     * Handle login attendance request
     */
    public static function outAttendance(){
        $data = Attendance::where('user_id',Auth::id())
            ->whereNull('out_time')->first();
        $current_time = Carbon::now()->format('Y-m-d H:i');
        $timeFirst  = strtotime($data->in_time);
        $timeSecond = strtotime($current_time);
        $differenceInSeconds = $timeSecond - $timeFirst;
        $workHour = gmdate("H.i", $differenceInSeconds);
        $data->out_time = $current_time;
        $data->work_hour = $workHour;
        if($data->save()){
            return true;
        } else{
            return false;
        }
    }

    /**
     * Check has checkoin time
     */
    public static function hasCheckIn() {
        if(Attendance::where('user_id',Auth::id())->whereNotNull('in_time')->whereNull('out_time')->exists()){
            return  false;
        } else {
            return true;
        }
    }

    /**
     * Check has checkout time
     */
    public static function hasCheckOut() {
        if(Attendance::where('user_id',Auth::id())->whereNotNull('in_time')->whereNull('out_time')->exists()){
            return  true;
        } else {
            return false;
        }
    }
}
