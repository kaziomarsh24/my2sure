@foreach($comments as $comment)
<div class="display-comment">
    <strong>{{ $comment->user->name }}</strong>
    <p>{{ $comment->comment }}</p>
    <a href=""
        id="reply"></a>
    <form class="border-0 mt-0 shadow" method="post"
        action="{{ route('reply.store') }}" id="bordergreen">
        @csrf
        <div class="d-flex align-content-center">
            <div class="form-group flex-grow-2 mb-0 mr-2">
                <input type="text"
                       name="comment"
                       class="form-control" required />
                <input type="hidden"
                       name="post_id"
                       value="{{ $post_id }}" />
                <input type="hidden"
                       name="comment_id"
                       value="{{ $comment->id }}" />
            </div>
            <div class="form-group mb-0">
                <input type="submit"
                       class="btn btn-sm btn-outline-danger py-2"
                       style="font-size: 0.8em;"
                       value="Reply" />
            </div>
        </div>

    </form>
    @include('client.games.replys', ['comments' => $comment->replies])
</div>
@endforeach
