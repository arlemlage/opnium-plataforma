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
  # This is Vacation Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Model\HolidaySetting;
use App\Model\ProductCategory;
use App\Model\Vacation;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VacationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj = Vacation::live()->orderBy('id', 'DESC')->get();
        return view('vacation.index', compact('obj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vacation.addEditVacation');
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
            'title' => 'required|string|max:191',
            'start_date' => 'required',
            'end_date' => 'required',
            'mail_subject' => 'required_if:auto_response,==,on|max:191',
            'mail_body' => 'required_if:auto_response,==,on',
        ],[
            'title.required' => __("index.title_required"),
            'title.max' => __('index.title.max_191'),
            'start_date.required' => __('index.start_date_required'),
            'end_date.required' => __('index.end_date_field_required'),
            'mail_subject.required_if' => __('index.mail_subject_required'),
            'mail_subject.max' => __('index.mail_subject_max_191'),
            'mail_body.required_if' => __('index.mail_body_required'),
        ]);

        $obj = new Vacation();
        $obj->title = getPlainText($request->title);
        $obj->start_date = date("Y-m-d",strtotime($request->start_date));
        $obj->end_date = date("Y-m-d",strtotime($request->end_date));
        $obj->auto_response = $request->auto_response ?? "off";
        $obj->mail_subject = getPlainText($request->mail_subject) ?? Null;
        $obj->mail_body = $request->mail_body ?? Null;
        if ($obj->save()){
            return redirect('vacations')->with(saveMessage());
        }else{
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $obj = Vacation::findOrFail(encrypt_decrypt($id,'decrypt'));
        return view('vacation.addEditVacation', compact('obj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'start_date' => 'required',
            'end_date' => 'required',
            'mail_subject' => 'required_if:auto_response,==,on|max:191',
            'mail_body' => 'required_if:auto_response,==,on',
        ],[
            'title.required' => __("index.title_required"),
            'title.max' => __('index.title.max_191'),
            'start_date.required' => __('index.start_date_required'),
            'end_date.required' => __('index.end_date_field_required'),
            'mail_subject.required_if' => __('index.mail_subject_required'),
            'mail_subject.max' => __('index.mail_subject_max_191'),
            'mail_body.required_if' => __('index.mail_body_required'),
        ]);

        $obj = Vacation::findOrFail(encrypt_decrypt($id,'decrypt'));
        $obj->title = getPlainText($request->title);
        $obj->start_date = date("Y-m-d",strtotime($request->start_date));
        $obj->end_date = date("Y-m-d",strtotime($request->end_date));
        $obj->auto_response = $request->auto_response ?? "off";
        $obj->mail_subject = getPlainText($request->mail_subject) ?? Null;
        $obj->mail_body = $request->mail_body ?? Null;
        if ($obj->save()){
            return redirect('vacations')->with(updateMessage());
        }else{
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obj = Vacation::findOrFail(encrypt_decrypt($id,'decrypt'));
        $obj->del_status = "DELETED";
        $obj->save();
        return redirect()->route('vacations.index')->with(deleteMessage());
    }
}
