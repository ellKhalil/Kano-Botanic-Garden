'use strict';

class StickyHeader {
  constructor() {
    this.$tbayHeader = $('#tbay-header');

    if (this.$tbayHeader.hasClass('main-sticky-header')) {
      this._initStickyHeader();
    }
  }

  _initStickyHeader() {
    var _this = this;

    var tbay_width = $(window).width();
    var topslider_height = typeof $('.top-slider').height() != 'undefined' ? $('.top-slider').height() : 0;
    var header_height = this.$tbayHeader.height();
    $(window).scroll(function () {
      var cart_height_v1 = $('#tbay-top-cart.tbay-top-cart.v1 .dropdown-content').height() > 0 ? $('#tbay-top-cart.tbay-top-cart.v1').height() : 0;

      if (tbay_width >= 1024) {
        if ($(this).scrollTop() > header_height + cart_height_v1 + 100) {
          if (_this.$tbayHeader.hasClass('sticky-header1')) return;
          var isExistedEventMiniCartClick = false;

          _this._stickyHeaderOnDesktop(isExistedEventMiniCartClick, header_height, topslider_height);
        } else {
          _this.$tbayHeader.css("top", 0).removeClass('sticky-header1').addClass('sticky-header2').next().css('margin-top', 0);
        }
      }

      if (tbay_width <= 767) {
        _this._fixedHeaderOnMobile();
      }
    });
  }

  _fixedHeaderOnMobile() {
    if (!$('body').hasClass('post-type-archive-product')) return;
    var NextScroll = $('.archive-shop .tbay-filter + .products').offset().top - $(window).scrollTop();

    if (NextScroll < 99) {
      $('.archive-shop .tbay-filter').next().css('margin-top', $('.archive-shop .tbay-filter').height() + 20);
      $('.archive-shop .tbay-filter').addClass('fixed').css("top", $('.topbar-device-mobile').outerHeight());
    } else {
      $('.archive-shop .tbay-filter').css("top", 0).removeClass('fixed').next().css('margin-top', 0);
    }
  }

  _stickyHeaderOnDesktop(isExistedEventMiniCartClick, header_height, topslider_height) {
    this.$tbayHeader.addClass('sticky-header1').css("top", $('#wpadminbar').outerHeight()).removeClass('sticky-header2');
    $("#tbay-top-cart").slideUp(500);
    this.$tbayHeader.next().css('margin-top', header_height - topslider_height);

    if (isExistedEventMiniCartClick) {
      return;
    }

    $('#tbay-header.sticky-header1 .tbay-topcart a.mini-cart.v1').on('click', function () {
      isExistedEventMiniCartClick = true;
      $('html, body').scrollTop(0);
    });
  }

}

class AutoComplete {
  constructor() {
    if (typeof puca_settings === "undefined") return;

    var _this = this;

    _this._callAjaxSearch();

    $(document.body).on('search_device_mobile', event => {
      _this._callAjaxSearch();
    });
  }

