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
  # This is Holiday Setting Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\HolidaySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidaySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = __('index.holiday_list');
        $holidays = HolidaySetting::oldest('id')->get();
        return view('vacation.holiday_list',compact('title','holidays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('index.add_holiday');
        $route = route('holiday-setting.store');
        $days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
        return view('vacation.holiday_add_edit',compact('title','days','route'));
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
            'day' => 'required|max:10',
            'start_time' => 'required',
            'end_time' => 'required',
            'mail_subject' => 'required_if:auto_response,==,on|max:191',
            'mail_body' => 'required_if:auto_response,==,on',
        ],[
            'day.required' => __('index.day_required'),
            'day.max' => __('index.day_max_10'),
            'start_time.required' => __('index.start_time_required'),
            'end_time.required' => __('index.end_time.required'),
            'mail_subject.required_if' => __('index.mail_subject_required'),
            'mail_subject.max' => __('index.mail_subject_max_191'),
            'mail_body.required_if' => __('index.mail_body_required'),
        ]);
        $holiday = new HolidaySetting();
        $holiday->day = $request->day;
        $holiday->start_time = $request->start_time;
        $holiday->end_time = $request->end_time;
        $holiday->auto_response = $request->auto_response ?? "off";
        $holiday->mail_subject = getPlainText($request->mail_subject);
        $holiday->mail_body = $request->mail_body;
        $holiday->save();
        return redirect()->route('holiday-setting.index')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = __('index.edit_holiday');
        $data = HolidaySetting::findOrFail(encrypt_decrypt($id,'decrypt'));
        $route = route('holiday-setting.update',$id);
        $days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
        return view('vacation.holiday_add_edit',compact('title','days','route','data'));

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
            'day' => 'required|max:10',
            'start_time' => 'required',
            'end_time' => 'required',
            'mail_subject' => 'required_if:auto_response,==,on|max:191',
            'mail_body' => 'required_if:auto_response,==,on',
        ],[
            'day.required' => __('index.day_required'),
            'day.max' => __('index.day_max_10'),
            'start_time.required' => __('index.start_time_required'),
            'end_time.required' => __('index.end_time.required'),
            'mail_subject.required_if' => __('index.mail_subject_required'),
            'mail_subject.max' => __('index.mail_subject_max_191'),
            'mail_body.required_if' => __('index.mail_body_required'),
        ]);
        $holiday = HolidaySetting::findOrFail(encrypt_decrypt($id,'decrypt'));
        $holiday->day = $request->day;
        $holiday->start_time = $request->start_time;
        $holiday->end_time = $request->end_time;
        $holiday->auto_response = $request->auto_response ?? "off";
        $holiday->mail_subject = getPlainText($request->mail_subject);
        $holiday->mail_body = $request->mail_body;
        $holiday->save();;
        return redirect()->route('holiday-setting.index')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HolidaySetting::findOrFail(encrypt_decrypt($id,'decrypt'))->delete();
        return redirect()->route('holiday-setting.index')->with(saveMessage("Information has been deleted successfully !"));
    }
}
