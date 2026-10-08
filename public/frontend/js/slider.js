(function () {
    'use strict';

    var AUTOPLAY_MS = 5000;

    function initSlider(root) {
        var section = root.closest('section') || document;
        var track = root.querySelector('[data-slider-track]');
        var dotsWrap = root.querySelector('[data-slider-dots]');
        var prev = section.querySelector('[data-slider-prev]');
        var next = section.querySelector('[data-slider-next]');
        var dotClass = root.getAttribute('data-dot-class') || 'slider__dot';
        if (!track) return;

        var cards = Array.prototype.slice.call(track.children);
        var dots = [];
        var timer = null;
        var paused = false;

        function step() {
            if (cards.length < 2) return track.clientWidth;
            return cards[1].offsetLeft - cards[0].offsetLeft;
        }

        function maxScroll() {
            return track.scrollWidth - track.clientWidth;
        }

        function pageCount() {
            var cs = getComputedStyle(track);
            var inner = track.clientWidth - parseFloat(cs.paddingLeft) - parseFloat(cs.paddingRight);
            var perView = Math.max(1, Math.floor((inner + parseFloat(cs.columnGap || 0) + 1) / step()));
            return Math.max(1, cards.length - perView + 1);
        }

        function currentIndex() {
            if (track.scrollLeft >= maxScroll() - 4) return pageCount() - 1;
            return Math.round(track.scrollLeft / step());
        }

        function goTo(index) {
            var count = pageCount();
            if (index < 0) index = count - 1;
            if (index >= count) index = 0;
            track.scrollTo({ left: Math.min(index * step(), maxScroll()) });
        }

        function buildDots() {
            if (!dotsWrap) return;
            var count = pageCount();
            if (dots.length === count) return;
            dotsWrap.innerHTML = '';
            dots = [];
            for (var i = 0; i < count; i++) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = dotClass;
                dot.setAttribute('role', 'tab');
                dot.setAttribute('aria-label', 'Trang ' + (i + 1));
                dot.addEventListener('click', goTo.bind(null, i));
                dotsWrap.appendChild(dot);
                dots.push(dot);
            }
            dotsWrap.hidden = count < 2;
        }

        function update() {
            var index = currentIndex();
            dots.forEach(function (dot, i) {
                dot.classList.toggle('is-active', i === index);
                dot.setAttribute('aria-selected', i === index ? 'true' : 'false');
            });
        }

        function stop() {
            clearInterval(timer);
            timer = null;
        }

        function start() {
            stop();
            if (paused || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            timer = setInterval(function () { goTo(currentIndex() + 1); }, AUTOPLAY_MS);
        }

        if (prev) prev.addEventListener('click', function () { goTo(currentIndex() - 1); start(); });
        if (next) next.addEventListener('click', function () { goTo(currentIndex() + 1); start(); });

        var ticking = false;
        track.addEventListener('scroll', function () {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(function () { ticking = false; update(); });
        }, { passive: true });

        track.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft') { e.preventDefault(); goTo(currentIndex() - 1); }
            if (e.key === 'ArrowRight') { e.preventDefault(); goTo(currentIndex() + 1); }
        });

        [root, prev, next].forEach(function (el) {
            if (!el) return;
            el.addEventListener('mouseenter', function () { paused = true; stop(); });
            el.addEventListener('mouseleave', function () { paused = false; start(); });
        });
        root.addEventListener('focusin', function () { paused = true; stop(); });
        root.addEventListener('focusout', function () { paused = false; start(); });

        var dragStartX = 0;
        var dragStartScroll = 0;
        var dragMoved = false;
        var dragging = false;

        track.addEventListener('pointerdown', function (e) {
            if (e.pointerType !== 'mouse' || e.button !== 0) return;
            dragging = true;
            dragMoved = false;
            dragStartX = e.clientX;
            dragStartScroll = track.scrollLeft;
        });

        window.addEventListener('pointermove', function (e) {
            if (!dragging) return;
            var dx = e.clientX - dragStartX;
            if (!dragMoved && Math.abs(dx) > 5) {
                dragMoved = true;
                track.classList.add('is-dragging');
            }
            if (dragMoved) track.scrollLeft = dragStartScroll - dx;
        });

        window.addEventListener('pointerup', function () {
            if (!dragging) return;
            dragging = false;
            if (!dragMoved) return;
            var index = Math.round(track.scrollLeft / step());
            track.classList.remove('is-dragging');
            goTo(Math.min(index, pageCount() - 1));
        });

        track.addEventListener('dragstart', function (e) { e.preventDefault(); });

        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () { buildDots(); update(); }, 150);
        });

        buildDots();
        update();
        start();
    }

    function init() {
        document.querySelectorAll('[data-slider]').forEach(initSlider);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
