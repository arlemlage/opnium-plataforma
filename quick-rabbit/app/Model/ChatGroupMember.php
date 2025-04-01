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
  # This is Chat Group Member Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChatGroupMember extends Model
{
    protected $table = "tbl_chat_group_members";
    protected $guarded = [];
}
