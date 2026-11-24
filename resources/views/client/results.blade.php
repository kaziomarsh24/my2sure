@extends('client.layout')
@section('title', 'Winning Results')

@push('styles')
    <style>
        .results-section {
            padding: 50px 0;
            background: #f5f7fa;
        }
        .result-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        @media (max-width: 992px) {
            .result-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 576px) {
            .result-grid { grid-template-columns: 1fr; }
        }
        .result-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.07);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
        }
        .result-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.12);
            text-decoration: none;
            color: inherit;
        }
        .result-card-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .result-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .result-card:hover .result-card-image img {
            transform: scale(1.05);
        }
        .result-card-no-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #34b5f7 0%, #1a6fa8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .result-card-no-image i {
            font-size: 48px;
            color: rgba(255,255,255,0.4);
        }
        .result-card-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .result-card-body h3 {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 8px;
            line-height: 1.4;
        }
        .result-card-meta {
            font-size: 12px;
            color: #aaa;
            margin-bottom: 12px;
        }
        .result-card-meta i {
            color: #34b5f7;
            margin-right: 4px;
        }
        .result-card-excerpt {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            flex-grow: 1;
        }
        .result-card-footer {
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .result-card-comments {
            font-size: 12px;
            color: #aaa;
        }
        .result-read-more {
            font-size: 13px;
            color: #34b5f7;
            font-weight: 600;
        }
        .results-empty {
            text-align: center;
            padding: 80px 0;
            color: #aaa;
        }
        .results-empty i {
            font-size: 60px;
            color: #34b5f7;
            opacity: 0.3;
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
                        <h1 class="page-title">Winning Results</h1>
                        <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Home</a></li>
                                <li class="breadcrumb-item active">Winning Results</li>
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

    <section class="results-section">
        <div class="container">

            @if($posts->count() == 0)
                <div class="results-empty">
                    <i class="fa fa-trophy"></i>
                    <h4>No results posted yet. Check back soon!</h4>
                </div>
            @else
                <div class="result-grid">
                    @foreach($posts as $post)
                        <a href="{{ route('client.results.show', $post->id) }}" class="result-card">
                            <div class="result-card-image">
                                @if($post->image)
                                    <img src="{{ asset('uploads/' . $post->image) }}" alt="{{ $post->title }}">
                                @else
                                    <div class="result-card-no-image">
                                        <i class="fa fa-trophy"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="result-card-body">
                                <h3>{{ $post->title }}</h3>
                                <div class="result-card-meta">
                                    <i class="fa fa-user"></i> {{ $post->user->name ?? 'Admin' }}
                                    &nbsp;
                                    <i class="fa fa-calendar"></i> {{ $post->created_at->format('d M Y, h:i A') }}
                                </div>
                                <div class="result-card-excerpt">
                                    {{ Str::limit(strip_tags(html_entity_decode($post->body)), 100) }}
                                </div>
                                <div class="result-card-footer">
                            <span class="result-card-comments">
                                <i class="fa fa-comment"></i> {{ $post->comments->count() }} Comments
                            </span>
                                    <span class="result-read-more">Read More →</span>
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
