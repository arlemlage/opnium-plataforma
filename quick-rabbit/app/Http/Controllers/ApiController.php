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
  # This is API Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Model\AdminNotification;
use App\Model\AgentNotification;
use App\Model\CustomerNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class ApiController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),['email'=>'required|email','password'=>'required'],
            [
                'email.required' => __('index.email_required'),
                'email.email' => __('index.valid_email.email'),
                'password.required' => __('index.password_required')
            ]);
        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ]);
        }
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $token =  $user->createToken('MyApiToken')->plainTextToken; 
            $user->api_token = $token;
            $user->save();
            return response()->json(array('code' => 200,'message' => "Login Successfull",'token' => $token));
        } else{ 
            return response()->json(array('code' => 401,'message' => "Unauthorised"));
        } 
    }

    /**
     * Get auth user information
     */
    public function userInformation() {
        if(Auth::check()) {
            return response()->json(array('code' => 200,'data' => Auth::user()));
        } else {
            return response()->json(array('code' => 401,'message' => 'Unauthorised'));
        }
    }

    /**
     * Get all notification
     */
    public function getAllNotification() {
        $perPage = 10; 
        $page = request()->get('page', 1);
        if(authUserRole() == 1) {
            $data = AdminNotification::query();
            $data->live();
            $data->latest('id');
            $data->select('id','type','message','redirect_link','mark_as_read_status','del_status');
            $all_notification_info = $data->paginate($perPage, ['*'], 'page', $page);
        } elseif (authUserRole() == 2) {
            $data = AgentNotification::query();
            $data->live();
            $data->where('agent_for',auth()->user()->id);
            $data->latest('id');
            $all_notification_info = $data->paginate($perPage, ['*'], 'page', $page);
        } elseif (authUserRole() == 3) {
            $data = CustomerNotification::where('customer_for',auth()->user()->id);
            $data->live();
            $data->latest('id');
            $all_notification_info = $data->paginate($perPage, ['*'], 'page', $page);
        }
        return $all_notification_info;
    }

    /**
     * All notification mark as read
     */
    public function makrAsReadAll(){
        if(authUserRole() == 1) {
            AdminNotification::query()->update(array('mark_as_read_status' => 1));
        } elseif(authUserRole() == 2) {
            AgentNotification::where('agent_for',authUserId())->update(array('mark_as_read_status' => 1));
        } elseif (authUserRole() == 3) {
            CustomerNotification::where('customer_for',authUserId())->update(array('mark_as_read_status' => 1));
        }
        return response()->json(['status' => true,'Information has been updated successfully!']);
    }

    /**
     * Delete all notification
     */
    public function deleteAll() {
        if(authUserRole() == 1) {
            AdminNotification::query()->update(array('del_status' => 'DELETED'));
        } elseif(authUserRole() == 2) {
            AgentNotification::where('agent_for',authUserId())->update(array('del_status' => 'DELETED'));
        } elseif (authUserRole() == 3) {
            CustomerNotification::where('customer_for',authUserId())->update(array('del_status' => 'DELETED'));
        }
        return response()->json(['status' => true,'Information has been deleted successfully!']);
    }

    /**
     * @param  int  $id
     * Notification marks as read single item
     */
    public function markAsRead($id){
        if(authUserRole() == 1) {
            AdminNotification::find($id)->update(array('mark_as_read_status' => 1));
        } elseif(authUserRole() == 2) {
            AgentNotification::find($id)->update(array('mark_as_read_status' => 1));
        } elseif (authUserRole() == 3) {
            CustomerNotification::find($id)->update(array('mark_as_read_status' => 1));
        }
        return response()->json(['status' => true,'Information has been updated successfully!']);
    }

    /**
     * @param  int  $id
     * Notification marks as read single item
     */
    public function deleteNotification($id){
        if(authUserRole() == 1) {
            AdminNotification::find($id)->update(array('del_status' => 'DELETED'));
        } elseif(authUserRole() == 2) {
            AgentNotification::find($id)->update(array('del_status' => 'DELETED'));
        } elseif (authUserRole() == 3) {
            CustomerNotification::find($id)->update(array('del_status' => 'DELETED'));
        }
        return response()->json(['status' => true,'Information has been deleted successfully!']);
    }
}
