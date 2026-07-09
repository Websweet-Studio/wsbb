(function() {
    'use strict';

    if (!window.IntersectionObserver) {
        document.querySelectorAll('.wsbb-animate').forEach(function(el) {
            el.classList.add('wsbb-visible');
        });
        return;
    }

    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('wsbb-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    document.querySelectorAll('.wsbb-animate').forEach(function(el) {
        observer.observe(el);
    });
})();
