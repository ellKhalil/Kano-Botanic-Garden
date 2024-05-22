<?php

if( !class_exists('YITH_WCQV') ) return;

add_action( 'puca_woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 30 );
add_action( 'yith_wcqv_product_image', 'puca_woo_only_feature_product', 10 ); 

if (!function_exists('puca_quick_view_view_details_btn')) {
    add_action('puca_woocommerce_after_product_thumbnails', 'puca_quick_view_view_details_btn', 10);   
    function puca_quick_view_view_details_btn()
    {  
        global $product;
        $permalink = $product->get_permalink(); 
        echo '<div class="details-btn-wrapper"><a class="view-details-btn" href="'. esc_url($permalink) .'">'. esc_html__('View details', 'puca') .'</a></div>';
    } 
}