<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function storeLike(Request $request)
    {
        $request->validate([
            'posts_id' => 'required',
            'users_id' => 'required'
        ]);

        $user = User::where('id', $request->users_id)->first();

        $like = Like::where('users_id', $user->id)
                    ->where('posts_id', $request->posts_id)
                    ->first();

        if($like){
            $like->delete();
            return response()->json([
                'message' => 'You have Unliked a Post',
            ], 201);
        }else{
            $like = new Like();
            $like->users_id = $user->id;
            $like->posts_id = $request->posts_id;

            if($like->save()){
                return response()->json([
                       'message' => 'You have Liked a post',
                    'like' => $like->load('user')

                ], 201);
            }else{
                return response()->json([
                    'message' => 'Some error occurred, please try again'
                ], 500);
            }
        }
    }
    

    public function checkLike($posts_id, $users_id) {
        $posts = Like::with('user')->where('posts_id', $posts_id)->where('users_id', $users_id)->first();

        if($posts) {
            return ResponseFormatter::success(
                true,
                "Postingan telah di like"
            );
        }

        return ResponseFormatter::error(
            false,
            "Postingan tidak ditemukan",
            404,
        );
    }
}
