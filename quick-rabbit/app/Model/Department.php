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
  # This is Department Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Department extends Model
{
    protected $table = "tbl_departments";
    protected $guarded = [];
    public $timestamps = true;

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
     * Define relation with user table
     */
    public function getCreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Define relation with user table
     */
    public function getLeader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader', 'id');
    }

    /**
     * Get assigned agent ids from product/category
     */
    public static function assignedAgents($department_id) {
        $all_agents = User::agent()->whereNull('product_cat_ids')->whereNull('department_id')->pluck('id')->toArray();
        $not_null_agent_products = User::agent()->live()->whereRaw('FIND_IN_SET('."$department_id".', department_id)')
            ->pluck('id')->toArray();
        return array_merge($all_agents,$not_null_agent_products);
    }
}
