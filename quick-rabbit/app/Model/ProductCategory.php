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
  # This is Product Category Model
  ##############################################################################
 */

namespace App\Model;

use App\Scopes\Sort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class ProductCategory extends Model
{
    protected $table = "tbl_product_categories";
    protected $guarded = [];
    public $timestamps = true;
    protected $appends = ['type','has_custom_field'];

    /**
     * Get type attribute to append
     */
    public function getTypeAttribute() {
        return "Product";
    }

    /**
     * Fetch custom field has or not
     */
    public function getHasCustomFieldAttribute() {
        if(CustomField::where('product_category_id',$this->id)->live()->where('status','Active')->exists()){
            return true;
        } else {
            return false;
        }
    }

    public function getPhotoThumbAttribute($value) {
        if($value != Null && file_exists("uploads/product_category_thumbs/".$value)) {
            return "uploads/product_category_thumbs/".$value;
        } else {
            return 'assets/images/camera.png';
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
     * Define relation with article groups table
     */
    public function article_groups() {
        return $this->hasMany(ArticleGroup::class,'product_category','id')->live();
    }

    /**
     * Get assigned agent ids from product/category
     */
    public static function assignedAgents($product_id) {
        $all_agents = User::agent()->whereNull('product_cat_ids')->pluck('id')->toArray();
        $not_null_agent_products = User::agent()->live()->whereRaw('FIND_IN_SET('."$product_id".', product_cat_ids)')
            ->pluck('id')->toArray();
        return array_merge($all_agents,$not_null_agent_products);
    }

    /**
     * Define Scope for type single
     */

    public function scopeType($query)
    {
        if(appTheme() == 'single'){
            return $query->where('type','single');
        }

        if(appTheme() == 'multiple'){
            return $query->where('type','multiple');
        }
    }

    public function faqs() {
        return $this->hasMany(Faq::class,'product_category_id','id')->live();
    }
   
}
