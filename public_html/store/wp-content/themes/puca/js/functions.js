'use strict';

/**
 * @preserve
 * Project: Bootstrap Hover Dropdown
 * Author: Cameron Spear
 * Version: v2.2.1
 * Contributors: Mattia Larentis
 * Dependencies: Bootstrap's Dropdown plugin, jQuery
 * Description: A simple plugin to enable Bootstrap dropdowns to active on hover and provide a nice user experience.
 * License: MIT
 * Homepage: http://cameronspear.com/blog/bootstrap-dropdown-on-hover-plugin/
 */
(function ($, window, undefined$1) {
    var $allDropdowns = $();
    $.fn.dropdownHover = function (options) {
        if('ontouchstart' in document) return this;
        $allDropdowns = $allDropdowns.add(this.parent());
        return this.each(function () {
            var $this = $(this),
                $parent = $this.parent(),
                defaults = {
                    delay: 500,
                    hoverDelay: 0,
                    instantlyCloseOthers: true
                },
                data = {
                    delay: $(this).data('delay'),
                    hoverDelay: $(this).data('hover-delay'),
                    instantlyCloseOthers: $(this).data('close-others')
                },
                showEvent   = 'show.bs.dropdown',
                hideEvent   = 'hide.bs.dropdown',
                settings = $.extend(true, {}, defaults, options, data),
                timeout, timeoutHover;
            $parent.hover(function (event) {
                if(!$parent.hasClass('open') && !$this.is(event.target)) {
                    return true;
                }
                openDropdown();
            }, function () {
                window.clearTimeout(timeoutHover);
                timeout = window.setTimeout(function () {
                    $this.attr('aria-expanded', 'false');
                    $parent.removeClass('open');
                    $this.trigger(hideEvent);
                }, settings.delay);
            });
            $this.hover(function (event) {
                if(!$parent.hasClass('open') && !$parent.is(event.target)) {
                    return true;
                }
                openDropdown();
            });
            $parent.find('.dropdown-submenu').each(function (){
                var $this = $(this);
                var subTimeout;
                $this.hover(function () {
                    window.clearTimeout(subTimeout);
                    $this.children('.dropdown-menu').show();
                    $this.siblings().children('.dropdown-menu').hide();
                }, function () {
                    var $submenu = $this.children('.dropdown-menu');
                    subTimeout = window.setTimeout(function () {
                        $submenu.hide();
                    }, settings.delay);
                });
            });
            function openDropdown(event) {
                if($this.parents(".navbar").find(".navbar-toggle").is(":visible")) {
                    return;
                }
                window.clearTimeout(timeout);
                window.clearTimeout(timeoutHover);
                timeoutHover = window.setTimeout(function () {
                    $allDropdowns.find(':focus').blur();
                    if(settings.instantlyCloseOthers === true)
                        $allDropdowns.removeClass('open');
                    window.clearTimeout(timeoutHover);
                    $this.attr('aria-expanded', 'true');
                    $parent.addClass('open');
                    $this.trigger(showEvent);
                }, settings.hoverDelay);
            }
        });
    };
    $(document).ready(function () {
        $('[data-hover="dropdown"]').dropdownHover();
    });
})(jQuery, window);

const TREE_VIEW_OPTION_MEGA_MENU = {
  animated: 300,
  collapsed: true,
  unique: true,
  persist: "location"
};
const TREE_VIEW_OPTION_MOBILE_MENU = {
  animated: 300,
  collapsed: true,
  unique: true,
  hover: false
};
const DEVICE = {
  ANDROID: /Android/i,
  BLACK_BERRY: /BlackBerry/i,
  IOS: /iPhone|iPad|iPod/i,
  OPERA: /Opera Mini/i,
  WINDOW: /IEMobile/i,
  ANY: /Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i
};

