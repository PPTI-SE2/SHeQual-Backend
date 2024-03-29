<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function consultant(): BelongsTo{
        return $this->belongsTo(Consultant::class, 'consultants_id', 'users_id');
    }

}
