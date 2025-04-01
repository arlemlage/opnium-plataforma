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
  # This is Notice Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Notice;
use App\Model\Notification;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Notice::query();
        $results = $data->oldest()->get();
        return view('notice.notice_list',compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notice.notice_add_edit');
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
            'title' => 'required|max:191',
            'start_date' => 'required',
            'end_date' => 'required',
            'notice' => 'required|max:150'
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title.max_191'),
            'start_date.required' => __('index.start_date_required'),
            'end_date.required' => __('index.end_date_required'),
            'notice.required' => __('index.notice_required')
        ]);

        $row = new Notice();
        $row->title = $request->title;
        $row->start_date = $request->start_date;
        $row->end_date = $request->end_date;
        $row->notice = $request->notice;
        $row->save();
        return redirect()->route('notices.index')->with(saveMessage());
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Notice::findOrFail(encrypt_decrypt($id,'decrypt'));
        return view('notice.notice_add_edit',compact('data'));
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
            'title' => 'required|max:191',
            'start_date' => 'required',
            'end_date' => 'required',
            'notice' => 'required|max:250'
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title.max_191'),
            'start_date.required' => __('index.start_date_required'),
            'end_date.required' => __('index.end_date_required'),
            'notice.required' => __('index.notice_required')
        ]);
        $row = Notice::findOrFail(encrypt_decrypt($id,'decrypt'));
        $row->title = $request->title;
        $row->start_date = $request->start_date;
        $row->end_date = $request->end_date;
        $row->notice = $request->notice;
        $row->save();
        return redirect()->route('notices.index')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notice::findOrFail(encrypt_decrypt($id,'decrypt'))->delete();
        return redirect()->route('notices.index')->with(deleteMessage());
    }
}
