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
  # This is Canned Message Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\CannedMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CannedMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj = CannedMessage::live()->oldest()->get();
        return view('canned-msg.index', compact('obj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('canned-msg.addEditCannedMsg');
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
            'title' => 'required|string|max:100',
            'canned_msg_content' => 'required',
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max_100'),
            'canned_msg_content.required' => __('index.content_required'),
        ]);

        $obj = new CannedMessage();
        $obj->title = getPlainText($request->title);
        $obj->canned_msg_slug = Str::slug($request->title);
        $obj->canned_msg_content = $request->canned_msg_content;

        if ($obj->save()){
            return redirect('canned-message')->with(saveMessage());
        }else{
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = CannedMessage::find($id);
        return view('canned-msg.view', compact('obj'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = CannedMessage::find($id);
        return view('canned-msg.addEditCannedMsg', compact('obj'));
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
            'title' => 'required|string|max:100',
            'canned_msg_content' => 'required',
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max_100'),
            'canned_msg_content.required' => __('index.content_required'),
        ]);

        $id = encrypt_decrypt($id, 'decrypt');
        $obj = CannedMessage::find($id);
        $obj->title = getPlainText($request->title);
        $obj->canned_msg_slug = Str::slug($request->title);
        $obj->canned_msg_content = $request->canned_msg_content;

        if ($obj->save()){
            return redirect('canned-message')->with(updateMessage());
        }else{
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = CannedMessage::find($id);
        $obj->del_status = "Deleted";
        $obj->save();
        return redirect('canned-message')->with(deleteMessage());
    }
}
