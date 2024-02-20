<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'title',
        'content',
        'img_post'
    ];

    protected $hidden = [

    ];
    
    protected $casts = [];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'users_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'posts_id');
    }

    public function likes(): HasMany{
        return $this->hasMany(Like::class, 'posts_id');
    }

}
