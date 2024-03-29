<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function getArticle(Request $request)
    {        
        $ArticleID = $request->input('ArticleID');
        $Title = $request->input('Title');
        $Publisher = $request->input('Publisher');
        $Content = $request->input('Content');
        $ImgArticle = $request->input('ImgArticle');
        $DatePost = $request->input('DatePost');
        
        
        if($ArticleID){ 
            $article = Article::find($ArticleID);
            if($article){
                return ResponseFormatter::success(
                    $article,
                    "Artikel ditemukan"
                );
            }else{
                return ResponseFormatter::error(
                    null,
                    "Artikel gagal ditemukan",
                    404
                );
            }
        }

        return ResponseFormatter::success(
            Article::all(),
            "Data artikel berhasil diambil"
        );
    }
}
