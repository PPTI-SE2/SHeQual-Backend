<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameQuestion extends Model
{
    use HasFactory;


    protected $fillable = [
        'articles_id',
        'question',
        'img_question'
    ];

    protected $hidden = [

    ];
    
    protected $casts = [];

    public function article():BelongsTo{
        return $this->belongsTo(Article::class);
    }

    public function questions():HasMany{
        return $this->hasMany(AnswerQuestion::class);
    }
}
