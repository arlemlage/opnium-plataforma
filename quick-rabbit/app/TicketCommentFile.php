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
  # This is Ticket Comment File Model
  ##############################################################################
 */
namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketCommentFile extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "tbl_ticket_comment_files";
    protected $guarded = [];

    /**
     * Get File path attribute to append
     */
    public function getFilePathAttribute($value)
    {
        if($value != Null && file_exists(rootFilePath().'tickets/comment_attachments/'.$value)) {
            return rootFilePath().'tickets/comment_attachments/'.$value;
        } else {
            return null;
        }
    }
}
