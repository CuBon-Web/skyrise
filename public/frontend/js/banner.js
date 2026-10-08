(function () {
    var banner = document.querySelector('[data-hero-banner]');
    if (!banner) return;

    var slides = banner.querySelectorAll('.hero-banner__slide');
    var bgs = banner.querySelectorAll('.hero-banner__bg');
    var dots = banner.querySelectorAll('.hero-banner__dot');
    var bar = banner.querySelector('.hero-banner__progress span');
    var interval = parseInt(banner.getAttribute('data-interval'), 10) || 6000;
    var current = 0;
    var timer = null;

    banner.style.setProperty('--hero-interval', interval + 'ms');

    function syncScrollbar() {
        var width = window.innerWidth - document.documentElement.clientWidth;
        banner.style.setProperty('--scrollbar-width', width + 'px');
    }
    syncScrollbar();
    window.addEventListener('resize', syncScrollbar);

    function restartProgress() {
        if (!bar) return;
        bar.classList.remove('is-running');
        void bar.offsetWidth;
        bar.classList.add('is-running');
    }

    function show(index) {
        current = (index + slides.length) % slides.length;
        slides.forEach(function (slide, i) {
            var active = i === current;
            slide.classList.toggle('is-active', active);
            slide.setAttribute('aria-hidden', active ? 'false' : 'true');
        });
        bgs.forEach(function (bg, i) {
            bg.classList.toggle('is-active', i === current);
        });
        dots.forEach(function (dot, i) {
            var active = i === current;
            dot.classList.toggle('is-active', active);
            if (active) dot.setAttribute('aria-current', 'true');
            else dot.removeAttribute('aria-current');
        });
        restartProgress();
    }

    function start() {
        stop();
        timer = setInterval(function () { show(current + 1); }, interval);
    }

    function stop() {
        if (timer) clearInterval(timer);
        timer = null;
    }

    function go(index) {
        show(index);
        start();
    }

    dots.forEach(function (dot, i) {
        dot.addEventListener('click', function () { go(i); });
    });

    var prev = banner.querySelector('[data-hero-prev]');
    var next = banner.querySelector('[data-hero-next]');
    if (prev) prev.addEventListener('click', function () { go(current - 1); });
    if (next) next.addEventListener('click', function () { go(current + 1); });

    document.addEventListener('visibilitychange', function () {
        if (slides.length < 2) return;
        if (document.hidden) stop(); else start();
    });

    show(0);
    if (slides.length > 1) start();
})();
