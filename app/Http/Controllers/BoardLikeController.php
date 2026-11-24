<?php

namespace App\Http\Controllers;

use App\BoardPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoardLikeController extends Controller
{
    public function toggle(Request $request)
    {
        $postId = $request->post_id;
        $userId = Auth::id();

        $existing = DB::table('post_likes')
            ->where('post_id', $postId)
            ->where('user_id', $userId)
            ->first();

        if ($existing) {
            // Unlike
            DB::table('post_likes')
                ->where('post_id', $postId)
                ->where('user_id', $userId)
                ->delete();
            $liked = false;
        } else {
            // Like
            DB::table('post_likes')->insert([
                'post_id'    => $postId,
                'user_id'    => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $liked = true;
        }

        $count = DB::table('post_likes')->where('post_id', $postId)->count();

        return response()->json([
            'liked' => $liked,
            'count' => $count,
        ]);
    }
}