(function ($) {
  $.extend($.fn, {
    swapClass: function (c1, c2) {
      var c1Elements = this.filter('.' + c1);
      this.filter('.' + c2).removeClass(c2).addClass(c1);
      c1Elements.removeClass(c1).addClass(c2);
      return this;
    },
    replaceClass: function (c1, c2) {
      return this.filter('.' + c1).removeClass(c1).addClass(c2).end();
    },
    hoverClass: function (className) {
      className = className || "hover";
      return this.on('hover', function () {
        $(this).addClass(className);
      }, function () {
        $(this).removeClass(className);
      });
    },
    heightToggle: function (animated, callback) {
      animated ? this.animate({
        height: "toggle"
      }, animated, callback) : this.each(function () {
        jQuery(this)[jQuery(this).is(":hidden") ? "show" : "hide"]();
        if (callback) callback.apply(this, arguments);
      });
    },
    heightHide: function (animated, callback) {
      if (animated) {
        this.animate({
          height: "hide"
        }, animated, callback);
      } else {
        this.hide();
        if (callback) this.each(callback);
      }
    },
    prepareBranches: function (settings) {
      if (!settings.prerendered) {
        this.filter(":last-child:not(ul)").addClass(CLASSES.last);
        this.filter((settings.collapsed ? "" : "." + CLASSES.closed) + ":not(." + CLASSES.open + ")").find(">ul").hide();
      }

      return this.filter(":has(>ul),:has(>.dropdown-menu)");
    },
    applyClasses: function (settings, toggler) {
      this.filter(":has(>ul):not(:has(>a))").find(">span").on('click', function (event) {
        toggler.apply($(this).next());
      }).add($("a", this)).hoverClass();

      if (!settings.prerendered) {
        this.filter(":has(>ul:hidden),:has(>.dropdown-menu:hidden)").addClass(CLASSES.expandable).replaceClass(CLASSES.last, CLASSES.lastExpandable);
        this.not(":has(>ul:hidden),:has(>.dropdown-menu:hidden)").addClass(CLASSES.collapsable).replaceClass(CLASSES.last, CLASSES.lastCollapsable);
        this.prepend("<div class=\"" + CLASSES.hitarea + "\"/>").find("div." + CLASSES.hitarea).each(function () {
          var classes = "";
          $.each($(this).parent().attr("class").split(" "), function () {
            classes += this + "-hitarea ";
          });
          $(this).addClass(classes);
        });
      }

      this.find("div." + CLASSES.hitarea).on('click', toggler);
    },
    treeview: function (settings) {
      settings = $.extend({
        cookieId: "treeview"
      }, settings);

      if (settings.add) {
        return this.trigger("add", [settings.add]);
      }

      if (settings.toggle) {
        var callback = settings.toggle;

        settings.toggle = function () {
          return callback.apply($(this).parent()[0], arguments);
        };
      }

      function treeController(tree, control) {
        function handler(filter) {
          return function () {
            toggler.apply($("div." + CLASSES.hitarea, tree).filter(function () {
              return filter ? $(this).parent("." + filter).length : true;
            }));
            return false;
          };
        }

        $("a:eq(0)", control).on('click', handler(CLASSES.collapsable));
        $("a:eq(1)", control).cli.on('click', handler(CLASSES.expandable));
        $("a:eq(2)", control).on('click', handler());
      }

      function toggler() {
        $(this).parent().find(">.hitarea").swapClass(CLASSES.collapsableHitarea, CLASSES.expandableHitarea).swapClass(CLASSES.lastCollapsableHitarea, CLASSES.lastExpandableHitarea).end().swapClass(CLASSES.collapsable, CLASSES.expandable).swapClass(CLASSES.lastCollapsable, CLASSES.lastExpandable).find(">ul,>.dropdown-menu").heightToggle(settings.animated, settings.toggle);

        if (settings.unique) {
          $(this).parent().siblings().find(">.hitarea").replaceClass(CLASSES.collapsableHitarea, CLASSES.expandableHitarea).replaceClass(CLASSES.lastCollapsableHitarea, CLASSES.lastExpandableHitarea).end().replaceClass(CLASSES.collapsable, CLASSES.expandable).replaceClass(CLASSES.lastCollapsable, CLASSES.lastExpandable).find(">ul,>.dropdown-menu").heightHide(settings.animated, settings.toggle);
        }
      }

      function serialize() {

        var data = [];
        branches.each(function (i, e) {
          data[i] = $(e).is(":has(>ul:visible)") ? 1 : 0;
        });
        $.cookie(settings.cookieId, data.join(""));
      }

      function deserialize() {
        var stored = $.cookie(settings.cookieId);

        if (stored) {
          var data = stored.split("");
          branches.each(function (i, e) {
            $(e).find(">ul")[parseInt(data[i]) ? "show" : "hide"]();
          });
        }
      }

      this.addClass("treeview");
      var branches = this.find("li").prepareBranches(settings);

      switch (settings.persist) {
        case "cookie":
          var toggleCallback = settings.toggle;

          settings.toggle = function () {
            serialize();

            if (toggleCallback) {
              toggleCallback.apply(this, arguments);
            }
          };

          deserialize();
          break;

        case "location":
          var current = this.find("a").filter(function () {
            return this.href.toLowerCase() == location.href.toLowerCase();
          });

          if (current.length) {
            current.addClass("selected").parents("ul, li").add(current.next()).show();
          }

          break;
      }

      branches.applyClasses(settings, toggler);

      if (settings.control) {
        treeController(this, settings.control);
        $(settings.control).show();
      }

      return this.on("add", function (event, branches) {
        $(branches).prev().removeClass(CLASSES.last).removeClass(CLASSES.lastCollapsable).removeClass(CLASSES.lastExpandable).find(">.hitarea").removeClass(CLASSES.lastCollapsableHitarea).removeClass(CLASSES.lastExpandableHitarea);
        $(branches).find("li").andSelf().prepareBranches(settings).applyClasses(settings, toggler);
      });
    }
  });
  var CLASSES = $.fn.treeview.classes = {
    open: "open",
    closed: "closed",
    expandable: "expandable",
    expandableHitarea: "expandable-hitarea",
    lastExpandableHitarea: "lastExpandable-hitarea",
    collapsable: "collapsable",
    collapsableHitarea: "collapsable-hitarea",
    lastCollapsableHitarea: "lastCollapsable-hitarea",
    lastCollapsable: "lastCollapsable",
    lastExpandable: "lastExpandable",
    last: "last",
    hitarea: "hitarea"
  };
  $.fn.Treeview = $.fn.treeview;
})(jQuery);

let isDevice = device => {
  navigator.userAgent.match(device);
};

class Mobile {
  constructor() {
    this._topBarDevice();

    this._fixVCAnimation();

    this._initTreeviewMenu();

    this._categoryMenu();

    this._mobileMenu();

    $(window).scroll(() => {
      this._topBarDevice();

      this._fixVCAnimation();
    });
  }

