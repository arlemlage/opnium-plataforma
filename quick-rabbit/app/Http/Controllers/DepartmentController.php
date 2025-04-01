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
  # This is Department Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Department;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj = Department::orderBy('id','DESC')->where('del_status',"Live")->get();
        return view('setting.department_list',compact('obj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setting.department_add_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,['name' => 'required|max:50','leader' => 'required|max:50','description' => 'max:50'],[
            'name.required' => __('index.name_required'),
            'leader.required' => __('index.leader_required'),
        ]);
        $obj = new \App\Model\Department;
        $obj->name = htmlspecialchars($request->get('name'));
        $obj->leader = $request->leader;
        $obj->description = htmlspecialchars($request->get('description'));
        $obj->save();
        return redirect('departments')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $obj = Department::find(encrypt_decrypt($id, 'decrypt'));
        return view('setting.department_add_edit',compact('obj'));
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
        $this->validate($request,['name' => 'required|max:50','leader' => 'required|max:50','description' => 'max:50'],[
            'name.required' => __('index.name_required'),
            'leader.required' => __('index.leader_required'),
        ]);
        $obj = Department::find($id);
        $obj->name = htmlspecialchars($request->get('name'));
        $obj->leader = $request->leader;
        $obj->description = htmlspecialchars($request->get('description'));
        $obj->save();
        return redirect('departments')->with(updateMessage());
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
        $obj = Department::find($id);
        $obj->del_status = "Deleted";
        $obj->save();
        return redirect('departments')->with(deleteMessage());
    }
}
