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
  # This is Article Model
  ##############################################################################
 */

namespace App\Model;

use App\Scopes\Sort;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nicolaslopezj\Searchable\SearchableTrait;

class Article extends Model
{
    use SearchableTrait;

    protected $table = "tbl_articles";
    protected $guarded = [];
    public $timestamps = true;
    protected $appends = ['type'];

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
            $post->updated_by = Auth::user()->id ?? 0;
        });
    }

    protected $searchable = [
        'columns' => [
            'title' => 10,
            'tag_titles' => 10,
        ],
    ];

    /**
     * Fetch type to append
     */
    public function getTypeAttribute(): string
    {
        return "Article";
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
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    /**
     * Define relation with article group table
     */
    public function getArticleGroup(): BelongsTo
    {
        return $this->belongsTo(ArticleGroup::class, 'article_group_id', 'id');
    }

    /**
     * Scope a query to only include internal articles.
     
     */

    public function scopeInternal($query) {
        return $query->where('internal_external',2);
    }

    /**
     * Scope a query to only include external articles.
     */

    public function scopeExternal($query) {
        return $query->where('internal_external',1);
    }

    public function scopeCategory($query, $category) {
        if($category) {
            return $query->where('product_category_id', $category);
        }

        return $query;
    }
}
