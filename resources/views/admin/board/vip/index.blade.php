@extends('admin.layout')
@section('title', $pageTitle)
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle }}</h3>
            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel">
                        <h4>{{ $pageTitle }}</h4>
                        <a href="{{ route('admin.board.vip.create') }}" class="btn btn-md btn-info pull-right">Add New Post</a>

                        @if(session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @endif

                        <table class="table table-bordered table-striped table-condensed mt-3">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Posted By</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $key => $post)
                                <tr>
                                    <td>{{ ($posts->currentPage() - 1) * $posts->perPage() + $key + 1 }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>
                                        @if($post->image)
                                            <img src="{{ asset('uploads/' . $post->image) }}" style="width:60px; height:40px; object-fit:cover; border-radius:4px;">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->user->name ?? 'N/A' }}</td>
                                    <td>{{ $post->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.board.vip.edit', $post->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{ route('admin.board.vip.destroy', $post->id) }}"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Delete this post and all its comments?')">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $posts->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
