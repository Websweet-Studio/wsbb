(function ($) {
  $(function () {

    $('.wsbb-post-carousel').each(function () {
      var $carousel = $(this);
      var $track    = $carousel.find('.wsbb-post-carousel-track');
      var $items    = $track.children('.wsbb-post-item');
      var $prev     = $carousel.find('.wsbb-carousel-prev');
      var $next     = $carousel.find('.wsbb-carousel-next');
      var $dotsCt   = $carousel.find('.wsbb-carousel-dots');

      var slides      = parseInt($carousel.data('slides'), 10) || 3;
      var autoplay    = $carousel.data('autoplay') === 'yes';
      var autoplaySpd = parseInt($carousel.data('autoplay-speed'), 10) || 4000;
      var showArrows  = $carousel.data('arrows') === 'yes';
      var showDots    = $carousel.data('dots') === 'yes';

      var total       = $items.length;
      var current     = 0;
      var maxIndex    = Math.max(0, total - slides);
      var gap         = parseInt($track.css('gap'), 10) || 20;
      var interval    = null;
      var isDragging  = false;
      var startX      = 0;
      var endX        = 0;

      if (total <= slides) {
        $prev.hide();
        $next.hide();
        return;
      }

      // Build dots
      if (showDots && $dotsCt.length) {
        for (var i = 0; i <= maxIndex; i++) {
          $dotsCt.append('<button class="wsbb-carousel-dot" data-index="' + i + '"></button>');
        }
      }

      var update = function () {
        var itemWidth = $items.first().outerWidth(true);
        var offset = -current * (itemWidth + gap);
        $track.css('transform', 'translateX(' + offset + 'px)');

        if (showDots) {
          $dotsCt.find('.wsbb-carousel-dot').removeClass('wsbb-active');
          $dotsCt.find('[data-index="' + current + '"]').addClass('wsbb-active');
        }

        if (showArrows) {
          $prev.toggle(current > 0);
          $next.toggle(current < maxIndex);
        }
      };

      var goTo = function (index) {
        current = Math.max(0, Math.min(maxIndex, index));
        update();
      };

      var goNext = function () {
        if (current < maxIndex) {
          goTo(current + 1);
        } else {
          goTo(0);
        }
      };

      var goPrev = function () {
        if (current > 0) {
          goTo(current - 1);
        } else {
          goTo(maxIndex);
        }
      };

      // Navigation events
      $next.on('click', goNext);
      $prev.on('click', goPrev);

      if (showDots && $dotsCt.length) {
        $dotsCt.on('click', '.wsbb-carousel-dot', function () {
          goTo(parseInt($(this).data('index'), 10));
        });
      }

      // Touch / swipe
      $track.on('mousedown touchstart', function (e) {
        isDragging = true;
        startX = e.type === 'touchstart' ? e.originalEvent.touches[0].pageX : e.pageX;
        $track.css('transition', 'none');
      });

      $track.on('mousemove touchmove', function (e) {
        if (!isDragging) return;
        e.preventDefault();
        endX = e.type === 'touchmove' ? e.originalEvent.touches[0].pageX : e.pageX;
      });

      $(document).on('mouseup.swipe touchend.swipe', function () {
        if (!isDragging) return;
        isDragging = false;
        $track.css('transition', 'transform 0.4s ease');

        var diff = startX - endX;
        var threshold = 50;

        if (Math.abs(diff) > threshold) {
          if (diff > 0) {
            goNext();
          } else {
            goPrev();
          }
        } else {
          update();
        }
      });

      // Autoplay
      if (autoplay) {
        var startAutoplay = function () {
          interval = setInterval(goNext, autoplaySpd);
        };
        var stopAutoplay = function () {
          clearInterval(interval);
        };

        startAutoplay();

        $carousel.on('mouseenter', stopAutoplay);
        $carousel.on('mouseleave', startAutoplay);
        $carousel.on('touchstart', stopAutoplay);
        $carousel.on('touchend', function () {
          setTimeout(startAutoplay, 2000);
        });
      }

      update();
    });

  });
})(jQuery);
