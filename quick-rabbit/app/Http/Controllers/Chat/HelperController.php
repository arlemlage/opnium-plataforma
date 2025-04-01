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
  # This is Chat Helper Controller
  ##############################################################################
 */

namespace App\Http\Controllers\Chat;

use App\Events\AdminNotification;
use App\Events\AgentNotification;
use App\Http\Controllers\Controller;
use App\Model\ChatGroup;
use App\Model\ChatGroupMember;
use App\Model\ChatProduct;
use App\Model\ChatProductSequence;
use App\Model\ProductCategory;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelperController extends Controller
{
    /**
     * Check envato product
     */
    public function checkEnvatoProduct($product_id) {
        if (!empty($product_id)){
            return ProductCategory::find($product_id)->verification;
        }
    }

    /**
     * Create a new group
     */
    public function createGroupOld(Request $request) {
        $group = new ChatGroup();
        $group->created_by = Auth::id();
        $group->product_id = $request->product_id;
        $group_code = ChatGroup::getGroupCode();
        if(ChatGroup::where('code',$group_code)->exists()){
            $group_code = ChatGroup::getGroupCode();
        }
        $group->code = $group_code;
        $group->name = Auth::user()->full_name.' - '.ProductCategory::find($request->product_id)->title.' - '.$group_code;
        $group->status = "Active";
        $group->save();
        $get_assigned_agents = User::live()->whereRaw('FIND_IN_SET('."$request->product_id".', product_cat_ids)')
            ->orWhereNull('product_cat_ids')->pluck('id')->toArray();
        array_push($get_assigned_agents,Auth::id());
        foreach ($get_assigned_agents as $user) {
            $group_member = new ChatGroupMember();
            $group_member->group_id = $group->id;
            $group_member->user_id = $user;
            $group_member->save();
        }

        //used as chat product, not used
        if(isset($chat_product)) {
            $chat_seq = ChatProductSequence::where('chat_product_id',$chat_product->id)->orderBy('sort_id','asc')->first()->agent_id;
            if(isset($chat_seq)) {
                $group_members = [];
                array_push($group_members,$chat_seq);
                array_push($group_members,Auth::id());
            }
        }

        return redirect()->to('customer/live-chat');
    }

    /**
     * Create a new group by customer
     */
    public function createGroup(Request $request) {
        $group = new ChatGroup();
        $group->created_by = Auth::id();
        $group->product_id = $request->product_id;
        $group_code = ChatGroup::getGroupCode();
        if(ChatGroup::where('code',$group_code)->exists()){
            $group_code = ChatGroup::getGroupCode();
        }
        $group->code = $group_code;
        $group->name = ProductCategory::find($request->product_id)->title.'-'.Auth::user()->full_name;
        $group->status = "Active";
        $group->save();

        $group_members = [];
        $agent_id = '';
        if(ProductCategory::where('id',$request->product_id)->whereNotNull('first_chat_agent_id')->exists()) {
            $agent_id = ProductCategory::find($request->product_id)->first_chat_agent_id;
        } else {
            $agent_id = adminId();
        }
        array_push($group_members,$agent_id);
        if(authUserRole() == 3) {
            array_push($group_members,Auth::id());
        }
        foreach ($group_members as $user) {
            $group_member = new ChatGroupMember();
            $group_member->group_id = $group->id;
            $group_member->user_id = $user;
            $group_member->save(); 
        }
        return redirect()->to('/live-chat');
    }
}
