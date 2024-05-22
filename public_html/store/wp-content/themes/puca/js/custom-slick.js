'use strict';

class Carousel {
  CarouselSlickQuickView() {
    const wrap = jQuery('#yith-quick-view-content .woocommerce-product-gallery__wrapper');
    wrap.each(function () {
      const _this = jQuery(this);

      if (_this.children().length === 0 || _this.hasClass("slick-initialized")) return;
      const rtl = _this.parent('.woocommerce-product-gallery-quick-view').data('rtl') === 'yes';

      _this.slick({
        slidesToShow: 1,
        infinite: false,
        focusOnSelect: true,
        dots: true,
        arrows: true,
        adaptiveHeight: true,
        mobileFirst: true,
        vertical: false,
        cssEase: 'ease',
        prevArrow: '<button type="button" class="slick-prev"><i class="icon-arrow-left icons"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="icon-arrow-right icons"></i></button>',
        settings: "unslick",
        rtl
      });
    });
    jQuery(".variations_form").on("woocommerce_variation_select_change", function () {
      wrap.slick("slickGoTo", 0);
    });
  }

  CarouselSlick() {
    var _this = this;

    if (jQuery(".owl-carousel[data-carousel=owl]:visible").length === 0) return;
    jQuery('.owl-carousel[data-carousel=owl]:visible:not(.scroll-init)').each(function () {
      _this._initCarouselSlick(jQuery(this));
    });
    jQuery('.owl-carousel[data-carousel=owl]:visible.scroll-init').waypoint(function () {
      var $this = $($(this)[0].element);

      _this._initCarouselSlick($this);
    }, {
      offset: '100%'
    });
  }

  _initCarouselSlick(_this2) {
    var _this = this;

    var config = _this._getSlickConfigOption(_this2);

    if (_this2.hasClass("slick-initialized")) return;

    if (!jQuery.browser.mobile || $(window).width() > 767) {
      _this2.slick(config);
    } else {
      _this2.slick(config);
    }
  }

  _getSlickConfigOption($el) {
    var defaultItems = $el.data('items');
    var _config = {
      dots: $el.data('pagination'),
      arrows: $el.data('nav'),
      infinite: $el.data('loop'),
      speed: 500,
      autoplay: $el.data('auto'),
      autoplaySpeed: $el.data('autospeed') || 2000,
      cssEase: 'linear',
      slidesToShow: defaultItems,
      slidesToScroll: defaultItems,
      mobileFirst: true,
      vertical: false,
      prevArrow: '<button type="button" class="slick-prev"><i class="icon-arrow-left icons"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="icon-arrow-right icons"></i></button>',
      rtl: $('html').attr('dir') === 'rtl'
    };
    var isUnslick = $el.data('unslick');
    _config.responsive = [{
      breakpoint: 1500,
      settings: {
        slidesToShow: defaultItems,
        slidesToScroll: defaultItems
      }
    }, {
      breakpoint: 1200,
      settings: {
        slidesToShow: $el.data('large') || defaultItems,
        slidesToScroll: $el.data('large') || defaultItems
      }
    }, {
      breakpoint: 980,
      settings: {
        slidesToShow: $el.data('medium') || defaultItems,
        slidesToScroll: $el.data('medium') || defaultItems
      }
    }, {
      breakpoint: 767,
      settings: {
        slidesToShow: $el.data('smallmedium') || defaultItems,
        slidesToScroll: $el.data('smallmedium') || defaultItems,
        infinite: false
      }
    }, {
      breakpoint: 479,
      settings: isUnslick ? "unslick" : {
        slidesToShow: $el.data('extrasmall') || 2,
        slidesToScroll: $el.data('extrasmall') || 2,
        infinite: false
      }
    }, {
      breakpoint: 0,
      settings: isUnslick ? "unslick" : {
        slidesToShow: $el.data('verysmall') || 2,
        slidesToScroll: $el.data('verysmall') || 2,
        infinite: false
      }
    }];
    return _config;
  }

  getSlickTabs() {
    var $ = jQuery;
    $('.nav-tabs li a').on('shown.bs.tab', event => {
      let carouselItemTab = $(event.target.hash).find(".owl-carousel[data-carousel=owl]:visible");
      let carouselItemDestroy = $(event.relatedTarget.hash).find(".owl-carousel[data-carousel=owl]");

      if (!carouselItemTab.hasClass("slick-initialized")) {
        carouselItemTab.slick(this._getSlickConfigOption(carouselItemTab));
      }

      if (carouselItemDestroy.hasClass("slick-initialized")) {
        carouselItemDestroy.slick('unslick');
      }
    });
  }

}

