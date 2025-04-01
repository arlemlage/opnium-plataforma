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
  # This is Blog Comment Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;
    protected $table = "tbl_blog_comments";
    protected $guarded = [];
    protected $appends = array('user_image','user_type');

    /**
     * Get user image attribute to append
     */
    public function getUserImageAttribute()
    {
        if($this->user_id != Null) {
            return User::find($this->user_id)->image;
        } else {
            return 'assets/images/avator.jpg';
        }
    }

    /**
     * Get user image attribute to append
     */
    public function getUserTypeAttribute()
    {
        if($this->user_id != Null) {
            return User::find($this->user_id)->type;
        } else {
            return 'Guest';
        }
    }
}
