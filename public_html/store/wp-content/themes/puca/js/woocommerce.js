'use strict';

class MiniCart {
  miniCartTop() {
    $("#tbay-top-cart").hide();
    $(".mini-cart.top, #tbay-top-cart .offcanvas-close").on("click", function () {
      $("#tbay-top-cart").slideToggle(500);
    });
  }

  miniCartBottom() {
    $(".mini-cart.bottom").on("click", function (e) {
      $('.tbay-bottom-cart').toggleClass('active');
    });
    $(".tbay-bottom-cart .offcanvas-close").on("click", function () {
      $('.tbay-bottom-cart').removeClass('active');
    });
  }

  miniCartAll() {
    jQuery(".dropdown-toggle").dropdown();
    var $win = $(window);
    var $box = $('.tbay-dropdown-cart .dropdown-content,.tbay-bottom-cart .content,.topbar-mobile .btn,#tbay-mobile-menu, .active-mobile button,#tbay-offcanvas-main,.topbar-mobile .btn-toggle-canvas,#tbay-offcanvas-main .btn-toggle-canvas');
    $win.on("click.Bst,click touchstart tap", function (event) {
      if ($box.has(event.target).length == 0 && !$box.is(event.target)) {
        $('#wrapper-container').removeClass('active active-cart');
        $('#wrapper-container').removeClass('offcanvas-right');
        $('#wrapper-container').removeClass('offcanvas-left');
        $('.tbay-dropdown-cart').removeClass('active');
        $('#tbay-offcanvas-main,.tbay-offcanvas').removeClass('active');
        $("#tbay-dropdown-cart").hide(500);
        $('.tbay-bottom-cart').removeClass('active');
      }
    });
    $("#tbay-offcanvas-main .btn-toggle-canvas").on("click", function () {
      $('#tbay-offcanvas-main').removeClass('active');
    });
    $(".mini-cart.v2").on('click', function (e) {
      $('#wrapper-container').toggleClass('active-cart');
      $('#wrapper-container').toggleClass(e.currentTarget.dataset.offcanvas);
      $('.tbay-dropdown-cart').toggleClass('active');
    });
    $(".tbay-dropdown-cart.v2 .offcanvas-close").on('click', function () {
      $('#wrapper-container').removeClass('active');
      $('#wrapper-container').removeClass('offcanvas-right');
      $('#wrapper-container').removeClass('offcanvas-left');
      $('.tbay-dropdown-cart').removeClass('active');
    });
  }

}

const ADDING_TO_CART_EVENT = "adding_to_cart";
const ADDED_TO_CART_EVENT = "added_to_cart";
const LOADMORE_AJAX_HOME_PAGE = "puca_more_post_ajax";
const LOADMORE_AJAX_SHOP_PAGE = "puca_pagination_more_post_ajax";
const LIST_POST_AJAX_SHOP_PAGE = "puca_list_post_ajax";
const GRID_POST_AJAX_SHOP_PAGE = "puca_grid_post_ajax";

class AjaxCart {
  constructor() {
    if (typeof puca_settings === "undefined") return;

    var _this = this;

    this.ajaxCartPosition = puca_settings.cart_position;

    switch (this.ajaxCartPosition) {
      case "popup":
        this._initAjaxPopupOrTopCart("popup");

        break;

      case "top":
        this._initAjaxPopupOrTopCart("top");

        break;

      case "bottom":
        this._initAjaxCartBottom();

        this._initAjaxSingleCart();

        break;

      case "left":
        this._initAjaxCartLeftOrRight("left");

        this._initAjaxSingleCart();

        break;

      case "right":
        this._initAjaxCartLeftOrRight("right");

        this._initAjaxSingleCart();

        break;
    }

    MiniCart.prototype.miniCartAll();

    this._initEventRemoveProduct();

    _this._initEventMiniCartAjaxQuantity();
  }

  _initAjaxPopupOrTopCart(position) {
    var product_info = null,
        product_id = null;
    jQuery(`.ajax_cart_${position}`).on(ADDING_TO_CART_EVENT, (button, data1, data2) => {
      product_info = data2;

      if (product_info.product_id == 'undefined') {
        return;
      } else {
        product_id = product_info.product_id;
      }
    });
    jQuery(`.ajax_cart_${position}`).on(ADDED_TO_CART_EVENT, function () {
      if (product_info && product_info != null) {
        $('#tbay-cart-modal').modal();
        var url = puca_settings.ajaxurl + '?action=puca_add_to_cart_product&product_id=' + product_id;
        $.get(url, function (data, status) {
          $('#tbay-cart-modal .modal-body .modal-body-content').html(data);
        });
        $('#tbay-cart-modal').on('hidden.bs.modal', function () {
          $(this).find('.modal-body .modal-body-content').empty();
        });
      }
    });

    if (position == "top") {
      MiniCart.prototype.miniCartTop();
    }
  }

