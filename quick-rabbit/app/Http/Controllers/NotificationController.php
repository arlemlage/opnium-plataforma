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
  # This is Notification Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Model\AdminNotification;
use App\Http\Controllers\Controller;
use App\Model\AgentNotification;
use App\Model\CustomerNotification;
use App\Model\Notification;
use App\Model\Ticket;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * All notification
     */
    public function index(){
        $page = request()->get('page', 1); // Get the page number from the request
        $label = request()->get('label');
        $perPage = 10 * $page; // Number of records per page
        if(authUserRole() == 1) {
            $data = AdminNotification::query();
            $data->live();
            $data->latest('id');
            if($label == 1){
                $data->unread();
            }
            $all_notification_info = $data->take($perPage)->get();
        } elseif (authUserRole() == 2) {
            $data = AgentNotification::query();
            $data->live();
            $data->where('agent_for',auth()->user()->id);
            $data->latest('id');
            if($label == 1){
                $data->unread();
            }
            $all_notification_info = $data->take($perPage)->get();
        } elseif (authUserRole() == 3) {
            $data = CustomerNotification::where('customer_for',auth()->user()->id);
            $data->live();
            $data->latest('id');
            if($label == 1){
                $data->unread();
            }
            $all_notification_info = $data->take($perPage)->get();
        }
        return ['data' => $all_notification_info];
    }

    /**
     * All notification for ajax call
     */
    public function allNotification() {
        if(authUserRole() == 1) {
            $data = AdminNotification::query();
            $data->live();
            $data->latest('id');
            $results = $data->get();
        } elseif (authUserRole() == 2) {
            $data = AgentNotification::query();
            $data->live();
            $data->where('agent_for',Auth::id());
            $data->latest('id');
            $results = $data->get();
        } elseif (authUserRole() == 3) {
            $data = CustomerNotification::query();
            $data->live();
            $data->where('customer_for',Auth::id());
            $data->latest('id');
            $results = $data->get();
        }
        return view('notification.all_notification',compact('results'));
    }

    /**
     * Delete notification by id
     */
    public function destroy($id){
        if(! request()->ajax()) {
            $id = encrypt_decrypt($id, 'decrypt');
        } 
        if(authUserRole() == 1) {
            AdminNotification::where('id',$id)->update(array('del_status' => 'DELETED'));
        } elseif(authUserRole() == 2) {
            AgentNotification::where('id',$id)->update(array('del_status' => 'DELETED'));
        } elseif (authUserRole() == 3) {
            CustomerNotification::where('id',$id)->update(array('del_status' => 'DELETED'));
        }
        if(request()->ajax()){
            return response()->json(array('status' => true,'unread_count' => showTotalNotification()));
        } else {
            return redirect()->back()->with(deleteMessage());
        }
        
    }

    /**
     * Notification marks as read single item
     */
    public function markAsRead($id){
        if(! request()->ajax()) {
            $id = encrypt_decrypt($id, 'decrypt');
        } 
        if(authUserRole() == 1) {
            AdminNotification::find($id)->update(array('mark_as_read_status' => 1));
        } elseif(authUserRole() == 2) {
            AgentNotification::find($id)->update(array('mark_as_read_status' => 1));
        } elseif (authUserRole() == 3) {
            CustomerNotification::find($id)->update(array('mark_as_read_status' => 1));
        }
        if(request()->ajax()){
            return response()->json(array('status' => true));
        } else {
            return redirect()->back()->with(updateMessage());
        }
        
    }
    

    /**
     * Get authenticate user info
     */
    public function getAuthenticatedUser(){
        $user_info = Auth::user();
        return response()->json([
            'user_id' => $user_info->id,
            'type' => $user_info->type,
            'browser_notification' => $user_info->browser_notification ?? false,
            'chat_sound' => $user_info->chat_sound ?? true
        ]);
    }

    /**
     * Get notification info
     */
    public function getNotificationInfo($id){
        return Notification::select('id', 'for', 'agent_ids', 'customer_ids', 'message')->find($id);
    }

    /**
     * Allow browser push notification
     */
    public function allowBrowserNotification() {
        $user = Auth::user();
        $user->browser_notification = true;
        $user->save();
        return response()->json(['status' => true]);
    }

    /**
     * Store browser token
     */
    public function storeToken(Request $request)
    {
        $user = Auth::user();
        $user->device_key = $request->token;
        if($user->save()) {
            return response()->json(['Token successfully stored.']);
        } else {
            return response()->json(['Token not stored.']);
        }
        
    }

    /**
     * Send browser push notification
     */
    public function webNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send'; // for firebase connection we used the googleleapis.
        $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();

        $serverKey = firebaseInfo()['server_key'];

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        dd($result);
    }

    /**
     * All notification mark as read
     */
    public function makrAsReadAll(Request $request){
        $ids = $request->notification_ids;
        if(authUserRole() == 1) {
            if(isset($ids)) {
                AdminNotification::whereIn('id',$ids)->update(array('mark_as_read_status' => 1)); 
            } else {
                AdminNotification::query()->update(array('mark_as_read_status' => 1));
            }
        } elseif(authUserRole() == 2) {
            if(isset($ids)) {
                AgentNotification::whereIn('id',$ids)->update(array('mark_as_read_status' => 1));
            } else {
                AgentNotification::where('agent_for',authUserId())->update(array('mark_as_read_status' => 1));
            }
        } elseif (authUserRole() == 3) {
            if(isset($ids)) {
                CustomerNotification::whereIn('id',$ids)->update(array('mark_as_read_status' => 1));
            } else {
                CustomerNotification::where('customer_for',authUserId())->update(array('mark_as_read_status' => 1));
            }
        }
        return response()->json(['status' => true]);
    }

    /**
     * Delete all notification
     */
    public function deleteAll(Request $request) {
        $ids = $request->notification_ids;
        if(authUserRole() == 1) {
            if(isset($ids) && !empty($ids)) {
                AdminNotification::whereIn('id',$ids)->update(array('del_status' => 'DELETED'));
            } else {
                AdminNotification::query()->update(array('del_status' => 'DELETED'));
            }
        } elseif(authUserRole() == 2) {
            if(isset($ids) && !empty($ids)) {
                AgentNotification::whereIn('id',$ids)->update(array('del_status' => 'DELETED'));
            } else {
                AgentNotification::where('agent_for',authUserId())->update(array('del_status' => 'DELETED'));
            }
        } elseif (authUserRole() == 3) {
            if(isset($ids) && !empty($ids)) {
                CustomerNotification::whereIn('id',$ids)->update(array('del_status' => 'DELETED'));
            } else {
                CustomerNotification::where('customer_for',authUserId())->update(array('del_status' => 'DELETED'));
            }
        }
        return response()->json(['status' => true]);
    }

}
