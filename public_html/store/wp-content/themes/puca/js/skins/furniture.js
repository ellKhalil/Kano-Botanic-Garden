'use strict';

class StickyHeader {
  constructor() {
    this.$tbayHeader = $('#tbay-header');

    if (this.$tbayHeader.hasClass('main-sticky-header')) {
      this._initStickyHeader();
    }

    if (this.$tbayHeader.hasClass('active-offcanvas-desktop')) {
      $('body').addClass('active-offcanvas-desktop');
    }

    $('.search-min-wrapper .btn-search-min').on('click', this._onClickSeachMin);
    $('.tbay-search-form .overlay-box').on('click', this._onClickOverLayBox);
    this._intSearchOffcanvas;
  }

  _initStickyHeader() {
    var _this = this;

    var tbay_width = $(window).width();
    var topslider_height = typeof $('.top-slider').height() != 'undefined' ? $('.top-slider').height() : 0;
    var header_height = this.$tbayHeader.height();
    $(window).scroll(function () {
      var cart_height_v1 = $('#tbay-top-cart.tbay-top-cart.v1 .dropdown-content').height() > 0 ? $('#tbay-top-cart.tbay-top-cart.v1').height() : 0;

      if (tbay_width >= 1024) {
        if ($(this).scrollTop() > header_height + cart_height_v1) {
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
      $('.archive-shop .tbay-filter').next().css('margin-top', $('.archive-shop .tbay-filter').height() + 21);
      $('.archive-shop .tbay-filter').addClass('fixed').css("top", 50);
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

  _onClickSeachMin() {
    $('.tbay-search-form.tbay-search-min form').toggleClass('show');
    $(this).toggleClass('active');
  }

  _onClickOverLayBox() {
    $('.search-min-wrapper .btn-search-min').removeClass('active');
    $('.tbay-search-form.tbay-search-min form').removeClass('show');
  }

  _intSearchOffcanvas() {
    $('[data-toggle="offcanvas-main-search"]').on('click', function () {
      $('#wrapper-container').toggleClass('show');
      $('#tbay-offcanvas-main').toggleClass('show');
    });
    var $box_totop = $('#tbay-offcanvas-main, .search');
    $(window).on("click.Bst", function (event) {
      if ($box_totop.has(event.target).length == 0 && !$box_totop.is(event.target)) {
        $('#wrapper-container').removeClass('show');
        $('#tbay-offcanvas-main').removeClass('show');
      }
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
        $t = jQuery("input[name=s]"),
        jQuerytop = 0;

    if ($t.data('style') == 'style1') {
      jQuerytop = 30;
    }

    $t.on("focus", function () {
      var _this2 = $(this);

      if (!$(this).parents('.tbay-search-form').hasClass('tbay-search-ajax')) return;
      var appendto = typeof jQuery(this).parents('form').data('appendto') !== "undefined" ? jQuery(this).parents('form').data('appendto') : '.tbay-search-results';

      _this2.autocomplete({
        source: function (req, response) {
          $.ajax({
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
          my: ' top-' + jQuerytop + ''
        },
        appendTo: appendto,
        minLength: 2,
        autoFocus: true,
        search: function (event, ui) {
          $(event.currentTarget).parents('.tbay-search-form').addClass('load');
        },
        select: function (event, ui) {
          window.location.href = ui.item.link;
        },
        create: function () {
          $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
            var string = '';
            item.count;
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
            var strings = $("<li>").append(string).appendTo(ul);
            return strings;
          };

          jQuery(this).data('ui-autocomplete')._renderMenu = function (ul, items) {
            var that = this;
            jQuery.each(items, function (index, item) {
              that._renderItemData(ul, item);
            });

            if (typeof _this2.data('style') !== "undefined" && _this2.data('style') == 'style1') {
              if (items[0].view_all) {
                ul.append('<li class="list-header ui-menu-divider">' + items[0].result + '<a id="search-view-all" data-id="#' + this.element.parents('form').attr('id') + '" href="javascript:void(0)">' + puca_settings.view_all + '</a></li>');
              } else {
                ul.append('<li class="list-header ui-menu-divider">' + items[0].result + '</li>');
              }
            } else {
              if (items[0].view_all) {
                ul.append('<li class="list-header ui-menu-divider">' + items[0].result + '</li>');
                ul.append('<li class="list-bottom ui-menu-divider"><a id="search-view-all" data-id="#' + this.element.parents('form').attr('id') + '" href="javascript:void(0)">' + puca_settings.view_all + '</a></li>');
              } else {
                ul.append('<li class="list-header ui-menu-divider">' + items[0].result + '</li>');
              }
            }

            $(document.body).trigger('puca_search_view_all');
          };
        },
        response: (event, ui) => {
          _this._autoCompeleteResponse(ui.content.length);
        },
        open: event => {
          _this._autoCompeleteOpen(event);
        },
        close: event => {
          _this._autoCompeleteClose(event);
        }
      }).focus(function () {
        if (_this2.val().length > 1) {
          if (_this2.parents('form').find(appendto).find('ul li').length > 0) {
            _this2.parents('form').find(appendto).find('ul').show();
          } else if ($('.ui-autocomplete.' + _this2.data('style')).find('li').length > 0) {
            $('.ui-autocomplete.' + _this2.data('style')).show();
          }

          _this2.trigger(jQuery.Event("keydown"));
        }
      });
    });
    $t.keyup(function () {
      if (jQuery(this).val().length == 0) {
        jQuery(this).parents('.tbay-search-form').removeClass('load');
      }
    });
    $(document.body).on('puca_search_view_all', () => {
      $('#search-view-all').on('click', function () {
        $($(this).data('id')).submit();
      });
    });
    $('.tbay-preloader').on('click', event => {
      _this._onClickTbayPreloader();
    });
  }

  _autoCompeleteOpen(event) {
    $(event.target).parents('.tbay-search-form').removeClass('load');
    $(event.target).parents('.tbay-search-form').addClass('active');
    let width_ul = $(event.target).parents('form').outerWidth();
    let left = 0;
    $(event.target).autocomplete("widget").css({
      "width": width_ul,
      "left": left,
      "top": "100%",
      "position": "absolute"
    });
  }

  _autoCompeleteClose(event) {
    $(event.target).parents('.tbay-search-form').removeClass('load');
  }

  _autoCompeleteResponse(length) {
    let preloader = jQuery(".tbay-preloader");

    if (length === 0) {
      preloader.text(puca_settings.no_results);
      preloader.addClass('no-results');
      preloader.parents('.tbay-search-form').removeClass('load');
      preloader.parents('.tbay-search-form').addClass('active');
    } else {
      preloader.empty();
      preloader.removeClass('no-results');
    }

    $(document.body).trigger('puca_search_no_results');
  }

  _onClickTbayPreloader() {
    jQuery(event.currentTarget).parents('.tbay-search-form').removeClass('active');
    jQuery(event.currentTarget).parents('.tbay-search-form').find('input[name=s]').val('');
    jQuery(event.currentTarget).parents('.tbay-search-form').find('input[name=s]').autocomplete('destroy');

    if (jQuery(event.currentTarget).hasClass('no-results')) {
      jQuery(event.currentTarget).removeClass('no-results').empty();
    }
  }

}

jQuery(document).ready(() => {
  new StickyHeader();
  new AutoComplete();
});