  _topBarDevice() {
    var scroll = $(window).scrollTop();
    var objectSelect = $(".topbar-device-mobile").height();
    var scrollmobile = $(window).scrollTop();
    $(".topbar-device-mobile").toggleClass("active", scroll <= objectSelect);
    $("#tbay-mobile-menu, #tbay-mobile-menu-navbar").toggleClass("offsetop", scrollmobile == 0);
    var objectSelect_adminbar = $("#wpadminbar");

    if (objectSelect_adminbar.length > 0) {
      $("body").toggleClass("active-admin-bar", scrollmobile == 0);
    }
  }

  _fixVCAnimation() {
    if ($(".wpb_animate_when_almost_visible").length > 0 && !$(".wpb_animate_when_almost_visible").hasClass('wpb_start_animation')) {
      let animate_height = $(window).height();
      let wpb_not_animation_element = $(".wpb_animate_when_almost_visible:not(.wpb_start_animation)");
      var next_scroll = wpb_not_animation_element.offset().top - $(window).scrollTop();

      if (isDevice(DEVICE.ANY)) {
        wpb_not_animation_element.removeClass('wpb_animate_when_almost_visible');
      } else if (next_scroll < animate_height - 50) {
        wpb_not_animation_element.addClass("wpb_start_animation animated");
      }
    }
  }

  _initTreeviewMenu() {
    if (typeof jQuery.fn.treeview === "undefined") return;
    $("#category-menu").addClass('treeview');
    jQuery(".treeview-menu .menu, #category-menu").treeview(TREE_VIEW_OPTION_MEGA_MENU);
    jQuery("#main-mobile-menu, #main-mobile-menu-xlg").treeview(TREE_VIEW_OPTION_MOBILE_MENU);
  }

  _categoryMenu() {
    $(".category-inside .category-inside-title").on('click', function (event) {
      $(event.target).parents('.category-inside').toggleClass("open");
      $(event.target).next().slideToggle();
    });
  }

  _mobileMenu() {
    $('[data-toggle="offcanvas"], .btn-offcanvas').on('click', function () {
      $('#wrapper-container').toggleClass('active');
      $('#tbay-mobile-menu').toggleClass('active');
    });
    $("#main-mobile-menu .caret").on('click', function (event) {
      $("#main-mobile-menu .dropdown").removeClass('open');
      $(event.target).parent().addClass('open');
    });
  }

}

class AccountMenu {
  constructor() {
    this._slideToggleAccountMenu(".tbay-login");

    this._slideToggleAccountMenu(".topbar-mobile");

    this._pucaClickNotMyAccountMenu();
  }

  _pucaClickNotMyAccountMenu() {
    var $win_my_account = $(window);
    var $box_my_account = $('.tbay-login .dropdown .account-menu,.topbar-mobile .dropdown .account-menu,.tbay-login .dropdown .account-button,.topbar-mobile .dropdown .account-button');
    $win_my_account.on("click.Bst", function (event) {
      if ($box_my_account.has(event.target).length == 0 && !$box_my_account.is(event.target)) {
        $(".tbay-login .dropdown .account-menu").slideUp(500);
        $(".topbar-mobile .dropdown .account-menu").slideUp(500);
      }
    });
  }

  _slideToggleAccountMenu(parentSelector) {
    $(parentSelector).find(".dropdown .account-button").on('click', function () {
      $(parentSelector).find(".dropdown .account-menu").slideToggle(500);
    });
  }

}

class BackToTop {
  constructor() {
    this._init();
  }

  _init() {
    $(window).scroll(function () {
      var isActive = $(this).scrollTop() > 400;
      $('.tbay-to-top').toggleClass('active', isActive);
      $('.tbay-category-fixed').toggleClass('active', isActive);
    });
    $('#back-to-top-mobile, #back-to-top').on('click', this._onClickBackToTop);
  }

  _onClickBackToTop() {
    $('html, body').animate({
      scrollTop: '0px'
    }, 800);
  }

}

class CanvasMenu {
  constructor() {
    this._init();
  }

  _init() {
    $('[data-toggle="offcanvas"], .btn-offcanvas').on('click', function () {
      $('.row-offcanvas').toggleClass('active');
    });
    $("#main-menu-offcanvas .caret").on('click', function () {
      $("#main-menu-offcanvas .dropdown").removeClass('open');
      $(this).parent().addClass('open');
      return false;
    });
    $('[data-toggle="offcanvas-main"]').on('click', function () {
      $('#wrapper-container').toggleClass('active');
      $('#tbay-offcanvas-main').toggleClass('active');
    });
  }

}

class FuncCommon {
  constructor() {
    this._progressAnimation();

    this._createWrapStart();

    $('.mod-heading .widget-title > span').wrapStart();

    this._pucaResizeMegamenu();

    $(window).on("resize", () => {
      this._pucaResizeMegamenu();

      this._fixFull();
    });

    this._fixFull();
  }

  _createWrapStart() {
    $.fn.wrapStart = function () {
      return this.each(function () {
        var $this = $(this);
        var node = $this.contents().filter(function () {
          return this.nodeType == 3;
        }).first(),
            text = node.text().trim(),
            first = text.split(' ', 1).join(" ");
        if (!node.length) return;
        node[0].nodeValue = text.slice(first.length);
        node.before('<b>' + first + '</b>');
      });
    };
  }

  _progressAnimation() {
    $("[data-progress-animation]").each(function () {
      var $this = $(this);
      $this.appear(function () {
        var delay = $this.attr("data-appear-animation-delay") ? $this.attr("data-appear-animation-delay") : 1;
        if (delay > 1) $this.css("animation-delay", delay + "ms");
        setTimeout(function () {
          $this.animate({
            width: $this.attr("data-progress-animation")
          }, 800);
        }, delay);
      }, {
        accX: 0,
        accY: -50
      });
    });
  }

