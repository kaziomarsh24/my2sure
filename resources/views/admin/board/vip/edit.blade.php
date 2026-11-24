@extends('admin.layout')
@section('title', $pageTitle)
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle }}</h3>
            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel col-md-10">
                        <h4>{{ $pageTitle }}</h4>
                        <hr>

                        <form action="{{ route('admin.board.vip.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Body <span class="text-danger">*</span></label>
                                <textarea name="body" id="body" class="form-control" rows="10">{{ old('body', $post->body) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Image <span class="text-muted">(leave empty to keep current)</span></label>
                                @if($post->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('uploads/' . $post->image) }}" style="max-height:120px; border-radius:6px;">
                                    </div>
                                @endif
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Update Post</button>
                                <a href="{{ route('admin.board.vip.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <script src="https://cdn.tiny.cloud/1/vdueyo3bcyr6me5uw9ndyjay7snynbqqv8rxo90diozr3j04/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#body',
            plugins: 'anchor autolink image link lists media table wordcount',
            toolbar: 'undo redo | blocks | bold italic underline | link image | numlist bullist | removeformat',
            height: 400,
        });
    </script>
@endsection
