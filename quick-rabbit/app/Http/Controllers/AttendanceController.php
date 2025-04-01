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
  # This is Attendance Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Model\User;
use App\Model\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
     {
         $data = Attendance::query();
         $user_id = request()->get('user_id');
         $from_date  = request()->get('from_date');
         $to_date  = request()->get('to_date');
         if(isset($user_id)){
             $data->where('user_id',$user_id);
         }
         if (isset($from_date) && !isset($to_date)) {
             $data->whereDate('attendance_date',date($from_date));
         }
         if (isset($to_date) && !isset($from_date)) {
             $data->whereDate('attendance_date','<=',date($to_date));
         }
         if (isset($from_date) AND isset($to_date)) {
             $data->whereBetween('attendance_date', [date($from_date), date($to_date)]);
         }
         
         $data->orderBy('id','asc');
         $results = $data->get();
         $users = User::where('role_id','!=',3)->get();
         $user = User::find($user_id);
         return view('attendance.index',compact('results','users','user','user_id','from_date','to_date'));
 
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
         $title = __('index.add_attendance');
         $users = User::where('role_id','!=',3)->get();
         $count = Attendance::count();
         $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
         $tDate = date('Y-m-d', strtotime(Carbon::today()));
         return view('attendance.add_edit',compact('title','users','code','tDate'));
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
         $this->validate($request,[
             'user_id'=>'required',
             'attendance_date'=>'required',
             'in_time'=>'required',
             'note' => 'max:100'
         ],[
             'user_id.required' => __('index.agent_required'),
             'attendance_date.required' => __('index.date_required'),
             'in_time.required' => __('index.in_time_required'),
         ]);
         $data = new Attendance();
         $data->reference = $request->reference ?? str_pad(Attendance::count() + 1, 6, '0', STR_PAD_LEFT);
         $data->user_id = $request->user_id;
         $data->attendance_date = $request->attendance_date;
         $data->in_time = $request->in_time;
         $data->note = $request->note;
         $data->added_by = Auth::id();
         
         if(isset($request->out_time)){
            $duration = getTotalHour(date('H:i:s',strtotime($request->out_time)),date('H:i:s',strtotime($request->in_time)));             
             $data->out_time = $request->out_time;
             $data->work_hour = $duration;
         }
 
         $data->save();
         return redirect()->route('attendance.index')->with(saveMessage());
     }
 
     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit($id)
     {
         $id = encrypt_decrypt($id,'decrypt');
         $data = Attendance::findOrFail($id);
         $title = __('index.edit_attendance');
         $users = User::where('role_id','!=',3)->get();
         $tDate = date('Y-m-d', strtotime(Carbon::today()));
         return view('attendance.add_edit',compact('data','title','users','tDate'));
     }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, $id)
     {
        $this->validate($request,[
            'user_id'=>'required',
            'attendance_date'=>'required',
            'in_time'=>'required',
            'note' => 'max:100'
        ],[
            'user_id.required' => __('index.agent_required'),
            'attendance_date.required' => __('index.date_required'),
            'in_time.required' => __('index.in_time_required'),
        ]);
         $data = Attendance::findOrFail($id);
         $data->reference = $request->reference;
         $data->user_id = $request->user_id;
         $data->attendance_date = $request->attendance_date;
         $data->in_time = $request->in_time;
         $data->note = $request->note;
         $data->added_by = Auth::id();
 
         if(isset($request->out_time)){
            $duration = getTotalHour(date('H:i:s',strtotime($request->out_time)),date('H:i:s',strtotime($data->in_time)));             
            $data->out_time = $request->out_time;
            $data->work_hour = $duration;
         }
         $data->save();
         return redirect()->route('attendance.index')->with(updateMessage());
     }
 
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
        Attendance::findOrFail($id)->delete();
        return redirect()->route('attendance.index')->with(deleteMessage());
     }

     /**
      * User wise attendance check in/ out
      */
      public function checkInOut() {
        $data = Attendance::where('user_id',Auth::id());
        $from_date  = request()->get('from_date');
        $to_date  = request()->get('to_date');
        
        if (isset($from_date) && !isset($to_date)) {
            $data->whereDate('attendance_date',date($from_date));
        }
        if (isset($to_date) && !isset($from_date)) {
            $data->whereDate('attendance_date','<=',date($to_date));
        }
        if (isset($from_date) AND isset($to_date)) {
            $data->whereBetween('attendance_date', [date($from_date), date($to_date)]);
        }
        
        $data->orderBy('id','asc');
        $results = $data->get();
        return view('attendance.check_in_out',compact('results','from_date','to_date'));
      }

     /**
      * Check in attendance
      */
     public function inAttendance(){
        $count = Attendance::count();
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        $in_time =  Carbon::now()->format('H:i');
        $data = new  Attendance();
        $data->reference = $code;
        $data->attendance_date = Carbon::now()->format('Y-m-d');
        $data->user_id = Auth::id();
        $data->in_time = $in_time;
        $data->added_by = Auth::id();
        $data->save();
        return redirect()->back()->with(saveMessage("Work hour has been started successfully!"));
        
    }

    /**
     * Check out attendance
     */
    public function outAttendance(){
        $data = Attendance::where('user_id',Auth::id())
            ->whereNull('out_time')->first();

        $current_time = Carbon::now();  
        $data->out_time = date('H:i',strtotime($current_time));
        $duration = getTotalHour(date('H:i:s',strtotime($data->out_time)),date('H:i:s',strtotime($data->in_time)));
        $data->work_hour = $duration;
        $data->save();
        return redirect()->back()->with(saveMessage("Work hour end successfully!"));
        
    }

    /**
     * Get duration from two time
     */
    public function getDuration($end_time, $start_time) {
        $diff = abs(strtotime($end_time) - strtotime($start_time));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
        $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
        $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
        return $hours.'.'.$minutes.'.'.$seconds;
    }

    /**
     * Get total hour
     */
    function getTotalHour($out_time,$in_time){
        $time1 = $out_time;
        $time2 = $in_time;
        $array1 = explode(':', $time1);
        $array2 = explode(':', $time2);
    
        $minutes1 = ($array1[0] * 60.0 + $array1[1]);
        $minutes2 = ($array2[0] * 60.0 + $array2[1]);
    
        $total_min = $minutes1 - $minutes2;
        $total_tmp_hour = (int)($total_min/60);
        $total_tmp_hour_minus = ($total_min%60);
        return $total_tmp_hour.".".$this->get_numb_with_zero($total_tmp_hour_minus);
    
    }
    
    /**
     * Function to get number with zero
     */
    function get_numb_with_zero($number){
        $numb = str_pad($number, 2, '0', STR_PAD_LEFT);
        return $numb;
    }
}