  _pucaResizeMegamenu() {
    var window_size = $('body').innerWidth();

    if ($('.tbay_custom_menu').length > 0 && $('.tbay_custom_menu').hasClass('tbay-vertical-menu')) {
      if (window_size > 767) {
        this._resizeMegaMenuOnDesktop();
      } else {
        this._initTreeViewForMegaMenuOnMobile();
      }
    }

    if ($('.tbay-megamenu').length > 0 && $('.tbay-megamenu,.tbay-offcanvas-main').hasClass('verticle-menu') && window_size > 767) {
      this._resizeMegaMenuVertical();
    }
  }

  _resizeMegaMenuVertical() {
    var full_width = parseInt($('#main-container.container').innerWidth());
    var menu_width = parseInt($('.verticle-menu').innerWidth());
    var w = full_width - menu_width;
    $('.verticle-menu').find('.aligned-fullwidth').children('.dropdown-menu').css({
      "max-width": w,
      "width": full_width - 30
    });
  }

  _resizeMegaMenuOnDesktop() {
    let maxWidth = $('#main-container.container').innerWidth() - $('.tbay-vertical-menu').innerWidth();
    let width = $('#main-container.container').innerWidth() - 30;
    $('.tbay-vertical-menu').find('.active-mega-menu').children('.dropdown-menu').css({
      'max-width': maxWidth,
      "width": width
    });
  }

  _initTreeViewForMegaMenuOnMobile() {
    if (typeof $.fn.treeview === "undefined") return;
    $(".tbay-vertical-menu > .widget_nav_menu >.nav > ul").each(function () {
      if ($(this).hasClass('treeview')) return;
      $(this).treeview(TREE_VIEW_OPTION_MEGA_MENU);
    });
  }

  _fixFull() {
    var mainwidth = $('#tbay-main-content').width();
    var marginleft = ($('#tbay-main-content').width() - $('#tbay-main-content >.container').width()) / 2;
    $('.tb-full').css('width', mainwidth);
    $('.tb-full').css('max-width', mainwidth);

    if ($('body').hasClass("rtl")) {
      $('.tb-full').css('margin-right', -marginleft);
    } else {
      $('.tb-full').css('margin-left', -marginleft);
    }

    $('.tb-full >.vc_fluid').css('padding', 0);
  }

}

class NewsLetter {
  constructor() {
    this._init();
  }

  _init() {
    $('#popupNewsletterModal').on('hidden.bs.modal', function () {
      Cookies.set('hiddenmodal', 1, {
        expires: 0.1,
        path: '/'
      });
    });
    setTimeout(function () {
      if (typeof Cookies.get('hiddenmodal') === "undefined" || Cookies.get('hiddenmodal') == "") {
        $('#popupNewsletterModal').modal('show');
      }
    }, 3000);
  }

}

class Search {
  constructor() {
    this._init();
  }

  _init() {
    this._pucaSearchMobile();

    this._searchToTop();

    $('.button-show-search').on('click', () => $('.tbay-search-form').addClass('active'));
    $('.button-hidden-search').on('click', () => $('.tbay-search-form').removeClass('active'));
  }

  _pucaSearchMobile() {
    $(".topbar-mobile .search-popup, .search-device-mobile").each(function () {
      $(this).find(".show-search").on('click', event => {
        event.preventDefault();
        var target = $(event.currentTarget);
        target.parent().toggleClass('open');
        target.parent().find(".tbay-search").focus();
        $(document.body).trigger('search_device_mobile');
      });
    });
    $(".search-mobile-close").each(function (index) {
      let id = $(this).data('id');
      $(id).on("click", function () {
        $(this).parent().removeClass('open');
      });
    });
    $('.topbar-mobile .dropdown-menu').on('click', function (e) {
      e.stopPropagation();
    });
  }

  _searchToTop() {
    $('.search-totop-wrapper .btn-search-totop').on('click', function () {
      $('.search-totop-content').toggleClass('active');
      $(this).toggleClass('active');
    });
    var $box_totop = $('.search-totop-wrapper .btn-search-totop, .search-totop-content');
    $(window).on("click.Bst", function (event) {
      if ($box_totop.has(event.target).length == 0 && !$box_totop.is(event.target)) {
        $('.search-totop-wrapper .btn-search-totop').removeClass('active');
        $('.search-totop-content').removeClass('active');
      }
    });
  }

}

class Preload {
  constructor() {
    this._init();
  }

  _init() {
    if ($.fn.jpreLoader) {
      var $preloader = $('.js-preloader');
      $preloader.jpreLoader({}, function () {
        $preloader.addClass('preloader-done');
        $('body').trigger('preloader-done');
        $(window).trigger('resize');
      });
    }

    $('.tbay-page-loader').delay(100).fadeOut(400, function () {
      $('body').removeClass('tbay-body-loading');
      $(this).remove();
    });

    if ($(document.body).hasClass('tbay-body-loader')) {
      setTimeout(function () {
        $(document.body).removeClass('tbay-body-loader');
        $('.tbay-page-loader').fadeOut(250);
      }, 300);
    }
  }

}

class Tabs {
  constructor() {
    $('ul.nav-tabs li a').on('shown.bs.tab', event => {
      $(document.body).trigger('puca_tabs_carousel');
    });
  }

}

class Accordion {
  constructor() {
    this._init();
  }

