@extends('client.layout')
@section('title', 'VIP Membership')
@section('content')

    <style type="text/css">
        .vip-landing {
            background: radial-gradient(circle at top, #1c1a14 0%, #0c0b08 100%);
            color: #f5f5f5;
            padding: 60px 0 80px;
            min-height: 70vh;
        }
        .vip-landing .vip-title {
            font-size: 44px;
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: linear-gradient(45deg, #BF953F, #FCF6BA, #B38728, #FBF5B7, #AA771C);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }
        .vip-landing .vip-subtitle {
            text-align: center;
            color: #c9b37e;
            font-size: 18px;
            margin-bottom: 42px;
        }
        .vip-video-wrap {
            max-width: 820px;
            margin: 0 auto 42px;
            border: 2px solid #AA771C;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(170, 119, 28, 0.25);
        }
        .vip-video-ratio { position: relative; padding-bottom: 56.25%; height: 0; }
        .vip-video-ratio iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }
        .vip-desc {
            max-width: 820px;
            margin: 0 auto 52px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(191, 149, 63, 0.30);
            border-radius: 14px;
            padding: 28px 32px;
            line-height: 1.8;
            font-size: 16px;
            color: #ffffff;
        }
        .vip-desc,
        .vip-desc p,
        .vip-desc li,
        .vip-desc span,
        .vip-desc strong,
        .vip-desc b,
        .vip-desc em { color: #ffffff !important; }
        .vip-desc h1, .vip-desc h2, .vip-desc h3, .vip-desc h4 { color: #FCF6BA !important; }
        .vip-desc a { color: #FBF5B7 !important; text-decoration: underline; }

        .vip-tiers { display: flex; flex-wrap: wrap; gap: 24px; justify-content: center; }
        .vip-card {
            background: linear-gradient(160deg, #211d14, #14120c);
            border: 1px solid #AA771C;
            border-radius: 18px;
            padding: 30px 24px;
            width: 240px;
            text-align: center;
            transition: all .3s;
        }
        .vip-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(191, 149, 63, 0.35);
            border-color: #FCF6BA;
        }
        .vip-card .tier-name {
            font-size: 22px; font-weight: 700; color: #FCF6BA;
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px;
        }
        .vip-card .tier-price,
        .vip-card .tier-price .js-price { font-size: 32px; font-weight: 800; color: #ffffff !important; margin-bottom: 4px; }
        .vip-card .tier-note,
        .vip-card .tier-note.js-cur-note { font-size: 12px; color: #ffffff !important; margin-bottom: 22px; min-height: 16px; }
        .vip-card .tier-btn {
            display: inline-block; width: 100%; padding: 12px 0;
            border-radius: 40px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
            background: linear-gradient(45deg, #BF953F, #FCF6BA, #B38728, #FBF5B7, #AA771C);
            color: #000000 !important; border: 1px solid #AA771C; transition: all .3s;
        }
        .vip-card .tier-btn:hover {
            background: linear-gradient(45deg, #AA771C, #FBF5B7, #B38728, #FCF6BA, #BF953F);
            transform: scale(1.03);
        }
        @media (max-width: 600px) {
            .vip-landing .vip-title { font-size: 30px; }
            .vip-card { width: 100%; max-width: 320px; }
        }
    </style>

    <section class="vip-landing">
        <div class="container">
            <h1 class="vip-title">VIP Membership</h1>
            <p class="vip-subtitle">Exclusive predictions &amp; members-only content, updated daily.</p>

            @php
                // Resolve a YouTube embed URL. Prefer the one the controller built;
                // otherwise convert the raw saved URL right here so it always plays inline.
                $finalEmbed = $embedUrl ?? '';
                if (empty($finalEmbed) && isset($settings)) {
                    $raw = optional($settings->firstWhere('name', 'vip_video_url'))->detail ?? '';
                    $vid = '';
                    if (!empty($raw) && preg_match('~(?:youtu\.be/|[?&]v=|embed/|shorts/|live/)([A-Za-z0-9_-]{6,})~', $raw, $m)) {
                        $vid = $m[1];
                    }
                    $finalEmbed = $vid ? 'https://www.youtube.com/embed/' . $vid : '';
                }
            @endphp

            @if(!empty($finalEmbed))
                <div class="vip-video-wrap">
                    <div class="vip-video-ratio">
                        <iframe src="{{ $finalEmbed }}?rel=0"
                                title="VIP Video"
                                frameborder="0"
                                allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                    </div>
                </div>
            @endif

            @if(!empty($description))
                <div class="vip-desc">{!! $description !!}</div>
            @endif

            <div class="vip-tiers">
                @foreach($tiers as $key => $tier)
                    <div class="vip-card">
                        <div class="tier-name">{{ $tier['label'] }}</div>
                        <div class="tier-price">
                            <span class="js-price" data-usd="{{ $tier['price'] }}">${{ $tier['price'] }}</span>
                        </div>
                        <div class="tier-note js-cur-note">Charged in your local currency</div>
                        <a href="{{ route('client.vip.subscribe', ['duration' => $key]) }}" class="tier-btn">Subscribe</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        // Optional: convert displayed USD prices to the visitor's local currency.
        // Falls back silently to USD if detection fails — actual charge is converted at checkout.
        fetch('{{ route("detect.country") }}')
            .then(res => res.json())
            .then(data => {
                if (!data || !data.rate || !data.currency) return;
                document.querySelectorAll('.js-price').forEach(function (el) {
                    let usd  = parseFloat(el.getAttribute('data-usd'));
                    let conv = (usd * data.rate).toFixed(2);
                    el.textContent = data.currency + ' ' + conv;
                });
                document.querySelectorAll('.js-cur-note').forEach(function (el) {
                    el.textContent = 'Approx. local price • billed securely';
                });
            })
            .catch(() => {});
    </script>
@endpush