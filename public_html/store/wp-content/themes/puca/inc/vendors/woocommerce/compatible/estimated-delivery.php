<?php

if( !class_exists('EDWCore') ) return;


if ( !function_exists( 'puca_estimate_delivery' ) ) {
    add_action( 'woocommerce_product_meta_start', 'puca_estimate_delivery', 10 );
    function puca_estimate_delivery()
    {
        if( get_option('_edw_position','') !== 'disabled' ) return;

        echo do_shortcode('[estimate_delivery]');
    }
  } 