  _initAjaxSingleCart() {
    if (!puca_settings.enable_ajax_add_to_cart || !puca_settings.ajax_single_add_to_cart) return;

    $(document).on('click', '.single_add_to_cart_button', function (e) {
      if ($(this).closest('form.cart').find('input[name="puca_buy_now"]').length > 0 && $(this).closest('form.cart').find('input[name="puca_buy_now"]').val() === "1") return;
      let $button = $(this),
          $form = $button.closest('form.cart');

      if ($form.hasClass('grouped_form') || $form.find('input[name=quantity]').length == 0 || $button.parents('#yith-quick-view-content').length > 0) {
        return;
      }

      var id = $button.val(),
          product_qty = $form.find('input[name=quantity]').val() || 1,
          product_id = $form.find('input[name=product_id]').val() || id,
          variation_form = $(this).closest('.variations_form'),
          var_id = 0,
          item = {};
      if (!product_id) return;
      if ($button.is('.disabled')) return;

      if (variation_form.length > 0) {
        var_id = variation_form.find('input[name=variation_id]').val();
        product_id = variation_form.find('input[name=product_id]').val();
        var product_id = variation_form.find('input[name=product_id]').val();
            variation_form.find('input[name=quantity]').val();
            var check = true;
        let variations = variation_form.find('select[name^=attribute]');

        if (!variations.length) {
          variations = variation_form.find('[name^=attribute]:checked');
        }

        if (!variations.length) {
          variations = variation_form.find('input[name^=attribute]');
        }

        variations.each(function () {
          var $this = $(this),
              attributeName = $this.attr('name'),
              attributevalue = $this.val(),
              index,
              attributeTaxName;
          $this.removeClass('error');

          if (attributevalue.length === 0) {
            index = attributeName.lastIndexOf('_');
            attributeTaxName = attributeName.substring(index + 1);
            $this.addClass('required error').before('<div class="ajaxerrors"><p>Please select ' + attributeTaxName + '</p></div>');
            check = false;
          } else {
            item[attributeName] = attributevalue;
          }
        });

        if (!check) {
          return false;
        }
      }

      e.preventDefault();
      var data = {
        action: 'woocommerce_ajax_add_to_cart',
        product_id: product_id,
        product_sku: '',
        quantity: product_qty,
        variation_id: var_id,
        variation: item
      };
      $(document.body).trigger('adding_to_cart', [$button, data]);
      $.ajax({
        type: 'post',
        url: wc_add_to_cart_params.ajax_url,
        data: data,
        beforeSend: function (response) {
          $button.removeClass('added').addClass('loading');
        },
        complete: function (response) {
          $button.addClass('added').removeClass('loading');
        },
        success: function (response) {
          $.each(response.fragments, function (key, value) {
            $(key).replaceWith(value);
          });

          if (response.error & response.product_url) {
            window.location = response.product_url;
            return;
          } else {
            $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $button]);
            $('.woocommerce-notices-wrapper').empty().append(response.notices);
          }

          $('.tbay-dropdown-cart').addClass('active');
        }
      });
      return false;
    });
  }

  _initAjaxCartBottom() {
    jQuery('.ajax_cart_bottom').on(ADDED_TO_CART_EVENT, function () {
      $('.tbay-bottom-cart').addClass('active');
    });
    MiniCart.prototype.miniCartBottom();
  }

  _initAjaxCartLeftOrRight(position) {
    jQuery(`.ajax_cart_${position}`).on(ADDED_TO_CART_EVENT, function () {
      $('.tbay-dropdown-cart').addClass('active');
    });
  }

  _initEventRemoveProduct() {
    if (!puca_settings.enable_ajax_add_to_cart) return;
    $(document).on('click', '.mini_cart_content a.remove', event => {
      this._onclickRemoveProduct(event);
    });
  }

  _onclickRemoveProduct(event) {
    event.preventDefault();
    var product_id = $(event.currentTarget).attr("data-product_id"),
        cart_item_key = $(event.currentTarget).attr("data-cart_item_key"),
        product_container = jQuery(event.currentTarget).parents('.mini_cart_item'),
        thisItem = $(event.currentTarget).closest('.widget_shopping_cart_content');
    product_container.block({
      message: null,
      overlayCSS: {
        cursor: 'none'
      }
    });

    this._callRemoveProductAjax(product_id, cart_item_key, thisItem, event);
  }

  _callRemoveProductAjax(product_id, cart_item_key, thisItem, event) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: wc_add_to_cart_params.ajax_url,
      data: {
        action: "product_remove",
        product_id: product_id,
        cart_item_key: cart_item_key
      },
      beforeSend: function () {
        thisItem.find('.mini_cart_content').append('<div class="ajax-loader-wapper"><div class="ajax-loader"></div></div>').fadeTo("slow", 0.3);
        event.stopPropagation();
      },
      success: response => {
        this._onRemoveSuccess(response, product_id);
      }
    });
  }

  _onRemoveSuccess(response, product_id) {
    if (!response || response.error) return;
    var fragments = response.fragments;

    if (fragments) {
      $.each(fragments, function (key, value) {
        $(key).replaceWith(value);
      });
    }

    $('.add_to_cart_button.added[data-product_id="' + product_id + '"]').removeClass("added").next('.wc-forward').remove();
  }

  _initEventMiniCartAjaxQuantity() {
    $('body').on('change', '.mini_cart_content .qty', function (event) {
      event.preventDefault();
      var urlAjax = puca_settings.wc_ajax_url.toString().replace('%%endpoint%%', 'puca_quantity_mini_cart'),
          input = $(this),
          wrap = $(input).parents('.mini_cart_content'),
          hash = $(input).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1"),
          max = parseFloat($(input).attr('max'));

      if (!max) {
        max = false;
      }

      var quantity = parseFloat($(input).val());

      if (max > 0 && quantity > max) {
        $(input).val(max);
        quantity = max;
      }

      $.ajax({
        url: urlAjax,
        type: 'POST',
        dataType: 'json',
        cache: false,
        data: {
          hash: hash,
          quantity: quantity
        },
        beforeSend: function () {
          wrap.append('<div class="ajax-loader-wapper"><div class="ajax-loader"></div></div>').fadeTo("slow", 0.3);
          event.stopPropagation();
        },
        success: function (data) {
          if (data && data.fragments) {
            $.each(data.fragments, function (key, value) {
              if ($(key).length) {
                $(key).replaceWith(value);
              }
            });

            if (typeof $supports_html5_storage !== 'undefined' && $supports_html5_storage) {
              sessionStorage.setItem(wc_cart_fragments_params.fragment_name, JSON.stringify(data.fragments));
              set_cart_hash(data.cart_hash);

              if (data.cart_hash) {
                set_cart_creation_timestamp();
              }
            }

            $(document.body).trigger('wc_fragments_refreshed');
          }
        }
      });
    });
  }

}

