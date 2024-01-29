<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamesArticle extends Model
{
    use HasFactory;


    protected $fillable = [
        'articles_id',
        'title',
    ];

    protected $hidden = [

    ];
    
    protected $casts = [];

    public function article() {
        return $this->belongsTo(Article::class);
    }
}
