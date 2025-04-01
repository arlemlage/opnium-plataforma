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
  # This is User Document Model
  ##############################################################################
 */

namespace App\Model;

use App\Scopes\Live;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    /**
     * Define table name
     * @var string
     */
    protected $table = "tbl_user_documents";
    /**
     * Define guard for table
     * @var string
     */
    protected $guarded = [];

    /**
     * Call a global scope
     *@return mixed
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new Live());
    }
}
