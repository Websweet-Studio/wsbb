(function ($) {
  $(function () {

    var openLightbox = function (overlay, image, caption) {
      overlay.addClass('wsbb-active');
      overlay.find('.wsbb-lightbox-image').attr('src', image);
      overlay.find('.wsbb-lightbox-caption').text(caption || '');
      $('body').css('overflow', 'hidden');
    };

    var closeLightbox = function (overlay) {
      overlay.removeClass('wsbb-active');
      $('body').css('overflow', '');
    };

    // Click on gallery link → open lightbox
    $(document).on('click', '.wsbb-gallery-link', function (e) {
      e.preventDefault();
      var $link     = $(this);
      var $grid     = $link.closest('.wsbb-gallery-grid');
      var $items    = $grid.find('.wsbb-gallery-link');
      var $overlay  = $grid.siblings('.wsbb-lightbox-overlay');
      var img       = $link.attr('href');
      var caption   = $link.data('caption') || '';
      var index     = parseInt($link.data('index'), 10);

      $overlay.data('current-index', index);
      $overlay.data('total-items', $items.length);
      openLightbox($overlay, img, caption);
    });

    // Close button
    $(document).on('click', '.wsbb-lightbox-close', function () {
      var $overlay = $(this).closest('.wsbb-lightbox-overlay');
      closeLightbox($overlay);
    });

    // Click overlay background to close
    $(document).on('click', '.wsbb-lightbox-overlay', function (e) {
      if ($(e.target).hasClass('wsbb-lightbox-overlay')) {
        closeLightbox($(this));
      }
    });

    // Previous
    $(document).on('click', '.wsbb-lightbox-prev', function () {
      var $overlay  = $(this).closest('.wsbb-lightbox-overlay');
      var $grid     = $overlay.siblings('.wsbb-gallery-grid');
      var $items    = $grid.find('.wsbb-gallery-link');
      var current   = $overlay.data('current-index');
      var prevIndex = (current - 1 + $items.length) % $items.length;
      var $prev     = $items.eq(prevIndex);
      var img       = $prev.attr('href');
      var caption   = $prev.data('caption') || '';

      $overlay.data('current-index', prevIndex);
      openLightbox($overlay, img, caption);
    });

    // Next
    $(document).on('click', '.wsbb-lightbox-next', function () {
      var $overlay  = $(this).closest('.wsbb-lightbox-overlay');
      var $grid     = $overlay.siblings('.wsbb-gallery-grid');
      var $items    = $grid.find('.wsbb-gallery-link');
      var current   = $overlay.data('current-index');
      var nextIndex = (current + 1) % $items.length;
      var $next     = $items.eq(nextIndex);
      var img       = $next.attr('href');
      var caption   = $next.data('caption') || '';

      $overlay.data('current-index', nextIndex);
      openLightbox($overlay, img, caption);
    });

    // Keyboard navigation
    $(document).on('keydown', function (e) {
      var $overlay = $('.wsbb-lightbox-overlay.wsbb-active');
      if (!$overlay.length) return;

      if (e.key === 'Escape' || e.keyCode === 27) {
        closeLightbox($overlay);
      }
      if (e.key === 'ArrowLeft' || e.keyCode === 37) {
        $overlay.find('.wsbb-lightbox-prev').trigger('click');
      }
      if (e.key === 'ArrowRight' || e.keyCode === 39) {
        $overlay.find('.wsbb-lightbox-next').trigger('click');
      }
    });

  });
})(jQuery);
