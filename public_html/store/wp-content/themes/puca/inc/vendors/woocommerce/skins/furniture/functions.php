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
            update_option( 'yith_woocompare_compare_button_in_product_page', 'no' ); 
        }        

        if( class_exists( 'YITH_WCWL' ) ) {
            update_option( 'yith_wcwl_button_position', 'shortcode' ); 
        }        

        if( class_exists( 'YITH_WCBR' ) ) {
            update_option( 'yith_wcbr_brands_label', '' ); 
        }

        add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {

            $tbay_thumbnail_width       = get_option( 'tbay_woocommerce_thumbnail_image_width', 164);
            $tbay_thumbnail_height      = get_option( 'tbay_woocommerce_thumbnail_image_height', 196);
            $tbay_thumbnail_cropping    = get_option( 'tbay_woocommerce_thumbnail_cropping', 'yes');
            $tbay_thumbnail_cropping    = ($tbay_thumbnail_cropping == 'yes') ? true : false;

            return array(
                'width'  => $tbay_thumbnail_width,
                'height' => $tbay_thumbnail_height,
                'crop'   => $tbay_thumbnail_cropping,
            );
        } );
        
        $ptreviews_width       = get_option( 'tbay_photo_reviews_thumbnail_image_width', 100);
        $ptreviews_height      = get_option( 'tbay_photo_reviews_thumbnail_image_height', 100);
        $ptreviews_cropping    = get_option( 'tbay_photo_reviews_thumbnail_image_cropping', 'yes');

        $ptreviews_cropping    = ($ptreviews_cropping == 'yes') ? true : false;

        add_image_size( 'tbay_photo_reviews_thumbnail_image', $ptreviews_width, $ptreviews_height, $ptreviews_cropping );

    }
}

if ( ! function_exists( 'puca_woocommerce_setup_size_image' ) ) {
    add_action( 'after_setup_theme', 'puca_woocommerce_setup_size_image' );
    function puca_woocommerce_setup_size_image() {
        if( puca_tbay_get_global_config('config_media', false) ) return;

        $thumbnail_width = 370;
        $main_image_width = 650;
        $cropping_custom_width = 1;
        $cropping_custom_height = 1;

        // Image sizes
        update_option( 'woocommerce_thumbnail_image_width', $thumbnail_width );
        update_option( 'woocommerce_single_image_width', $main_image_width ); 

        update_option( 'woocommerce_thumbnail_cropping', 'custom' );
        update_option( 'woocommerce_thumbnail_cropping_custom_width', $cropping_custom_width );
        update_option( 'woocommerce_thumbnail_cropping_custom_height', $cropping_custom_height );
    }
}

if(class_exists( 'YITH_WCBR' )) {
    remove_action( 'woocommerce_product_meta_end', array( YITH_WCBR(), 'add_single_product_brand_template' ) );
    add_action( 'woocommerce_single_product_summary', array( YITH_WCBR(), 'add_single_product_brand_template' ), 0 );
}

if ( ! function_exists( 'puca_furniture_add_product_description' ) ) {
    function puca_furniture_add_product_description() {
        wc_get_template( 'single-product/short-description.php' );
    }
}

if ( ! function_exists( 'puca_woocommerce_product_buttons' ) ) {
    // Change Product Buttons
    function puca_woocommerce_product_buttons(){
        global $product;
        ?>
        <?php if(class_exists('YITH_WCWL') || class_exists('YITH_Woocompare')){ ?>
            <?php if(class_exists('YITH_WCWL')) { ?> 
                <div class="tbay-wishlist">
                   <?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>
                </div>  
            <?php } ?>
            <?php if(class_exists('YITH_Woocompare')){ ?>
                <div class="tbay-compare">
                    <?php echo do_shortcode('[yith_compare_button]') ?>
                </div>
            <?php } ?>
        <?php } ?>
        <?php
    }
    add_action('woocommerce_after_add_to_cart_button', 'puca_woocommerce_product_buttons', 10);
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
                     data-date="<?php echo gmdate('Y', $time_sale).'-'.gmdate('m', $time_sale).'-'.gmdate('d', $time_sale).' '. gmdate('H', $time_sale) . ':' . gmdate('i', $time_sale) . ':' .  gmdate('s', $time_sale) ; ?>">
                </div>
            </div> 
        <?php endif; ?> 
        <?php
    }
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
                  <div class="title"><?php esc_html_e('Sale Countdown','puca'); ?></div>
                  <div class="tbay-countdown scroll-init" data-id="<?php echo esc_attr($_id); ?>-<?php echo esc_attr($product->get_id()); ?>" id="countdown-<?php echo esc_attr($_id); ?>-<?php echo esc_attr($product->get_id()); ?>" data-time="timmer" data-days="<?php esc_attr_e('Days','puca'); ?>" data-hours="<?php esc_attr_e('Hours','puca'); ?>"  data-mins="<?php esc_attr_e('Mins','puca'); ?>" data-secs="<?php esc_attr_e('Secs','puca'); ?>"
                     data-date="<?php echo gmdate('Y', $time_sale).'-'.gmdate('m', $time_sale).'-'.gmdate('d', $time_sale).' '. gmdate('H', $time_sale) . ':' . gmdate('i', $time_sale) . ':' .  gmdate('s', $time_sale) ; ?>">
                </div>
              </div> 
            </div> 
        <?php endif; ?> 
        <?php
    }
}

remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
add_action( 'woocommerce_after_cart_table', 'woocommerce_button_proceed_to_checkout' );

if ( ! function_exists( 'puca_woo_show_product_loop_outstock_flash' ) ) {
    /*Change Out of Stock woo*/
    add_filter( 'woocommerce_before_shop_loop_item_title', 'puca_woo_show_product_loop_outstock_flash' );
    function puca_woo_show_product_loop_outstock_flash( $html ) {

        global $product;
        $availability   = $product->get_availability();
        $return_content = '';

        if ( $product->is_on_sale() && ! $product->is_in_stock() ) {
            $return_content .= '<span class="out-stock out-stock-sale"><span>'. esc_html__('Out of stock', 'puca') .'</span></span>';
        } else if ( ! $product->is_in_stock() ) {
           $return_content .= '<span class="out-stock"><span>' . esc_html__('Out of stock', 'puca') .'</span></span>';
        }

        echo trim($return_content);
    }
}

/* Add label Quantity */
if( !function_exists('puca_woo_add_label_quantity') ){
    function puca_woo_add_label_quantity(  ) {
        $output = '';

        if( !(bool) ( puca_tbay_get_config('enable_buy_now', false) ) ) {
            $output = '<span class="name">'. esc_html__( 'Quantity', 'puca' ) .'</span>';
        }
        
        echo trim($output);
    }
    add_action('woocommerce_before_quantity_input_field', 'puca_woo_add_label_quantity', 10);
    
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