<?php
/*
##############################################################################
# AI Powered Customer Support Portal and Knowledgebase System
##############################################################################
# AUTHOR:        Door Soft
##############################################################################
# EMAIL:        info@doorsoft.co
##############################################################################
# COPYRIGHT:        RESERVED BY Door Soft
##############################################################################
# WEBSITE:        https://www.doorsoft.co
##############################################################################
# This is Forum Model
##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;
    protected $table = "tbl_forums";
    protected $guarded = [];
    public $timestamps = true;
    protected $appends = array('last_reply', 'last_four_reply');

    /**
     * get Last Reply
     */
    public function getLastReplyAttribute()
    {
        $comment = ForumComment::where('forum_id', $this->id)->orderBy('created_at', 'desc')->first();
        if (isset($comment)) {
            return [
                'comment_by' => getUserName($comment->user_id) ?? "",
                'comment_time' => $comment->created_at->diffForHumans() . ' ' . $comment->created_at->format('d M, Y h:i A') ?? "",
            ];
        } else {
            return [
                'comment_time' => "",
                'comment_by' => "",
            ];
        }
    }

    /*
     * Get Last 4 Reply User
     */
    public function getLastFourReplyAttribute()
    {
        $comments = ForumComment::where('forum_id', $this->id)->orderBy('created_at', 'desc')->limit(4)->pluck('user_id')->toArray();
        $lastFourReply = [];
        foreach ($comments as $comment) {
            $lastFourReply[] = [
                'comment_by' => getUserName($comment) ?? "",
                'image' => getUserImage($comment) ?? "",
            ];
        }
        return $lastFourReply;
    }

    /**
     * Define Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Define Relationship with Product Category
     */

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_id', 'id');
    }

    /**
     * Define Relationship with Forum Comment
     */

    public function comments()
    {
        return $this->hasMany(ForumComment::class, 'forum_id', 'id');
    }

    /*
     * Most Commented Forum
     */
    public static function mostCommentedForum()
    {
        $singleProductId = 0;
        $data_single = ProductCategory::live()->where('type', 'single')->first();
        if($data_single){
            $singleProductId = $data_single->id;
        }
        $forums = Forum::withCount('comments')->where('product_id', $singleProductId)->orderBy('comments_count', 'desc')->limit(5)->get();
        return $forums;
    }
}
