<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointments extends Model
{
    use HasFactory;

    protected $fillable =[
        'users_id',
        'consultants_id',
        'date',        
        'time',
        'status',
        'message'    
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'users_id');
    }

}
