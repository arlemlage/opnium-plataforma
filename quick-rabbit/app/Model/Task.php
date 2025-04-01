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
  # This is Task Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'tbl_tasks';
    protected $guarded = [];
    protected $appends = array('bg_color');

    /**
     * Get work date attribute to append
     */
    public function getWorkDateAttribute($value) {
        return date('Y-m-d',strtotime($value));
    }

    /**
     * Get background color attribute to append
     */
    public function getBgColorAttribute() {
        if($this->status == 'Pending') {
            return 'red';
        } elseif($this->status == "In-Progress") {
            return 'yellow';
        } elseif($this->status == "Done") {
            return "green";
        }
    }

    /**
     * Define relation with user table
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'assigned_person','id');
    }

    /**
     * Define relation with ticket table
     */
    public function ticket(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ticket::class,'ticket_id','id');
    }
}
