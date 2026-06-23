(function ($) {
  $(function () {

    $('.wsbb-testimoni-carousel').each(function () {
      var $carousel = $(this);
      var $track    = $carousel.find('.wsbb-testimoni-carousel-track');
      var $items    = $track.children('.wsbb-testimoni-item');
      var $prev     = $carousel.find('.wsbb-carousel-prev');
      var $next     = $carousel.find('.wsbb-carousel-next');
      var $dotsCt   = $carousel.find('.wsbb-carousel-dots');

      var slides      = parseInt($carousel.data('slides'), 10) || 3;
      var autoplay    = $carousel.data('autoplay') === 'yes';
      var autoplaySpd = parseInt($carousel.data('autoplay-speed'), 10) || 4000;
      var showArrows  = $carousel.data('arrows') === 'yes';
      var showDots    = $carousel.data('dots') === 'yes';
      var loop        = $carousel.data('loop') === 'yes';

      var total       = $items.length;
      var gap         = parseInt($track.css('gap'), 10) || 20;
      var interval    = null;
      var isDragging  = false;
      var startX      = 0;
      var endX        = 0;
      var isTransitioning  = false;
      var pendingTransition = null;
      var transitionDir     = null;

      if (total <= slides) {
        loop = false;
        $prev.hide();
        $next.hide();
      }

      var clonesBefore = 0;
      var maxIndex     = Math.max(0, total - slides);
      var current      = 0;

      if (loop && total > slides) {
        clonesBefore = slides;

        for (var i = total - slides; i < total; i++) {
          $track.prepend($items.eq(i).clone().addClass('wsbb-clone'));
        }

        for (var j = 0; j < slides; j++) {
          $track.append($items.eq(j).clone().addClass('wsbb-clone'));
        }

        current = clonesBefore;
        maxIndex = total - 1;
      }

      if (showDots && $dotsCt.length) {
        var dotCount = loop ? total : (maxIndex + 1);
        for (var d = 0; d < dotCount; d++) {
          $dotsCt.append('<button class="wsbb-carousel-dot" data-index="' + d + '"></button>');
        }
      }

      var getRealIndex = function () {
        if (!loop) return current;
        return current - clonesBefore;
      };

      var update = function () {
        var itemWidth = $track.children().first().outerWidth(true);
        var offset = -current * (itemWidth + gap);
        $track.css('transform', 'translateX(' + offset + 'px)');

        if (showDots) {
          var ri = getRealIndex();
          $dotsCt.find('.wsbb-carousel-dot').removeClass('wsbb-active');
          $dotsCt.find('[data-index="' + ri + '"]').addClass('wsbb-active');
        }

        if (showArrows && !loop) {
          $prev.toggle(current > 0);
          $next.toggle(current < maxIndex);
        }
      };

      var jumpToReal = function (realIndex) {
        $track.css('transition', 'none');
        current = clonesBefore + realIndex;
        update();
        $track[0].offsetHeight;
        $track.css('transition', 'transform 0.4s ease');
      };

      var goTo = function (index) {
        if (loop) {
          current = index;
        } else {
          current = Math.max(0, Math.min(maxIndex, index));
        }
        update();
      };

      var goNext = function () {
        if (isTransitioning) {
          if (transitionDir !== 'next') return;
          clearTimeout(pendingTransition);
          if (current >= clonesBefore + total) {
            jumpToReal(0);
          }
        }

        if (loop) {
          transitionDir = 'next';
          isTransitioning = true;
          current++;
          update();

          if (current >= clonesBefore + total) {
            pendingTransition = setTimeout(function () {
              jumpToReal(0);
              isTransitioning = false;
              transitionDir = null;
              pendingTransition = null;
            }, 400);
          } else {
            pendingTransition = setTimeout(function () {
              isTransitioning = false;
              transitionDir = null;
              pendingTransition = null;
            }, 400);
          }
        } else {
          if (current < maxIndex) {
            goTo(current + 1);
          } else {
            goTo(0);
          }
        }
      };

      var goPrev = function () {
        if (isTransitioning) {
          if (transitionDir !== 'prev') return;
          clearTimeout(pendingTransition);
          if (current < clonesBefore) {
            jumpToReal(total - 1);
          }
        }

        if (loop) {
          transitionDir = 'prev';
          isTransitioning = true;
          current--;
          update();

          if (current < clonesBefore) {
            pendingTransition = setTimeout(function () {
              jumpToReal(total - 1);
              isTransitioning = false;
              transitionDir = null;
              pendingTransition = null;
            }, 400);
          } else {
            pendingTransition = setTimeout(function () {
              isTransitioning = false;
              transitionDir = null;
              pendingTransition = null;
            }, 400);
          }
        } else {
          if (current > 0) {
            goTo(current - 1);
          } else {
            goTo(maxIndex);
          }
        }
      };

      $next.on('click', goNext);
      $prev.on('click', goPrev);

      if (showDots && $dotsCt.length) {
        $dotsCt.on('click', '.wsbb-carousel-dot', function () {
          var target = parseInt($(this).data('index'), 10);
          goTo(loop ? clonesBefore + target : target);
        });
      }

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
