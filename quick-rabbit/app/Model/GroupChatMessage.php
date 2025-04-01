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
  # This is Group Chat Message Model
  ##############################################################################
 */

namespace App\Model;

use App\Http\Controllers\Admin\MailSendController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupChatMessage extends Model
{
    protected $table = "tbl_group_chat_messages";
    protected $guarded = [];
    protected $appends = array('message_type','message_time','is_link','is_file','is_image');

    /**
     * Get message type attribute to append
     */
    public function getMessageTypeAttribute() {
        
        if($this->user_type == "forward") {
            return "forward_message";
        }
        if(Auth::check()) {
            if(authUserRole() == 3) {
                if($this->from_id == Auth::id()) {
                    return 'outgoing_message';
                } else {
                    return "incoming_message";
                }
            } else {
                if($this->from_id == 0) {
                    return "incoming_message"; 
                } else {
                    if(User::where('id',$this->from_id)->first()->role_id == 3) {
                        return "incoming_message"; 
                    } else {
                        return 'outgoing_message';
                    }
                }
            }
        } else {
            if($this->from_id == 0) {
                return 'outgoing_message';
            } else {
                return "incoming_message";
            }
        }
    }

    /**
     * Get message time attribute to append
     */
    public function getMessageTimeAttribute() {
        return $this->created_at->format('h:i a');
    }

    /**
     * Get is link check attribute to append
     */
    public function getIsLinkAttribute() {
        if (filter_var($this->message, FILTER_VALIDATE_URL)) {
            return true;
        } elseif(Str::endsWith($this->message,getDomainExtensions())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get is file check attribute to append
     */
    public function getIsFileAttribute() {
        if ($this->file !== Null && file_exists($this->file)) {
            return true;
        } else {
        return false;
        }
    }

    /**
     * Get is image attribute to append
     */
    public function getIsImageAttribute() {
        if ($this->file !== Null && file_exists($this->file) && Str::startsWith(mime_content_type ($this->file),'image')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Define relation with chat group table
     */
    public function group() {
        return $this->belongsTo(ChatGroup::class,'group_id','id');
    }


    public function getSenderAttribute() {
        if($this->from_id == 0 && $this->user_type == 'guest') {
            return [
                'id' => 0,
                'full_name' => ChatGroup::where('id',$this->group_id)->first()->created_by,
                'image' => 'assets/images/avator.jpg'
            ];
        } else {
            return [
                'id' => $this->from_id,
                'full_name' => getUserName($this->from_id),
                'image' => getUserImage($this->from_id)
            ];
        }
    }
}