class Slider {
  tbaySlickSlider() {
    jQuery('.flex-control-thumbs').each((i, el) => {
      if (!el.children.length) return;
      const parent = jQuery(el).parent('.woocommerce-product-gallery');
      const {
        layout,
        columns,
        rtl
      } = parent.data();
      const _config = {
        vertical: layout === 'vertical',
        slidesToShow: columns,
        infinite: false,
        focusOnSelect: true,
        settings: "unslick",
        prevArrow: '<span class="owl-prev"></span>',
        nextArrow: '<span class="owl-next"></span>',
        rtl: rtl === 'yes' && layout !== 'vertical',
        responsive: [{
          breakpoint: 1200,
          settings: {
            vertical: false,
            slidesToShow: 4
          }
        }]
      };
      jQuery(el).slick(_config);
    });
  }

}

class Layout {
  tbaySlickLayoutSlide() {
    const sliderFor = $('.tbay-slider-for');

    if (sliderFor.length) {
      const configFor = {};
      const configNav = {};
      configFor.rtl = $('body').hasClass('rtl');
      configFor.slidesToShow = sliderFor.data('number') || 1;
      configFor.arrows = true;
      configFor.infinite = true;
      configFor.slidesToScroll = 1;
      configFor.prevArrow = '<span class="owl-prev"></span>';
      configFor.nextArrow = '<span class="owl-next"></span>';
      configFor.asNavFor = '.tbay-slider-nav';
      configFor.responsive = [{
        breakpoint: 1025,
        settings: {
          vertical: false,
          slidesToShow: configFor.slidesToShow > 1 ? configFor.slidesToShow - 1 : 1
        }
      }, {
        breakpoint: 480,
        settings: {
          vertical: false,
          slidesToShow: 1
        }
      }];
      configNav.dots = false;
      configNav.arrows = true;
      configNav.centerMode = false;
      configNav.focusOnSelect = true;
      configNav.infinite = false;
      configNav.slidesToShow = 4;
      configNav.slidesToScroll = 1;
      configNav.prevArrow = '<span class="owl-prev"></span>';
      configNav.nextArrow = '<span class="owl-next"></span>';
      configNav.asNavFor = '.tbay-slider-for';
      $('.tbay-slider-for').slick(configFor);
      $('.tbay-slider-nav').slick(configNav);

      if ($('.single-product .tbay-slider-for .slick-slide').length) {
        jQuery('.single-product .tbay-slider-for .slick-slide').zoom();
        $('.single-product .tbay-slider-for .slick-track').addClass('woocommerce-product-gallery__image single-product-main-image');
      }
    }
  }

}

(function ($, sr) {
  var debounce = function (func, threshold, execAsap) {
    var timeout;
    return function debounced() {
      var obj = this,
          args = arguments;

      function delayed() {
        if (!execAsap) func.apply(obj, args);
        timeout = null;
      }
      if (timeout) clearTimeout(timeout);else if (execAsap) func.apply(obj, args);
      timeout = setTimeout(delayed, threshold || 100);
    };
  };

  jQuery.fn[sr] = function (fn) {
    return fn ? this.on('resize', debounce(fn)) : this.trigger(sr);
  };
})(jQuery, 'smartresize');

jQuery(document).ready(() => {
  const carousel = new Carousel();
  const slider = new Slider();
  const layout = new Layout();
  carousel.CarouselSlick();
  carousel.getSlickTabs();

  if (puca_settings.single_product) {
    slider.tbaySlickSlider();

    if (puca_settings.is_layoutslide) {
      layout.tbaySlickLayoutSlide();
    }
  }

  $(window).smartresize(() => {
    if ($(window).width() >= 767) {
      try {
        carousel.CarouselSlick();

        if (puca_settings.single_product) {
          slider.tbaySlickSlider();

          if (puca_settings.is_layoutslide) {
            layout.tbaySlickLayoutSlide();
          }
        }
      } catch {}
    }
  });
});
setTimeout(() => {
  jQuery(window).on('qv_loader_stop', () => {
    const carousel = new Carousel();
    carousel.CarouselSlickQuickView();
  });
  jQuery(document.body).on('tbay_carousel_slick', () => {
    const carousel = new Carousel();
    carousel.CarouselSlick();
  });
}, 2000);

var CustomSlickHandler = function ($scope, $) {
  var carousel = new Carousel();
  carousel.CarouselSlick();
};

jQuery(window).on('elementor/frontend/init', function () {
  if (typeof puca_settings !== "undefined" && Array.isArray(puca_settings.elements_ready.slick)) {
    $.each(puca_settings.elements_ready.slick, function (index, value) {
      elementorFrontend.hooks.addAction('frontend/element_ready/tbay-' + value + '.default', CustomSlickHandler);
    });
  }
});