class WishList {
  constructor() {
    this._onChangeWishListItem();
  }

  _onChangeWishListItem() {
    jQuery(document).on('added_to_wishlist removed_from_wishlist', () => {
      var counter = jQuery('.count_wishlist');
      if (counter.length === 0) return;
      $.ajax({
        url: yith_wcwl_l10n.ajax_url,
        data: {
          action: 'yith_wcwl_update_wishlist_count'
        },
        dataType: 'json',
        success: function (data) {
          counter.html(data.count);
        },
        beforeSend: function () {
          counter.block();
        },
        complete: function () {
          counter.unblock();
        }
      });
    });
  }

}

class ProductItem {
  _initOnChangeQuantity(callback) {
    var _this = this;

    jQuery(document).off('click', '.plus, .minus').on('click', '.plus, .minus', function (event) {
      event.preventDefault();

      var qty = jQuery(this).closest('.quantity').find('.qty'),
          currentVal = parseFloat(qty.val()),
          max = qty.attr('max'),
          min = qty.attr('min'),
          step = qty.attr('step'),
          number_digits = _this.numberAfterDecimal(step);

      currentVal = !currentVal || currentVal === '' || currentVal === 'NaN' ? 0 : currentVal;
      max = max === '' || max === 'NaN' ? '' : max;
      min = min === '' || min === 'NaN' ? 0 : min;
      step = step === 'any' || step === '' || step === undefined || parseFloat(step) === NaN ? 1 : step;

      if ($(this).is('.plus')) {
        if (max && (max == currentVal || currentVal > max)) {
          qty.val(max);
        } else {
          qty.val((currentVal + parseFloat(step)).toFixed(number_digits));
        }
      } else {
        if (min && (min == currentVal || currentVal < min)) {
          qty.val(min);
        } else if (currentVal > 0) {
          qty.val((currentVal - parseFloat(step)).toFixed(number_digits));
        }
      }

      if (callback && typeof callback == "function") {
        $(this).parent().find('input').trigger("change");
        callback();

        if ($(event.target).parents('.mini_cart_content').length > 0) {
          event.stopPropagation();
        }
      }
    });
  }

  numberAfterDecimal(value) {
    let output = 0;

    if (value.toString().split(".").length > 1) {
      output = value.toString().split(".")[1].length;
    } else {
      return output;
    }

    if (output < 0) return output;
    return output;
  }

  _initQuantityMode() {
    if (typeof puca_settings === "undefined" || !puca_settings.quantity_mode) return;
    $(".woocommerce .products").on("click", ".quantity .qty", function () {
      return false;
    });
    $(document).on('change', ".quantity .qty", function () {
      var add_to_cart_button = $(this).parents(".product-block").find(".add_to_cart_button");
      add_to_cart_button.attr("data-quantity", $(this).val());
    });
    $(document).on("keypress", ".quantity .qty", function (e) {
      if ((e.which || e.keyCode) === 13) {
        $(this).parents(".product-block").find(".add_to_cart_button").trigger("click");
      }
    });
  }

  _initSwatches() {
    jQuery('body').on('click', '.tbay-swatches-wrapper li a', function () {
      let $active = false;
      let $parent = $(this).closest('.product-block');
      var $image = $parent.find('.product-image img:eq(0)');

      if (!$(this).closest('ul').hasClass('active')) {
        $(this).closest('ul').addClass('active');
        $image.attr('data-old', $image.attr('src'));
      }

      if (!$(this).hasClass('selected')) {
        $(this).closest('ul').find('li a').each(function () {
          if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
          }
        });
        $(this).addClass('selected');
        $parent.addClass('product-swatched');
        $active = true;
      } else {
        $image.attr('src', $image.data('old'));
        $(this).removeClass('selected');
        $parent.removeClass('product-swatched');
      }

      if (!$active) return;

      if (typeof $(this).data('imageSrc') !== 'undefined') {
        $image.attr('src', $(this).data('imageSrc'));
      }

      if (typeof $(this).data('imageSrcset') !== 'undefined') {
        $image.attr('srcset', $(this).data('imageSrcset'));
      }

      if (typeof $(this).data('imageSizes') !== 'undefined') {
        $image.attr('sizes', $(this).data('imageSizes'));
      }
    });
  }

}

class Cart {
  constructor() {
    if (typeof puca_settings === "undefined") return;

    let _this = this;

    _this._initEventChangeQuantity();

    jQuery(document.body).on('updated_wc_div', () => {
      _this._initEventChangeQuantity();

      jQuery(document.body).trigger('puca_load_more');

      if (typeof woocs_refresh_mini_cart !== 'undefined') {
        woocs_refresh_mini_cart(200);
      }

      if (typeof wc_add_to_cart_variation_params !== 'undefined') {
        jQuery('.variations_form').each(function () {
          jQuery(this).wc_variation_form();
        });
      }
    });
    jQuery(document.body).on("cart_page_refreshed", () => {
      _this._initEventChangeQuantity();
    });
  }

