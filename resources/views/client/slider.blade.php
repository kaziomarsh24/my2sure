<div class="marquee-wrapper">
    @if(!empty($objSliders))
        <button type="button" class="marquee-nav marquee-prev" aria-label="Previous slide">&#10094;</button>
        <div class="marquee-scroller">
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
        </div>
        <button type="button" class="marquee-nav marquee-next" aria-label="Next slide">&#10095;</button>
    @endif
</div>

<style>
    .marquee-wrapper {
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    .marquee-scroller {
        width: 100%;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        cursor: grab;
    }

    .marquee-scroller::-webkit-scrollbar {
        display: none;
    }

    .marquee-scroller.is-dragging {
        cursor: grabbing;
    }

    .marquee-track {
        display: flex;
        width: max-content;
    }

    .marquee-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.55);
        color: #fff;
        font-size: 18px;
        line-height: 40px;
        text-align: center;
        cursor: pointer;
        transition: background 0.2s ease, opacity 0.2s ease;
    }

    .marquee-nav:hover {
        background: rgba(0, 0, 0, 0.85);
    }

    .marquee-prev {
        left: 12px;
    }

    .marquee-next {
        right: 12px;
    }

    .marquee-item {
        flex-shrink: 0;
        width: 600px;
        height: 360px;
        overflow: hidden;
        margin-right: 10px;
        background: #fff;
        user-select: none;
    }

    .marquee-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
        transition: transform 0.3s ease;
        background: #fff;
        pointer-events: none;
    }

    .marquee-item:hover img {
        transform: scale(1.03);
    }

    @media (max-width: 768px) {
        .marquee-item {
            width: 300px;
            height: 200px;
        }
        .marquee-nav {
            width: 34px;
            height: 34px;
            font-size: 15px;
            line-height: 34px;
        }
    }

    @media (min-width: 769px) and (max-width: 1200px) {
        .marquee-item {
            width: 450px;
            height: 280px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.marquee-wrapper').forEach(function (wrapper) {
        var scroller = wrapper.querySelector('.marquee-scroller');
        var track = wrapper.querySelector('.marquee-track');
        var prevBtn = wrapper.querySelector('.marquee-prev');
        var nextBtn = wrapper.querySelector('.marquee-next');
        if (!scroller || !track) return;

        var isPaused = false;
        var isDragging = false;
        var hasDragged = false;
        var startX = 0;
        var startScrollLeft = 0;
        var carry = 0;
        var speedPxPerSec = 35;
        var lastTime = null;

        function getHalfWidth() {
            return track.scrollWidth / 2;
        }

        function normalizeLoop() {
            var half = getHalfWidth();
            if (half <= 0) return;
            if (scroller.scrollLeft >= half) {
                scroller.scrollLeft -= half;
            } else if (scroller.scrollLeft <= 0) {
                scroller.scrollLeft += half;
            }
        }

        function step(timestamp) {
            if (lastTime === null) lastTime = timestamp;
            var dt = (timestamp - lastTime) / 1000;
            lastTime = timestamp;

            if (!isPaused && !isDragging) {
                carry += speedPxPerSec * dt;
                if (carry >= 1) {
                    var whole = Math.floor(carry);
                    carry -= whole;
                    scroller.scrollLeft += whole;
                    normalizeLoop();
                }
            }
            requestAnimationFrame(step);
        }

        requestAnimationFrame(step);

        wrapper.addEventListener('mouseenter', function () { isPaused = true; });
        wrapper.addEventListener('mouseleave', function () { isPaused = false; });
        scroller.addEventListener('touchstart', function () { isPaused = true; }, { passive: true });
        scroller.addEventListener('touchend', function () {
            setTimeout(function () { isPaused = false; }, 1500);
        }, { passive: true });

        scroller.addEventListener('mousedown', function (e) {
            isDragging = true;
            hasDragged = false;
            scroller.classList.add('is-dragging');
            startX = e.pageX;
            startScrollLeft = scroller.scrollLeft;
        });

        window.addEventListener('mousemove', function (e) {
            if (!isDragging) return;
            var dx = e.pageX - startX;
            if (Math.abs(dx) > 5) hasDragged = true;
            scroller.scrollLeft = startScrollLeft - dx;
            normalizeLoop();
        });

        window.addEventListener('mouseup', function () {
            if (!isDragging) return;
            isDragging = false;
            scroller.classList.remove('is-dragging');
        });

        scroller.addEventListener('click', function (e) {
            if (hasDragged) {
                e.preventDefault();
                hasDragged = false;
            }
        });

        function slideBy(direction) {
            var item = track.querySelector('.marquee-item');
            var stepSize = item ? (item.offsetWidth + 10) : 320;
            if (direction < 0 && scroller.scrollLeft < stepSize) {
                scroller.scrollLeft += getHalfWidth();
            }
            scroller.scrollBy({ left: direction * stepSize, behavior: 'smooth' });
            setTimeout(normalizeLoop, 450);
        }

        if (prevBtn) prevBtn.addEventListener('click', function () { slideBy(-1); });
        if (nextBtn) nextBtn.addEventListener('click', function () { slideBy(1); });
    });
});
</script>