  _callAjaxSearch() {
    var acs_action = 'puca_autocomplete_search',
        _this = this,
        jQuerytop = 0,
        $t = jQuery("input[name=s]");

    if ($t.data('style') == 'style1') {
      jQuerytop = 30;
    }

    $t.on("focus", function () {
      var _this2 = $(this);

      if (!$(this).parents('.tbay-search-form').hasClass('tbay-search-ajax')) return;
      var appendto = typeof _this2.parents('form').data('appendto') !== "undefined" ? _this2.parents('form').data('appendto') : '.tbay-search-results';

      _this2.autocomplete({
        source: function (req, response) {
          jQuery.ajax({
            url: puca_settings.ajaxurl + '?callback=?&action=' + acs_action,
            dataType: "json",
            data: {
              term: req.term,
              category: this.element.parent().find('.dropdown_product_cat').val(),
              style: this.element.data('style'),
              post_type: this.element.parent().find('.post_type').val()
            },
            success: function (data, event, ui) {
              if (!data.length) {
                if (_this2.val().length > 1) {
                  if (_this2.parents('form').find(appendto).find('ul').length > 0) {
                    _this2.parents('form').find(appendto).find('ul li').remove();
                  } else {
                    $('.ui-autocomplete.' + _this2.data('style')).find('li').remove();
                  }
                }
              }

              response(data);
            }
          });
        },
        position: {
          my: 'left+0 top+' + jQuerytop + ''
        },
        appendTo: appendto,
        minLength: 2,
        autoFocus: true,
        search: function (event) {
          jQuery(event.currentTarget).parents('.tbay-search-form').addClass('load');
        },
        select: function (event, ui) {
          window.location.href = ui.item.link;
        },
        create: function () {
          jQuery(this).data('ui-autocomplete')._renderItem = function (ul, item) {
            var string = '';
            ul.addClass('ui-autocomplete-search');
            ul.addClass(item.style);

            if (item.image && item.image.length > 0) {
              var string = '<a href="' + item.link + '" title="' + item.label + '"><img src="' + item.image + '" ></a>';
            }

            string += '<div class="group">';
            string += '<div class="name"><a href="' + item.link + '" title="' + item.label + '">' + item.label + '</a></div>';

            if (item.sku && item.sku.length > 0) {
              string += '<div class="product-sku">' + item.sku + '</div>';
            }

            if (item.price && item.price.length > 0) {
              string += '<div class="price">' + item.price + '</div>';
            }

            string += '</div>';
            var strings = jQuery("<li>").append(string).appendTo(ul);
            return strings;
          };

          jQuery(this).data('ui-autocomplete')._renderMenu = function (ul, items) {
            var that = this;
            jQuery.each(items, function (index, item) {
              that._renderItemData(ul, item);
            });

            if (items[0].view_all) {
              ul.append('<li class="list-header ui-menu-divider">' + items[0].result + '<a id="search-view-all" data-id="#' + this.element.parents('form').attr('id') + '" href="javascript:void(0)">' + puca_settings.view_all + '</a></li>');
            } else {
              ul.append('<li class="list-header ui-menu-divider">' + items[0].result + '</li>');
            }

            $(document.body).trigger('puca_search_view_all');
          };
        },
        response: function (event, ui) {
          let preloader = jQuery(".tbay-preloader");

          if (ui.content.length === 0) {
            preloader.text(puca_settings.no_results);
            preloader.addClass('no-results');
            preloader.parents('.tbay-search-form').removeClass('load');
            preloader.parents('.tbay-search-form').addClass('active').addClass('no-results');
          } else {
            preloader.empty();
            preloader.removeClass('no-results');
            preloader.parents('.tbay-search-form').removeClass('no-results');
          }
        },
        open: _this._autoCompeleteOpen,
        close: function (event, ui) {
          jQuery(event.target).parents('.tbay-search-form').removeClass('load');
        }
      }).focus(function () {
        if (_this2.val().length > 1) {
          if (_this2.parents('form').find(appendto).find('ul').length > 0) {
            _this2.parents('form').find(appendto).find('ul').show();
          } else {
            $('.ui-autocomplete.' + _this2.data('style')).show();
          }

          _this2.trigger(jQuery.Event("keydown"));
        }
      });
    });
    jQuery('.tbay-preloader').on('click', function (event) {
      jQuery(event.currentTarget).parents('.tbay-search-form').removeClass('active');
      jQuery(event.currentTarget).parents('.tbay-search-form').find('input[name=s]').val('');

      if (jQuery(event.currentTarget).hasClass('no-results')) {
        jQuery(event.currentTarget).removeClass('no-results').empty();
        jQuery(event.currentTarget).parents('.tbay-search-form').removeClass('no-results');
      }

      jQuery(event.currentTarget).parents('.tbay-search-form').find('input[name=s]').autocomplete('destroy');
    });
    $(document.body).on('puca_search_view_all', () => {
      $('#search-view-all').on('click', function () {
        $($(this).data('id')).submit();
      });
    });
  }

  _autoCompeleteOpen(event) {
    $(event.target).parents('.tbay-search-form').removeClass('load');
    $(event.target).parents('.tbay-search-form').addClass('active');
    var width_ul = $(event.target).parents('form').outerWidth();
    var left = $(event.target).parents('form').offset().left;
    jQuery(event.target).autocomplete("widget").css({
      "width": width_ul,
      "left": left
    });
  }

}

jQuery(document).ready(() => {
  new StickyHeader();
  new AutoComplete();
});
