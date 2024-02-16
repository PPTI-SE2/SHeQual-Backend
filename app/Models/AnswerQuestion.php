<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_question_id',
        'answer',
        'is_correct',
    ];

    protected $hidden = [

    ];
    
    protected $casts = [];

    public function gameQuestion() {
        return $this->belongsTo(GameQuestion::class);
    }

    public function gameHistories() {
        return $this->hasMany(GameHistory::class);
    }


}
