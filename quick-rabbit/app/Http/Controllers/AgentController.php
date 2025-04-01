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
  # This is Agent Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Model\Role;
use App\Model\User;
use App\Model\Ticket;
use App\Model\Department;
use App\Model\SiteSetting;
use Illuminate\Http\Request;
use App\Model\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $obj = User::query()->where('del_status', 'Live')->where('role_id', 2);
        if(appTheme() == 'single'){
            $productId = ProductCategory::where('del_status', 'Live')->where('type', 'single')->first()->id;
            $obj->whereRaw("FIND_IN_SET($productId, product_cat_ids)");
        }else{
            $productId = ProductCategory::where('del_status', 'Live')->where('type', 'multiple')->pluck('id')->toArray();
            $obj->whereIn('product_cat_ids', $productId);

        }
        $obj->orderBy('id','DESC');
        $obj = $obj->get();
        return view('agent.index', compact('obj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_category = ProductCategory::where('del_status', 'Live')->type()->pluck('title', 'id');
        $departments = Department::live()->get();
        $roles = Role::orderBy('title')->get();
        return view('agent.addEditAgent', compact('product_category', 'departments','roles'));
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
            'permission_role' => 'required',
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'email' => 'required|email|max:50|unique:tbl_users',
            'mobile' => 'required|unique:tbl_users|max:20',
            'status' => 'required',
        ],[
            'permission_role.required' => __('index.permission_role_required'),
            'first_name.required' => __('index.first_name_required'),
            'first_name.max' => __('index.first_name_max_191'),
            'last_name.required' => __('index.last_name_required'),
            'last_name.max' => __('index.last_name_max_191'),
            'email.required' => __('index.email_required'),
            'email.email' => __('index.email.email'),
            'email.max' => __('index.email_max_50'),
            'email.unique' => __('index.email.unique'),
            'mobile.required' => __('index.mobile_required'),
            'mobile.max' => __('index.mobile_max_20'),
            'mobile.unique' => __('index.mobile.unique'),
            'status.required' => __('index.status_required'),
        ]);


        if(empty($request->product_cat_ids)){
            $product_cat_ids = null;
        }else if(is_array($request->product_cat_ids) && count($request->product_cat_ids) > 0){
            $product_cat_ids = implode(',', $request->product_cat_ids);
        }else{
            $product_cat_ids = $request->product_cat_ids;
        }

        $generated_password = substr(md5(uniqid(random_int(0, 50), true)), 0, 6);
        $site_setting_info = SiteSetting::first();
        $obj = new User();
        $obj->setting_id = !empty($site_setting_info)? $site_setting_info->id:1;
        $obj->role_id = 2;
        $obj->type = 'Agent';
        $obj->first_name = $request->first_name;
        $obj->last_name = $request->last_name;
        $obj->email = $request->email;
        $obj->mobile = $request->mobile;
        $obj->product_cat_ids = $product_cat_ids;
        $obj->department_id = empty($request->department_id)? null:$request->department_id;
        $obj->signature = $request->signature;
        $obj->password = Hash::make($generated_password);
        $obj->need_change_password = true;
        $obj->plain_password = $generated_password;
        $obj->permission_role = $request->permission_role;
        $obj->status = !empty($request->status)? $request->status:null;
        $obj->created_by = Auth::user()->id;

        if(!empty($request->image_url)) {
            $obj->image = bas64ToImage($request->image_url,'user_photos/');
        }

        if ($obj->save()){
            $to_email = [$request->email];
            if (!empty($to_email)){
                $mail_data = [
                    'to' => $to_email,
                    'subject' => 'Welcome to '.$site_setting_info->title ?? "TicketHive",
                    'user_name' => $obj->full_name,
                    'body' => 'Your login credentials have been given below. Please login into your account and change your password.',
                    'email' => $obj->email,
                    'password' => $generated_password,
                    'login_url' => route('agent.login'),
                    'view' => 'create-new-customer-mail',
                ];
                MailSendController::sendMailToUser($mail_data);
            }
            return redirect('agent')->with(saveMessage());
        }else{
           return redirect()->back()->with(waringMessage());
        }
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
        $obj = User::find($id);
        $product_category = ProductCategory::where('del_status', 'Live')->type()->pluck('title', 'id');
        $departments = Department::live()->get();
        $roles = Role::orderBy('title','asc')->get();
        
        return view('agent.addEditAgent', compact('product_category', 'departments', 'obj','roles'));
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
            'permission_role' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'status' => 'required',
        ],[
            'permission_role.required' => __('index.permission_role_required'),
            'first_name.required' => __('index.first_name_required'),
            'last_name.required' => __('index.last_name_required'),
            'email.required' => __('index.email_required'),
            'email.email' => __('index.email.email'),
            'mobile.required' => __('index.mobile_required'),
            'status.required' => __('index.status_required'),
        ]);

        $site_setting_info = SiteSetting::first();
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = User::find($id);
        if(empty($request->product_cat_ids)){
            $product_cat_ids = null;
        }else if(is_array($request->product_cat_ids) && count($request->product_cat_ids) > 0){
            $product_cat_ids = implode(',', $request->product_cat_ids);
        }else{
            $product_cat_ids = $request->product_cat_ids;
        }
        if(isset($request->product_cat_ids) && is_array($request->product_cat_ids) && count($request->product_cat_ids)) {
            $from_assigned_ticket_ids = DB::table('tbl_tickets')->where('del_status','LIVE')->whereRaw('FIND_IN_SET("'.$obj->id.'", tbl_tickets.assign_to_ids)')->whereNotIn('product_category_id',$request->product_cat_ids)->pluck('id')->toArray();
            foreach($from_assigned_ticket_ids as $ticket_id) {
                $ticket_info = Ticket::where('id',$ticket_id)->first();
                if($ticket_info->assign_to_ids) {
                    $agent_ids =  explode(',',$ticket_info->assign_to_ids);
                    if (($key = array_search($obj->id, $agent_ids)) !== false) {
                        unset($agent_ids[$key]);
                    }
                   $ticket_info->assign_to_ids  = implode(',',$agent_ids);
                   $ticket_info->save();
                } 
            }
            // Assigned if not exists
            $assigned_ticket_ids = DB::table('tbl_tickets')->where('del_status','LIVE')->whereIn('product_category_id',$request->product_cat_ids)->pluck('id')->toArray();
            foreach($assigned_ticket_ids as $ticket_id) {
                $ticket_info = Ticket::where('id',$ticket_id)->first();
                    $agent_ids =  explode(',',$ticket_info->assign_to_ids);
                    if (! in_array($obj->id,$agent_ids)) {
                        array_push($agent_ids,$obj->id);
                    }
                   $ticket_info->assign_to_ids  = implode(',',$agent_ids);
                   $ticket_info->save();
                
            }
        } else {
            foreach(Ticket::live()->select('id')->get() as $ticket) {
                $ticket_info = Ticket::where('id',$ticket->id)->first();
                if(!empty($ticket_info->assign_to_ids)) {
                    $agent_ids =  explode(',',$ticket_info->assign_to_ids);
                } else {
                    $agent_ids = [];
                }
                if (! in_array($obj->id,$agent_ids)) {
                    array_push($agent_ids,$obj->id);
                }
                $new_ids = implode(',',$agent_ids);
                $ticket_info->assign_to_ids  = isset($new_ids) ? $new_ids : Null;
                $ticket_info->save();
            }
        }

        $obj->setting_id = !empty($site_setting_info)? $site_setting_info->id:1;
        $obj->role_id = 2;
        $obj->type = 'Agent';
        $obj->first_name = $request->first_name;
        $obj->last_name = $request->last_name;
       
        $obj->product_cat_ids = $product_cat_ids;
        $obj->department_id = empty($request->department_id)? null:$request->department_id;
        $obj->signature = $request->signature;
        $obj->permission_role = $request->permission_role;
        $obj->status = !empty($request->status)? $request->status:null;
        $obj->created_by = Auth::user()->id;

        if($request->email !== $obj->email) {
            if(User::where('email',$request->email)->exists()) {
                return redirect()->back()->with([
                    'email_error'=> __('index.email.unique'),
                    'email' => $request->email
                ]);
            } else {
                $obj->update(array('email' => $request->email));
                User::sendVerificationEmail($request->email);
                $obj->is_email_verified = 0;
            }
        }
        if($request->mobile !== $obj->mobile) {
            if(User::where('mobile',$request->mobile)->exists()) {
                return redirect()->back()->with([
                    'mobile_error'=> __('index.mobile.unique'),
                    'mobile' => $request->mobile
                ]);
            } else {
                $obj->update(array('mobile' => $request->mobile));
            }
        }

        if(!empty($request->image_url)) {
            $obj->image = bas64ToImage($request->image_url,'user_photos/');
        }

        if ($obj->save()){
            return redirect('agent')->with(updateMessage());
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
        $obj = User::find($id);
        $obj->del_status = "Deleted";
        $obj->email = $obj->email.'-deleted';
        $obj->save();
        $obj->delete();
        return redirect('agent')->with(deleteMessage());
    }
}
