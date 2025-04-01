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
  # This is Transaction Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "tbl_transactions";
    protected $guarded = [];
    /**
     * Define relation with ticket
     */
    public function ticket() {
        return $this->belongsTo(Ticket::class,'ticket_id','id');
    }
    /**
     * Define relation with customer
     */
    public function customer() {
        return $this->belongsTo(User::class,'customer_id','id');
    }
}
