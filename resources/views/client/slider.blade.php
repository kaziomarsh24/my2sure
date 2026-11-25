<div class="marquee-wrapper">
    @if(!empty($objSliders))
        <div class="marquee-track">
            {{-- Original set --}}
            @foreach($objSliders as $objSlider)
                <a href="{{$objSlider['link']}}" target="_blank" class="marquee-item">
                    <img src="{{ \App\Support\MediaHelper::url($objSlider['image'], 'thumb') }}" loading="lazy" decoding="async" alt="slide">
                </a>
            @endforeach
            {{-- Duplicate set for seamless loop --}}
            @foreach($objSliders as $objSlider)
                <a href="{{$objSlider['link']}}" target="_blank" class="marquee-item">
                    <img src="{{ \App\Support\MediaHelper::url($objSlider['image'], 'thumb') }}" loading="lazy" decoding="async" alt="slide">
                </a>
            @endforeach
        </div>
    @endif
</div>

<style>
    .marquee-wrapper {
        width: 100%;
        overflow: hidden;
        /*background: #000;*/
        position: relative;
    }

    .marquee-track {
        display: flex;
        width: max-content;
        animation: marqueeScroll 60s linear infinite;
    }

    .marquee-track:hover {
        animation-play-state: paused;
    }

    .marquee-item {
        flex-shrink: 0;
        width: 600px;
        height: 360px;
        overflow: hidden;
        margin-right: 10px;
        background: #fff;
    }

    .marquee-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
        transition: transform 0.3s ease;
        background: #fff;
    }

    .marquee-item:hover img {
        transform: scale(1.03);
    }

    @keyframes marqueeScroll {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    @media (max-width: 768px) {
        .marquee-item {
            width: 300px;
            height: 200px;
        }
    }

    @media (min-width: 769px) and (max-width: 1200px) {
        .marquee-item {
            width: 450px;
            height: 280px;
        }
    }
</style>
