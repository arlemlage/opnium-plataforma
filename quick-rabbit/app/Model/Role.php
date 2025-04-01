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
  # This is Role Model
  ##############################################################################
 */

namespace App\Model;

use App\Scopes\Live;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = "tbl_roles";
    /**
     * Define guard for table
     * @var string
     */
    protected $guarded = [];

    /**
     * Append extra field
     */
    protected $appends = array('menu_ids','activity_ids');

    /**
     * Get menu ids
     */
    public function getMenuIdsAttribute() {
        return RolePermission::where('role_id',$this->id)->pluck('menu_id')->toArray();
    }

    /**
     * Get menu ids
     */
    public function getActivityIdsAttribute() {
        return RolePermission::where('role_id',$this->id)->pluck('activity_id')->toArray();
    }


}