  _initEventChangeQuantity() {
    const updateCart = jQuery("body.woocommerce-cart [name='update_cart']");
    const productItem = new ProductItem();

    const onChangeQuantity = () => {
      updateCart.prop("disabled", false);

      if (typeof puca_settings !== "undefined" && puca_settings.ajax_update_quantity) {
        jQuery("[name='update_cart']").trigger("click");
      }
    };

    if (updateCart.length === 0) {
      productItem._initOnChangeQuantity(() => {});
    } else {
      productItem._initOnChangeQuantity(onChangeQuantity);
    }
  }

}

class Checkout {
  constructor() {
    this._toogleWoocommerceIcon();
  }

  _toogleWoocommerceIcon() {
    if ($('.woocommerce-info a').length < 1) {
      return;
    }

    $('.woocommerce-info a').on('click', function () {
      $(this).find('.icons').toggleClass('icon-arrow-down').toggleClass('icon-arrow-up');
    });
  }

}

class SideBar {
  constructor() {
    this._layoutShopCanvasSidebar();

    this._layoutShopFullWidth();

    this._layoutSidebarMobile();
  }

  _layoutShopCanvasSidebar() {
    $(".button-canvas-sidebar, .product-canvas-sidebar .product-canvas-close").on("click", function (e) {
      $('.product-canvas-sidebar').toggleClass('active');
      $("body").toggleClass('product-canvas-active');
    });
    var win_canvas = $(window);
    var box_canvas = $('.product-canvas-sidebar .content,.button-canvas-sidebar');
    win_canvas.on("click.Bst", event => {
      event.target;

      if (box_canvas.has(event.target).length == 0 && !box_canvas.is(event.target)) {
        $('.product-canvas-sidebar').removeClass('active');
        $("body").removeClass('product-canvas-active');
      }
    });
  }

  _layoutSidebarMobile() {
    $(document).on('click', '.puca-sidebar-mobile-btn', function () {
      $('body').toggleClass('show-sidebar');
    });
    $(document).on('click', '.close-side-widget, .puca-close-side', function () {
      $('body').removeClass('show-sidebar');
    });
  }

  _layoutShopFullWidth() {
    $(".button-product-top").on("click", function (e) {
      $('.product-top-sidebar').toggleClass('active');
      $('.product-top-sidebar > .container .content').slideToggle(500, function () {});
    });
  }

}

class LoadMore {
  constructor() {
    if (typeof puca_settings === "undefined") return;

    this._initLoadMoreOnHomePage();

    this._initLoadMoreOnShopPage();

    this._int_berocket_lmp_end();
  }

  _initLoadMoreOnHomePage() {
    var _this = this;

    $('.more_products').each(function () {
      var id = $(this).data('id');
      $(`#more_products_${id} a[data-loadmore="true"]`).on('click', function () {
        var event = $(this);

        _this._callAjaxLoadMore({
          data: {
            action: LOADMORE_AJAX_HOME_PAGE,
            paged: $(this).data('paged') + 1,
            number: $(this).data('number'),
            columns: $(this).data('columns'),
            layout: $(this).data('layout'),
            type: $(this).data('type'),
            category: $(this).data('category'),
            screen_desktop: $(this).data('desktop'),
            screen_desktopsmall: $(this).data('desktopsmall'),
            screen_tablet: $(this).data('tablet'),
            screen_mobile: $(this).data('mobile')
          },
          event: event,
          id: id,
          thisItem: $(this).parent().parent()
        });

        return false;
      });
    });
  }

  _initLoadMoreOnShopPage() {
    $('.tbay-pagination-load-more').each(function (index) {
      $('.tbay-pagination-load-more a[data-loadmore="true"]').on('click', function () {
        var event = $(this),
            data = {
          'action': LOADMORE_AJAX_SHOP_PAGE,
          'query': puca_settings.posts,
          'page': puca_settings.current_page
        };
        $.ajax({
          url: woocommerce_params.ajax_url,
          data: data,
          type: 'POST',
          beforeSend: function (xhr) {
            event.addClass('active');
          },
          success: function (data) {
            if (data) {
              event.closest('#content').find('.products > .row').append(data);
              puca_settings.current_page++;
              $('.woocommerce-product-gallery').each(function () {
                jQuery(this).wc_product_gallery();
              });
              $(document.body).trigger('puca_load_more');

              if (typeof tawcvs_variation_swatches_form !== 'undefined') {
                $('.variations_form').tawcvs_variation_swatches_form();
                $(document.body).trigger('tawcvs_initialized');
              }

              if (typeof wc_add_to_cart_variation_params !== 'undefined') {
                $('.variations_form').each(function () {
                  $(this).wc_variation_form().find('.variations select:eq(0)').trigger('change');
                  $(this).wc_variation_form();
                });
              }

              event.removeClass('active');
              if (puca_settings.current_page == puca_settings.max_page) event.remove();
            } else {
              event.remove();
            }
          }
        });
        return false;
      });
    });
  }

