(function () {
    'use strict';

    var section = document.querySelector('.gallery-marquee');
    if (!section) return;

    var links = Array.prototype.slice.call(section.querySelectorAll('[data-gallery-item]'));
    var photos = [];
    links.forEach(function (link) {
        var href = link.getAttribute('href');
        if (photos.some(function (p) { return p.src === href; })) return;
        var img = link.querySelector('img');
        photos.push({ src: href, alt: (img && img.alt) || '' });
    });
    if (!photos.length) return;

    var box = document.createElement('div');
    box.className = 'gallery-lightbox';
    box.setAttribute('role', 'dialog');
    box.setAttribute('aria-modal', 'true');
    box.setAttribute('aria-label', 'Xem ảnh');
    box.hidden = true;
    box.innerHTML =
        '<button type="button" class="gallery-lightbox__close" aria-label="Đóng">' +
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>' +
        '</button>' +
        '<button type="button" class="gallery-lightbox__arrow gallery-lightbox__arrow--prev" aria-label="Ảnh trước">' +
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg>' +
        '</button>' +
        '<figure class="gallery-lightbox__figure"><img class="gallery-lightbox__img" alt=""></figure>' +
        '<button type="button" class="gallery-lightbox__arrow gallery-lightbox__arrow--next" aria-label="Ảnh tiếp theo">' +
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg>' +
        '</button>' +
        '<span class="gallery-lightbox__counter"></span>';
    document.body.appendChild(box);

    var img = box.querySelector('.gallery-lightbox__img');
    var counter = box.querySelector('.gallery-lightbox__counter');
    var closeBtn = box.querySelector('.gallery-lightbox__close');
    var current = 0;
    var lastFocus = null;

    function show(index) {
        current = (index + photos.length) % photos.length;
        box.classList.add('is-loading');
        img.onload = function () { box.classList.remove('is-loading'); };
        img.src = photos[current].src;
        img.alt = photos[current].alt;
        counter.textContent = (current + 1) + ' / ' + photos.length;
    }

    function open(index) {
        lastFocus = document.activeElement;
        box.hidden = false;
        document.documentElement.classList.add('gallery-lightbox-open');
        requestAnimationFrame(function () { box.classList.add('is-open'); });
        show(index);
        closeBtn.focus();
    }

    function close() {
        box.classList.remove('is-open');
        document.documentElement.classList.remove('gallery-lightbox-open');
        setTimeout(function () { box.hidden = true; img.removeAttribute('src'); }, 250);
        if (lastFocus) lastFocus.focus({ preventScroll: true });
    }

    section.addEventListener('click', function (e) {
        var link = e.target.closest('[data-gallery-item]');
        if (!link) return;
        e.preventDefault();
        e.stopPropagation();
        var href = link.getAttribute('href');
        var index = photos.findIndex(function (p) { return p.src === href; });
        open(index < 0 ? 0 : index);
    }, true);

    closeBtn.addEventListener('click', close);
    box.querySelector('.gallery-lightbox__arrow--prev').addEventListener('click', function () { show(current - 1); });
    box.querySelector('.gallery-lightbox__arrow--next').addEventListener('click', function () { show(current + 1); });
    box.addEventListener('click', function (e) {
        if (e.target === box || e.target.classList.contains('gallery-lightbox__figure')) close();
    });

    document.addEventListener('keydown', function (e) {
        if (box.hidden) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') show(current - 1);
        if (e.key === 'ArrowRight') show(current + 1);
    });

    var touchX = null;
    box.addEventListener('touchstart', function (e) { touchX = e.touches[0].clientX; }, { passive: true });
    box.addEventListener('touchend', function (e) {
        if (touchX === null) return;
        var dx = e.changedTouches[0].clientX - touchX;
        touchX = null;
        if (Math.abs(dx) > 40) show(current + (dx < 0 ? 1 : -1));
    });
})();
