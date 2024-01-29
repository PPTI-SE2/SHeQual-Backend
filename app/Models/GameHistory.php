<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_games_id',
        'users_id',
        'correct',
        'status_game',
    ];

    protected $hidden = [

    ];
    
    protected $casts = [];

    public function questionGame() {
        return $this->belongsTo(QuestionGame::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
