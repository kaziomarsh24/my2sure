<?php

namespace App\Http\Controllers;

use App\BoardPost;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function results()
    {
        $posts = BoardPost::with('user')
            ->where('type', 'result')
            ->orderBy('id', 'DESC')
            ->paginate(12);

        return view('client.results', [
            'posts' => $posts,
        ]);
    }

    public function vip()
    {
        // VIP gate — Flutterwave integration will go here later
        // For now all logged-in users can access

        $posts = BoardPost::with('user')
            ->where('type', 'vip')
            ->orderBy('id', 'DESC')
            ->paginate(12);

        return view('client.vip', [
            'posts' => $posts,
        ]);
    }

    public function resultShow($id)
    {
        $post = BoardPost::with([
            'user',
            'comments' => function($q) {
                $q->whereNull('parent_id')->orderBy('id', 'DESC');
            },
            'comments.user',
            'comments.replies.user',
            'comments.replies.replies.user',
            'comments.replies.replies.replies.user',
        ])->where('type', 'result')->findOrFail($id);

        return view('client.results_detail', [
            'post' => $post,
        ]);
    }

    public function vipShow($id)
    {
        $post = BoardPost::with([
            'user',
            'comments' => function($q) {
                $q->whereNull('parent_id')->orderBy('id', 'DESC');
            },
            'comments.user',
            'comments.replies.user',
            'comments.replies.replies.user',
            'comments.replies.replies.replies.user',
        ])->where('type', 'vip')->findOrFail($id);

        return view('client.vip_detail', [
            'post' => $post,
        ]);
    }
}
