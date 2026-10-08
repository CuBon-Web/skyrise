(function () {
    var triggers = document.querySelectorAll('[data-video-popup]');
    if (!triggers.length) return;

    var modal = document.createElement('div');
    modal.className = 'video-popup';
    modal.setAttribute('role', 'dialog');
    modal.setAttribute('aria-modal', 'true');
    modal.setAttribute('aria-label', 'Video');
    modal.innerHTML =
        '<div class="video-popup__backdrop" data-video-close></div>' +
        '<div class="video-popup__dialog">' +
            '<button type="button" class="video-popup__close" data-video-close aria-label="Đóng">&times;</button>' +
            '<div class="video-popup__frame"></div>' +
        '</div>';
    document.body.appendChild(modal);

    var frame = modal.querySelector('.video-popup__frame');
    var lastTrigger = null;

    function open(id, trigger) {
        lastTrigger = trigger;
        frame.innerHTML = '<iframe src="https://www.youtube.com/embed/' + encodeURIComponent(id) +
            '?autoplay=1&rel=0&modestbranding=1" title="YouTube video" frameborder="0"' +
            ' allow="autoplay; encrypted-media; picture-in-picture; fullscreen" allowfullscreen></iframe>';
        modal.classList.add('is-open');
        document.documentElement.classList.add('video-popup-lock');
        modal.querySelector('.video-popup__close').focus();
    }

    function close() {
        if (!modal.classList.contains('is-open')) return;
        modal.classList.remove('is-open');
        document.documentElement.classList.remove('video-popup-lock');
        frame.innerHTML = '';
        if (lastTrigger) lastTrigger.focus();
    }

    triggers.forEach(function (trigger) {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            open(trigger.getAttribute('data-video-popup'), trigger);
        });
    });

    modal.addEventListener('click', function (e) {
        if (e.target.closest('[data-video-close]')) close();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') close();
    });
})();
