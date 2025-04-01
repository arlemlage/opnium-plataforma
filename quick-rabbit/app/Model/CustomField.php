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
  # This is Custom Field Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;
    protected $table = "tbl_custom_fields";
    protected $guarded = [];

    /**
     * Define relation with product category
     */
    public function product_category() {
        return $this->belongsTo(ProductCategory::class,'product_category_id','id');
    }

    /**
     * Define relation with department
     */

    public function department() {
        return $this->belongsTo(Department::class,'department_id','id');
    }
}
