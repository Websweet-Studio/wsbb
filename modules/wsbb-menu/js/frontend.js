(function ($) {
  "use strict";

  $(function () {
    // ── Mobile hamburger toggle ──────────────────────────
    $(".wsbb-menu-toggle").on("click", function (e) {
      e.stopPropagation();
      var $btn = $(this);
      var $wrap = $btn.closest(".wsbb-menu-wrap");
      var $nav = $wrap.find(".wsbb-menu-nav");
      var isOpen = $nav.hasClass("wsbb-menu--open");

      if (isOpen) {
        closeMenu($btn, $nav);
      } else {
        $nav.addClass("wsbb-menu--open");
        $btn.attr("aria-expanded", "true");
      }
    });

    // ── Submenu toggle button click ──────────────────────
    $(".wsbb-submenu-toggle").on("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      toggleSubmenu($(this));
    });

    // ── Accordion: click on parent link toggles submenu ──
    $(
      ".wsbb-menu-accordion .wsbb-has-submenu > .wsbb-has-submenu-container > a",
    ).on("click", function (e) {
      var $li = $(this).closest("li.wsbb-has-submenu");
      var $sub = $li.children(".sub-menu");
      if ($sub.length) {
        e.preventDefault();
        toggleAccordion($li);
      }
    });

    // ── Close menu when clicking outside ────────────────
    $(document).on("click", function (e) {
      var $target = $(e.target);
      if (!$target.closest(".wsbb-menu-wrap").length) {
        $(".wsbb-menu-nav.wsbb-menu--open").each(function () {
          var $nav = $(this);
          var $wrap = $nav.closest(".wsbb-menu-wrap");
          var $btn = $wrap.find(".wsbb-menu-toggle");
          closeMenu($btn, $nav);
        });
      }
    });

    // ── Escape key closes submenus and mobile menu ──────
    $(document).on("keydown", function (e) {
      if (e.key !== "Escape") return;
      var $target = $(e.target);

      // Close mobile menu
      if ($target.closest(".wsbb-menu--open").length) {
        var $nav = $target.closest(".wsbb-menu-nav");
        var $wrap = $nav.closest(".wsbb-menu-wrap");
        var $btn = $wrap.find(".wsbb-menu-toggle");
        if ($btn.length) {
          closeMenu($btn, $nav);
          $btn.trigger("focus");
          return;
        }
      }

      // Close accordion submenu
      if ($target.closest(".wsbb-submenu-open").length) {
        var $li = $target.closest("li.wsbb-submenu-open");
        $li.removeClass("wsbb-submenu-open");
        $li.children(".sub-menu").removeClass("wsbb-submenu-open");
        $li.find("> .wsbb-has-submenu-container > a").trigger("focus");
      }
    });

    // ── Helper: toggle submenu (for horizontal/vertical) ─
    function toggleSubmenu($toggle) {
      var $container = $toggle.closest(".wsbb-has-submenu-container");
      var $li = $container.closest("li.wsbb-has-submenu");
      var isOpen = $li.hasClass("wsbb-submenu-open");

      // Close siblings
      $li.siblings(".wsbb-submenu-open").each(function () {
        $(this).removeClass("wsbb-submenu-open");
        $(this).children(".sub-menu").removeClass("wsbb-submenu-open");
        $(this)
          .find("> .wsbb-has-submenu-container > .wsbb-submenu-toggle")
          .attr("aria-expanded", "false");
      });

      if (isOpen) {
        $li.removeClass("wsbb-submenu-open");
        $li.children(".sub-menu").removeClass("wsbb-submenu-open");
        $toggle.attr("aria-expanded", "false");
      } else {
        $li.addClass("wsbb-submenu-open");
        $li.children(".sub-menu").addClass("wsbb-submenu-open");
        $toggle.attr("aria-expanded", "true");
      }
    }

    // ── Helper: toggle accordion ─────────────────────────
    function toggleAccordion($li) {
      var isOpen = $li.hasClass("wsbb-submenu-open");
      var $wrap = $li.closest(".wsbb-menu-accordion");

      // Collapse siblings if collapse behavior is active
      if ($wrap.length) {
        $li.siblings(".wsbb-submenu-open").each(function () {
          $(this).removeClass("wsbb-submenu-open");
          $(this).children(".sub-menu").removeClass("wsbb-submenu-open");
          $(this)
            .find("> .wsbb-has-submenu-container > .wsbb-submenu-toggle")
            .attr("aria-expanded", "false");
        });
      }

      if (isOpen) {
        $li.removeClass("wsbb-submenu-open");
        $li.children(".sub-menu").removeClass("wsbb-submenu-open");
        $li
          .find("> .wsbb-has-submenu-container > .wsbb-submenu-toggle")
          .attr("aria-expanded", "false");
      } else {
        $li.addClass("wsbb-submenu-open");
        $li.children(".sub-menu").addClass("wsbb-submenu-open");
        $li
          .find("> .wsbb-has-submenu-container > .wsbb-submenu-toggle")
          .attr("aria-expanded", "true");
      }
    }

    // ── Helper: close mobile menu ────────────────────────
    function closeMenu($btn, $nav) {
      $nav.removeClass("wsbb-menu--open");
      $btn.attr("aria-expanded", "false");
    }
  });
})(jQuery);
