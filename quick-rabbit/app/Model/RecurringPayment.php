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
  # This is Recurring Payment Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecurringPayment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "tbl_recurring_payments";
    protected $guarded = [];
    protected $appends = ['products'];

    public function getProductsAttribute() {
        if($this->product_cat_ids != null) {
            $products = explode(',',$this->product_cat_ids);
            if(count($products )) {
                $product_names = [];
                foreach($products as $product) {
                    $product_db = ProductCategory::find($product);
                    if(isset($product_db)) {
                        array_push($product_names,$product_db->title);
                    }
                }
                return implode(',',$product_names);
            } else {
                return "N/A";
            }
        } else {
            return "N/A";
        }
    }

    public function customer() {
        return $this->belongsTo(User::class,'customer_id','id');
    }

    public function product_category() {
        return $this->belongsTo(ProductCategory::class,'customer_id','id');
    }
}
