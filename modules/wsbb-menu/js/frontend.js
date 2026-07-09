(function($) {
    $(function() {
        $('.wsbb-menu-toggle').on('click', function() {
            var $btn   = $(this);
            var $wrap  = $btn.closest('.wsbb-menu-wrap');
            var $nav   = $wrap.find('.wsbb-menu-nav');
            var isOpen = $nav.hasClass('wsbb-menu--open');

            if (isOpen) {
                $nav.removeClass('wsbb-menu--open');
                $btn.attr('aria-expanded', 'false');
            } else {
                $nav.addClass('wsbb-menu--open');
                $btn.attr('aria-expanded', 'true');
            }
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            var $target = $(e.target);
            if (! $target.closest('.wsbb-menu-wrap').length) {
                $('.wsbb-menu-nav.wsbb-menu--open')
                    .removeClass('wsbb-menu--open')
                    .closest('.wsbb-menu-wrap')
                    .find('.wsbb-menu-toggle')
                    .attr('aria-expanded', 'false');
            }
        });
    });
})(jQuery);
