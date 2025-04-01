<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'tbl_testimonials';

    protected $fillable = [
        'user_id',
        'review',
        'rating',
        'created_at',
        'del_status',
    ];

    /**
     * Define relation with user
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
