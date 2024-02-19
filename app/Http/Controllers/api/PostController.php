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
    public function index(){
        $posts = Post::all();
        return ResponseFormatter::success(
            $posts,
            "Data Post berhasil didapatkan",
        );
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required',
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Post::create([
            'users_id'  => '1',
            'img_post'  => $request->image,
            'title'     => $request->title,
            'content'   => $request->content,
        ]);
        
        return response()->json($post);        
    }

    public function storeComment(Request $req, $id){
        $post = Post::find($id);        
        
        $validator = Validator::make($req->all(), [
            'details' => 'required', 'min:3', 'max:50'
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Comment::create([            
            'users_id' => '1',
            'posts_id' => $id,
            'details' => $req->details
        ]);

        // $comments = Comment::where('posts_id', $id)->get();
        // $data = array(
        //     'post' => $post,
        //     'comments' => $comments,
        // );

        return ResponseFormatter::success(
            $user,
            "Komentar baru berhasi ditambahkan"
        );
    }
}