  _callAjaxLoadMore(params) {
    var _this = this;

    var data = params.data;
    var event = params.event;
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: woocommerce_params.ajax_url,
      data: data,
      beforeSend: function () {
        event.addClass('active');
      },
      success: function (response) {
        _this._onAjaxSuccess(response, params);
      }
    });
  }

  _onAjaxSuccess(response, params) {
    var data = params.data;
    var event = params.event;

    if (response.check == false) {
      event.remove();
    }

    event.data('paged', data.paged);
    event.data('number', data.number + data.columns * (params.data.action === LOADMORE_AJAX_HOME_PAGE ? 3 : 2));
    var $element = params.data.action === LOADMORE_AJAX_HOME_PAGE ? $(`.widget_products_${params.id} .products>.row`) : $('.archive-shop .products >.row');
    $element.append(response.posts);
    $('.woocommerce-product-gallery').each(function () {
      jQuery(this).wc_product_gallery();
    });
    $(document.body).trigger('puca_load_more');

    if (typeof wc_add_to_cart_variation_params !== 'undefined') {
      $('.variations_form').each(function () {
        $(this).wc_variation_form();
      });
    }

    if (typeof tawcvs_variation_swatches_form !== 'undefined') {
      $('.variations_form').tawcvs_variation_swatches_form();
      $(document.body).trigger('tawcvs_initialized');
    }

    event.find('.loadding').remove();
    event.removeClass('active');
    event.button('reset');
    params.thisItem.removeAttr("style");
  }

  _int_berocket_lmp_end() {
    $(document).on('berocket_lmp_end', () => {
      $('.woocommerce-product-gallery').each(function () {
        jQuery(this).wc_product_gallery();
      });
      $(document.body).trigger('puca_load_more');

      if (typeof tawcvs_variation_swatches_form !== 'undefined') {
        $('.variations_form').tawcvs_variation_swatches_form();
        $(document.body).trigger('tawcvs_initialized');
      }

      if (typeof wc_add_to_cart_variation_params !== 'undefined') {
        $('.variations_form').each(function () {
          $(this).wc_variation_form().find('.variations select:eq(0)').trigger('change');
        });
      }
    });
  }

}

class ModalVideo {
  constructor($el, options = {
    classBtn: '.tbay-modalButton',
    defaultW: 640,
    defaultH: 360
  }) {
    this.$el = $el;
    this.options = options;

    this._initVideoIframe();
  }

  _initVideoIframe() {
    $(`${this.options.classBtn}[data-target='${this.$el}']`).on('click', this._onClickModalBtn);
    $(this.$el).on('hidden.bs.modal', () => {
      $(this.$el).find('iframe').html("").attr("src", "");
    });
  }

  _onClickModalBtn(event) {
    let html = $(event.currentTarget).data('target');
    var allowFullscreen = $(event.currentTarget).attr('data-tbayVideoFullscreen') || false;
    var dataVideo = {
      'src': $(event.currentTarget).attr('data-tbaySrc'),
      'height': $(event.currentTarget).attr('data-tbayHeight') || this.options.defaultH,
      'width': $(event.currentTarget).attr('data-tbayWidth') || this.options.defaultW
    };
    if (allowFullscreen) dataVideo.allowfullscreen = "";
    $(html).find("iframe").attr(dataVideo);
  }

}

class WooCommon {
  constructor() {
    this._pucaFixRemove();

    this._pucaVideoModal();
  }

  _pucaFixRemove() {
    $('.tbay-gallery-varible .woocommerce-product-gallery__trigger').remove();
  }

  _pucaVideoModal() {
    $('.tbay-video-modal').each((index, element) => {
      new ModalVideo(`#video-modal-${$(element).attr("data-id")}`);
    });
  }

}

class QuickView {
  constructor() {
    $(document).on('qv_loader_stop', () => {
      new ProductItem()._initOnChangeQuantity();
    });
  }

}

class singleProduct {
  constructor() {
    var _this = this;

    _this._initOnClickReview();

    _this._initBuyNow();

    _this._intReviewPopup();

    _this._intSliderGallery();

    _this._initChangeImageVarible();

    _this._initOpenAttributeMobile();

    _this._initCloseAttributeMobile();

    _this._initCloseAttributeMobileWrapper();

    _this._initAddToCartClickMobile();

    _this._initBuyNowwClickMobile();

    _this._initAskAQuestionName();
  }

  _initOnClickReview() {
    $('body').on('click', 'a.woocommerce-review-link', function () {
      if (!$('#reviews').closest('.panel').find('.tabs-title a').hasClass('collapsed')) return;
      $('#reviews').closest('.panel').find('.tabs-title a.collapsed').on('click');
    });
  }

  _initBuyNow() {
    $('body').on('click', '.tbay-buy-now', function (e) {
      e.preventDefault();
      let productform = $(this).closest('form.cart'),
          submit_btn = productform.find('[type="submit"]'),
          buy_now = productform.find('input[name="puca_buy_now"]'),
          is_disabled = submit_btn.is('.disabled');

      if (is_disabled) {
        submit_btn.trigger('click');
      } else {
        buy_now.val('1');
        productform.find('.single_add_to_cart_button').click();
      }
    });
    $(document.body).on('check_variations', function () {
      let btn_submit = $('form.variations_form').find('.single_add_to_cart_button');
      btn_submit.each(function (index) {
        let is_submit_disabled = $(this).is('.disabled');

        if (is_submit_disabled) {
          $(this).parent().find('.tbay-buy-now').addClass('disabled');
        } else {
          $(this).parent().find('.tbay-buy-now').removeClass('disabled');
        }
      });
    });
  }

