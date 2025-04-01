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
  # This is Media Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $table = "tbl_medias";
    protected $guarded = [];
    public $timestamps = true;
    protected $appends = ['type'];

    /**
     * Get media path
     */
    public function getMediaPathAttribute($value) {
      return rootFilePath().'media/media_images/'.$value;
    }
    /**
     * Get Thumb Image
     */

    public function getThumbImgAttribute($value) {
      return rootFilePath().'media/thumbnails/'.$value;
    }
}
