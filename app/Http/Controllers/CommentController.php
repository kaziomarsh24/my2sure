<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use App\User;
use Auth;
class CommentController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id=$user->id;


        $post = Post::find($request->post_id);
        $post->comments()->save($comment);
        return back();
    }
    public function replyStore(Request $request)
    {
        $user = Auth::user();
        
        $reply = new Comment();

        $reply->comment = $request->get('comment');

        $reply->user_id=$user->id;

        $reply->parent_id = $request->get('comment_id');

        $post = Post::find($request->get('post_id'));

        $post->comments()->save($reply);

        return back();
    }
}
