<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_articles_id',
        'title',
        'img_question',
        'answer',
        'is_correct',
    ];

    protected $hidden = [

    ];
    
    protected $casts = [];

    public function gameArticle() {
        return $this->belongsTo(GamesArticle::class);
    }

    public function gameHistories() {
        return $this->hasMany(GameHistory::class);
    }


}
