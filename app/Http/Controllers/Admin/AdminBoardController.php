<?php


namespace App\Http\Controllers\Admin;

use App\BoardComment;
use App\BoardPost;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->objUser = \Auth::user();
            if ($this->objUser->type != "admin") {
                return redirect()->route('client.redirectPayment', [
                    'status' => 'LIMITED ACCESS',
                    'msg' => '<h3>' . $this->objUser->name . '</h3> You do not have access to this page.'
                ]);
            }
            return $next($request);
        });
    }

    // ─── RESULT POSTS ───────────────────────────────────────

    public function resultIndex()
    {
        $posts = BoardPost::with('user')
            ->where('type', 'result')
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return view('admin.board.result.index', [
            'posts' => $posts,
            'pageTitle' => 'Result Posts',
        ]);
    }

    public function resultCreate()
    {
        return view('admin.board.result.create', [
            'pageTitle' => 'Add New Result Post',
        ]);
    }

    public function resultStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|max:4096',
        ]);

        try {
            DB::beginTransaction();

            $imageName = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move('uploads', $imageName);
            }

            BoardPost::create([
                'type' => 'result',
                'title' => $request->title,
                'body' => $request->body,
                'image' => $imageName,
                'user_id' => \Auth::id(),
            ]);

            DB::commit();
            return redirect()->route('admin.board.result.index')
                ->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function resultEdit($id)
    {
        $post = BoardPost::where('type', 'result')->findOrFail($id);

        return view('admin.board.result.edit', [
            'post' => $post,
            'pageTitle' => 'Edit Result Post',
        ]);
    }

    public function resultUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|max:4096',
        ]);

        try {
            DB::beginTransaction();

            $post = BoardPost::where('type', 'result')->findOrFail($id);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move('uploads', $imageName);
                $post->image = $imageName;
            }

            $post->title = $request->title;
            $post->body = $request->body;
            $post->save();

            DB::commit();
            return redirect()->route('admin.board.result.index')
                ->with('success', 'Post updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function resultDestroy($id)
    {
        $post = BoardPost::where('type', 'result')->findOrFail($id);
        BoardComment::where('post_id', $id)->delete();
        $post->delete();

        return redirect()->route('admin.board.result.index')
            ->with('success', 'Post deleted successfully.');
    }

    public function resultComments(Request $request)
    {
        $query = BoardComment::with(['user', 'post'])
            ->whereHas('post', fn($q) => $q->where('type', 'result'))
            ->whereNull('parent_id')
            ->orderBy('id', 'DESC');

        if (!empty($request->search)) {
            $query->where('comment', 'like', '%' . $request->search . '%');
        }

        $comments = $query->paginate(50);

        return view('admin.board.comments', [
            'comments' => $comments,
            'pageTitle' => 'Result Post Comments',
            'type' => 'result',
        ]);
    }

    // ─── VIP POSTS ───────────────────────────────────────────

    public function vipIndex()
    {
        $posts = BoardPost::with('user')
            ->where('type', 'vip')
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return view('admin.board.vip.index', [
            'posts' => $posts,
            'pageTitle' => 'VIP Room Posts',
        ]);
    }

    public function vipCreate()
    {
        return view('admin.board.vip.create', [
            'pageTitle' => 'Add New VIP Post',
        ]);
    }

    public function vipStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|max:4096',
        ]);

        try {
            DB::beginTransaction();

            $imageName = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move('uploads', $imageName);
            }

            BoardPost::create([
                'type' => 'vip',
                'title' => $request->title,
                'body' => $request->body,
                'image' => $imageName,
                'user_id' => \Auth::id(),
            ]);

            DB::commit();
            return redirect()->route('admin.board.vip.index')
                ->with('success', 'VIP Post created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function vipEdit($id)
    {
        $post = BoardPost::where('type', 'vip')->findOrFail($id);

        return view('admin.board.vip.edit', [
            'post' => $post,
            'pageTitle' => 'Edit VIP Post',
        ]);
    }

    public function vipUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|max:4096',
        ]);

        try {
            DB::beginTransaction();

            $post = BoardPost::where('type', 'vip')->findOrFail($id);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move('uploads', $imageName);
                $post->image = $imageName;
            }

            $post->title = $request->title;
            $post->body = $request->body;
            $post->save();

            DB::commit();
            return redirect()->route('admin.board.vip.index')
                ->with('success', 'VIP Post updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function vipDestroy($id)
    {
        $post = BoardPost::where('type', 'vip')->findOrFail($id);
        BoardComment::where('post_id', $id)->delete();
        $post->delete();

        return redirect()->route('admin.board.vip.index')
            ->with('success', 'VIP Post deleted successfully.');
    }

    public function vipComments(Request $request)
    {
        $query = BoardComment::with(['user', 'post'])
            ->whereHas('post', fn($q) => $q->where('type', 'vip'))
            ->whereNull('parent_id')
            ->orderBy('id', 'DESC');

        if (!empty($request->search)) {
            $query->where('comment', 'like', '%' . $request->search . '%');
        }

        $comments = $query->paginate(50);

        return view('admin.board.comments', [
            'comments' => $comments,
            'pageTitle' => 'VIP Room Comments',
            'type' => 'vip',
        ]);
    }

    // ─── SHARED COMMENT EDIT/DELETE ──────────────────────────

    public function commentEdit($id)
    {
        $comment = BoardComment::with(['user', 'replies.user'])->findOrFail($id);

        return view('admin.board.comment_edit', [
            'comment' => $comment,
            'pageTitle' => 'Edit Comment',
        ]);
    }

    public function commentUpdate(Request $request, $id)
    {
        $request->validate(['comment' => 'required|string']);

        $comment = BoardComment::findOrFail($id);
        $comment->comment = $request->comment;
        $comment->save();

        // redirect back to correct comments page
        $type = $comment->post->type;
        return redirect()->route("admin.board.{$type}.comments")
            ->with('success', 'Comment updated.');
    }

    public function commentDestroy($id)
    {
        $comment = BoardComment::with('post')->findOrFail($id);
        $type = $comment->post->type;

        BoardComment::where('parent_id', $id)->delete();
        $comment->delete();

        return redirect()->route("admin.board.{$type}.comments")
            ->with('success', 'Comment deleted.');
    }
}
