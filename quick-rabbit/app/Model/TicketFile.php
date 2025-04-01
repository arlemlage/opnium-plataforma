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
  # This is Ticket File Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketFile extends Model
{
    use HasFactory;
    protected $table = "tbl_ticket_files";
    protected $guarded = [];

    /**
     * Get File path attribute to append
     */
    public function getFilePathAttribute($value)
    {
        if($value != Null && file_exists(rootFilePath().'tickets/ticket_attachments/'.$value)) {
            return rootFilePath().'tickets/ticket_attachments/'.$value;
        } else {
            return null;
        }
    }
}