  _initChangeImageVarible() {
    let form = $(".information form.variations_form");
    if (form.length === 0) return;
    form.on('change', function () {
      var _this = $(this);

      var attribute_label = [];

      _this.find('.variations tr').each(function () {
        if (typeof $(this).find('select').val() !== "undefined") {
          attribute_label.push($(this).find('select option:selected').text());
        }
      });

      _this.parent().find('.mobile-attribute-list .value').empty().append(attribute_label.join('/ '));

      if (form.find('.single_variation_wrap .single_variation').is(':empty')) {
        form.find('.mobile-infor-wrapper .infor-body').empty().append(form.parent().children('.price').html());
      } else if (!form.find('.single_variation_wrap .single_variation .woocommerce-variation-price').is(':empty')) {
        form.find('.mobile-infor-wrapper .infor-body').empty().append(form.find('.single_variation_wrap .single_variation').html());
      } else {
        form.find('.mobile-infor-wrapper .infor-body').empty().append(form.find('.single_variation_wrap .single_variation').html());
        form.find('.mobile-infor-wrapper .infor-body .woocommerce-variation-price').empty().append(form.parent().children('.price').html()).wrapInner('<p class="price"></p>');
      }
    });
    setTimeout(function () {
      jQuery(document.body).on('reset_data', () => {
        form.find('.mobile-infor-wrapper .infor-body .woocommerce-variation-availability').empty();
        form.find('.mobile-infor-wrapper .infor-body').empty().append(form.parent().children('.price').html()).wrapInner('<p class="price"></p>');
        return;
      });
      jQuery(document.body).on('woocommerce_gallery_init_zoom', () => {
        let src_image = $(".flex-control-thumbs").find('.flex-active').attr('src');
        $('.mobile-infor-wrapper img').attr('src', src_image);
      });
      jQuery(document.body).on('mobile_attribute_open', () => {
        if (form.find('.single_variation_wrap .single_variation').is(':empty')) {
          form.find('.mobile-infor-wrapper .infor-body').empty().append(form.parent().children('.price').html());
        } else if (!form.find('.single_variation_wrap .single_variation .woocommerce-variation-price').is(':empty')) {
          form.find('.mobile-infor-wrapper .infor-body').empty().append(form.find('.single_variation_wrap .single_variation').html());
        } else {
          form.find('.mobile-infor-wrapper .infor-body').empty().append(form.find('.single_variation_wrap .single_variation').html());
          form.find('.mobile-infor-wrapper .infor-body .woocommerce-variation-price').empty().append(form.parent().children('.price').html()).wrapInner('<p class="price"></p>');
        }
      });
    }, 1000);
  }

  _intReviewPopup() {
    if ($('#list-review-images').length === 0) return;
    var container = [];
    $('#list-review-images').find('.review-item').each(function () {
      var $link = $(this).find('a'),
          item = {
        src: $link.attr('href'),
        w: $link.data('width'),
        h: $link.data('height'),
        title: $link.data('caption')
      };
      container.push(item);
    });
    $('#list-review-images .review-gallery').off('click').on('click', function (event) {
      event.preventDefault();
      var $pswp = $('.pswp')[0],
          options = {
        index: $(this).parents('.review-item').index(),
        showHideOpacity: true,
        closeOnVerticalDrag: false,
        mainClass: 'pswp-review-images'
      };
      var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
      gallery.init();
      event.stopPropagation();
    });
  }

  _intSliderGallery() {
    if ($('#product-sliders-gallery').length === 0) return;
    var container = [];
    $('#product-sliders-gallery').find('.slider-gallery').each(function () {
      var item = {
        src: $(this).attr('href'),
        w: $(this).data('width'),
        h: $(this).data('height'),
        title: $(this).data('caption')
      };
      container.push(item);
    });
    $('#product-sliders-gallery .slider-gallery').off('click').on('click', function (event) {
      event.preventDefault();
      var $pswp = $('.pswp')[0],
          options = {
        index: $(this).parents('.product-gallery-item').index(),
        showHideOpacity: true,
        closeOnVerticalDrag: false,
        mainClass: 'pswp-gallery-images'
      };
      var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
      gallery.init();
    });
  }

  _initOpenAttributeMobile() {
    let attribute = $("#attribute-open");
    if (attribute.length === 0) return;
    attribute.on('click', function () {
      $(this).parent().parent().find('form.cart').addClass('open open-btn-all');
      $(this).parents('#tbay-main-content').addClass('open-main-content');
    });
  }

  _initAddToCartClickMobile() {
    let addtocart = $("#tbay-click-addtocart");
    if (addtocart.length === 0) return;
    addtocart.on('click', function () {
      $(this).parent().parent().find('form.cart').addClass('open open-btn-addtocart');
      $(this).parents('#tbay-main-content').addClass('open-main-content');
    });
  }

  _initBuyNowwClickMobile() {
    let buy_now = $("#tbay-click-buy-now");
    if (buy_now.length === 0) return;
    buy_now.on('click', function () {
      $(this).parent().parent().find('form.cart').addClass('open open-btn-buynow');
      $(this).parents('#tbay-main-content').addClass('open-main-content');
    });
  }

  _initCloseAttributeMobile() {
    let close = $("#mobile-close-infor");
    if (close.length === 0) return;
    close.on('click', function () {
      $(this).parents('form.cart').removeClass('open');

      if ($(this).parents('form.cart').hasClass('open-btn-all')) {
        $(this).parents('form.cart').removeClass('open-btn-all');
        $(this).parents('#tbay-main-content').removeClass('open-main-content');
      }

      if ($(this).parents('form.cart').hasClass('open-btn-buynow')) {
        $(this).parents('form.cart').removeClass('open-btn-buynow');
        $(this).parents('#tbay-main-content').removeClass('open-main-content');
      }

      if ($(this).parents('form.cart').hasClass('open-btn-addtocart')) {
        $(this).parents('form.cart').removeClass('open-btn-addtocart');
        $(this).parents('#tbay-main-content').removeClass('open-main-content');
      }
    });
  }

