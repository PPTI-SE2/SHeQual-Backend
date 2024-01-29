<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'publisher',
        'content',
        'img_article',
    ];

    protected $hidden = [

    ];
    
    protected $casts = [];

    public function role() {
        return $this->belongsTo(User::class);
    }
}
