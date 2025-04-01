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
  # This is Task Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Task;
use App\Model\Ticket;
use App\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = __('index.task_list');
        $tasks = Task::live()->oldest()->get();
        return view('task.task_list',compact('title','tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('index.add_task');
        $agents = User::live()->where('role_id',2)->get();
        $tickets = Ticket::where('status','!=',2)->select('id','ticket_no','title')->get();
        $route = route('task-lists.store');
        return view('task.task_add_edit',compact('agents','tickets','title','route'));
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
           'task_title' => 'required|max:191',
           'work_date' => 'required',
           'description' => 'required|max:2000',
           'file' => 'max:5120',
           'status' => 'required'
        ], [
           'task_title.required' => __('index.title_required'),
           'task_title.max' => __('index.title.max_191'),
           'work_date.required' => __('index.date_required'),
           'file.max' => __('index.file_size_required'),
           'description.required' => __('index.description_required'),
           'status.required' => __('index.status_required'),
        ]);
        $row = new Task();
        $row->task_title = $request->task_title;
        $row->ticket_id =  !empty($request->ticket_id) ? $request->ticket_id : Null;
        $row->assigned_person = !empty($request->assigned_person) ?$request->assigned_person : Auth::id();
        $row->work_date = date('Y-m-d',strtotime($request->work_date));
        $row->status = $request->status ?? "Pending";
        $row->description = $request->description;
        if($request->file('file')) {
            $name = Str::slug($request->task_name);
            $row->file = uploadFile($request->file('file'),'tasks/',$name);
        }
        $row->save();
        return redirect()->route('task-lists.index')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = __('index.edit_task');
        $agents = User::live()->where('role_id',2)->get();
        $tickets = Ticket::where('status','!=',2)->select('id','title')->get();
        $data = Task::findOrFail(encrypt_decrypt($id,'decrypt'));
        $route = route('task-lists.update',$id);
        return view('task.task_add_edit',compact('agents','tickets','title','route','data'));
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
            'task_title' => 'required|max:191',
            'work_date' => 'required',
            'description' => 'required|max:2000',
            'file' => 'max:5120',
            'status' => 'required'
         ], [
            'task_title.required' => __('index.title_required'),
            'task_title.max' => __('index.title.max_191'),
            'work_date.required' => __('index.date_required'),
            'description.required' => __('index.description_required'),
            'file.max' => __('index.file_size_required'),
            'status.required' => __('index.status_required'),
         ]);
        $row = Task::findOrFail(encrypt_decrypt($id,'decrypt'));
        $row->task_title = $request->task_title;
        $row->ticket_id =  !empty($request->ticket_id) ? $request->ticket_id : Null;
        $row->assigned_person = !empty($request->assigned_person) ?$request->assigned_person : Auth::id();
        $row->work_date = date('Y-m-d',strtotime($request->work_date));
        $row->status = $request->status ?? "Pending";
        $row->description = $request->description;
        if($request->file('file')) {
            $name = Str::slug($request->task_name);
            $row->file = uploadFile($request->file('file'),'task/',$name);
        }
        $row->save();
        return redirect()->route('task-lists.index')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::findOrFail(encrypt_decrypt($id,'decrypt'))->update(['del_status'=>'DELETED']);
        return redirect()->route('task-lists.index')->with(updateMessage("Information has been deleted successfully !"));
    }

    /**
     * Task calendar view
     */
    public function taskCalendr() {
        return view('task.task_calendar');
    }

    /**
     * Update task status
     */
    public function updateTaskStatus(Request $request, $task_id) {
        if($request->status == "Done") {
           Task::findOrFail($task_id)->update([
               'status' => $request->status,
               'done_date' =>  Carbon::now(),
               'updated_at' => Carbon::now(),
           ]);
        } else {
            Task::findOrFail($task_id)->update([
                'status' => $request->status,
                'done_date' => Null,
                'updated_at' => Carbon::now(),
            ]);
        }

        $route = route('task-calendar');
        return $route;
    }
}
