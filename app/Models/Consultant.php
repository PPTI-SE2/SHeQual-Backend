<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consultant extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'patients',
        'experience',
        'bio_data',
        'status'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    
    public function appointments(): HasMany{
        return $this->hasMany(Appointments::class, 'consultants_id');
    }
}
