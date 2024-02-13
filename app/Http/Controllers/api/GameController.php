<?php

namespace App\Http\Controllers\API;

use App\Models\GameArticle;
use App\Models\QuestionGame;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GameController extends Controller
{
    public function getGame(Request $request){
        $id = $request->input('id');
        $articles_id = $request->input('articles_id');
    
        if($articles_id){
            // $QuestionGames = QuestionGame::with('gameArticle')->where('game_articles_id', $articles_id)->get();
            // return $QuestionGames;
    
            $GameArticle = GameArticle::with('article')->find($articles_id);
            $QuestionGames = QuestionGame::with('gameArticle')->where('game_articles_id', $articles_id)->get();
            
            return [$GameArticle, $QuestionGames];
       }   
       
       return QuestionGame::all();
      }   
}
