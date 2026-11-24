@extends('client.layout')
@section('title', $post->title)

@push('styles')
    <style>
        .vip-detail-section {
            padding: 50px 0;
            background: #0f0f1a;
            min-height: 70vh;
        }
        .vip-detail-card {
            background: linear-gradient(145deg, #1a1a2e, #16213e);
            border: 1px solid rgba(191,149,63,0.2);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0,0,0,0.5);
            margin-bottom: 30px;
        }
        .vip-detail-image img {
            width: 100%;
            max-height: 440px;
            object-fit: cover;
            opacity: 0.9;
        }
        .vip-detail-body { padding: 36px; }
        .vip-detail-body h1 {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(45deg, #BF953F, #FCF6BA, #B38728);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
            line-height: 1.3;
        }
        .vip-detail-meta {
            font-size: 13px;
            color: rgba(255,255,255,0.3);
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(191,149,63,0.15);
        }
        .vip-detail-meta i { color: #BF953F; margin-right: 4px; }
        .vip-detail-content {
            font-size: 16px;
            color: rgba(255,255,255,0.75);
            line-height: 1.9;
        }
        .vip-detail-content p,
        .vip-detail-content span,
        .vip-detail-content h1,
        .vip-detail-content h2,
        .vip-detail-content h3,
        .vip-detail-content h4,
        .vip-detail-content h5,
        .vip-detail-content h6,
        .vip-detail-content li,
        .vip-detail-content td,
        .vip-detail-content a {
            color: rgba(255,255,255,0.85) !important;
        }
        .vip-detail-content a {
            color: #BF953F !important;
            text-decoration: underline;
        }
        .vip-detail-content a:hover {
            color: #FCF6BA !important;
        }
        .vip-detail-content strong,
        .vip-detail-content b {
            color: #ffffff !important;
        }
        .board-comment-bubble p,
        .board-comment-bubble span,
        .board-comment-bubble strong {
            color: rgba(255,255,255,0.85) !important;
        }
        .board-reply-bubble p,
        .board-reply-bubble span,
        .board-reply-bubble strong {
            color: rgba(255,255,255,0.75) !important;
        }
        .board-comments-section strong {
            color: rgba(255,255,255,0.9) !important;
        }
        .board-comment-bubble {
            color: rgba(255,255,255,0.85) !important;
        }
        .board-reply-bubble {
            color: rgba(255,255,255,0.75) !important;
        }
        .vip-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #BF953F;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
            text-decoration: none;
        }
        .vip-back-btn:hover {
            color: #FCF6BA;
            text-decoration: none;
        }

        /* VIP Comments */
        .board-comments-title {
            font-size: 15px;
            font-weight: 700;
            color: #BF953F;
            border-bottom: 1px solid rgba(191,149,63,0.3);
            padding-bottom: 8px;
            margin-bottom: 20px;
        }
        .board-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(45deg, #BF953F, #B38728);
            color: #1a1a2e;
            font-weight: 700;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .board-avatar-sm { width: 28px; height: 28px; font-size: 12px; }
        .board-comment-input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(191,149,63,0.2);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            color: #fff;
            resize: none;
            outline: none;
            transition: border 0.2s;
        }
        .board-comment-input:focus { border-color: #BF953F; }
        .board-comment-input::placeholder { color: rgba(255,255,255,0.25); }
        .board-comment-btn {
            margin-top: 8px;
            background: linear-gradient(45deg, #BF953F, #B38728);
            color: #1a1a2e;
            border: none;
            border-radius: 6px;
            padding: 7px 18px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .board-comment-btn:hover { opacity: 0.85; }
        .board-comment { margin-bottom: 16px; }
        .board-comment-bubble {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(191,149,63,0.1);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            color: rgba(255,255,255,0.8);
        }
        .board-reply-bubble {
            background: rgba(191,149,63,0.05);
            border-color: rgba(191,149,63,0.15);
        }
        .board-comment-time { font-size: 11px; color: rgba(255,255,255,0.25); margin-left: 8px; }
        .board-reply-toggle {
            background: none;
            border: none;
            color: #BF953F;
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
                        <h1 class="page-title">VIP Room</h1>
                        <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('client.vip') }}">VIP Room</a></li>
                                <li class="breadcrumb-item active">{{ Str::limit($post->title, 40) }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="vip-detail-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">


                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="{{ route('client.vip') }}" class="vip-back-btn">
                            <i class="fa fa-arrow-left"></i> Back to VIP Room
                        </a>
                        <a href="#comments-section" class="result-back-btn" style="margin-bottom: 0; color: #34b5f7;">
                            <i class="fa fa-comments"></i> Go to Comments
                        </a>
                    </div>
                    <div class="vip-detail-card">
                        @if($post->image)
                            <div class="vip-detail-image">
                                <img src="{{ asset('uploads/' . $post->image) }}" alt="{{ $post->title }}">
                            </div>
                        @endif
                        <div class="vip-detail-body">
                            <h1>{{ $post->title }}</h1>
                            <div class="result-detail-meta" style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="text-white-50">
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
                            <div class="vip-detail-content">
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
