@extends('client.layout')
@section('title', $post->title)

@push('styles')
    <style>
        .result-detail-section {
            padding: 50px 0;
            background: #f5f7fa;
        }
        .result-detail-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 30px;
        }
        .result-detail-image img {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
        }
        .result-detail-body {
            padding: 36px;
        }
        .result-detail-body h1 {
            font-size: 32px;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 12px;
            line-height: 1.3;
        }
        .result-detail-meta {
            font-size: 13px;
            color: #aaa;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }
        .result-detail-meta i {
            color: #34b5f7;
            margin-right: 4px;
        }
        .result-detail-content {
            font-size: 16px;
            color: #444;
            line-height: 1.9;
        }
        .result-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #34b5f7;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
            text-decoration: none;
        }
        .result-back-btn:hover {
            color: #1a8fd1;
            text-decoration: none;
        }

        /* Comments */
        .board-comments-title {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            border-bottom: 2px solid #34b5f7;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }
        .board-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #34b5f7;
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .board-avatar-sm {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }
        .board-comment-input {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            resize: none;
            outline: none;
            transition: border 0.2s;
        }
        .board-comment-input:focus {
            border-color: #34b5f7;
        }
        .board-comment-btn {
            margin-top: 8px;
            background: #34b5f7;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 7px 18px;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .board-comment-btn:hover {
            background: #1a8fd1;
        }
        .board-comment {
            margin-bottom: 16px;
        }
        .board-comment-bubble {
            background: #f5f7fa;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
        }
        .board-reply-bubble {
            background: #eef7ff;
        }
        .board-comment-time {
            font-size: 11px;
            color: #aaa;
            margin-left: 8px;
        }
        .board-reply-toggle {
            background: none;
            border: none;
            color: #34b5f7;
            font-size: 12px;
            cursor: pointer;
            padding: 4px 0;
            margin-top: 4px;
        }
        .gap-2 { gap: 12px; }
    </style>
@endpush

@section('content')

    <section class="inner-page-banner has_bg_image" data-background="{{ asset('assets/images/inner-page-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-page-banner-area">
                        <h1 class="page-title">Winning Results</h1>
                        <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('client.results') }}">Winning Results</a></li>
                                <li class="breadcrumb-item active">{{ Str::limit($post->title, 40) }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        @include('client.slider')
    </section>

    <section class="result-detail-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="{{ route('client.results') }}" class="result-back-btn" style="margin-bottom: 0;">
                            <i class="fa fa-arrow-left"></i> Back to Results
                        </a>
                        <a href="#comments-section" class="result-back-btn" style="margin-bottom: 0; color: #34b5f7;">
                            <i class="fa fa-comments"></i> Go to Comments
                        </a>
                    </div>

                    <div class="result-detail-card">
                        @if($post->image)
                            <div class="result-detail-image">
                                <img src="{{ asset('uploads/' . $post->image) }}" alt="{{ $post->title }}">
                            </div>
                        @endif
                        <div class="result-detail-body">
                            <h1>{{ $post->title }}</h1>
                            <div class="result-detail-meta" style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <i class="fa fa-user"></i> {{ $post->user->name ?? 'Admin' }}
                                    &nbsp;&nbsp;
                                    <i class="fa fa-calendar"></i> {{ $post->created_at->format('d M Y, h:i A') }}
                                </div>
                                <div>
                                    @php
                                        $likeCount  = DB::table('post_likes')->where('post_id', $post->id)->count();
                                        $userLiked  = Auth::check() ? DB::table('post_likes')->where('post_id', $post->id)->where('user_id', Auth::id())->exists() : false;
                                    @endphp
                                    <button id="likeBtn"
                                            data-post="{{ $post->id }}"
                                            style="
                                            background: none;
                                            border: none;
                                            cursor: pointer;
                                            font-size: 22px;
                                            color: {{ $userLiked ? '#e74c3c' : '#ccc' }};
                                            transition: all 0.2s;
                                            display: flex;
                                            align-items: center;
                                            gap: 6px;
                                        ">
                                        <i class="fa fa-heart"></i>
                                        <span id="likeCount" style="font-size: 14px; font-weight: 600; color: #888;">{{ $likeCount }}</span>
                                    </button>
                                </div>
                            </div>
                            <div class="result-detail-content">
                                {!! $post->body !!}
                            </div>
                            <div id="comments-section">
                                 @include('client.partials.board_comments', ['post' => $post])
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
         @include('client.partials.footer_buttons')
    </section>

@endsection

@push('scripts')
    <script>
        function toggleReply(id) {
            var el = document.getElementById(id);
            el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }

        $('#likeBtn').click(function() {
            let postId = $(this).data('post');

            $.post('{{ route("client.board.like") }}', {
                '_token':  $('meta[name=csrf-token]').attr('content'),
                'post_id': postId,
            }).done(function(data) {
                if (data.liked) {
                    $('#likeBtn i').css('color', '#e74c3c');
                } else {
                    $('#likeBtn i').css('color', '#ccc');
                }
                $('#likeCount').text(data.count);
            });
        });
    </script>
@endpush
