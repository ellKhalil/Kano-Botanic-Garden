<?php 

/**
 * WooCommerce
 *
 */
if ( ! function_exists( 'puca_woocommerce_setup_support' ) ) {
    add_action( 'after_setup_theme', 'puca_woocommerce_setup_support' );
    function puca_woocommerce_setup_support() {
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
        
        if( class_exists( 'YITH_Woocompare' ) ) {
            update_option( 'yith_woocompare_compare_button_in_products_list', 'no' ); 
        }

        add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {

            $tbay_thumbnail_width       = get_option( 'tbay_woocommerce_thumbnail_image_width', 210);
            $tbay_thumbnail_height      = get_option( 'tbay_woocommerce_thumbnail_image_height', 270);
            $tbay_thumbnail_cropping    = get_option( 'tbay_woocommerce_thumbnail_cropping', 'yes');
            $tbay_thumbnail_cropping    = ($tbay_thumbnail_cropping == 'yes') ? true : false;

            return array(
                'width'  => $tbay_thumbnail_width,
                'height' => $tbay_thumbnail_height,
                'crop'   => $tbay_thumbnail_cropping,
            );
        } );

        $ptreviews = puca_photo_reviews_thumbnail_image();
        add_image_size( 'puca_photo_reviews_thumbnail_image', $ptreviews['width'], $ptreviews['height'], $ptreviews['crop'] );
    }
}

if ( ! function_exists( 'puca_woocommerce_setup_size_image' ) ) {
    add_action( 'after_setup_theme', 'puca_woocommerce_setup_size_image' );
    function puca_woocommerce_setup_size_image() {
        if( puca_tbay_get_global_config('config_media',false) ) return;
        
        $thumbnail_width = 417;
        $main_image_width = 695; 
        $cropping_custom_width = 141;
        $cropping_custom_height = 181;

        // Image sizes
        update_option( 'woocommerce_thumbnail_image_width', $thumbnail_width );
        update_option( 'woocommerce_single_image_width', $main_image_width ); 

        update_option( 'woocommerce_thumbnail_cropping', 'custom' );
        update_option( 'woocommerce_thumbnail_cropping_custom_width', $cropping_custom_width );
        update_option( 'woocommerce_thumbnail_cropping_custom_height', $cropping_custom_height );
    }
}


/*product time countdown*/
if(!function_exists('puca_woo_product_time_countdown')){
    add_action( 'puca_woocommerce_time_countdown', 'puca_woo_product_time_countdown', 10 );
    function puca_woo_product_time_countdown() {
        global $product;
        wp_enqueue_script( 'jquery-countdowntimer' );
        $time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
        $_id = puca_tbay_random_key();
        ?>
        <?php if ( $time_sale ): ?>
            <div class="time">
                <div class="tbay-countdown scroll-init" data-id="<?php echo esc_attr($_id); ?>-<?php echo esc_attr($product->get_id()); ?>" id="countdown-<?php echo esc_attr($_id); ?>-<?php echo esc_attr($product->get_id()); ?>" data-time="timmer" data-days="<?php esc_attr_e('Days','puca'); ?>" data-hours="<?php esc_attr_e('Hours','puca'); ?>"  data-mins="<?php esc_attr_e('Mins','puca'); ?>" data-secs="<?php esc_attr_e('Secs','puca'); ?>"
                     data-date="<?php echo gmdate('m', $time_sale).'-'.gmdate('d', $time_sale).'-'.gmdate('Y', $time_sale).'-'. gmdate('H', $time_sale) . '-' . gmdate('i', $time_sale) . '-' .  gmdate('s', $time_sale) ; ?>">
                </div>
            </div> 
        <?php endif; ?> 
        <?php
    }
}


if ( ! function_exists( 'puca_woo_show_product_loop_outstock_flash' ) ) {
    /*Change Out of Stock woo*/
    add_filter( 'woocommerce_before_shop_loop_item_title', 'puca_woo_show_product_loop_outstock_flash' ,15 );
    function puca_woo_show_product_loop_outstock_flash( $html ) {
        $product        = wc_get_product();
        
        if( empty($product) ) {
          $return_content =  $html;
        } else {
            $return_content = '';

            if ( ! $product->is_in_stock() ) {
               $return_content .= '<span class="out-stock">'. esc_html__('Out of stock', 'puca') .'</span>';
            }   
        }


        echo trim($return_content);
    }
}

/*YITH Wishlist*/
if ( ! function_exists( 'puca_remove_wishlist_text' ) ) {
    function puca_remove_wishlist_text( $text ) {
        if( class_exists('YITH_WCWL') && apply_filters( 'tbay_yith_wcwl_remove_text', true ) ) {
            return '';
        } else {
            return $text;
        }
    }
    add_filter('yith_wcwl_product_already_in_wishlist_text_button', 'puca_remove_wishlist_text', 10, 1);
    add_filter('yith_wcwl_product_added_to_wishlist_message_button', 'puca_remove_wishlist_text', 10, 1);
}
if ( ! function_exists( 'puca_custom_label_add_to_wishlist' ) ) {
    function puca_custom_label_add_to_wishlist($text) {
        $text_custom                       = esc_html__('Wishlist','puca'); 

        if (class_exists('YITH_WCWL') && apply_filters('tbay_yith_wcwl_remove_text', true)) {
            return $text_custom;
        } else {
            return $text;
        }
    }
    add_filter( 'yith_wcwl_browse_wishlist_label', 'puca_custom_label_add_to_wishlist', 10, 1 );
    add_filter( 'yith_wcwl_button_label', 'puca_custom_label_add_to_wishlist', 10, 1 );
    add_filter( 'yith_wcwl_view_wishlist_label', 'puca_custom_label_add_to_wishlist', 10, 1 );
} 

    
/*product time countdown*/
if(!function_exists('puca_woo_product_single_time_countdown')){

    add_action( 'woocommerce_before_single_product', 'puca_woo_product_single_time_countdown', 20 );

    function puca_woo_product_single_time_countdown() {

        global $product;

        $style_countdown   = puca_tbay_get_config('show_product_countdown',false);

        if ( isset($_GET['countdown']) ) {
            $countdown = $_GET['countdown'];
        }else {
            $countdown = $style_countdown;
        }  

        if(!$countdown || !$product->is_on_sale() ) {
          return '';
        }


        wp_enqueue_script( 'jquery-countdowntimer' );
        $time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
        $_id = puca_tbay_random_key();
        ?>
        <?php if ( $time_sale ): ?>
            <div class="container tbay-time-wrapper"> 
              <div class="time tbay-time">
                  <div class="title"><?php esc_html_e('Hurry up! This deal will end in:','puca'); ?></div>
                  <div class="tbay-countdown scroll-init" data-id="<?php echo esc_attr($_id); ?>-<?php echo esc_attr($product->get_id()); ?>" id="countdown-<?php echo esc_attr($_id); ?>-<?php echo esc_attr($product->get_id()); ?>" data-time="timmer" data-days="" data-hours=""  data-mins="" data-secs=""
                     data-date="<?php echo gmdate('m', $time_sale).'-'.gmdate('d', $time_sale).'-'.gmdate('Y', $time_sale).'-'. gmdate('H', $time_sale) . '-' . gmdate('i', $time_sale) . '-' .  gmdate('s', $time_sale) ; ?>">
                </div>
              </div>  
            </div> 
        <?php endif; ?> 
        <?php
    }
}