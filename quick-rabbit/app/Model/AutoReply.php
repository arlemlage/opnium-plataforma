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
  # This is Auto Reply Model
  ##############################################################################
 */

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutoReply extends Model
{
    protected $table = "tbl_auto_replies";
    protected $guarded = [];
    public $timestamps = true;

    /**
     * Define relation with Product Category
     */
    public function getProductCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    /**
     * Define relation with Department
     */

    public function getDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
