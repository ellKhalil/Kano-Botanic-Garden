<?php
if ( !puca_is_woocommerce_activated() ) return;

/**
 * ------------------------------------------------------------------------------------------------
 * Size Guide button
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('puca_the_delivery_return')) {
    function puca_the_delivery_return($product_id)
    {
        $delivery_return_type     = maybe_unserialize(get_post_meta($product_id, '_puca_delivery_return_type', true));

        if( !empty($delivery_return_type) && $delivery_return_type !== 'global' ) {
            $delivery_return          = maybe_unserialize(get_post_meta($product_id, '_puca_delivery_return', true));
            
        } else {
            $delivery_return          = maybe_unserialize(puca_tbay_get_config('single_delivery_return'));
        }

        if( empty($delivery_return) ) return;
        
        wp_enqueue_script('jquery-magnific-popup');
        wp_enqueue_style('magnific-popup');
        ?>
        <li class="item tbay-delivery-return">
            <a href="#tbay-content-delivery-return" class="popup-button-open">
                <i class="tb-icon tb-icon-zzzz-delivery-return"></i>
                <span><?php esc_html_e('Delivery Return', 'puca'); ?></span>
            </a>
            <div id="tbay-content-delivery-return" class="tbay-popup-content zoom-anim-dialog mfp-hide">
                <div class="content">
                    <?php echo do_shortcode($delivery_return); ?>
                </div>
            </div>
        </li>
        <?php
    }
}