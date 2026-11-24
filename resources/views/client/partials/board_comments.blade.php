<div class="board-comments-section mt-4">
    <h5 class="board-comments-title">
        <i class="fa fa-comments"></i>
        {{ $post->comments->count() }} Comment{{ $post->comments->count() != 1 ? 's' : '' }}
    </h5>

    @auth
        <form action="{{ route('client.board.comment.store') }}" method="POST" class="board-comment-form mb-4">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <div class="d-flex gap-2">
                <div class="board-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="flex-grow-1">
                    <textarea name="comment" class="board-comment-input" placeholder="Write a comment..." rows="2" required></textarea>
                    <button type="submit" class="board-comment-btn">Post Comment</button>
                </div>
            </div>
        </form>
    @endauth

    @foreach($post->comments as $comment)
        @include('client.partials.board_comment_recursive', [
            'comment' => $comment,
            'post'    => $post,
            'depth'   => 0,
        ])
    @endforeach
</div>
