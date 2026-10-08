(function () {
    var sidebar = document.querySelector('.event-sidebar');
    if (!sidebar) return;

    var baseTop = 140;
    var update = function () {
        // Tall sidebars stick by their bottom edge so the last widget stays reachable.
        var fit = window.innerHeight - sidebar.offsetHeight - 20;
        sidebar.style.setProperty('--event-sticky-top', Math.min(baseTop, fit) + 'px');
    };

    update();
    window.addEventListener('resize', update);
    window.addEventListener('load', update);
})();