  _init() {
    if ($('.single-product').length === 0) return;
    $('#accordion').on('shown.bs.collapse', function (e) {
      var offset = $(this).find('.collapse.in').prev('.tabs-title');

      if (offset) {
        $('html,body').animate({
          scrollTop: $(offset).offset().top - 150
        }, 500);
      }
    });
  }

}

class MenuDropdownsAJAX {
  constructor() {
    if (typeof puca_settings === "undefined") return;

    this._initmenuDropdownsAJAX();
  }

  _initmenuDropdownsAJAX() {
    var _this = this;

    $('body').on('mousemove', function () {
      $('.menu').has('.dropdown-load-ajax').each(function () {
        var $menu = $(this);

        if ($menu.hasClass('dropdowns-loading') || $menu.hasClass('dropdowns-loaded')) {
          return;
        }

        if (!_this.isNear($menu, 50, event)) {
          return;
        }

        _this.loadDropdowns($menu);
      });
    });
  }

  loadDropdowns($menu) {
    var _this = this;

    $menu.addClass('dropdowns-loading');
    var storageKey = '',
        unparsedData = '',
        menu_mobile_id = '';

    if ($menu.closest('nav').attr('id') === 'tbay-mobile-menu-navbar') {
      if ($('#main-mobile-menu-mmenu-wrapper').length > 0) {
        menu_mobile_id += '_' + $('#main-mobile-menu-mmenu-wrapper').data('id');
      }

      if ($('#main-mobile-second-mmenu-wrapper').length > 0) {
        menu_mobile_id += '_' + $('#main-mobile-second-mmenu-wrapper').data('id');
      }

      storageKey = puca_settings.storage_key + '_megamenu_mobile' + menu_mobile_id;
    } else {
      storageKey = puca_settings.storage_key + '_megamenu_' + $menu.closest('nav').find('ul').data('id');
    }

    unparsedData = localStorage.getItem(storageKey);
    var storedData = false;
    var $items = $menu.find('.dropdown-load-ajax'),
        ids = [];
    $items.each(function () {
      ids.push($(this).find('.dropdown-html-placeholder').data('id'));
    });

    try {
      storedData = JSON.parse(unparsedData);
    } catch (e) {
      console.log('cant parse Json', e);
    }

    if (storedData) {
      _this.renderResults(storedData, $menu);

      if ($menu.attr('id') !== 'tbay-mobile-menu-navbar') {
        $menu.removeClass('dropdowns-loading').addClass('dropdowns-loaded');
      }
    } else {
      $.ajax({
        url: puca_settings.ajaxurl,
        data: {
          action: 'puca_load_html_dropdowns',
          ids: ids
        },
        dataType: 'json',
        method: 'POST',
        success: function (response) {
          if (response.status === 'success') {
            _this.renderResults(response.data, $menu);

            localStorage.setItem(storageKey, JSON.stringify(response.data));
          } else {
            console.log('loading html dropdowns returns wrong data - ', response.message);
          }
        },
        error: function () {
          console.log('loading html dropdowns ajax error');
        }
      });
    }
  }

  renderResults(data, $menu) {
    var _this = this;

    Object.keys(data).forEach(function (id) {
      _this.removeDuplicatedStylesFromHTML(data[id], function (html) {
        let html2 = html;
        const regex1 = '<li[^>]*><a[^>]*href=["]' + window.location.href + '["]>.*?<\/a><\/li>';
        let content = html.match(regex1);

        if (content !== null) {
          let $url = content[0];
          let $class = $url.match(/(?:class)=(?:["']\W+\s*(?:\w+)\()?["']([^'"]+)['"]/g)[0].split('"')[1];
          let $class_new = $class + ' active';
          let $url_new = $url.replace($class, $class_new);
          html2 = html2.replace($url, $url_new);
        }

        $menu.find('[data-id="' + id + '"]').replaceWith(html2);

        if ($menu.attr('id') !== 'tbay-mobile-menu-navbar') {
          $menu.addClass('dropdowns-loaded');
          setTimeout(function () {
            $menu.removeClass('dropdowns-loading');
          }, 1000);
        }
      });
    });
  }

  isNear($element, distance, event) {
    var left = $element.offset().left - distance,
        top = $element.offset().top - distance,
        right = left + $element.width() + 2 * distance,
        bottom = top + $element.height() + 2 * distance,
        x = event.pageX,
        y = event.pageY;
    return x > left && x < right && y > top && y < bottom;
  }

  removeDuplicatedStylesFromHTML(html, callback) {
    if (puca_settings.combined_css) {
      callback(html);
      return;
    } else {
      const regex = /<style>.*?<\/style>/mg;
      let output = html.replace(regex, "");
      callback(output);
      return;
    }
  }

}

class SumoSelect {
  constructor() {
    if (typeof jQuery.fn.SumoSelect === "undefined") return;

    this._init();
  }

  _init() {
    jQuery(document).ready(function () {
      $('.dropdown_product_cat').SumoSelect({
        csvDispCount: 3,
        captionFormatAllSelected: "Yeah, OK, so everything."
      });
      $('.woocommerce-currency-switcher,.woocommerce-fillter >.select, .woocommerce-ordering > .orderby, .tbay-filter select').SumoSelect({
        csvDispCount: 3,
        captionFormatAllSelected: "Yeah, OK, so everything."
      });
    });
  }

}

class Sticky {
  constructor() {
    if (typeof puca_settings === "undefined") return;

    this._tbayPortfolioStick();

    this._tbayProductSingleStick();

    $(window).resize(() => {
      this._tbayPortfolioStick();
    });
  }

