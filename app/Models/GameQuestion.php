<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function article() {
        return $this->belongsTo(Article::class);
    }

    public function questions() {
        return $this->hasMany(AnswerQuestion::class);
    }
}
