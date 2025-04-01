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
  # This is Feedback Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Feedback extends Model
{
    protected $table = "tbl_feedbacks";
    protected $guarded = [];
    public $timestamps = true;

    /**
     * Define relation with user table
     */
    public function getCreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

}
