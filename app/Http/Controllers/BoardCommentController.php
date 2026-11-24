<?php


namespace App\Http\Controllers;

use App\BoardComment;
use App\BoardPost;
use Illuminate\Http\Request;
use Auth;

class BoardCommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'post_id' => 'required|exists:board_posts,id',
        ]);

        BoardComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'parent_id' => null,
        ]);

        return back();
    }

    public function replyStore(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'post_id' => 'required|exists:board_posts,id',
            'comment_id' => 'required|exists:board_comments,id',
        ]);

        BoardComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'parent_id' => $request->comment_id,
        ]);

        return back();
    }
}
