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
  # This is Ticket Reply Comment Model
  ##############################################################################
 */

namespace App\Model;

use App\TicketCommentFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class TicketReplyComment extends Model
{
    protected $table = "tbl_ticket_reply_comments";
    protected $guarded = [];
    public $timestamps = true;
    protected $observables = array('sendCCMail','notifyAdminAgent','notifyAgentCustomer','notifyAdminCustomer');

    /**
     * Fire CC Mail send observer
     */
    public function sendCCMail() {
        $this->fireModelEvent('sendCCMail');
    }

    /**
     * Fire observer when opened by customer
     */
    public function notify($event) {
        if($event == 'replied_by_customer') {
            $this->fireModelEvent('notifyAdminAgent');
        } elseif ($event == 'replied_by_admin') {
            $this->fireModelEvent('notifyAgentCustomer');
        } elseif ($event == 'replied_by_agent') {
            $this->fireModelEvent('notifyAdminCustomer');
        }
    }

    /**
     * Define relation with user table
     */
    public function getCreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Define relation with Ticket table
     */
    public function get_ticket_info(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }

    /**
     * Define relation with ticket files table
     */
    public function comment_files()
    {
        return $this->hasMany(TicketCommentFile::class,'comment_id','id');
    }

}
