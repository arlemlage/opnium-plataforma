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
  # This is Chat Group Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatGroup extends Model
{
    protected $table = "tbl_chat_groups";
    protected $guarded = [];
    protected $appends = array('last_message','pair_key','image','members','agent_online');

    /**
     * Get last message attribute to append
     */
     public function getLastMessageAttribute() {
        $message = GroupChatMessage::where('group_id',$this->id)->where('user_type','!=','forward')->orderBy('created_at','desc')->first();
        $last_message = [];
        $last_message['message'] = '';
        $last_message['seen_status'] = '';
        $last_message['from_id'] = '';
        if(isset($message)) {
            if($message->is_file) {
                return "An attachment";
            } else {
                $last_message['message'] = $message->message;
                $last_message['seen_status'] = $message->seen_status;
                $last_message['from_id'] = $message->from_id;
                return $last_message;
            }
        } else {
            return $last_message = [];
        }
    }

    /**
     * Get pair key attribute to append
     */
    public function getPairKeyAttribute() {
        return Auth::id().'_'.$this->id;
    }

    /**
     * Get image attribute to append
     */
    public function getImageAttribute() {
        if($this->logo !== null && file_exists($this->logo)) {
            return $this->logo;
        } else {
            return 'frequent_changing/images/1668595245.png';
        }
    }

    /**
     * Get members attribute to append
     */
    public function getMembersAttribute() {
        $user_ids = ChatGroupMember::where('group_id',$this->id)->pluck('user_id');
        return User::whereIn('id',$user_ids)->get();
    }

    /**
     * Check any agent has online
     */
    public function getAgentOnlineAttribute() {
        $members = ChatGroupMember::where('group_id',$this->id)->pluck('user_id');
        if (User::whereIn('id',$members)->where('role_id','!=',3)->where('online_status',1)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Define relation with Chat group memeber table
     */
    public function members(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ChatGroupMember::class,'group_id','id');
    }

    /**
     * Static method to get group code
     */
    public static function getGroupCode() {
        $groupCode = str_pad(1, 4, "0", STR_PAD_LEFT);
        $last_group_code = ChatGroup::whereNotNull('code')->orderBy('created_at','desc')->first();
        if(isset($last_group_code)) {
            $new_code = $last_group_code->code + 1;
            return str_pad($new_code, 4, "0", STR_PAD_LEFT);;
        } else {
            return $groupCode;
        }
    }
}
