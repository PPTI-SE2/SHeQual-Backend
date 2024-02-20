<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'posts_id',
    ];

    protected $hidden = [

    ];
    
    protected $casts = [];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function post(): BelongsTo {
        return $this->belongsTo(Post::class, 'posts_id');
    }
}
