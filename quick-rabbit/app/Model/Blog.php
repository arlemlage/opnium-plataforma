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
  # This is Blog Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Nicolaslopezj\Searchable\SearchableTrait;

class Blog extends Model
{
    use SearchableTrait;
    protected $table = "tbl_blogs";
    protected $guarded = [];
    protected $appends = array('tags','type');
    public $timestamps = true;

    protected $searchable = [
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
        return "Blog";
    }

     /**
     * Get image attribute to append
     */
    public function getImageAttribute($value)
    {
        if($value != Null && file_exists(rootFilePath().'blogs/'.$value)) {
            return rootFilePath().'blogs/'.$value;
        } else {
            return 'assets/images/camera-icon-blog.jpg';
        }
    }

    /**
     * Get thumnb Image attribute to append
     */
    public function getThumbImgAttribute($value)
    {
        if($value != Null && file_exists(rootFilePath().'blogs/thumb/'.$value)) {
            return rootFilePath().'blogs/thumb/'.$value;
        } else {
            return null;
        }
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
     * Define relation with category table
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class,'category_id','id');
    }

    /**
     * Define relation with user table
     */
    public function getCreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Define relation with comments table
     */
    public function comments() 
    {
        return $this->hasMany(BlogComment::class,'blog_id','id');
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
}
