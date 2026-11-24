<div class="board-comment" style="margin-left: {{ min($depth * 24, 96) }}px;">
    <div class="d-flex gap-2">
        <div class="board-avatar {{ $depth > 0 ? 'board-avatar-sm' : '' }}">
            {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
        </div>
        <div class="flex-grow-1">
            <div class="board-comment-bubble {{ $depth > 0 ? 'board-reply-bubble' : '' }}">
                <strong>{{ $comment->user->name ?? 'Deleted User' }}</strong>
                <span class="board-comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                <p class="mb-0 mt-1">{{ $comment->comment }}</p>
            </div>

            @auth
                <button class="board-reply-toggle" onclick="toggleReply('reply-{{ $comment->id }}')">
                    <i class="fa fa-reply"></i> Reply
                </button>
            @endauth

            @auth
                <div id="reply-{{ $comment->id }}" class="board-reply-form" style="display:none;">
                    <form action="{{ route('client.board.reply.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                        <div class="d-flex gap-2 mt-2">
                            <div class="board-avatar board-avatar-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <textarea name="comment" class="board-comment-input" placeholder="Reply to {{ $comment->user->name ?? 'user' }}..." rows="2" required></textarea>
                                <button type="submit" class="board-comment-btn">Reply</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endauth

            @if($comment->replies && $comment->replies->count() > 0)
                @foreach($comment->replies as $reply)
                    @include('client.partials.board_comment_recursive', [
                        'comment' => $reply,
                        'post'    => $post,
                        'depth'   => $depth + 1,
                    ])
                @endforeach
            @endif
        </div>
    </div>
</div>
