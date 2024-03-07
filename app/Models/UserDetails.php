<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'users_id',        
        'bio_data'        
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'users_id');
    }
}
