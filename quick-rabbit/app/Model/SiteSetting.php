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
  # This is Site Setting Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class SiteSetting extends Model
{
    protected $table = "tbl_site_settings";
    protected $guarded = [];
    public $timestamps = true;
    protected $append = array('banner');

    /**
     * Call boot method
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->created_by = Auth::user()->id;
            $post->updated_by = Auth::user()->id;
        });

        static::updating(function ($post) {
            $post->updated_by = Auth::user()->id;
        });
    }

    /**
     * Get Banner Attribute
     */
    public function getBannerAttribute() {
        return url("'".$this->banner_img."'");
    }

    /**
     * Get Banner Image Attribute
     */
    public function getBannerImgAttribute($value) {
        if($value == Null || !file_exists(rootFilePath().'settings/'.$value)) {
            return 'assets/images/banner.png';
        } else {
            return rootFilePath().'settings/'.$value;
        }
    }
    /**
     * Get Logo Image Attribute
     */

    public function getLogoAttribute($value) {
        if($value == Null || !file_exists(rootFilePath().'settings/'.$value)) {
            return 'assets/images/logo.png';
        } else {
            return rootFilePath().'settings/'.$value;
        }
    }

    /**
     * Get Footer Logo Image Attribute
     */

    public function getFooterLogoAttribute($value) {
        if($value == Null || !file_exists(rootFilePath().'settings/'.$value)) {
            return 'assets/images/footer_logo.png';
        } else {
            return rootFilePath().'settings/'.$value;
        }
    }

    /**
     * Get Loader Image Attribute
     */

    public function getLoaderImgAttribute($value) {
        if($value == Null) {
            return 'assets/images/loader.png';
        } else {
            return $value;
        }
    }

    /**
     * Get Icon Image Attribute
     */

    public function getIconAttribute($value) {
        if($value == Null || !file_exists(rootFilePath().'settings/'.$value)) {
            return 'assets/images/favicon.ico';
        } else {
            return rootFilePath().'settings/'.$value;
        }
    }
}
