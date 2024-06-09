<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            // 'user_name' => 'required|string',
            'message' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->post_id = $postId;
        // $comment->user_name = $request->user_name;
        $comment->message = $request->message;
        $comment->created_at = now();
        $comment->save();

        return response()->json($comment, 201);
    }
}
