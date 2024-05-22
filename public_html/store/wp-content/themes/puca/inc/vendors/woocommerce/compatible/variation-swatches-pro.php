<?php

if (!puca_is_woo_variation_swatches_pro()) {
    return;
}

if (!function_exists('puca_quantity_swatches_pro_field_archive')) {
    function puca_quantity_swatches_pro_field_archive()
    {
        global $product;
        if (puca_is_quantity_field_archive() && $product->backorders_allowed()) {
            woocommerce_quantity_input(['min_value' => 1]);
        } elseif ($product->get_stock_quantity()) {
            woocommerce_quantity_input(['min_value' => 1, 'max_value' => $product->get_stock_quantity()]);
        }
    }
}

if (!function_exists('puca_variation_swatches_pro_group_button')) {
    function puca_variation_swatches_pro_group_button()
    {
        global $product;

        if (!$product->is_type('variable')) {
            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

            return;
        }

        $class_active = puca_tbay_woocommerce_quantity_mode_active() ? 'quantity-group-btn' : 'woo-swatches-pro-btn';

        if (puca_tbay_woocommerce_quantity_mode_active() && puca_is_quantity_field_archive()) {
            $class_active .= ' active';
        }

        echo '<div class="'.esc_attr($class_active).'">';

        if (puca_tbay_woocommerce_quantity_mode_active()) {
            puca_quantity_swatches_pro_field_archive();
        }

        woocommerce_template_loop_add_to_cart();
        echo '</div>';
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    }

    add_action('woocommerce_after_shop_loop_item', 'puca_variation_swatches_pro_group_button', 5);
}

if (!function_exists('puca_variation_enable_swatches')) {
    add_action('woocommerce_init', 'puca_variation_enable_swatches', 5);
    function puca_variation_enable_swatches()
    {
        $enable = wc_string_to_bool(woo_variation_swatches()->get_option('show_on_archive', 'yes'));
        $position = sanitize_text_field(woo_variation_swatches()->get_option('archive_swatches_position', 'after'));

        if (!$enable) {
            return;
        }

        if ('after' === $position) {
            add_action('puca_woocommerce_after_shop_loop_item_caption', [Woo_Variation_Swatches_Pro_Archive_Page::instance(), 'after_shop_loop_item'], 30);
        } else {
            add_action('puca_woocommerce_after_shop_loop_item_caption', [Woo_Variation_Swatches_Pro_Archive_Page::instance(), 'after_shop_loop_item'], 7);
        }
    }
}

if (class_exists('Woo_Variation_Swatches_Pro_Archive_Page')) {
    remove_action('woocommerce_init', [Woo_Variation_Swatches_Pro_Archive_Page::instance(), 'enable_swatches'], 1);
}
