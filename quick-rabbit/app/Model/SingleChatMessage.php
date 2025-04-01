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
  # This is Single Chat Message Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SingleChatMessage extends Model
{
    protected $table = "tbl_single_chat_messages";
    protected $guarded = [];
    protected $appends = array('message_type','message_time','is_link','is_file','is_image');

    /**
     * Get message type attribute to appends
     */
    public function getMessageTypeAttribute() {
        $message_type = '';
        if($this->from_id == Auth::id()) {
            $message_type = 'outgoing_message';
        } elseif($this->to_id == Auth::id()) {
            $message_type = "incoming_message";
        }
        return $message_type;
    }

    /**
     * Get message time attribute to appends
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
     * Define relation with user table
     */
    public function sender() {
        return $this->belongsTo(User::class,'from_id','id');
    }

    /**
     * Define relation with user table
     */
    public function receiver() {
        return $this->belongsTo(User::class,'to_id','id');
    }

}