  _tbayProductSingleStick() {
    if ($('.active-stick .information').length) {
      $('.active-stick .information').hcSticky({
        stickTo: '.active-stick .image-mains',
        top: $('#tbay-header').hasClass('main-sticky-header') ? 180 : 50
      });
    }
  }

  _tbayPortfolioStick() {
    if ($('.wrap-right-single-project').length) {
      $('.wrap-right-single-project').hcSticky({
        stickTo: '.wrap-left-single-project',
        top: 100
      });
    }
  }

}

class CountDownTimer {
  constructor() {
    if (typeof jQuery.fn.tbayCountDown === "undefined") return;
    if (typeof puca_settings === "undefined") return;

    this._CountDownTimer();
  }

  _CountDownTimer() {
    let _this = this;

    if (!jQuery('[data-time="timmer"]').length && !jQuery('[data-countdown="countdown"]').length) return;
    jQuery('[data-time="timmer"]:not(.scroll-init), [data-countdown="countdown"]:not(.scroll-init)').each(el => _this._initCountDownTimer(jQuery(el)));
    jQuery('[data-time="timmer"].scroll-init, [data-countdown="countdown"].scroll-init').waypoint(el => {
      let $this = $(el[0].element);

      _this._initCountDownTimer($this);
    }, {
      offset: '100%'
    });
  }

  _initCountDownTimer(el) {
    let date = $(el).data('date').split("-"),
        days = $(el).data('days'),
        hours = $(el).data('hours'),
        mins = $(el).data('mins'),
        secs = $(el).data('secs');
    jQuery(el).tbayCountDown({
      TargetDate: date[0] + "/" + date[1] + "/" + date[2] + " " + date[3] + ":" + date[4] + ":" + date[5],
      DisplayFormat: "<div class=\"times\"><div class=\"day\">%%D%% " + days + " </div><div class=\"hours\">%%H%% " + hours + " </div><div class=\"minutes\">%%M%% " + mins + " </div><div class=\"seconds\">%%S%% " + secs + " </div></div>",
      FinishMessage: ""
    });
  }

}

class CounterUp {
  constructor() {
    if (typeof jQuery.fn.countTo === "undefined") return;
    if (typeof puca_settings === "undefined") return;
    if (jQuery('.count-number').length === 0) return;

    this._intCounterUp();
  }

  _intCounterUp() {
    jQuery(function ($) {
      $(".count-number").data("countToOptions", {
        formatter: function (value, options) {
          return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ",");
        }
      });
      $(".count-number.timer").each(count);

      function count(options) {
        var $this = $(this);
        options = $.extend({}, options || {}, $this.data("countToOptions") || {});
        $this.countTo(options);
      }
    });
  }

}

class Fancybox {
  constructor() {
    if (typeof jQuery.fn.fancybox === "undefined") return;
    if (typeof puca_settings === "undefined") return;
    $(".fancybox-video").fancybox({
      maxWidth: 800,
      maxHeight: 600,
      fitToView: false,
      width: '70%',
      height: '70%',
      autoSize: false,
      closeClick: false,
      openEffect: 'none',
      closeEffect: 'none'
    });
    $(".fancybox").fancybox();
  }

}

class FastClicker {
  constructor() {
    if (typeof puca_settings === "undefined") return;

    this._initFastClick();
  }

  _initFastClick() {
    if ('addEventListener' in document) {
      document.addEventListener('DOMContentLoaded', function () {
        FastClick.attach(document.body);
      }, false);
    }
  }

}

class Magnific {
  constructor() {
    if (typeof $.magnificPopup === "undefined") return;
    if (typeof puca_settings === "undefined") return;

    this._init();

    this._list_button_popup();
  }

  _init() {
    if (!$('.lightbox-gallery').length) return;
    $('.lightbox-gallery').magnificPopup({
      type: 'image',
      tLoading: 'Loading image #%curr%...',
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0, 1]
      },
      image: {
        titleSrc: 'title',
        verticalFit: true
      }
    });
  }

  _list_button_popup() {
    if (!$('.popup-button-open').length) return;
    $('.popup-button-open').magnificPopup({
      type: 'inline',
      fixedContentPos: 'hidden',
      fixedBgPos: true,
      closeBtnInside: true,
      preloader: false,
      midClick: true,
      removalDelay: 300,
      mainClass: 'popup-button-mfp-zoom-in tbay-mfp-max-width'
    });
  }

}

class MMenu {
  constructor() {
    if (typeof jQuery.fn.mmenu === "undefined") return;
    if (typeof puca_settings === "undefined") return;

    this._initMmenu();
  }

