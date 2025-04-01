<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_id',
        'parent_id',
        'name',
        'email',
        'comment',
        'del_status',
    ];

    /**
     * Define relation with article
     */

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Define relation with user
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define relation with children
     */
    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    /**
     * Define relation with parent
     */
    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }
}
