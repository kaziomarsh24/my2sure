@extends('admin.layout')
@section('title', 'Manage Comments')
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle }}</h3>

            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel">
                        <h4>{{ $pageTitle }}</h4>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- Search --}}
                        <form method="GET" action="{{ route('admin.comments.index') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Search comments..."
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-sm btn-primary">Search</button>
                                    <a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-default">Reset</a>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Comment</th>
                                <th>Replies</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $key => $comment)
                                <tr>
                                    <td>{{ ($comments->currentPage() - 1) * $comments->perPage() + $key + 1 }}</td>
                                    <td>
                                        <strong>{{ $comment->user->name ?? 'Deleted User' }}</strong><br>
                                        <small>{{ $comment->user->email ?? '' }}</small>
                                    </td>
                                    <td>{{ $comment->comment }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $comment->replies->count() ?? 0 }}</span>
                                    </td>
                                    <td>{{ $comment->created_at->format('d M Y, h:i A') }}</td>
                                    <td>
                                        <a href="{{ route('admin.comments.edit', $comment->id) }}"
                                           class="btn btn-sm btn-warning">Edit</a>

                                        <a href="{{ route('admin.comments.destroy', $comment->id) }}"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Delete this comment and all its replies?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $comments->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
