@extends('client.layout')
@section('title', 'VIP Room')

@push('styles')
    <style>
        .vip-hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 70px 0 50px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .vip-hero::before {
            content: 'VIP';
            position: absolute;
            font-size: 200px;
            font-weight: 900;
            color: rgba(255,255,255,0.02);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }
        .vip-crown { font-size: 48px; margin-bottom: 16px; }
        .vip-hero h1 {
            font-size: 46px;
            font-weight: 800;
            background: linear-gradient(45deg, #BF953F, #FCF6BA, #B38728, #FBF5B7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }
        .vip-hero p { font-size: 16px; color: rgba(255,255,255,0.6); }
        .vip-badge {
            display: inline-block;
            background: linear-gradient(45deg, #BF953F, #FCF6BA, #B38728);
            color: #1a1a2e;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 5px 16px;
            border-radius: 30px;
            margin-bottom: 20px;
        }
        .vip-section {
            padding: 50px 0;
            background: #0f0f1a;
            min-height: 60vh;
        }
        .vip-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        @media (max-width: 992px) {
            .vip-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 576px) {
            .vip-grid { grid-template-columns: 1fr; }
        }
        .vip-card {
            background: linear-gradient(145deg, #1a1a2e, #16213e);
            border: 1px solid rgba(191,149,63,0.2);
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
        }
        .vip-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(191,149,63,0.15);
            border-color: rgba(191,149,63,0.5);
            text-decoration: none;
            color: inherit;
        }
        .vip-card-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }
        .vip-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
            opacity: 0.85;
        }
        .vip-card:hover .vip-card-image img {
            transform: scale(1.05);
        }
        .vip-card-no-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #1a1a2e, #0f3460);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
        }
        .vip-card-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .vip-card-body h3 {
            font-size: 18px;
            font-weight: 700;
            background: linear-gradient(45deg, #BF953F, #FCF6BA, #B38728);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            line-height: 1.4;
        }
        .vip-card-meta {
            font-size: 12px;
            color: rgba(255,255,255,0.3);
            margin-bottom: 12px;
        }
        .vip-card-meta i { color: #BF953F; margin-right: 4px; }
        .vip-card-excerpt {
            font-size: 14px;
            color: rgba(255,255,255,0.75);
            line-height: 1.6;
            flex-grow: 1;
        }
        .vip-card-footer {
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid rgba(191,149,63,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .vip-card-comments {
            font-size: 12px;
            color: rgba(255,255,255,0.25);
        }
        .vip-read-more {
            font-size: 13px;
            color: #BF953F;
            font-weight: 600;
        }
        .vip-empty {
            text-align: center;
            padding: 80px 0;
            color: rgba(255,255,255,0.3);
        }
        .vip-empty i {
            font-size: 60px;
            color: rgba(191,149,63,0.3);
            display: block;
            margin-bottom: 16px;
        }
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
                                <li class="breadcrumb-item active">VIP Room</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="vip-hero">
        <div class="container">
            <div class="vip-crown">👑</div>
            <div class="vip-badge">Exclusive Members Only</div>
            <h1>VIP Room</h1>
            <p>Premium predictions, exclusive insights, and members-only content</p>
        </div>
    </section>

    <section class="vip-section">
        <div class="container">

            @if($posts->count() == 0)
                <div class="vip-empty">
                    <i class="fa fa-star"></i>
                    <h4 style="color: rgba(255,255,255,0.3);">No VIP posts yet. Check back soon!</h4>
                </div>
            @else
                <div class="vip-grid">
                    @foreach($posts as $post)
                        <a href="{{ route('client.vip.show', $post->id) }}" class="vip-card">
                            <div class="vip-card-image">
                                @if($post->image)
                                    <img src="{{ asset('uploads/' . $post->image) }}" alt="{{ $post->title }}">
                                @else
                                    <div class="vip-card-no-image">👑</div>
                                @endif
                            </div>
                            <div class="vip-card-body">
                                <h3>{{ $post->title }}</h3>
                                <div class="vip-card-meta">
                                    <i class="fa fa-user"></i> {{ $post->user->name ?? 'Admin' }}
                                    &nbsp;
                                    <i class="fa fa-calendar"></i> {{ $post->created_at->format('d M Y, h:i A') }}
                                </div>
                                <div class="vip-card-excerpt">
                                    {{ Str::limit(strip_tags(html_entity_decode($post->body)), 100) }}
                                </div>
                                <div class="vip-card-footer">
                            <span class="vip-card-comments">
                                <i class="fa fa-comment"></i> {{ $post->comments->count() }} Comments
                            </span>
                                    <span class="vip-read-more">Read More →</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $posts->links('pagination::bootstrap-4') }}
                </div>
            @endif

        </div>
{{--        @include('client.partials.footer_buttons')--}}
    </section>

@endsection
