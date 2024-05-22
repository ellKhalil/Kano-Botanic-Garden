'use strict';

!function ($) {
  $("body").on("click", ".tbay-checkbox", function () {
    jQuery('.' + this.id).toggle();
  });
  $('.tbay-wpcolorpicker').each(function () {
    $(this).wpColorPicker();
  });
  $('#_puca_size_guide_type').on('change', function () {
    if ($(this).val() === 'global') {
      $('.show_size_guide_customize').hide();
    } else {
      $('.show_size_guide_customize').show();
    }
  }).trigger('change');
  $('#_puca_delivery_return_type').on('change', function () {
    if ($(this).val() === 'global') {
      $('.show_delivery_return_customize').hide();
    } else {
      $('.show_delivery_return_customize').show();
    }
  }).trigger('change');
}(window.jQuery);
