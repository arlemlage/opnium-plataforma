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
  # This is Article Group Model
  ##############################################################################
 */

namespace App\Model;

use App\Scopes\Sort;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleGroup extends Model
{
    protected $table = "tbl_article_groups";
    protected $guarded = [];
    public $timestamps = true;

    protected $appends = ['type'];

    /**
     * Get type attribute to append
     */
    public function getTypeAttribute()
    {
        return "Article-Group";
    }

    /**
     * Define boot method
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->created_by = Auth::user()->id;
            $post->updated_by = Auth::user()->id;
        });

        static::updating(function ($post) {
            $post->updated_by = Auth::user()->id ?? 1;
        });
        static::addGlobalScope(new Sort);
    }

    /**
     * Define relation with user table
     */
    public function getCreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Define relation with category table
     */
    public function getProductCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category', 'id');
    }

    /**
     * Define relation with articles table
     */
    public function articles() {
        return $this->hasMany(Article::class,'article_group_id','id')->live()->statusActive();
    }
}
