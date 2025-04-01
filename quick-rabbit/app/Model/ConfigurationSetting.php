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
  # This is ConfigurationSetting Model
  ##############################################################################
 */
namespace App\Model;

use Google\Cloud\Core\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurationSetting extends Model
{
    use HasFactory;
    protected $table = "tbl_configuration_settings";
    protected $guarded = [];
    public $timestamps = false;
}
