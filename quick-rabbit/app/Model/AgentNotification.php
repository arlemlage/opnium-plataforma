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
  # This is Agent Notification Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentNotification extends Model
{
    protected $table = "tbl_agent_notifications";
    protected $guarded = [];
    protected $appends = array('details_link','delete_link','seen_link','creation_date','ticket_title','bg_color');

    /**
     * Get the details link
     */
    public function getDetailsLinkAttribute() {
        return  url($this->redirect_link);
    }

    /**
     * Get the delete link
     */
    public function getDeleteLinkAttribute() {
        return url('notification-delete', encrypt_decrypt($this->id, 'encrypt'));
    }

    /**
     * Get the seen link
     */

    public function getSeenLinkAttribute() {
        return url('mark-as-read', encrypt_decrypt($this->id, 'encrypt'));
    }

    /**
     * Get the creation date
     */

    public function getCreationDateAttribute() {
        return orgDateFormat($this->created_at);
    }

    /**
     * Get the ticket title
     */
    public function getTicketTitleAttribute() {
        return Ticket::find($this->ticket_id)->title ?? "";
    }

    /**
     * Get the background color
     */

    public function getBgColorAttribute() {
        if($this->mark_as_read_status == 1) {
            return 'bg-white';
        } else {
            return 'bg-unseen';
        }
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query) {
        return $query->where('mark_as_read_status', null);
    }
}