  _initCloseAttributeMobileWrapper() {
    let close = $("#mobile-close-infor-wrapper");
    if (close.length === 0) return;
    close.on('click', function () {
      $(this).parent().find('form.cart').removeClass('open');

      if ($(this).parent().find('form.cart').hasClass('open-btn-all')) {
        $(this).parent().find('form.cart').removeClass('open-btn-all');
        $(this).parents('#tbay-main-content').removeClass('open-main-content');
      }

      if ($(this).parent().find('form.cart').hasClass('open-btn-buynow')) {
        $(this).parent().find('form.cart').removeClass('open-btn-buynow');
        $(this).parents('#tbay-main-content').removeClass('open-main-content');
      }

      if ($(this).parent().find('form.cart').hasClass('open-btn-addtocart')) {
        $(this).parent().find('form.cart').removeClass('open-btn-addtocart');
        $(this).parents('#tbay-main-content').removeClass('open-main-content');
      }
    });
  }

  _initAskAQuestionName() {
    let question = $('.popup-aska-question');
    if (question.find('.product_name').length === 0) return;
    question.find('.product_name').val(question.find('.product-info .name').text());
  }

}

class DisplayMode {
  constructor() {
    if (typeof puca_settings === "undefined") return;

    this._initModeListShopPage();

    this._initModeGridShopPage();

    $(document.body).on('displayMode', () => {
      this._initModeListShopPage();

      this._initModeGridShopPage();
    });
    $(document).on("woof_ajax_done", () => {
      this._initModeListShopPage();

      this._initModeGridShopPage();

      if (typeof tawcvs_variation_swatches_form !== 'undefined') {
        $('.variations_form').tawcvs_variation_swatches_form();
        $(document.body).trigger('tawcvs_initialized');
      }

      if (typeof wc_add_to_cart_variation_params !== 'undefined') {
        $('.variations_form').each(function () {
          $(this).wc_variation_form().find('.variations select:eq(0)').trigger('change');
        });
      }
    });
  }

  _initModeListShopPage() {

    $('.display-mode button.list').each(function (index) {
      $(this).on('click', function () {
        if ($(this).hasClass('active')) return;
        var event = $(this),
            data = {
          'action': LIST_POST_AJAX_SHOP_PAGE,
          'query': puca_settings.posts
        };
        $.ajax({
          url: puca_settings.ajaxurl,
          data: data,
          type: 'POST',
          beforeSend: function (xhr) {
            event.closest('#main').find('.products').addClass('load-ajax');
          },
          success: function (data) {
            if (data) {
              event.parent().children().removeClass('active');
              event.addClass('active');
              event.closest('#main').find('.products > div').html(data);
              let products = event.closest('#main').find('div.products');
              products.addClass('products-list').removeClass('products-grid').fadeIn(300);
              $('.woocommerce-product-gallery').each(function () {
                jQuery(this).wc_product_gallery();
              });
              $(document.body).trigger('puca_load_more');

              if (typeof tawcvs_variation_swatches_form !== 'undefined') {
                $('.variations_form').tawcvs_variation_swatches_form();
                $(document.body).trigger('tawcvs_initialized');
              }

              if (typeof wc_add_to_cart_variation_params !== 'undefined') {
                $('.variations_form').each(function () {
                  $(this).wc_variation_form().find('.variations select:eq(0)').trigger('change');
                });
              }

              event.closest('#main').find('.products').removeClass('load-ajax');
              Cookies.set('display_mode', 'list', {
                expires: 0.1,
                path: '/'
              });
            }
          }
        });
        return false;
      });
    });
  }

  _initModeGridShopPage() {

    $('.display-mode button.grid').each(function (index) {
      $(this).on('click', function () {
        if ($(this).hasClass('active')) return;
        var event = $(this),
            data = {
          'action': GRID_POST_AJAX_SHOP_PAGE,
          'query': puca_settings.posts
        };
        $.ajax({
          url: puca_settings.ajaxurl,
          data: data,
          type: 'POST',
          beforeSend: function (xhr) {
            event.closest('#main').find('.products').addClass('load-ajax');
          },
          success: function (data) {
            if (data) {
              event.parent().children().removeClass('active');
              event.addClass('active');
              event.closest('#main').find('.products > div').html(data);
              let products = event.closest('#main').find('div.products');
              products.addClass('products-grid').removeClass('products-list').fadeIn(300);
              $('.woocommerce-product-gallery').each(function () {
                jQuery(this).wc_product_gallery();
              });
              $(document.body).trigger('puca_load_more');

              if (typeof tawcvs_variation_swatches_form !== 'undefined') {
                $('.variations_form').tawcvs_variation_swatches_form();
                $(document.body).trigger('tawcvs_initialized');
              }

              if (typeof wc_add_to_cart_variation_params !== 'undefined') {
                $('.variations_form').each(function () {
                  $(this).wc_variation_form().find('.variations select:eq(0)').trigger('change');
                });
              }

              products.removeClass('load-ajax');
              Cookies.set('display_mode', 'grid', {
                expires: 0.1,
                path: '/'
              });
            }
          }
        });
        return false;
      });
    });
  }

