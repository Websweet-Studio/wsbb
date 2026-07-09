(function() {
    'use strict';

    document.querySelectorAll('.wsbb-load-more-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            var button = e.currentTarget;
            var page   = parseInt(button.getAttribute('data-page'), 10) + 1;
            var total  = parseInt(button.getAttribute('data-total'), 10);

            if (page > total) {
                button.disabled = true;
                return;
            }

            // Find the next page link from hidden pagination
            var wrapper = button.closest('.wsbb-post-pagination');
            var links   = wrapper.querySelectorAll('.page-numbers');
            var nextUrl = null;

            links.forEach(function(link) {
                var href = link.getAttribute('href');
                if (href && href.indexOf('paged=' + page) !== -1) {
                    nextUrl = href;
                }
            });

            if (!nextUrl) {
                // fallback: construct from current URL
                var url = new URL(window.location.href);
                url.searchParams.set('paged', page);
                nextUrl = url.toString();
            }

            button.textContent = 'Loading...';
            button.disabled = true;

            fetch(nextUrl)
                .then(function(response) { return response.text(); })
                .then(function(html) {
                    var parser = new DOMParser();
                    var doc    = parser.parseFromString(html, 'text/html');
                    var items  = doc.querySelectorAll('.wsbb-post-item');

                    if (items.length === 0) {
                        button.textContent = 'No more posts';
                        return;
                    }

                    var container = button.closest('.fl-module-wsbb-post');
                    var target    = container ? container.querySelector('.wsbb-post-wrapper') : null;

                    if (!target) {
                        // fallback: just use previous sibling
                        target = button.parentNode.previousElementSibling;
                    }
                    if (!target) return;

                    items.forEach(function(item) {
                        target.appendChild(item);
                    });

                    button.setAttribute('data-page', page);
                    button.textContent = page < total ? 'Load More' : 'All loaded';
                    button.disabled = page >= total;
                })
                .catch(function() {
                    button.textContent = 'Error loading posts';
                    button.disabled = false;
                });
        });
    });
})();
