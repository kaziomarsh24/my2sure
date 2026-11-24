<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->objUser = \Auth::user();
            if ($this->objUser->type != "admin") {
                return redirect()->route('client.redirectPayment', [
                    'status' => 'LIMITED ACCESS',
                    'msg'    => '<h3>' . $this->objUser->name . '</h3> You do not have access to this page.'
                ]);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Comment::with(['user'])
            ->whereNull('parent_id') // top-level comments
            ->orderBy('id', 'DESC');

        if (!empty($request->search)) {
            $query->where('comment', 'like', '%' . $request->search . '%');
        }

        $comments = $query->paginate(50);

        return view('admin.comments.index', [
            'comments'  => $comments,
            'pageTitle' => 'Manage Comments',
        ]);
    }

    public function edit($id)
    {
        $comment = Comment::with('user')->findOrFail($id);

        return view('admin.comments.edit', [
            'comment'   => $comment,
            'pageTitle' => 'Edit Comment',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->comment = $request->comment;
        $comment->save();

        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment updated successfully.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Delete replies too
        Comment::where('parent_id', $id)->delete();
        $comment->delete();

        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment deleted successfully.');
    }
}