  _getDisplayMode() {
    if (puca_settings.display_mode == 'list') {
      Cookies.set('display_mode', 'list', {
        expires: 0.1,
        path: '/'
      });
    } else if (puca_settings.display_mode == 'grid') {
      Cookies.set('display_mode', 'grid', {
        expires: 0.1,
        path: '/'
      });
    }

    if (Cookies.get('display_mode') != undefined && Cookies.get('display_mode') !== "") {
      if (Cookies.get('display_mode') == 'grid') {
        let mode = $('.display-mode').find("button.grid");
        mode.parent().children().removeClass('active');
        mode.addClass('active');
        $('.tbay-filter').parents('#main').find('.products').addClass('products-' + Cookies.get('display_mode'));
      }

      if (Cookies.get('display_mode') == 'list') {
        let mode = $('.display-mode').find("button.list");
        mode.parent().children().removeClass('active');
        mode.addClass('active');
        $('.tbay-filter').parents('#main').find('.products').addClass('products-' + Cookies.get('display_mode'));
      }
    }
  }

}

class ProductTabs {
  constructor() {
    if (typeof puca_settings === "undefined") return;

    this._initProductTabs();
  }

  _initProductTabs() {
    var process = false;
    $('.tbay-product-tabs-ajax.ajax-active').each(function () {
      var $this = $(this);
      $this.find('.product-tabs-title li a').off('click').on('click', function (e) {
        e.preventDefault();
        var $this = $(this),
            atts = $this.parent().parent().data('atts'),
            value = $this.data('value'),
            id = $this.attr('href');

        if (process || $(id).hasClass('active-content')) {
          return;
        }

        process = true;
        $.ajax({
          url: puca_settings.ajaxurl,
          data: {
            atts: atts,
            value: value,
            action: 'puca_get_products_tab_shortcode'
          },
          dataType: 'json',
          method: 'POST',
          beforeSend: function (xhr) {
            $(id).parent().addClass('load-ajax');
          },
          success: function (data) {
            $(id).find('.grid-wrapper').prepend(data.html);
            $(id).parent().find('.current').removeClass('current');
            $(id).parent().removeClass('load-ajax');
            $(id).addClass('active-content');
            $(id).addClass('current');
            $(document.body).trigger('tbay_carousel_slick');
            $(document.body).trigger('tbay_ajax_tabs_products');
          },
          error: function () {
            console.log('ajax error');
          },
          complete: function () {
            process = false;
          }
        });
      });
    });
  }

}

class ProductCategoriesTabs {
  constructor() {
    if (typeof puca_settings === "undefined") return;

    this._initProductCategoriesTabs();
  }

  _initProductCategoriesTabs() {
    var process = false;
    $('.tbay-product-categories-tabs-ajax.ajax-active').each(function () {
      var $this = $(this);
      $this.find('.product-categories-tabs-title li a').off('click').on('click', function (e) {
        e.preventDefault();
        var $this = $(this),
            atts = $this.parent().parent().data('atts'),
            value = $this.data('value'),
            id = $this.attr('href');
        var type = typeof $this.data('type') !== "undefined" ? $this.data('type') : '';

        if (process || $(id).hasClass('active-content')) {
          return;
        }

        process = true;
        $.ajax({
          url: puca_settings.ajaxurl,
          data: {
            atts: atts,
            value: value,
            type: type,
            action: 'puca_get_products_categories_tab_shortcode'
          },
          dataType: 'json',
          method: 'POST',
          beforeSend: function (xhr) {
            $(id).parent().addClass('load-ajax');
          },
          success: function (data) {
            if ($(id).find('.tab-ajax-content').length > 0) {
              $(id).find('.tab-ajax-content').prepend(data.html);
            } else if ($(id).find('.tab-banner').length > 0) {
              $(id).append(data.html);
            } else {
              $(id).prepend(data.html);
            }

            $(id).parent().find('.current').removeClass('current');
            $(id).parent().removeClass('load-ajax');
            $(id).addClass('active-content');
            $(id).addClass('current');
            $(document.body).trigger('tbay_carousel_slick');
            $(document.body).trigger('tbay_ajax_tabs_products');
          },
          error: function () {
            console.log('ajax error');
          },
          complete: function () {
            process = false;
          }
        });
      });
    });
  }

}

jQuery(document).ready(() => {
  var product_item = new ProductItem();

  product_item._initSwatches();

  product_item._initQuantityMode();

  jQuery(document.body).trigger('tawcvs_initialized');
  new AjaxCart(), new singleProduct(), new SideBar(), new WishList(), new Cart(), new Checkout(), new WooCommon(), new LoadMore(), new ModalVideo("#productvideo"), new QuickView(), new DisplayMode(), new ProductTabs(), new ProductCategoriesTabs();
});
jQuery(document).on("woof_ajax_done", () => {
  let displaymode = new DisplayMode();

  displaymode._initModeListShopPage();

  displaymode._initModeGridShopPage();

  if (typeof tawcvs_variation_swatches_form !== 'undefined') {
    jQuery('.variations_form').tawcvs_variation_swatches_form();
    jQuery(document.body).trigger('tawcvs_initialized');
  }

  if (typeof wc_add_to_cart_variation_params !== 'undefined') {
    jQuery('.variations_form').each(function () {
      jQuery(this).wc_variation_form().find('.variations select:eq(0)').trigger('change');
    });
  }
});

var AjaxProductTabs = function ($scope, $) {
  new ProductTabs(), new ProductCategoriesTabs();
};

jQuery(window).on('elementor/frontend/init', function () {
  if (typeof puca_settings !== "undefined" && elementorFrontend.isEditMode() && Array.isArray(puca_settings.elements_ready.ajax_tabs)) {
    jQuery.each(puca_settings.elements_ready.ajax_tabs, function (index, value) {
      elementorFrontend.hooks.addAction('frontend/element_ready/tbay-' + value + '.default', AjaxProductTabs);
    });
  }
});
