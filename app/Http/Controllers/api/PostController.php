<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Comment;

class PostController extends Controller
{

    public function showPostComment(){
        $posts = Post::with('comments.user', 'user')->get();

        $data = $posts->map(function ($post){
            return[
                 'post_id' => $post->id,
                 'title'     => $post->title,
                 'img_post'  => $post->img_post,
                 'content'   => $post->content,
                 'username'  => $post->user->username,
                 'user_id'    => $post->user->id,
                 'created_at' => $post->created_at,
                 'comments' => $post->comments->map(function ($comment) {
                    return [
                        'comment_id' => $comment->id,
                        'post_id' => $comment->posts_id,
                        'username' => $comment->user->username,
                        'user_iD' => $comment->user->id,
                        'details' => $comment->details,
                        'created_at' => $comment->created_at,
                    ];
                }),
            ];
         });

        return ResponseFormatter::success($data, 'sukses brody');
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required',
            'image'     => 'required',
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'ditolak validasi', 422);
        }

        //create post
        $post = Post::create([
            'users_id'  => $request->user_id,
            'img_post'  => $request->image,
            'title'     => $request->title,
            'content'   => $request->content,
        ]);
        
        return ResponseFormatter::success($post, 'sukses bro');        
    }

    public function storeComment(Request $req){        
        
        $validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'post_id' => 'required',
            'details' => 'required', 'min:3', 'max:50'
        ]);
        
        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'ditolak validasi', 422);
        }

        $user = Comment::create([            
            'users_id' => $req->user_id,
            'posts_id' => $req->post_id,
            'details' => $req->details
        ]);

        return ResponseFormatter::success(
            $user,
            "Komentar baru berhasi ditambahkan"
        );
    }
}
