<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\GameQuestion;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GameController extends Controller
{
    public function getGame(Request $request){
        $articles_id = $request->input('articles_id');
    
        $questionGames = GameQuestion::with('questions')->where('articles_id', $articles_id)->get();
        
        if(!$questionGames) {
            return ResponseFormatter::error(
                null,
                "Data tidak ditemukan",
                404
            );
        }

        return ResponseFormatter::success(
            $questionGames,
            "Data game berhasil didapatkan",
        );
      }   
}
