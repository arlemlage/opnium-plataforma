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
  # This is Pages Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Nicolaslopezj\Searchable\SearchableTrait;

class Pages extends Model
{
    use SearchableTrait;
    protected $table = "tbl_pages";
    protected $guarded = [];
    public $timestamps = true;
    protected $appends = array('tags','type');

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'title' => 10,
            'tag_titles' => 10,
        ],
    ];

    /**
     * Get type attribute to append
     */
    public function getTypeAttribute()
    {
        return "Page";
    }

    /**
     * Get tags attribute to append
     */
    public function getTagsAttribute() {
        $tags = [];
        foreach (explode(',',$this->tag_ids) as $tag_id) {
            array_push($tags,Tag::find($tag_id)->title ?? "");
        }
        return $tags;
    }

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
}
