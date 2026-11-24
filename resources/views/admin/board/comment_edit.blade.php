@extends('admin.layout')
@section('title', $pageTitle)
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle }}</h3>
            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel col-md-8">
                        <h4>{{ $pageTitle }}</h4>
                        <hr>

                        <div class="mb-3">
                            <strong>By:</strong> {{ $comment->user->name ?? 'Deleted User' }}
                            ({{ $comment->user->email ?? '' }})<br>
                            <strong>Post:</strong> {{ $comment->post->title ?? 'N/A' }}<br>
                            <strong>Posted:</strong> {{ $comment->created_at->format('d M Y, h:i A') }}
                        </div>

                        <form action="{{ route('admin.board.comment.update', $comment->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea name="comment" class="form-control" rows="5" required>{{ old('comment', $comment->comment) }}</textarea>
                            </div>

                            @if($comment->replies->count() > 0)
                                <div class="form-group">
                                    <label>Replies ({{ $comment->replies->count() }})</label>
                                    <div class="list-group">
                                        @foreach($comment->replies as $reply)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $reply->user->name ?? 'Deleted User' }}:</strong>
                                                    {{ $reply->comment }}
                                                    <br><small class="text-muted">{{ $reply->created_at->format('d M Y, h:i A') }}</small>
                                                </div>
                                                <a href="{{ route('admin.board.comment.destroy', $reply->id) }}"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Delete this reply?')">Delete</a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-success">Update Comment</button>
                                <a href="javascript:history.back()" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