  _initMmenu() {
    if ($('body').hasClass('admin-bar')) {
      $('html').addClass('html-mmenu');
    }

    var cancel_text = typeof puca_settings !== "undefined" ? puca_settings.cancel : '';
    var _PLUGIN_ = 'mmenu';

    $[_PLUGIN_].i18n({
      'cancel': cancel_text
    });

    var mmenu = $("#tbay-mobile-smartmenu");
    if (!mmenu.length) return;
    var themes = mmenu.data("themes");
    var enablesearch = mmenu.data("enablesearch");
    var textsearch = enablesearch ? mmenu.data("textsearch") : "";
    var searchnoresults = enablesearch ? mmenu.data("searchnoresults") : "";
    var searchsplash = enablesearch ? mmenu.data("searchsplash") : "";
    var menu_title = mmenu.data("title");
    var searchcounters = mmenu.data("counters");
    var enabletabs = mmenu.data("enabletabs");
    var tabone = enabletabs ? mmenu.data("tabone") : "";
    var taboneicon = enabletabs ? mmenu.data("taboneicon") : "";
    var tabsecond = enabletabs ? mmenu.data("tabsecond") : "";
    var tabsecondicon = enabletabs ? mmenu.data("tabsecondicon") : "";
    var enablesocial = mmenu.data("enablesocial");
    var socialjsons = "";
    var enableeffects = mmenu.data("enableeffects");
    var effectspanels = enableeffects ? mmenu.data("effectspanels") : "";
    var effectslistitems = enableeffects ? mmenu.data("effectslistitems") : "";
    var mmenuOptions = {
      offCanvas: true,
      counters: Boolean(searchcounters),
      extensions: [themes, effectspanels, effectslistitems]
    };
    var mmenuOptionsAddition = {
      navbars: [],
      searchfield: {},
      navbar: {}
    };

    if (!menu_title.length) {
      mmenuOptionsAddition.navbar = {
        add: false
      };
    } else {
      mmenuOptionsAddition.navbar = {
        title: menu_title
      };
    }

    mmenuOptions = Object.assign(mmenuOptionsAddition, mmenuOptions);

    if (enablesearch) {
      mmenuOptionsAddition.navbars.push({
        position: ["top"],
        content: ["searchfield"]
      });
      mmenuOptionsAddition.searchfield = {
        placeholder: textsearch,
        noResults: searchnoresults,
        panel: {
          add: true,
          splash: searchsplash,
          title: puca_settings.search || ""
        },
        showTextItems: true,
        clear: true
      };
    }

    if (enabletabs) {
      mmenuOptionsAddition.navbars.push({
        type: 'tabs',
        content: ['<a href="#main-mobile-menu-mmenu"><i class="' + taboneicon + '"></i> <span>' + tabone + '</span></a>', '<a href="#mobile-menu-second-mmenu"><i class="' + tabsecondicon + '"></i> <span>' + tabsecond + '</span></a>']
      });
    }

    if (enablesocial) {
      socialjsons = JSON.parse(mmenu.data("socialjsons").replace(/'/g, '"'));
      var content = $.map(socialjsons, function (value) {
        return `<a class="mmenu-icon" href="${value.url}" target="_blank"><i class="${value.icon}"></i></a>`;
      });
      mmenuOptionsAddition.navbars.push({
        position: 'bottom',
        content: content
      });
    }

    mmenuOptions = _.extend(mmenuOptionsAddition, mmenuOptions);
    var mmenuConfigurations = {
      offCanvas: {
        pageSelector: "#tbay-main-content"
      },
      searchfield: {
        clear: true
      }
    };
    $("#tbay-mobile-menu-navbar").mmenu(mmenuOptions, mmenuConfigurations);
  }

}

class OnePageNav {
  constructor() {
    if (typeof jQuery.fn.onePageNav === "undefined") return;
    if (typeof puca_settings === "undefined") return;

    this._productSingleOnepagenav();
  }

  _productSingleOnepagenav() {
    if ($('#onepage-single-product').length) {
      var offset = $('#onepage-single-product').height() + 40;
      $('#onepage-single-product').onePageNav({
        currentClass: 'current',
        changeHash: false,
        scrollSpeed: 750,
        scrollThreshold: 0.5,
        scrollOffset: offset,
        filter: '',
        easing: 'swing',
        begin: function () {},
        end: function () {},
        scrollChange: function () {}
      });
    }

    var onepage = $('#onepage-single-product');

    if (onepage.length > 0) {
      var tbay_width = $(window).width();
      var header_height = $('#tbay-header').height();
      var breadscrumb_height = $('#tbay-breadscrumb').height();
      var sum_height = header_height + breadscrumb_height;

      this._checkScroll(tbay_width, sum_height, onepage);

      $(window).scroll(() => {
        this._checkScroll(tbay_width, sum_height, onepage);
      });
    }

    if (onepage.hasClass('active') && jQuery('#wpadminbar').length > 0) {
      onepage.css('top', $('#wpadminbar').height());
    }
  }

  _checkScroll(tbay_width, sum_height, onepage) {
    if (tbay_width >= 678) {
      var NextScroll = $(window).scrollTop();

      if (NextScroll > sum_height) {
        onepage.addClass('active');

        if (jQuery('#wpadminbar').length > 0) {
          onepage.css('top', $('#wpadminbar').height());
        }
      } else {
        onepage.removeClass('active');
      }
    } else {
      onepage.removeClass('active');
    }
  }

}

class PucaShuffle {
  constructor() {
    this._init();
  }

  _init() {
    if ($("#projects_list").length > 0) {
      this.shuffleInstance = new Shuffle(document.getElementById('projects_list'), {
        itemSelector: '.project'
      });
      $('.filter-options .btn').on('click', event => {
        this._onClickFilterOption(event);
      });
    }
  }

  _onClickFilterOption(event) {
    let filterBtn = $(event.currentTarget),
        isActive = filterBtn.hasClass('active'),
        group = isActive ? Shuffle.ALL_ITEMS : filterBtn.data('group');

    if (!isActive) {
      $('.filter-options .active').removeClass('active');
    }

    filterBtn.toggleClass('active');
    this.shuffleInstance.filter(group);
  }

}

class TimeTo {
  constructor() {
    if (typeof jQuery.fn.timeTo === "undefined") return;
    if (typeof puca_settings === "undefined") return;

    this._init();
  }

  _init() {
    if (jQuery('[data-time="timmer"]').length === 0 && jQuery('[data-countdown="countdown"]').length === 0) return;

    var _this = this;

    jQuery('[data-time="timmer"]:not(.scroll-init), [data-countdown="countdown"]:not(.scroll-init)').each(function () {
      _this._initCountDownTimer(jQuery(this));
    });
    jQuery('[data-time="timmer"].scroll-init, [data-countdown="countdown"].scroll-init').waypoint(function () {
      var $this = $($(this)[0].element);

      _this._initCountDownTimer($this);
    }, {
      offset: '100%'
    });
  }

  _initCountDownTimer(el) {
    let id = $(el).data('id');
    let date = $(el).data('date').split("-");
    var futureDate = new Date('' + date[2] + '-' + date[0] + '-' + date[1] + 'T' + date[3] + ':' + date[4] + ':' + date[5] + '');
    $("#countdown-" + id + "").timeTo({
      timeTo: new Date(futureDate)
    });
  }

}

class TimeCircles {
  constructor() {
    if (typeof jQuery.fn.TimeCircles === "undefined") return;
    if (typeof puca_settings === "undefined") return;

    this._init();
  }

  _init() {
    if (jQuery('[data-time="timmer"]').length === 0 && jQuery('[data-countdown="countdown"]').length === 0) return;

    var _this = this;

    jQuery('[data-time="timmer"]:not(.scroll-init), [data-countdown="countdown"]:not(.scroll-init)').each(function () {
      _this._initCountDownTimer(jQuery(this));
    });
    jQuery('[data-time="timmer"].scroll-init, [data-countdown="countdown"].scroll-init').waypoint(function () {
      var $this = $($(this)[0].element);

      _this._initCountDownTimer($this);
    }, {
      offset: '100%'
    });
  }

  _initCountDownTimer(el) {
    var id = $(el).data('id');
    $("#countdown-" + id + "").TimeCircles({
      "animation": "smooth",
      "use_background": false,
      "bg_width": 0.1,
      "fg_width": 0.0033333333333333335,
      "circle_bg_color": "#90989F",
      "time": {
        "Days": {
          "text": "Days",
          "color": "#000000",
          "show": true
        },
        "Hours": {
          "text": "Hours",
          "color": "#000000",
          "show": true
        },
        "Minutes": {
          "text": "Minutes",
          "color": "#000000",
          "show": true
        },
        "Seconds": {
          "text": "Seconds",
          "color": "#000000",
          "show": true
        }
      }
    });
    $(".owl-carousel[data-carousel=owl]").each(function () {
      $(this).on('beforeChange', function () {
        $("#countdown-" + id + "").TimeCircles().rebuild();
      });
    });
  }

}

window.$ = window.jQuery;
jQuery(document).ready(() => {
  new MenuDropdownsAJAX(), new Tabs(), new Accordion(), new Mobile(), new AccountMenu(), new BackToTop(), new CanvasMenu(), new FuncCommon(), new NewsLetter(), new Preload(), new Search(), new SumoSelect(), new Sticky(), new CountDownTimer(), new CounterUp(), new Fancybox(), new FastClicker(), new Magnific(), new MMenu(), new OnePageNav(), new PucaShuffle(), new TimeTo(), new TimeCircles();
  jQuery(document).on("woof_ajax_done", woof_ajax_done_handler2);

  function woof_ajax_done_handler2(e) {
    new SumoSelect();
  }
});
jQuery(window).resize(function () {
  new TimeCircles();
});

var CountDownTimerHandler = function ($scope, $) {
  new CountDownTimer();
};

jQuery(window).on('elementor/frontend/init', function () {
  if (typeof puca_settings !== "undefined" && Array.isArray(puca_settings.elements_ready.countdowntimer)) {
    $.each(puca_settings.elements_ready.countdowntimer, function (index, value) {
      elementorFrontend.hooks.addAction('frontend/element_ready/tbay-' + value + '.default', CountDownTimerHandler);
    });
  }
});

var CounterUpHandler = function ($scope, $) {
  new CounterUp();
};

jQuery(window).on('elementor/frontend/init', function () {
  if (typeof puca_settings !== "undefined" && Array.isArray(puca_settings.elements_ready.counterup)) {
    $.each(puca_settings.elements_ready.counterup, function (index, value) {
      elementorFrontend.hooks.addAction('frontend/element_ready/tbay-' + value + '.default', CounterUpHandler);
    });
  }
});

var TimeToHandler = function ($scope, $) {
  new TimeTo();
};

jQuery(window).on('elementor/frontend/init', function () {
  if (typeof puca_settings !== "undefined" && Array.isArray(puca_settings.elements_ready.countdowntimer)) {
    $.each(puca_settings.elements_ready.countdowntimer, function (index, value) {
      elementorFrontend.hooks.addAction('frontend/element_ready/tbay-' + value + '.default', TimeToHandler);
    });
  }
});

var TimeCirclesHandler = function ($scope, $) {
  new TimeCircles();
};

jQuery(window).on('elementor/frontend/init', function () {
  if (typeof puca_settings !== "undefined" && Array.isArray(puca_settings.elements_ready.countdowntimer)) {
    $.each(puca_settings.elements_ready.countdowntimer, function (index, value) {
      elementorFrontend.hooks.addAction('frontend/element_ready/tbay-' + value + '.default', TimeCirclesHandler);
    });
  }
});
