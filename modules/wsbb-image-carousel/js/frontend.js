(function ($) {
  $(function () {
    $(".wsbb-ic-wrapper").each(function () {
      var $wrapper = $(this);
      var mode = $wrapper.data("mode"); // 'carousel' | 'marquee'

      if (mode === "carousel") {
        var $track = $wrapper.find(".wsbb-ic-track");
        initCarousel($wrapper, $track);
      } else if (mode === "marquee") {
        var $track = $wrapper.find(".wsbb-ic-marquee-track");
        initMarquee($wrapper, $track);
      }
    });

    function initCarousel($wrapper, $track) {
      var $slides = $track.children(".wsbb-ic-slide");
      var $prev = $wrapper.find(".wsbb-carousel-prev");
      var $next = $wrapper.find(".wsbb-carousel-next");
      var $dotsCt = $wrapper.find(".wsbb-carousel-dots");

      var visible     = parseInt($wrapper.data("visible"), 10) || 4;
      var step        = parseInt($wrapper.data("step"), 10) || 1;
      var autoplay    = $wrapper.data("autoplay") === "yes";
      var autoplaySpd = parseInt($wrapper.data("autoplay-speed"), 10) || 4000;
      var showArrows  = $wrapper.data("arrows") === "yes";
      var showDots    = $wrapper.data("dots") === "yes";
      var loop        = $wrapper.data("loop") === "yes";

      var total = $slides.length;
      var gapVal = parseInt($track.css("gap"), 10) || 20;
      var current = 0;
      var maxIndex = Math.max(0, total - visible);
      var interval = null;
      var isDragging = false;
      var startX = 0;
      var endX = 0;
      var isTransitioning = false;
      var pendingTransition = null;
      var transitionDir = null;

      if (total <= visible) {
        loop = false;
        $prev.hide();
        $next.hide();
      }

      var clonesBefore = 0;
      if (loop && total > visible) {
        clonesBefore = visible;
        for (var i = total - visible; i < total; i++) {
          $track.append($slides.eq(i).clone().addClass("wsbb-clone"));
        }
        for (var j = 0; j < visible; j++) {
          $track.prepend($slides.eq(j).clone().addClass("wsbb-clone"));
        }
        current = clonesBefore;
        maxIndex = total - 1;
      }

      if (showDots && $dotsCt.length) {
        var dotCount = loop ? total : Math.max(1, Math.ceil(total / step));
        for (var d = 0; d < dotCount; d++) {
          $dotsCt.append(
            '<button class="wsbb-carousel-dot" data-index="' +
              d +
              '"></button>',
          );
        }
      }

      var getRealIndex = function () {
        if (!loop) return current;
        return current - clonesBefore;
      };

      var update = function () {
        var itemWidth = $slides.first().outerWidth(true);
        var offset = -current * (itemWidth + gapVal);
        $track.css("transform", "translateX(" + offset + "px)");

        if (showDots) {
          var ri = loop ? getRealIndex() : Math.floor(current / step);
          $dotsCt.find(".wsbb-carousel-dot").removeClass("wsbb-active");
          $dotsCt.find('[data-index="' + ri + '"]').addClass("wsbb-active");
        }

        if (showArrows && !loop) {
          $prev.toggle(current > 0);
          $next.toggle(current + visible < total);
        }
      };

      var jumpToReal = function (realIndex) {
        $track.css("transition", "none");
        current = clonesBefore + realIndex;
        update();
        $track[0].offsetHeight;
        $track.css("transition", "transform 0.4s ease");
      };

      var goTo = function (index) {
        if (loop) {
          current = index;
        } else {
          current = Math.max(0, Math.min(total - visible, index));
        }
        update();
      };

      var goNext = function () {
        if (isTransitioning) {
          if (transitionDir !== "next") return;
          clearTimeout(pendingTransition);
          if (current >= clonesBefore + total) jumpToReal(0);
        }

        if (loop) {
          transitionDir = "next";
          isTransitioning = true;
          current += step;
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
          if (current + step < total) goTo(current + step);
          else goTo(0);
        }
      };

      var goPrev = function () {
        if (isTransitioning) {
          if (transitionDir !== "prev") return;
          clearTimeout(pendingTransition);
          if (current < clonesBefore) jumpToReal(total - 1);
        }

        if (loop) {
          transitionDir = "prev";
          isTransitioning = true;
          current -= step;
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
          if (current - step >= 0) goTo(current - step);
          else goTo(total - visible);
        }
      };

      $next.on("click", goNext);
      $prev.on("click", goPrev);

      if (showDots && $dotsCt.length) {
        $dotsCt.on("click", ".wsbb-carousel-dot", function () {
          var target = parseInt($(this).data("index"), 10);
          goTo(loop ? clonesBefore + target : target);
        });
      }

      // Touch / swipe
      $track.on("mousedown touchstart", function (e) {
        isDragging = true;
        startX =
          e.type === "touchstart" ? e.originalEvent.touches[0].pageX : e.pageX;
        $track.css("transition", "none");
      });

      $track.on("mousemove touchmove", function (e) {
        if (!isDragging) return;
        e.preventDefault();
        endX =
          e.type === "touchmove" ? e.originalEvent.touches[0].pageX : e.pageX;
      });

      $(document).on("mouseup.swipe touchend.swipe", function () {
        if (!isDragging) return;
        isDragging = false;
        $track.css("transition", "transform 0.4s ease");
        var diff = startX - endX;
        if (Math.abs(diff) > 50) {
          if (diff > 0) goNext();
          else goPrev();
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
        $wrapper.on("mouseenter", stopAutoplay);
        $wrapper.on("mouseleave", startAutoplay);
        $wrapper.on("touchstart", stopAutoplay);
        $wrapper.on("touchend", function () {
          setTimeout(startAutoplay, 2000);
        });
      }

      update();
    }

    function initMarquee($wrapper, $track) {
      var speed = parseInt($wrapper.data("marquee-speed"), 10) || 20;
      var dir = $wrapper.data("marquee-dir") || "left";
      var pause = $wrapper.data("marquee-pause") === "yes";

      // Clone all items for seamless loop
      var $items = $track.children(".wsbb-ic-marquee-item");
      $items.each(function () {
        $track.append($(this).clone());
      });

      var animName =
        dir === "left" ? "wsbb-marquee-left" : "wsbb-marquee-right";
      var keyframesLeft =
        "@keyframes wsbb-marquee-left { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }";
      var keyframesRight =
        "@keyframes wsbb-marquee-right { 0% { transform: translateX(-50%); } 100% { transform: translateX(0); } }";

      var $style = $("<style>")
        .text(dir === "left" ? keyframesLeft : keyframesRight)
        .appendTo("head");

      $track.css({
        animation: animName + " " + speed + "s linear infinite",
      });

      if (pause) {
        $wrapper.on("mouseenter", function () {
          $wrapper.addClass("wsbb-ic-marquee-paused");
        });
        $wrapper.on("mouseleave", function () {
          $wrapper.removeClass("wsbb-ic-marquee-paused");
        });
      }
    }
  });
})(jQuery);
