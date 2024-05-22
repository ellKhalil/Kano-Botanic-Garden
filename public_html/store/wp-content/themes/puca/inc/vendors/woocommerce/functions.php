<?php

require get_template_directory() . '/inc/vendors/woocommerce/skins/'.puca_tbay_get_theme().'/functions.php';

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// class cart Postion
if ( ! function_exists( 'puca_tbay_body_classes_config_woocommerce' ) ) {
    function puca_tbay_body_classes_config_woocommerce( $classes ) {

        $classes[] =  ( is_cart() && puca_tbay_get_config('ajax_update_quantity', false) ) ? 'tbay-ajax-update-quantity' : ''; 

        $classes[] = ( class_exists( 'WooCommerce_Germanized' ) ) ? 'body-germanized' : '';

        return $classes;
    }
    add_filter( 'body_class', 'puca_tbay_body_classes_config_woocommerce' );
}

// cart Postion
if ( !function_exists('puca_tbay_woocommerce_cart_position') ) {
    function puca_tbay_woocommerce_cart_position() {
       
        global $post;

        $tbay_header = apply_filters( 'puca_tbay_get_header_layout', puca_tbay_get_config('header_type', 'v1') );
        $active_theme = puca_tbay_get_theme(); 

        $position = '';
        if( is_shop() ) {
          $post_id = wc_get_page_id('shop');
        } else if(isset($post->ID)) {
          $post_id = $post->ID;
        }

        if( isset($post_id) ) {
            $position = get_post_meta( $post_id, 'tbay_page_mini_cart_position', true );
            if ( $position == 'global' ) {
                $position = puca_tbay_get_config('woo_mini_cart_position');
            }

        } else {
            $position = puca_tbay_get_config('woo_mini_cart_position');
        } 

        if( isset($position) && empty($position) ) {
            $position = puca_tbay_get_config('woo_mini_cart_position');
        }

        $position = ( isset($_GET['ajax_cart']) ) ? $_GET['ajax_cart'] : $position;


        if( $active_theme == 'fashion' ) {
            if( isset($tbay_header) && $tbay_header == 'v14' ) {
               $position = 'left';
            }
        } 

        if( wp_is_mobile() ) {
            $position = 'right';
        }


        return $position;

    }
    add_filter( 'puca_cart_position', 'puca_tbay_woocommerce_cart_position' ); 
}


if ( !function_exists('puca_tbay_get_woocommerce_mini_cart') ) {
    function puca_tbay_get_woocommerce_mini_cart($name = null) {
        $active_theme = puca_tbay_get_part_theme(); 
        $position = apply_filters( 'puca_cart_position', 10,2 ); 
        if(is_null($name)) {
            get_template_part( 'woocommerce/cart/'.$active_theme.'/mini-cart-button', $position);
        } else {
            get_template_part( 'woocommerce/cart/'.$active_theme.'/'.$name.'/mini-cart-button', $position);
        }
    }
}
  
// class cart Postion
if ( ! function_exists( 'puca_tbay_body_classes_cart_postion' ) ) {
    function puca_tbay_body_classes_cart_postion( $classes ) {

        $position = apply_filters( 'puca_cart_position', 10,2 );

        $class = ( isset($_GET['ajax_cart']) ) ? 'ajax_cart_'.$_GET['ajax_cart'] : 'ajax_cart_'.$position;

        $classes[] = trim($class);

        return $classes;
    }
    add_filter( 'body_class', 'puca_tbay_body_classes_cart_postion' );
}


// add to cart modal box
if ( !function_exists('puca_tbay_woocommerce_add_to_cart_modal') ) {
    add_action( 'wp_footer', 'puca_tbay_woocommerce_add_to_cart_modal' );
    function puca_tbay_woocommerce_add_to_cart_modal(){
    ?>
    <div class="modal fade" id="tbay-cart-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close btn btn-close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                    <div class="modal-body-content"></div>
                </div>
            </div>
        </div>
    </div>
    <?php     
    }
}


// cart modal
if ( !function_exists('puca_tbay_woocommerce_cart_modal') ) {
    add_action( 'wp_ajax_puca_add_to_cart_product', 'puca_tbay_woocommerce_cart_modal' );
    add_action( 'wp_ajax_nopriv_puca_add_to_cart_product', 'puca_tbay_woocommerce_cart_modal' );
    function puca_tbay_woocommerce_cart_modal() {
        wc_get_template( 'content-product-cart-modal.php' , array( 'product_id' => (int)$_GET['product_id'] ) );
        die;
    }
}


/*get category by id array*/
if ( !function_exists('puca_tbay_get_category_by_id') ) {
    function puca_tbay_get_category_by_id($categories_id = array()) {
        $categories = array(); 

        if( !is_array($categories_id)) return $categories;

        foreach ($categories_id as $key => $value) {
           $categories[$key] = get_term_by( 'id', $value, 'product_cat' )->slug;
        }

        return $categories;

    }
}

if ( !function_exists('puca_tbay_get_products') ) {
    function puca_tbay_get_products($categories = array(), $product_type = 'featured_product', $paged = 1, $post_per_page = -1, $orderby = '', $order = '', $offset  = 0) {
        global $woocommerce, $wp_query;
        $args = array(
            'post_type'           => 'product',
            'posts_per_page'      => $post_per_page,
            'post_status'         => 'publish',
            'paged'               => $paged,
            'orderby'             => $orderby,
            'order'               => $order,
            'offset'              => $offset,
            'meta_query'          => WC()->query->get_meta_query(),
            'tax_query'           => WC()->query->get_tax_query(),
        );

        if ( isset( $args['orderby'] ) ) {
            if ( 'price' == $args['orderby'] ) {
                $args = array_merge( $args, array(
                    'meta_key'  => '_price',
                    'orderby'   => 'meta_value_num'
                ) );
            }
            if ( 'featured' == $args['orderby'] ) {
                $args = array_merge( $args, array(
                    'meta_key'  => '_featured',
                    'orderby'   => 'meta_value'
                ) );
            }
            if ( 'sku' == $args['orderby'] ) {
                $args = array_merge( $args, array(
                    'meta_key'  => '_sku',
                    'orderby'   => 'meta_value'
                ) );
            }
        }

        if ( !empty($categories) && is_array($categories) ) {
            $args['tax_query']    = array(
                array(
                    'taxonomy'      => 'product_cat',
                    'field'         => 'slug',
                    'terms'         => $categories,
                    'operator'      => 'IN'
                )
            );
        }

        switch ($product_type) {
            case 'best_selling':
                $args['meta_key']='total_sales';
                $args['orderby']='meta_value_num';
                $args['ignore_sticky_posts']   = 1;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'featured_product':
                $args['ignore_sticky_posts']    = 1;
                $args['meta_query']             = array();
                $args['meta_query'][]           = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][]           = $woocommerce->query->visibility_meta_query();
                $args['tax_query'][]              = array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN'
                    )
                );
                
                break;
            case 'top_rate':
                $args['meta_key']       ='_wc_average_rating';
                $args['orderby']        ='meta_value_num';
                $args['order']          ='DESC';
                $args['meta_query']     = array();
                $args['meta_query'][]   = WC()->query->get_meta_query();
                $args['tax_query'][]    = WC()->query->get_tax_query();
                break;

            case 'recent_product':
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;
            case 'random_product':
                $args['orderby']    = 'rand';
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;
            case 'deals':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $args['meta_query'][] =  array(
                    'relation' => 'AND',
                    array(
                        'relation' => 'OR',
                        array(
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                        array(
                            'key'           => '_min_variation_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                    ),            
                    array(
                        'key'           => '_sale_price_dates_to',
                        'value'         => time(),
                        'compare'       => '>',
                        'type'          => 'numeric'
                    ),
                );
                break;     
            case 'on_sale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                break;
        }

        if( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $args['meta_query'][] =  array(
                'relation' => 'AND',
                array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                )
            );
        }

        $args['tax_query'][] = array(
            'relation' => 'AND',
            array(
               'taxonomy' =>   'product_visibility',
                'field'    =>   'slug',
                'terms'    =>   array('exclude-from-search', 'exclude-from-catalog'),
                'operator' =>   'NOT IN',
            )
        );

        wc_reset_loop();
        
        return new WP_Query($args);
    }
}

// hooks
if ( !function_exists('puca_tbay_woocommerce_enqueue_styles') ) {
    function puca_tbay_woocommerce_enqueue_styles() { 
        
        $skin = puca_tbay_get_theme();
        $suffix = (puca_tbay_get_config('minified_js', false)) ? '.min' : PUCA_MIN_JS;
        // Load our main stylesheet.
          if( is_rtl() ){
          
               if ( $skin != 'default' && $skin ) {
                    $css_path =  PUCA_STYLES_SKINS . '/'.$skin.'/woocommerce.rtl.css';
               } else {
                    $css_path =  PUCA_STYLES . '/woocommerce.rtl.css';
               }
          }
          else{
               if ( $skin != 'default' && $skin ) {
                    $css_path =  PUCA_STYLES_SKINS . '/'.$skin.'/woocommerce.css';
               } else {
                    $css_path =  PUCA_STYLES . '/woocommerce.css';
               }
          }

        /**Fix dashboard woocommerce**/
        if( class_exists('MVX') && is_vendor_dashboard() ) {
        } else {
            wp_enqueue_script( 'puca-woocommerce-script', PUCA_SCRIPTS . '/woocommerce' . $suffix . '.js', array( 'jquery' ), PUCA_THEME_VERSION, true );    
        } 

        wp_register_style( 'puca-woocommerce', $css_path , array() , PUCA_THEME_VERSION, 'all' );

        wp_enqueue_style( 'puca-woocommerce' );

        wp_register_script( 'jquery-onepagenav', PUCA_SCRIPTS . '/jquery.onepagenav' . $suffix . '.js', array( 'jquery' ), '3.0.0', true ); 

    }
}
add_action( 'wp_enqueue_scripts', 'puca_tbay_woocommerce_enqueue_styles', 50 );

if( ! function_exists( 'puca_compare_styles' ) ) {
    add_action( 'wp_print_styles', 'puca_compare_styles', 200 );
    function puca_compare_styles() {
        if( ! class_exists( 'YITH_Woocompare' ) ) return;
        $view_action = 'yith-woocompare-view-table';
        if ( ( ! defined('DOING_AJAX') || ! DOING_AJAX ) && ( ! isset( $_REQUEST['action'] ) || $_REQUEST['action'] != $view_action ) ) return;
        wp_enqueue_style( 'font-awesome' ); 
        wp_enqueue_style( 'simple-line-icons' );
        wp_enqueue_style( 'font-tbay' );  
        wp_enqueue_style( 'puca-woocommerce' );
        wp_enqueue_style( 'puca-template' );
        add_filter( 'body_class', 'puca_tbay_body_classes_compare' );
    }
}


if ( ! function_exists( 'puca_tbay_body_classes_compare' ) ) {
    function puca_tbay_body_classes_compare( $classes ) {
        $class = 'tbay-body-compare';

        $classes[] = trim($class);

        return $classes;
    }

}


// cart
if ( !function_exists('puca_tbay_woocommerce_header_add_to_cart_fragment') ) {
    function puca_tbay_woocommerce_header_add_to_cart_fragment( $fragments ){
        $fragments['#cart .mini-cart-items'] =  sprintf(_n(' <span class="mini-cart-items"> %d  </span> ', ' <span class="mini-cart-items"> %d </span> ', WC()->cart->get_cart_contents_count(), 'puca'), WC()->cart->get_cart_contents_count() );
        $fragments['#cart .mini-cart-total'] = trim( WC()->cart->get_cart_subtotal() );
        return $fragments;
    }
    add_filter('woocommerce_add_to_cart_fragments', 'puca_tbay_woocommerce_header_add_to_cart_fragment', 10, 1 );
}

// breadcrumb for woocommerce page
if ( !function_exists('puca_tbay_woocommerce_breadcrumb_defaults') ) {
    function puca_tbay_woocommerce_breadcrumb_defaults( $args ) {
        $breadcrumb_img = puca_tbay_get_config('woo_breadcrumb_image');
        $breadcrumb_color = puca_tbay_get_config('woo_breadcrumb_color');
        $style = array();
        $img = '';

        $sidebar_configs = puca_tbay_get_woocommerce_layout_configs();


        $breadcrumbs_layout = puca_tbay_get_config('product_breadcrumb_layout', 'color');


        if( isset($_GET['breadcrumbs_layout']) ) {
             $breadcrumbs_layout = $_GET['breadcrumbs_layout'];
        }

        $class_container = '';
        if( isset($sidebar_configs['container_full']) &&  $sidebar_configs['container_full'] ) {
            $class_container = 'container-full';
        }

        switch ($breadcrumbs_layout) {
            case 'image':
                $breadcrumbs_class = ' breadcrumbs-image';
                break;
            case 'color':
                $breadcrumbs_class = ' breadcrumbs-color';
                break;
            case 'text':
                $breadcrumbs_class = ' breadcrumbs-text';
                break;
            default:
                $breadcrumbs_class  = ' breadcrumbs-image';
        }

        if(isset($sidebar_configs['breadscrumb_class'])) {
            $breadcrumbs_class .= ' '.$sidebar_configs['breadscrumb_class'];
        }



        if ( isset($breadcrumb_img['url']) && !empty($breadcrumb_img['url']) && $breadcrumbs_layout !=='color' && $breadcrumbs_layout !=='text' ) {
            $img = '<img src="'.esc_url($breadcrumb_img['url']).'">';
        }

        if( $breadcrumb_color && $breadcrumbs_layout !== 'image' ){
            $style[] = 'background-color:'.$breadcrumb_color;
        }

        $estyle = ( !empty($style) && $breadcrumbs_layout !=='text' ) ? ' style="'.implode(";", $style).'"':"";
        $skin = puca_tbay_get_theme();
        if ( is_shop() && $skin === 'fashion3' ) {
            $title = '<h1 class="page-title">'. esc_html__('Shop', 'puca') .'</h1>';
        } else {
            $title = '';
        }
        $args['wrap_before'] = '<section id="tbay-breadscrumb" '.$estyle.' class="tbay-breadscrumb '.esc_attr($breadcrumbs_class).'">'.$img.'<div class="container '.$class_container.'"><div class="breadscrumb-inner"><ol class="tbay-woocommerce-breadcrumb breadcrumb">';
        $args['wrap_after'] = '</ol>'.$title.'</div></div></section>';

        return $args;
    }
}

add_action( 'init', 'puca_woo_remove_wc_breadcrumb' );
function puca_woo_remove_wc_breadcrumb() {
    if( !puca_tbay_get_config('show_product_breadcrumb', false) ) {
        remove_action( 'puca_woo_template_main_before', 'woocommerce_breadcrumb', 30, 0 );
    } else {
        add_filter( 'woocommerce_breadcrumb_defaults', 'puca_tbay_woocommerce_breadcrumb_defaults' );
        add_action( 'puca_woo_template_main_before', 'woocommerce_breadcrumb', 30, 0 );     
    }
}

if ( !function_exists('puca_tbay_is_check_woocommerce_show_sidebar') ) {
    function puca_tbay_is_check_woocommerce_show_sidebar(){

        $sidebar_configs = puca_tbay_get_woocommerce_layout_configs();

        $active = false;

        if ( (isset($sidebar_configs['left']['sidebar']) && is_active_sidebar( $sidebar_configs['left']['sidebar'] )) && (isset($sidebar_configs['right']['sidebar']) && is_active_sidebar( $sidebar_configs['right']['sidebar'] )) ) {
            $active = false;
        } elseif( (isset($sidebar_configs['left']['sidebar']) && is_active_sidebar( $sidebar_configs['left']['sidebar'] )) || (isset($sidebar_configs['right']['sidebar']) && is_active_sidebar( $sidebar_configs['right']['sidebar'] )) )  {
            $active = true;
        }        

        if( (isset($sidebar_configs['left_descreption']['sidebar']) && is_active_sidebar( $sidebar_configs['left_descreption']['sidebar'] )) || (isset($sidebar_configs['right_descreption']['sidebar']) && is_active_sidebar( $sidebar_configs['right_descreption']['sidebar'] )) )  {
            $active = true;
        }

        if( is_product() ) $active = false;


        return $active;

    }
}

if ( !function_exists('puca_tbay_close_side_woocommerce_show_sidebar_btn') ) {
    add_action( 'wp_footer', 'puca_tbay_close_side_woocommerce_show_sidebar_btn' );
    function puca_tbay_close_side_woocommerce_show_sidebar_btn(){
       
       $active = puca_tbay_is_check_woocommerce_show_sidebar();

       if ( $active ) :

       ?>
            <div class="puca-close-side"></div>
           <?php 
       endif;
    }
}

if ( !function_exists('puca_tbay_header_mobile_side_woocommerce_sidebar') ) {
    add_action( 'puca_after_sidebar_mobile', 'puca_tbay_header_mobile_side_woocommerce_sidebar' );
    function puca_tbay_header_mobile_side_woocommerce_sidebar(){
       
       $active = puca_tbay_is_check_woocommerce_show_sidebar();

       if ( $active ) :

       ?>
           <div class="widget-mobile-heading"> <a href="javascript:void(0);" class="close-side-widget"><i class="icon-close icons"></i></a></div>
           <?php 
       endif;
    }
}

if ( !function_exists('puca_tbay_woocommerce_show_sidebar_btn') ) {
    add_action( 'woocommerce_before_shop_loop', 'puca_tbay_woocommerce_show_sidebar_btn' , 5 );
    function puca_tbay_woocommerce_show_sidebar_btn(){
       
       $active = puca_tbay_is_check_woocommerce_show_sidebar();
       $skin = puca_tbay_get_theme();
       $icon = ($skin === 'fashion3') ? 'tb-icon tb-icon-zzz-bars'  : 'icon-equalizer icons';

       if ( $active ) :
       ?>
            <div class="puca-sidebar-mobile-btn">
                <i class="<?php echo esc_attr($icon) ?>"></i>  
            </div>
           <?php 
       endif;
    }
}


// display woocommerce modes
if ( !function_exists('puca_tbay_woocommerce_display_modes') ) {
    function puca_tbay_woocommerce_display_modes(){
        if ( ! wc_get_loop_prop( 'is_paginated' ) || ( ! woocommerce_products_will_display() && !puca_woo_is_vendor_page())  ) {
            return;
        }

        global $wp;
        $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
        $woo_mode = puca_tbay_woocommerce_get_display_mode();
        $icon_grid = 'icon-grid';
        $icon_list = 'icon-list';
        $skin = puca_tbay_get_theme();
        if ($skin === 'fashion3') {
            $icon_grid = 'tb-icon tb-icon-zz-squares'; 
            $icon_list = 'tb-icon tb-icon-zz-list';
        }
        echo '<form action="javascript:void(0);" class="display-mode" method="get">';
        echo '<button title="'.esc_html__('Grid','puca').'" class="change-view grid '.($woo_mode == 'grid' ? 'active' : '').'" value="grid" name="display" type="submit"><i class="'.$icon_grid.'"></i></button>';
        echo '<button title="'.esc_html__( 'List', 'puca' ).'" class="change-view list '.($woo_mode == 'list' ? 'active' : '').'" value="list" name="display" type="submit"><i class="'.$icon_list.'"></i></button>';  
        echo '</form>'; 
    } 
    add_action( 'woocommerce_before_shop_loop', 'puca_tbay_woocommerce_display_modes' , 10 );
}

if ( !function_exists('puca_tbay_woocommerce_get_display_mode') ) {
    function puca_tbay_woocommerce_get_display_mode() {
        $woo_mode = puca_tbay_get_config('product_display_mode', 'grid'); 

        if ( isset($_COOKIE['display_mode']) && ($_COOKIE['display_mode'] == 'list' || $_COOKIE['display_mode'] == 'grid') ) {
            $woo_mode = $_COOKIE['display_mode'];
        }

        if( isset($_GET['display_mode']) && $_GET['display_mode'] == 'grid' ) {
            $woo_mode = 'grid';
        } else if( isset($_GET['display_mode']) && $_GET['display_mode'] == 'list' ) {
            $woo_mode = 'list';
        }

        return $woo_mode;
    }
}



if(!function_exists('puca_tbay_filter_before')){
    function puca_tbay_filter_before(){
        echo '<div class="tbay-filter">';
    }
}
if(!function_exists('puca_tbay_filter_after')){
    function puca_tbay_filter_after(){
        echo '</div>';
    }
}
add_action( 'woocommerce_before_shop_loop', 'puca_tbay_filter_before' , 1 );
add_action( 'woocommerce_before_shop_loop', 'puca_tbay_filter_after' , 40 );
add_action( 'dokan_store_profile_frame_after', 'puca_tbay_filter_before' , 1 );
add_action( 'dokan_store_profile_frame_after', 'puca_tbay_filter_after' , 40 );


/*Fix Layout Shop Descreption Width Left Rihgt*/
if(!function_exists('puca_tbay_subcategories_wraper_open')){
    function puca_tbay_subcategories_wraper_open(){

        $sidebar_configs = puca_tbay_get_woocommerce_layout_configs();

        if ( isset($sidebar_configs['left_descreption']) && !isset($sidebar_configs['right_descreption']) ) {
            $sidebar_configs['main_descreption']['class'] .= ' pull-right';
        }

        if( isset($sidebar_configs['descreption']) &&  $sidebar_configs['descreption'] ) {

            echo '<div class="row">';

            echo '<div class="'.esc_attr($sidebar_configs['main_descreption']['class']).'">';
        }

    } 
}
add_action( 'woocommerce_before_shop_loop', 'puca_tbay_subcategories_wraper_open' , 41 );

if(!function_exists('puca_tbay_subcategories_wraper_closed')){
    function puca_tbay_subcategories_wraper_closed(){
        $sidebar_configs = puca_tbay_get_woocommerce_layout_configs();

        if( isset($sidebar_configs['descreption']) &&  $sidebar_configs['descreption'] ) {
            echo '</div>';
            
            ?>
                <?php if ( isset($sidebar_configs['left_descreption']) ) : ?>
                    <div class="<?php echo esc_attr($sidebar_configs['left_descreption']['class']) ;?>">
                        <?php do_action( 'puca_after_sidebar_mobile' ); ?>
                        <aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                            <?php dynamic_sidebar( $sidebar_configs['left_descreption']['sidebar'] ); ?>
                        </aside>
                    </div>
                <?php endif; ?>

                <?php if ( isset($sidebar_configs['right_descreption']) ) : ?>
                    <div class="<?php echo esc_attr($sidebar_configs['right_descreption']['class']) ;?>">
                        <?php do_action( 'puca_after_sidebar_mobile' ); ?>
                        <aside class="sidebar sidebar-right" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                            <?php dynamic_sidebar( $sidebar_configs['right_descreption']['sidebar'] ); ?>
                        </aside>
                    </div>
                <?php endif; ?>

            <?php

            echo '</div>';

        }
    }
    add_action( 'woocommerce_after_shop_loop', 'puca_tbay_subcategories_wraper_closed' , 41 );
}


// Hook Product Top sidebar
if ( !function_exists('puca_tbay_get_product_top_sidebar') ) {
    function puca_tbay_get_product_top_sidebar() {

        $sidebar_configs = puca_tbay_get_woocommerce_layout_configs();

        $class_container = '';
        if( isset($sidebar_configs['container_full']) &&  $sidebar_configs['container_full'] ) {
            $class_container = 'container-full';
        }

        if( !is_product()  && isset($sidebar_configs['product_top_sidebar']) && $sidebar_configs['product_top_sidebar'] ) {
            ?>

            <?php if(is_active_sidebar('product-top-sidebar')) : ?>
                <div class="product-top-sidebar">

                    <div class="product-top-button-wrapper"> 
                        <div class="container <?php echo esc_attr($class_container); ?>">
                            <button class="button-product-top" type="submit"><?php esc_html_e('Advanced filter', 'puca'); ?><i class="fa fa-angle-down first" aria-hidden="true"></i><i class="fa fa-angle-up second" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="container <?php echo esc_attr($class_container); ?>">
                        <div class="content">
                            <?php dynamic_sidebar('product-top-sidebar'); ?>
                        </div>
                    </div>
                </div>
            <?php endif;?>

            <?php 
        }

    }
    add_action( 'puca_woo_template_main_before', 'puca_tbay_get_product_top_sidebar', 50 );
}


// Hook Product Top sidebar
if ( !function_exists('puca_tbay_get_product_top_multi_Viewed_sidebar') ) {
    function puca_tbay_get_product_top_multi_Viewed_sidebar() {

        $sidebar_configs = puca_tbay_get_woocommerce_layout_configs();

        if( !is_product()  && isset($sidebar_configs['multi_Viewed']) && $sidebar_configs['multi_Viewed'] ) {

            ?>

            <?php if(is_active_sidebar('product-top-multi-viewed-sidebar')) : ?>
                <div class="product-multi-Viewed-sidebar">
                    <?php dynamic_sidebar('product-top-multi-viewed-sidebar'); ?>
                </div>
            <?php endif;?>

            <?php 
        }

    }
    add_action( 'puca_woo_template_main_primary_before', 'puca_tbay_get_product_top_multi_Viewed_sidebar', 20 );
}



// set display mode to cookie
if ( !function_exists('puca_tbay_before_woocommerce_init') ) {
    function puca_tbay_before_woocommerce_init() {
        if( isset($_GET['display']) && ($_GET['display'] == 'list' || $_GET['display'] == 'grid') ){  
            setcookie( 'display_mode', trim($_GET['display']) , time()+3600*24*100,'/' );
            $_COOKIE['display_mode'] = trim($_GET['display']);
        }
    }
    add_action( 'init', 'puca_tbay_before_woocommerce_init' );
}


// Number of products per page
if ( !function_exists('puca_tbay_woocommerce_shop_per_page') ) {
    function puca_tbay_woocommerce_shop_per_page($number) {

        if( isset($_GET['product_per_page']) && is_numeric($_GET['product_per_page']) ) {
            $value = $_GET['product_per_page']; 
        } else {
            $value = puca_tbay_get_config('number_products_per_page');          
        }

        if ( is_numeric( $value ) && $value ) {
            $number = absint( $value );
        }
 
        if( isset($_GET['product_per_page']) && $_GET['product_per_page'] == -1 ) {
            $number = -1;
        }

        return $number;
    }
    add_filter( 'loop_shop_per_page', 'puca_tbay_woocommerce_shop_per_page' );
}


// Number of products per row
if ( !function_exists('puca_tbay_woocommerce_shop_columns') ) {
    function puca_tbay_woocommerce_shop_columns($number) {

        if( isset($_GET['product_columns']) && is_numeric($_GET['product_columns']) ) {
            $value = $_GET['product_columns']; 
        } else {
          $value = puca_tbay_get_config('product_columns');          
        }

        if ( in_array( $value, array(1, 2, 3, 4, 5, 6) ) ) {
            $number = $value;
        }
        return $number;
    }
    add_filter( 'loop_shop_columns', 'puca_tbay_woocommerce_shop_columns' );
}


if (!function_exists('puca_tbay_woocommerce_product_display_image_mode')) {
    function puca_tbay_woocommerce_product_display_image_mode($mode)
    {
        $show_swap_image = puca_tbay_get_config('show_swap_image', false);

        $show_swap_image = (isset($_GET['show_swap_image'])) ? $_GET['show_swap_image'] : $show_swap_image;

        if (wp_is_mobile() || !$show_swap_image ) {
            $mode = 'one';
        } else {
            $mode = 'two';
        }

        return $mode;
    }
    add_filter('puca_woo_display_image_mode', 'puca_tbay_woocommerce_product_display_image_mode');
}


if (!function_exists('puca_tbay_product_display_image_mode')) {
    function puca_tbay_product_display_image_mode()
    {
        $images_mode   = apply_filters('puca_woo_display_image_mode', 10, 2);

        if (wp_is_mobile()) {
            $images_mode = 'one';
        }

        switch ($images_mode) {
            case 'one':
                echo woocommerce_template_loop_product_thumbnail();
                break;

            case 'two':
                echo puca_tbay_woocommerce_get_two_product_thumbnail();
                break;
            
            default:
                echo woocommerce_template_loop_product_thumbnail();
                break;
        }
    }
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
    add_action('woocommerce_before_shop_loop_item_title', 'puca_tbay_product_display_image_mode', 10);
    add_action('woocommerce_before_shop_loop_item_only_img', 'puca_tbay_product_display_image_mode', 10);
}

// Two product thumbnail
if (!function_exists('puca_tbay_woocommerce_get_two_product_thumbnail')) {
    function puca_tbay_woocommerce_get_two_product_thumbnail()
    {
        global $product;

        $size = 'woocommerce_thumbnail';
        $placeholder = wc_get_image_size($size);
        $placeholder_width = $placeholder['width'];
        $placeholder_height = $placeholder['height'];
        $post_thumbnail_id =  $product->get_image_id();

        $output='';
        $class = 'image-no-effect';
        if (has_post_thumbnail()) {
            $attachment_ids = $product->get_gallery_image_ids();

            $class = ($attachment_ids && isset($attachment_ids[0])) ? 'attachment-shop_catalog image-effect' : $class;

            $output .= wp_get_attachment_image($post_thumbnail_id, $size, false, array('class' => $class ));
            if ($attachment_ids && isset($attachment_ids[0])) {
                $output .= wp_get_attachment_image($attachment_ids[0], $size, false,array('class' => 'image-hover' ));
            }
        } else {
            $output .= '<img src="'.wc_placeholder_img_src().'" alt="'. esc_attr__('Placeholder' , 'puca'). '" class="'. esc_attr($class) .'" width="'. esc_attr($placeholder_width) .'" height="'. esc_attr($placeholder_height) .'" />';
        }
        return trim($output);
    }
}

// layout class for woo page
if ( !function_exists('puca_tbay_woocommerce_content_class') ) {
    function puca_tbay_woocommerce_content_class( $class ) {
        $page = 'archive';
        if ( is_singular( 'product' ) ) {
            $page = 'single';

            if( !isset($_GET['product_'.$page.'_layout']) ) {
                $class .= ' '.puca_tbay_get_config('product_'.$page.'_layout');
            }  else {
                $class .= ' '.$_GET['product_'.$page.'_layout'];
            }

        } else {

            if( !isset($_GET['product_'.$page.'_layout']) ) {
                $class .= ' '.puca_tbay_get_config('product_'.$page.'_layout');
            }  else {
                $class .= ' '.$_GET['product_'.$page.'_layout'];
            }

        }
        return $class;
    }
}
add_filter( 'puca_tbay_woocommerce_content_class', 'puca_tbay_woocommerce_content_class' );




if ( !function_exists('puca_tbay_get_product_single_layout') ) {
    function puca_tbay_get_product_single_layout() {
        $product_single_layout  =   ( isset($_GET['product_single_layout']) )   ?   $_GET['product_single_layout'] :  puca_tbay_get_config('product_single_layout', 'full-width-vertical-left');

        return $product_single_layout;
    }
}

// get layout configs
if ( !function_exists('puca_tbay_get_woocommerce_layout_configs') ) {
    function puca_tbay_get_woocommerce_layout_configs() {
        $page = 'archive';
        if ( is_singular( 'product' ) ) {
            $page = 'single';
        }
        $left = puca_tbay_get_config('product_'.$page.'_left_sidebar');
        $right = puca_tbay_get_config('product_'.$page.'_right_sidebar');


        if ( !is_singular( 'product' ) ) {

            $product_archive_layout  =   ( isset($_GET['product_archive_layout']) ) ? $_GET['product_archive_layout'] : puca_tbay_get_config('product_archive_layout', 'layout-1');

            if( isset($product_archive_layout) ) {
                switch ( $product_archive_layout ) {
                    case 'shop-left':
                        $configs['left'] = array( 'sidebar'  => $left, 'class' => 'sidebar-mobile-wrapper col-xs-12 col-md-12 col-lg-3'  );
                        $configs['main'] = array( 'class'    => 'col-xs-12 col-md-12 col-lg-9' );
                        break;
                    case 'shop-right':
                        $configs['right'] = array( 'sidebar' => $right,  'class' => 'sidebar-mobile-wrapper col-xs-12 col-md-12 col-lg-3' ); 
                        $configs['main'] = array( 'class'    => 'col-xs-12 col-md-12 col-lg-9' );
                        break;                
                    case 'shop-des-left':
                        $configs['left_descreption'] = array( 'sidebar'  => $left, 'class' => 'sidebar-mobile-wrapper col-xs-12 col-md-12 col-lg-3'  );
                        $configs['main_descreption'] = array( 'class'    => 'col-xs-12 col-md-12 col-lg-9' );
                        $configs['main'] = array( 'class' => 'archive-full' );
                        $configs['descreption'] = true;
                        $configs['breadscrumb_class'] = 'shop-des';
                        break;                
                    case 'shop-des-right':
                        $configs['right_descreption'] = array( 'sidebar'  => $right, 'class' => 'sidebar-mobile-wrapper col-xs-12 col-md-12 col-lg-3'  );
                        $configs['main_descreption'] = array( 'class'    => 'col-xs-12 col-md-12 col-lg-9' );
                        $configs['main'] = array( 'class' => 'archive-full' );
                        $configs['descreption'] = true;
                        $configs['breadscrumb_class'] = 'shop-des';
                        break;                
                    case 'full-width-wide':
                        $configs['main'] = array( 'class' => 'archive-full' );
                        $configs['container_full'] = true;
                        $configs['product_top_sidebar'] = true;
                        break;                
                    case 'full-width':
                        $configs['main'] = array( 'class' => 'archive-full' );
                        $configs['product_top_sidebar'] = true;
                        break;                
                    case 'multi-viewed-left':
                        $configs['left'] = array( 'sidebar'  => $left, 'class' => 'sidebar-mobile-wrapper col-xs-12 col-md-12 col-lg-3'  );
                        $configs['main'] = array( 'class'    => 'col-xs-12 col-md-12 col-lg-9' );
                        $configs['multi_Viewed'] = true;
                        break;                
                    case 'multi-viewed-right':
                        $configs['right'] = array( 'sidebar' => $right,  'class' => 'sidebar-mobile-wrapper col-xs-12 col-md-12 col-lg-3' ); 
                        $configs['main'] = array( 'class'    => 'col-xs-12 col-md-12 col-lg-9' );
                        $configs['multi_Viewed'] = true;
                        break;                
                    case 'filter-bar':
                        $configs['main'] = array( 'class' => 'archive-full' );
                        $configs['filter_bar'] = true;
                        break;                
                    case 'canvas-left-sidebar':
                        $configs['main'] = array( 'class' => 'archive-full' );
                        $configs['canvas'] = true;
                        $configs['body_class']   = 'canvas-left';
                        $configs['canvas_left'] = true;
                        break;                
                    case 'canvas-right-sidebar':
                        $configs['main'] = array( 'class' => 'archive-full' );
                        $configs['canvas'] = true;
                        $configs['canvas_right'] = true;
                        $configs['body_class']   = 'canvas-right';
                        break;
                    default:
                        $configs['main'] = array( 'class' => 'archive-full' );
                        break;
                }
            } 
        } 
        else { 

            $product_single_layout  =   puca_tbay_get_product_single_layout();

            if( isset($product_single_layout) ) {
                switch ( $product_single_layout ) {
                    case 'full-width-vertical-left':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'vertical-left';
                        $configs['tabs']            = 'tbhorizontal';
                        $configs['tabs_position']   = 'bottom';
                        $configs['breadscrumb']     = 'color';
                        break;                    
                    case 'full-width-vertical-right':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'vertical-right';
                        $configs['tabs']            = 'tbhorizontal';
                        $configs['tabs_position']   = 'bottom';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'full-width-horizontal-top':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'horizontal-top';
                        $configs['tabs']            = 'accordion';
                        $configs['tabs_position']   = 'bottom';
                        $configs['breadscrumb']     = 'color';
                        break;                        
                    case 'full-width-horizontal-bottom':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'horizontal-bottom';
                        $configs['tabs']            = 'accordion';
                        $configs['tabs_position']   = 'bottom';
                        $configs['breadscrumb']     = 'color';
                        break;                  
                    case 'full-width-gallery':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'gallery';
                        $configs['tabs']            = 'accordion';
                        $configs['tabs_position']   = 'right';
                        $configs['breadscrumb']     = 'color';
                        break;                     
                    case 'full-width-stick':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'stick';
                        $configs['tabs']            = 'tbhorizontal';
                        $configs['tabs_position']   = 'bottom';
                        $configs['breadscrumb']     = 'color';
                        break;                    
                    case 'full-width-slide':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'slide';
                        $configs['tabs']            = 'accordion';
                        $configs['tabs_position']   = 'bottom';
                        $configs['breadscrumb']     = 'color';
                        break;                      
                    case 'full-width-carousel':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'carousel';
                        $configs['tabs']            = 'accordion';
                        $configs['tabs_position']   = 'bottom';
                        $configs['breadscrumb']     = 'color';
                        break;  
                    case 'left-main':
                        $configs['left']            = array( 'sidebar' => $left, 'class' => 'col-xs-12 col-md-12 col-lg-3'  );
                        $configs['main']            = array( 'class' => 'col-xs-12 col-md-12 col-lg-9' );
                        $configs['tabs_position']   = 'bottom';
                        $configs['thumbnail']       = 'horizontal-bottom';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'main-right':
                        $configs['right']           = array( 'sidebar' => $right,  'class' => 'col-xs-12 col-md-12 col-lg-3' ); 
                        $configs['main']            = array( 'class' => 'col-xs-12 col-md-12 col-lg-9' );
                        $configs['tabs_position']   = 'bottom';
                        $configs['thumbnail']       = 'horizontal-bottom';
                        $configs['breadscrumb']     = 'color';
                        break;              
                    default:
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'vertical-left';
                        $configs['tabs']            = 'tbhorizontal';
                        $configs['tabs_position']   = 'bottom';
                        $configs['breadscrumb']     = 'color';
                        break;
                }  
            } 
        }

        return $configs; 
    }
}




if ( !function_exists( 'puca_tbay_product_review_tab' ) ) {
    function puca_tbay_product_review_tab($tabs) {
        if ( !puca_tbay_get_config('show_product_review_tab', true) && isset($tabs['reviews']) ) {
            unset( $tabs['reviews'] ); 
        }
        return $tabs;
    }
}
add_filter( 'woocommerce_product_tabs', 'puca_tbay_product_review_tab', 100 );

if ( !function_exists( 'puca_tbay_minicart') ) {
    function puca_tbay_minicart() {
        $template = apply_filters( 'puca_tbay_minicart_version', '' );
        get_template_part( 'woocommerce/cart/mini-cart-button', $template ); 
    }
}
// Wishlist
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

if ( !function_exists( 'puca_tbay_remove_quick_view_default' ) ) {
    function puca_tbay_remove_quick_view_default() {
        if (class_exists('YITH_WCQV_Frontend')) {
            remove_action('woocommerce_after_shop_loop_item', array( YITH_WCQV_Frontend(), 'yith_add_quick_view_button' ), 15);
        }
    }
    add_action('init', 'puca_tbay_remove_quick_view_default', 10);
}

// Ajax Wishlist
if( defined( 'YITH_WCWL' ) && ! function_exists( 'puca_yith_wcwl_ajax_update_count' ) ){
function puca_yith_wcwl_ajax_update_count(){

    $wishlist_count = YITH_WCWL()->count_products();

    wp_send_json( array(
    'count' => $wishlist_count
    ) );
    }
    add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'puca_yith_wcwl_ajax_update_count' );
    add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'puca_yith_wcwl_ajax_update_count' );
}

if ( ! function_exists( 'puca_woocommerce_saved_sales_price' ) ) {

    add_filter( 'woocommerce_get_saved_sales_price_html', 'puca_woocommerce_saved_sales_price' );

    function puca_woocommerce_saved_sales_price( $productid ) {

        $product = wc_get_product( $productid );

        
        $onsale         = $product->is_on_sale();
        $saleprice      = $product->get_sale_price();   
        $regularprice   = $product->get_regular_price();
        $priceDiff      = (int)$regularprice - (int)$saleprice;
        $price          = '';
        $price1         = '';

        $off_content    ='';
        if($priceDiff != 0){
            $price1 = '<span class="saved">'. esc_html__('Save you ', 'puca') .' <span class="price">'. sprintf( get_woocommerce_price_format(), get_woocommerce_currency_symbol(), $priceDiff ) . '</span></span>';     
            $price .= '<div class="block-save-price">'.$price1.'</div>'; 
        }
        
        // Sale price
        return $price;
        
    }
}

if( ! function_exists( 'puca_brands_get_name' ) && class_exists( 'YITH_WCBR' ) ) {

    function puca_brands_get_name($product_id) {

        $terms = wp_get_post_terms($product_id,'yith_product_brand');

        $brand = '';
        if($terms && defined( 'YITH_WCBR' ) && YITH_WCBR) {

            $brand  .= '<ul class="show-brand">';

            foreach ($terms as $term) {
                
                $name = $term->name;
                $url = get_term_link( $term->slug, 'yith_product_brand' );

                $brand  .= '<li><a href="'. esc_url($url) .'">'. esc_html($name) .'</a></li>';

            }

            $brand  .= '</ul>';
        }

        echo  trim($brand);

    }

}

/* ---------------------------------------------------------------------------
 * WooCommerce - Function get Query
 * --------------------------------------------------------------------------- */
 
if ( ! function_exists( 'puca_woo_get_review_counting' ) ) {
    function puca_woo_get_review_counting(){

        global $post;
        $output = array();

        for($i=1; $i <= 5; $i++){
             $args = array(
                'post_id'      => ( $post->ID ),
                'status' => 'approve',
                'meta_query' => array(
                  array(
                    'key'   => 'rating',
                    'value' => $i
                  )
                ),
                'count' => true
            );
            $output[$i] = get_comments( $args );
        }
        return $output;
    }
}

/*Fix count ajax cart*/
add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {

    ob_start();
    ?>

    <span class="qty">
        <?php echo WC()->cart->get_cart_subtotal(); ?>
    </span>


    <?php $fragments['span.qty']             = ob_get_clean();

    return $fragments;

} );

add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {

    ob_start();
    ?>

    <span class="mini-cart-items"><?php echo WC()->cart->get_cart_contents_count(); ?></span>

    <?php $fragments['span.mini-cart-items'] = ob_get_clean();

    return $fragments;

} );

add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {

    ob_start();
    ?>

    <span class="mini-cart-items-fixed"><?php echo WC()->cart->get_cart_contents_count(); ?></span>

    <?php $fragments['span.mini-cart-items-fixed'] = ob_get_clean();

    return $fragments;

} );

add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {
    ob_start();
    ?>

    <span class="mini-cart-items cart-mobile"><?php echo sprintf( '%d', WC()->cart->cart_contents_count );?></span>

    <?php $fragments['span.cart-mobile'] = ob_get_clean();

    return $fragments;

} );
/*End count ajax cart*/

// Remove product in the cart using ajax
if ( ! function_exists( 'puca_ajax_product_remove' ) ) {
    function puca_ajax_product_remove(){
        // Get mini cart
        ob_start();

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item)
        {
            if($cart_item['product_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key'] )
            {
                WC()->cart->remove_cart_item($cart_item_key);
            }
        }

        WC()->cart->calculate_totals();
        WC()->cart->maybe_set_cart_cookies();

        woocommerce_mini_cart();

        $mini_cart = ob_get_clean();

        // Fragments and mini cart are returned
        $data = array(
            'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
                    'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
                )
            ),
            'cart_hash' => apply_filters( 'woocommerce_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
        );

        wp_send_json( $data );

        die();
    }
    add_action( 'wp_ajax_product_remove', 'puca_ajax_product_remove' );
    add_action( 'wp_ajax_nopriv_product_remove', 'puca_ajax_product_remove' );
}

/* ---------------------------------------------------------------------------
 * WooCommerce - Function Load more ajax
 * --------------------------------------------------------------------------- */
if ( ! function_exists( 'puca_fnc_more_post_ajax' ) ) {
    add_action('wp_ajax_nopriv_puca_more_post_ajax', 'puca_fnc_more_post_ajax');
    add_action('wp_ajax_puca_more_post_ajax', 'puca_fnc_more_post_ajax');

    function puca_fnc_more_post_ajax(){
        global $woocommerce_loop; 

        $columns                    =   (isset($_POST["columns"])) ? $_POST["columns"] : 4;
        $layout                     =   (isset($_POST["layout"])) ? $_POST["layout"] : '';
        $number                     =   (isset($_POST["number"])) ? $_POST["number"] : 8;
        $type                       =   (isset($_POST["type"])) ? $_POST["type"] : 'featured_product';
        $paged                      =   (isset($_POST["paged"])) ? $_POST["paged"] : 1;
        $category                   =   (isset($_POST["category"])) ? $_POST["category"] : '';
        $screen_desktop             =   (isset($_POST["screen_desktop"])) ? $_POST["screen_desktop"] : '';
        $screen_desktopsmall        =   (isset($_POST["screen_desktopsmall"])) ? $_POST["screen_desktopsmall"] : '';
        $screen_tablet              =   (isset($_POST["screen_tablet"])) ? $_POST["screen_tablet"] : '';
        $screen_mobile              =   (isset($_POST["screen_mobile"])) ? $_POST["screen_mobile"] : '';


        $product_item = isset($product_item) ? $product_item : 'inner';


        if(empty($category)) {
            $category = -1;
        }

        $offset         = $number*3;
        $number_load    = $columns*3;

        $woocommerce_loop['columns'] = $columns;

        if((strpos($category, ',') !== false )) {
            $categories = explode(',', $category); 
            $loop = puca_tbay_get_products( $categories, $type , $paged, $number_load, '', '', $number, $offset );
        } else {

            if( $category == -1 ) {
                $loop = puca_tbay_get_products( '', $type , $paged, $number_load, '', '', $number, $offset );
            } else {
              $loop = puca_tbay_get_products( array($category), '' , $paged, $number_load, '', '', $number, $offset );  
            } 

        } 

        $count = 0;
        $active_theme = puca_tbay_get_part_theme();

        add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'puca_get_swatch_html' , 10, 2 ); 
        add_filter( 'tawcvs_swatch_html', 'puca_swatch_html' , 5, 4 );

        if($loop->have_posts()) :
        ob_start();

             while ( $loop->have_posts() ) : $loop->the_post(); ?>

                <?php 

                    if( isset($layout) && $layout == 'special' ) {
                        wc_get_template( 'item-product/'.$active_theme.'/special.php', array('columns' => $columns, 'screen_desktop' => $screen_desktop,'screen_desktopsmall' => $screen_desktopsmall,'screen_tablet' => $screen_tablet,'screen_mobile' => $screen_mobile) );
                    } else {
                        wc_get_template( 'content-products.php', array('product_item' => $product_item,'columns' => $columns,'screen_desktop' => $screen_desktop,'screen_desktopsmall' => $screen_desktopsmall,'screen_tablet' => $screen_tablet,'screen_mobile' => $screen_mobile) );  
                    }

                ?>


                <?php $count++; ?>
            <?php endwhile; ?>
        <?php endif;

        wp_reset_postdata();

        $posts = ob_get_clean();

        $result['category'] = $category; 
        if($paged >= $loop->max_num_pages || $number_load > $loop->post_count ) {
            $result['check'] = false; 
        } else {
            $result['check'] = true;
        } 

        $result['posts'] = $posts;
        print_r(json_encode($result));
        exit();
    }
}

if ( ! function_exists( 'puca_woocommerce_post_class' ) ) {
    add_filter( 'post_class', 'puca_woocommerce_post_class', 21 );
    function puca_woocommerce_post_class( $classes ) {
        if ( 'product' == get_post_type() ) {
            $classes = array_diff( $classes, array( 'first', 'last' ) );
        }
        return $classes;
    }
}

if ( ! function_exists( 'puca_woocommerce_meta_query' ) ) {
    function puca_woocommerce_meta_query($type){

        $args = array();
        switch ($type) {
          
            case 'best_selling':
                $args['meta_key'] = 'total_sales';
                $args['order']    = 'DESC';
                $args['orderby']  = 'meta_value_num';
                break;

            case 'featured_product':
                $args['ignore_sticky_posts']    = 1;
                $args['meta_query']             = array();
                $args['tax_query'][]              = array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN'
                    )
                );
                break;

            case 'top_rate':
                $args['meta_query']     = WC()->query->get_meta_query();
                $args['tax_query']      = WC()->query->get_tax_query();
                $args['meta_key']       = '_wc_average_rating';
                $args['orderby']        = 'meta_value_num';
                $args['order']          = 'DESC';
                break;

            case 'recent_product':
                $args['orderby']    = 'date';
                $args['order']      =  'DESC';
                $args['meta_query'] = WC()->query->get_meta_query();
                $args['tax_query']  = WC()->query->get_tax_query();
                break; 

            case 'random_product':
                $args['orderby']    = 'rand';
                $args['meta_query'] = array();
                break;

            case 'on_sale':
                $args['meta_query']     = WC()->query->get_meta_query();
                $args['tax_query']      = WC()->query->get_tax_query();
                $args['post__in']       = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
                break;

        }

        if( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $args['meta_query'][] =  array(
                'relation' => 'AND',
                array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                )
            );
        }

        $args['tax_query'][] = array(
            'relation' => 'AND',
            array(
               'taxonomy' =>   'product_visibility',
                'field'    =>   'slug',
                'terms'    =>   array('exclude-from-search', 'exclude-from-catalog'),
                'operator' =>   'NOT IN',
            )
        );

        return $args;
    }
}

//Render form fillter product
if ( ! function_exists( 'puca_woocommerce_product_fillter' ) ) {
    function puca_woocommerce_product_fillter($options, $name, $default, $class = 'level-0'){
        // Only show on product categories
        if ( ! woocommerce_products_will_display() ) :
            return;
        endif;

        ?>
        <form method="get" class="woocommerce-fillter">
            <select name="<?php echo esc_attr($name); ?>" onchange="this.form.submit()" class="select">
                <?php $i = 0; foreach( $options as $key => $value ) : ?>
                    <?php 
                        if( $name === 'product_category' ) {
                            $category = get_term_by( 'slug', $key, 'product_cat' );
                        }
                        
                       if( $name !== 'product_category' || ( !empty($category->count) && $category->count > 0 ) ) :
                    ?>
                        <option class="<?php echo (!empty($class[$i])) ? trim($class[$i]) : '';?>" value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, puca_woocommerce_get_fillter($name, $default) ); ?> ><?php echo trim($value);?></option>
                        <?php $i++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        <?php
            // Keep query string vars intact
            foreach ( $_GET as $key => $val ) :

                if ( $name === $key || 'submit' === $key ) :
                    continue;
                endif;
                if ( is_array( $val ) ) :
                    foreach( $val as $inner_val ) :
                        ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>[]" value="<?php echo esc_attr( $inner_val ); ?>" /><?php
                    endforeach;
                else :
                    ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $val ); ?>" /><?php
                endif;
            endforeach;
        ?>
        </form>
    <?php

    }
}

//get value fillter
if ( ! function_exists( 'puca_woocommerce_get_fillter' ) ) {
    function puca_woocommerce_get_fillter($name, $default){

        if ( isset( $_GET[$name] ) ) :
            return $_GET[$name];
        else :
            return $default;
        endif;
    }
}


//Add query product type
if ( ! function_exists( 'puca_woocommerce_product_type_query' ) ) {
    function puca_woocommerce_product_type_query( $q ){
        $name = 'product_type';
        $default = 'recent_products';

        $product_type = puca_woocommerce_get_fillter($name, $default);
        $args    = puca_woocommerce_meta_query($product_type);
        $queries = array('meta_key', 'orderby', 'order', 'post__in', 'tax_query', 'meta_query');
        if ( function_exists( 'woocommerce_products_will_display' ) && $q->is_main_query() ) :
            foreach($queries as $query){
                if(isset($args[$query])){
                    $q->set( $query, $args[$query] );
                }
            }
        endif;
    }
}

//Add form fillter by product type
if ( ! function_exists( 'puca_woocommerce_product_type_fillter' ) ) {
    function puca_woocommerce_product_type_fillter(){
        $default = 'recent_product';
        $options = array(
            'best_selling'      => esc_html__('Best Selling', 'puca'),
            'featured_product'  => esc_html__('Featured Products', 'puca'),
            'recent_product'    => esc_html__('Recent Products', 'puca'),
            'on_sale'           => esc_html__('On Sale', 'puca'),
            'random_product'    => esc_html__('Random Products', 'puca')
        );
        $name = 'product_type';
        puca_woocommerce_product_fillter($options, $name, $default);
    }
}


//Add query product per page
if ( ! function_exists( 'puca_woocommerce_product_per_page_query' ) ) {
    function puca_woocommerce_product_per_page_query( $q ){
        $default            = puca_tbay_get_config('number_products_per_page');
        $product_per_page   = puca_woocommerce_get_fillter('product_per_page',$default);
        if ( function_exists( 'woocommerce_products_will_display' ) && $q->is_main_query() ) :
            $q->set( 'posts_per_page', $product_per_page );
        endif;
    }
}

//Add form fillter by product per page
if ( ! function_exists( 'puca_woocommerce_product_per_page_fillter' ) ) {
    function puca_woocommerce_product_per_page_fillter(){
        $columns = puca_tbay_get_config('product_columns', 4);
        $default = puca_tbay_get_config('number_products_per_page');
        $options= array();
        for($i=1; $i<=5; $i++){
            $options[$i*$columns] =  $i*$columns.' '.esc_html__( ' products per page', 'puca');
        }
        $options['-1'] = esc_html__('All products', 'puca' );
        $name = 'product_per_page';
        puca_woocommerce_product_fillter($options, $name, $default);
    }
}


//Add query product category
if ( ! function_exists( 'puca_woocommerce_product_category_query' ) ) {
    function puca_woocommerce_product_category_query( $q ){

        $default            = -1;
        $product_cat        = puca_woocommerce_get_fillter('product_category',$default);


        $tax_query = (array) $q->get( 'tax_query' );

        $tax_query[] = array(
                'posts_per_page' => -1,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $product_cat
                    )
                ),
                'post_type' => 'product',
                'orderby' => 'title,'
        );


        if ( function_exists( 'woocommerce_products_will_display' ) && $q->is_main_query() && $product_cat != -1 ) :
           $q->set( 'tax_query', $tax_query );
        endif;
    }
}


//Add form fillter by product category
if ( ! function_exists( 'puca_woocommerce_product_category_fillter' ) ) {
    function puca_woocommerce_product_category_fillter(){

        $taxonomy       = 'product_cat';
        $orderby        = 'name';  
        $pad_counts     = 0;      // 1 for yes, 0 for no
        $hierarchical   = 1;      // 1 for yes, 0 for no   
        $empty          = 0;
        $posts_per_page =  -1;

        $args = array(
            'taxonomy'       => $taxonomy, 
            'orderby'        => $orderby,
            'posts_per_page' => $posts_per_page,
            'pad_counts'     => $pad_counts,
            'hierarchical'   => $hierarchical,
            'hide_empty'     => $empty
        );

        $all_categories = get_categories( $args );

        $options = array();
        $class = array();
        $options['-1'] = esc_html__('All Category', 'puca' );
        $class[] = 'level-0';
        $default = esc_html__('All Category', 'puca' );
        foreach ($all_categories as $cat) {
            if($cat->category_parent == 0) {
                $cat_name   =   $cat->name;    
                $cat_id     =   $cat->term_id;    
                $cat_slug   =   $cat->slug;    
                $count      =   $cat->count;
                $level      =   0;

                $options[$cat_slug]      =  $cat_name.'('.$count.')';
                $class[]                 = 'level-'.$level;

                $taxonomy       =   'product_cat';
                $orderby        =   'name';  
                $pad_counts     =   0;      // 1 for yes, 0 for no
                $hierarchical   =   1;      // 1 for yes, 0 for no   
                $empty          =   0;
                $posts_per_page =  -1;


                $args2 = array(
                        'child_of'      => 0,
                        'parent'         => $cat_id,
                        'taxonomy'       => $taxonomy, 
                        'orderby'        => $orderby,
                        'posts_per_page' => $posts_per_page,
                        'pad_counts'     => $pad_counts,
                        'hierarchical'   => $hierarchical,
                        'hide_empty'     => $empty
                );

                $sub_cats = get_categories( $args2 );


                if($sub_cats) {
                    $level ++;

                    foreach($sub_cats as $sub_category) {

                        $sub_cat_name               =   $sub_category->name;    
                        $sub_cat_id                 =   $sub_category->term_id;    
                        $sub_cat_slug               =   $sub_category->slug;    
                        $sub_count                  =   $sub_category->count;
                        $class[]                    =  'level-'.$level;

                        $options[$sub_cat_slug]     =  $sub_cat_name.'('.$sub_count.')';


                        $taxonomy       =   'product_cat';
                        $orderby        =   'name';  
                        $pad_counts     =   0;      // 1 for yes, 0 for no
                        $hierarchical   =   1;      // 1 for yes, 0 for no   
                        $empty          =   0;
                        $posts_per_page =  -1;


                        $args2 = array(
                                'child_of'      => 0,
                                'parent'         => $sub_cat_id,
                                'taxonomy'       => $taxonomy, 
                                'orderby'        => $orderby,
                                'posts_per_page' => $posts_per_page,
                                'pad_counts'     => $pad_counts,
                                'hierarchical'   => $hierarchical,
                                'hide_empty'     => $empty
                        );

                        $sub_cats = get_categories( $args2 );


                        if($sub_cats) {
                            $level ++;

                            foreach($sub_cats as $sub_category) {

                                $sub_cat_name               =   $sub_category->name;    
                                $sub_cat_id                 =   $sub_category->term_id;    
                                $sub_cat_slug               =   $sub_category->slug;    
                                $sub_count                  =   $sub_category->count;
                                $class[]                    =  'level-'.$level;

                                $options[$sub_cat_slug]     =  $sub_cat_name.'('.$sub_count.')';
                            }
                        }

                    }
                }

            }
        }
                        
        $name = 'product_category';

        puca_woocommerce_product_fillter($options, $name, $default, $class);
    }
}




// Add hook to before shoop loop in layout filter bar
if ( !function_exists('puca_tbay_layout_filter_bar') ) {
    function puca_tbay_layout_filter_bar() {

        $sidebar_configs = puca_tbay_get_woocommerce_layout_configs();

        if( isset($sidebar_configs['filter_bar']) && $sidebar_configs['filter_bar'] ) {

            add_action( 'woocommerce_product_query', 'puca_woocommerce_product_type_query', 20, 2 );
            add_action('woocommerce_before_shop_loop', 'puca_woocommerce_product_type_fillter', 25);
            add_action('woocommerce_before_shop_loop', 'puca_woocommerce_product_per_page_fillter', 30);
            add_action('woocommerce_before_shop_loop', 'puca_woocommerce_product_category_fillter', 35);
            add_action( 'woocommerce_product_query', 'puca_woocommerce_product_category_query',30 ,2 );

        }

    }
    add_action( 'init', 'puca_tbay_layout_filter_bar' );
}


// Add hook to before shoop loop in layout filter bar
if ( !function_exists('puca_tbay_filter_config') ) {
    function puca_tbay_filter_config() {

        if( isset($_GET['product_type_fillter'])  ) {
            $product_type_fillter = $_GET['product_type_fillter'];
        } else {
            $product_type_fillter = puca_tbay_get_global_config('product_type_fillter');
        }        

        if( isset($_GET['product_per_page_fillter'])  ) {
            $product_per_page_fillter = $_GET['product_per_page_fillter'];
        } else {
            $product_per_page_fillter = puca_tbay_get_global_config('product_per_page_fillter');
        }        

        if( isset($_GET['product_category_fillter'] )  ) {
            $product_category_fillter = $_GET['product_category_fillter'];
        } else {
            $product_category_fillter = puca_tbay_get_global_config('product_category_fillter');
        }

        if ( $product_type_fillter ) {
            add_action('woocommerce_before_shop_loop', 'puca_woocommerce_product_type_fillter', 25);
        }

        add_action( 'woocommerce_product_query', 'puca_woocommerce_product_type_query', 20 ,2 );

        if ( $product_per_page_fillter ) {
             add_action('woocommerce_before_shop_loop', 'puca_woocommerce_product_per_page_fillter', 30);
             add_action( 'woocommerce_product_query', 'puca_woocommerce_product_per_page_query', 10, 2 );
        }

        if ( $product_category_fillter ) {
            add_action('woocommerce_before_shop_loop', 'puca_woocommerce_product_category_fillter', 35);
            add_action( 'woocommerce_product_query', 'puca_woocommerce_product_category_query',30 ,2 );
        }
        
    }
    add_action( 'init', 'puca_tbay_filter_config' );
}


// Add hook to before shoop loop in layout canvas sidebar
if(!function_exists('puca_tbay_layout_canvas_sidebar')){
    function puca_tbay_layout_canvas_sidebar(){

        $sidebar_configs = puca_tbay_get_woocommerce_layout_configs();

        $class_canvas = '';
        if ( isset($sidebar_configs['canvas_left']) && $sidebar_configs['canvas_left'] ) {
            $class_canvas = 'left';
        } elseif ( isset($sidebar_configs['canvas_right']) && $sidebar_configs['canvas_right'] ) {
            $class_canvas = 'right';
        }
        
        
        $skin = puca_tbay_get_theme();
        $icon = ($skin === 'fashion3') ? '<i class="tb-icon tb-icon-zz-cancel-1"></i>' : 'x';

        if ( isset($sidebar_configs['canvas']) && $sidebar_configs['canvas'] ) {
 
            if(is_active_sidebar('product-canvas-sidebar')) {
                ?>

                <div class="product-canvas-sidebar <?php echo esc_attr($class_canvas); ?>">
                    <div class="content"> 
                        <a href="javascript:;" class="product-canvas-close  <?php echo esc_attr($class_canvas); ?>"><span><?php echo trim($icon) ?></span></a>
                        <?php dynamic_sidebar('product-canvas-sidebar'); ?> 
                    </div>
                </div>

                <?php
            }

        }
    } 
    add_action( 'puca_woo_template_main_before', 'puca_tbay_layout_canvas_sidebar' , 10 );
}

// class body canvas
if ( ! function_exists( 'puca_tbay_body_classes_canvas' ) ) {
    function puca_tbay_body_classes_canvas( $classes ) {
        $sidebar_configs = puca_tbay_get_woocommerce_layout_configs();
        if ( isset($sidebar_configs['body_class']) && $sidebar_configs['body_class'] ) {
            $class = $sidebar_configs['body_class']; 
            $classes[] = trim($class);
        }
        return $classes;
    }
    add_filter( 'body_class', 'puca_tbay_body_classes_canvas' );
}


//Add button icon canvas sidebar
if(!function_exists('puca_tbay_layout_button_canvas_sidebar')){
    function puca_tbay_layout_button_canvas_sidebar(){

        $sidebar_configs = puca_tbay_get_woocommerce_layout_configs();
        $skin = puca_tbay_get_theme();
        $icon = ($skin === 'fashion3') ? 'tb-icon tb-icon-zzz-bars' : 'icons icon-settings';
        if( isset($sidebar_configs['canvas']) && $sidebar_configs['canvas'] ) {
            echo '<button class="button-canvas-sidebar" type="submit"><span><i class="'.$icon.'" aria-hidden="true"></i></span></button>';
        }  
       
    }
    add_action( 'woocommerce_before_shop_loop', 'puca_tbay_layout_button_canvas_sidebar' , 1 );
}


//Add button load more in shop
if(!function_exists('puca_tbay_woocommerce_shop_load_more')){
    function puca_tbay_woocommerce_shop_load_more(){
        global $wp_query;


        if (  $wp_query->max_num_pages > 1 ) {
            ?>
           <div class="tbay-pagination-load-more">
                <a href="javascript:void(0);" data-loadmore="true">
                    <i class="icon-plus icons"></i>
                    <span class="text"><?php esc_html_e('Load More', 'puca'); ?></span>
                </a>
           </div>

       <?php }
    }
}


/* ---------------------------------------------------------------------------
 * WooCommerce - Function Load more ajax
 * --------------------------------------------------------------------------- */
if(!function_exists('puca_pagination_fnc_more_post_ajax')){
    add_action('wp_ajax_nopriv_puca_pagination_more_post_ajax', 'puca_pagination_fnc_more_post_ajax');
    add_action('wp_ajax_puca_pagination_more_post_ajax', 'puca_pagination_fnc_more_post_ajax');

    function puca_pagination_fnc_more_post_ajax(){

        // prepare our arguments for the query
        $args = json_decode( stripslashes( $_POST['query'] ), true );
        $args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
        $args['post_status'] = 'publish';
     
        // it is always better to use WP_Query but not here
        query_posts( $args );
     
        if( have_posts() ) :
     
            while( have_posts() ): the_post();
     
                wc_get_template( 'content-product.php');

     
            endwhile;
     
        endif;
        die; // here we exit the script and even no wp_reset_postdata() required!
    }
}

/*Call funciton WCVariation Swatches  swallow2603*/
if( class_exists( 'TA_WC_Variation_Swatches' ) ) {
    function puca_get_swatch_html( $html, $args ) {
        $swatch_types = TA_WCVS()->types;
        $attr         = TA_WCVS()->get_tax_attribute( $args['attribute'] );

        // Return if this is normal attribute
        if ( empty( $attr ) ) {
            return $html;
        }

        if ( ! array_key_exists( $attr->attribute_type, $swatch_types ) ) {
            return $html;
        }

        $options   = $args['options'];
        $product   = $args['product'];
        $attribute = $args['attribute'];
        $class     = "variation-selector variation-select-{$attr->attribute_type}";
        $swatches  = '';

        if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
            $attributes = $product->get_variation_attributes();
            $options    = $attributes[$attribute];
        }

        if ( array_key_exists( $attr->attribute_type, $swatch_types ) ) {
            if ( ! empty( $options ) && $product && taxonomy_exists( $attribute ) ) {
                // Get terms if this is a taxonomy - ordered. We need the names too.
                $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

                foreach ( $terms as $term ) {
                    if ( in_array( $term->slug, $options ) ) {
                        $swatches .= apply_filters( 'tawcvs_swatch_html', '', $term, $attr, $args );
                    }
                }
            }

            if ( ! empty( $swatches ) ) {
                $class .= ' hidden';

                $swatches = '<div class="tawcvs-swatches" data-attribute_name="attribute_' . esc_attr( $attribute ) . '">' . $swatches . '</div>';
                $html     = '<div class="' . esc_attr( $class ) . '">' . $html . '</div>' . $swatches;
            }
        }

        return $html;
    }

    function puca_swatch_html( $html, $term, $attr, $args ) {
        $selected = sanitize_title( $args['selected'] ) == $term->slug ? 'selected' : '';
        $name     = esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) );

        switch ( $attr->attribute_type ) {
            case 'color':
                $color = get_term_meta( $term->term_id, 'color', true );
                list( $r, $g, $b ) = sscanf( $color, "#%02x%02x%02x" );
                $html = sprintf(
                    '<span class="swatch swatch-color swatch-%s %s" style="background-color:%s;color:%s;" title="%s" data-value="%s">%s</span>',
                    esc_attr( $term->slug ),
                    $selected,
                    esc_attr( $color ),
                    "rgba($r,$g,$b,0.5)",
                    esc_attr( $name ),
                    esc_attr( $term->slug ),
                    $name
                );
                break;

            case 'image':
                $image = get_term_meta( $term->term_id, 'image', true );
                $image = $image ? wp_get_attachment_image_src( $image ) : '';
                $image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
                $html  = sprintf(
                    '<span class="swatch swatch-image swatch-%s %s" title="%s" data-value="%s"><img src="%s" alt="%s">%s</span>',
                    esc_attr( $term->slug ),
                    $selected,
                    esc_attr( $name ),
                    esc_attr( $term->slug ),
                    esc_url( $image ),
                    esc_attr( $name ),
                    esc_attr( $name )
                );
                break;

            case 'label':
                $label = get_term_meta( $term->term_id, 'label', true );
                $label = $label ? $label : $name;
                $html  = sprintf(
                    '<span class="swatch swatch-label swatch-%s %s" title="%s" data-value="%s">%s</span>',
                    esc_attr( $term->slug ),
                    $selected,
                    esc_attr( $name ),
                    esc_attr( $term->slug ),
                    esc_html( $label )
                );
                break;
        }

        return $html;
    }
}


/*Hook page cart*/

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 99 );

/**
 *
 * Code used to change the price order in WooCommerce
 *
 * */
if(!function_exists('puca_woocommerce_price_html')){
    function puca_woocommerce_price_html($price, $product) {
        return preg_replace('@(<del.*>.*?</del>).*?(<ins>.*?</ins>)@misx', '$2 $1', $price);
    }

    add_filter('woocommerce_format_sale_price', 'puca_woocommerce_price_html', 100, 2);
}

/*Hook page checkout multistep*/
if(!function_exists('puca_woocommerce_is_multistep_checkout')){
    function puca_woocommerce_is_multistep_checkout() {
        if ( class_exists( 'YITH_Multistep_Checkout' ) || class_exists( 'WPMultiStepCheckout' ) || class_exists( 'WooCommerce_Germanized' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

if(!function_exists('puca_woocommerce_order_payment_heading')){
    function puca_woocommerce_order_payment_heading() {

        if ( puca_woocommerce_is_multistep_checkout() ) return;

        echo '<div class="order-payment"><h3 id="payment_heading">'. esc_html__( 'Payment method', 'puca' ) .'</h3></div>';
    }
    
    add_action( 'woocommerce_review_order_before_payment', 'puca_woocommerce_order_payment_heading', 20 );
}



// class product number mobile
if ( ! function_exists( 'puca_tbay_body_classes_product_number_mobile' ) ) {
    function puca_tbay_body_classes_product_number_mobile( $classes ) {

        $columns = puca_tbay_get_config('mobile_product_number', 'two');

        if( isset($columns) ) {
            $class = 'tbay-body-mobile-product-'.$columns;
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter( 'body_class', 'puca_tbay_body_classes_product_number_mobile' );
}

// catalog mode

if ( !function_exists('puca_tbay_woocommerce_catalog_mode_active') ) {
    function puca_tbay_woocommerce_catalog_mode_active() {
        $active = puca_tbay_get_config('enable_woocommerce_catalog_mode', false);

        $active = (isset($_GET['catalog_mode'])) ? $_GET['catalog_mode'] : $active;

        return $active;
    }
}
add_filter( 'puca_catalog_mode', 'puca_tbay_woocommerce_catalog_mode_active' );

if ( !function_exists('puca_woocommerce_catalog_mode_active') ) {
    function puca_woocommerce_catalog_mode_active() {
        $active = apply_filters( 'puca_catalog_mode', 10,2 );
        if( isset($active) && $active ) {  
          define( 'PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED', true );
        }
    }

    add_action( 'init', 'puca_woocommerce_catalog_mode_active' );
}

// Quantity mode

if ( !function_exists('puca_tbay_woocommerce_quantity_mode_active') ) {
    function puca_tbay_woocommerce_quantity_mode_active() {
        $catalog_mode = puca_tbay_woocommerce_catalog_mode_active();

        if( isset($catalog_mode) && $catalog_mode ) return false;

        $active = puca_tbay_get_config('enable_woocommerce_quantity_mode', false);

        $active = (isset($_GET['quantity_mode'])) ? $_GET['quantity_mode'] : $active;

        return $active;
    }
}


if ( ! function_exists( 'puca_is_quantity_field_archive' ) ) {
    function puca_is_quantity_field_archive( ) {
        global $product;

        if( $product && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
            $max_value = $product->get_max_purchase_quantity();
            $min_value = $product->get_min_purchase_quantity();

            if( $max_value && $min_value === $max_value ) {
                return false;     
            }
            
            return true;
        } else {
            return false;
        }
    }
}

if ( ! function_exists( 'puca_quantity_field_archive' ) ) {
    function puca_quantity_field_archive( ) {

        global $product;
        if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
            woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
        }

    }
}

if ( ! function_exists( 'puca_woocommerce_quantity_mode_group_button' ) ) {
    function puca_woocommerce_quantity_mode_group_button() {
        
        if( !puca_tbay_woocommerce_quantity_mode_active() || puca_is_woo_variation_swatches_pro() ) return;

        global $product;
        if(  puca_is_quantity_field_archive() &&  $product->is_type( 'simple' ) ) {
            $class_active = 'active';
        } else {
            return '';
        } 

        echo '<div class="quantity-group-btn '. esc_attr($class_active) .'">';
            if( puca_is_quantity_field_archive() && $product->is_type( 'simple' ) ) {
                puca_quantity_field_archive();
            }
            woocommerce_template_loop_add_to_cart();
        echo '</div>';
    }
    add_action('puca_loop_item_quantity', 'puca_woocommerce_quantity_mode_group_button', 5);
}  

if (! function_exists('puca_woocommerce_quantity_mode_active_class')) {
    function puca_woocommerce_quantity_mode_active_class($classes, $product)
    {
        
        if ( !puca_tbay_woocommerce_quantity_mode_active() ) {
            return $classes;
        }

        global $product;

        if(  puca_is_quantity_field_archive() &&  ( $product->is_type( 'simple' ) || ( $product->is_type( 'variable' ) && puca_is_woo_variation_swatches_pro() ) ) ) {
            $class_active = 'tbay-product-quantity';
        } else {
            $class_active = '';
        } 
    
        $classes[] = $class_active;
    
        return $classes;   
    }
    add_filter('woocommerce_post_class', 'puca_woocommerce_quantity_mode_active_class', 10, 2);
}

if ( ! function_exists( 'puca_woocommerce_quantity_mode_remove_add_to_cart' ) ) {
    function puca_woocommerce_quantity_mode_remove_add_to_cart() {
        if ( !puca_tbay_woocommerce_quantity_mode_active() ) {
            return '';
        } 

        global $product;

        if (puca_is_quantity_field_archive() &&  ($product->is_type('simple') || ($product->is_type('variable') && puca_is_woo_variation_swatches_pro()))) {
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 ); 
        } else {
            add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 ); 
        }

    }
    add_action( 'woocommerce_before_shop_loop_item_title', 'puca_woocommerce_quantity_mode_remove_add_to_cart', 10 ); 
}

if (!function_exists('puca_is_woo_variation_swatches_pro')) {
    function puca_is_woo_variation_swatches_pro()
    {
        return class_exists('Woo_Variation_Swatches_Pro') ? true : false;
    }
}



// class catalog mode
if ( ! function_exists( 'puca_tbay_body_classes_woocommerce_catalog_mod' ) ) {
    function puca_tbay_body_classes_woocommerce_catalog_mod( $classes ) {
        $class = '';
        $active = apply_filters( 'puca_catalog_mode', 10,2 );
        if( isset($active) && $active ) {  
            $class = 'tbay-body-woocommerce-catalog-mod';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter( 'body_class', 'puca_tbay_body_classes_woocommerce_catalog_mod' );
}

// 

if ( !function_exists('puca_woocommerce_catalog_mode') ) {
    function puca_woocommerce_catalog_mode() {
        $active = apply_filters( 'puca_catalog_mode', 10,2 );
        if( isset($active) && $active ) {  
           
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            remove_action('woocommerce_add_to_cart_validation', 'avoid_add_to_cart',  10, 2 );       

            if ( defined( 'YITH_WCQV' ) && YITH_WCQV ) {
                remove_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_add_to_cart', 25 );
            }
        }

    }

    add_action( 'init', 'puca_woocommerce_catalog_mode' );
}

// cart modal
if ( !function_exists('puca_woocommerce_catalog_mode_redirect_page') ) {
    function puca_woocommerce_catalog_mode_redirect_page() {
        $active = apply_filters( 'puca_catalog_mode', 10,2 );
        if( isset($active) && $active ) {  
           
            $cart     = is_page( wc_get_page_id( 'cart' ) );
            $checkout = is_page( wc_get_page_id( 'checkout' ) );

            wp_reset_postdata();

            if ( $cart || $checkout ) {

                wp_redirect( home_url() );
                exit;

            }
        }

    }

    add_action( 'wp', 'puca_woocommerce_catalog_mode_redirect_page' );
}
/*End catalog mode*/

/*Get layout product countdown*/
if ( !function_exists('puca_tbay_woo_get_product_countdown_layouts') ) {
    function puca_tbay_woo_get_product_countdown_layouts() {
        $layouts = array(
            esc_html__('Grid', 'puca') => 'grid',
        );
        $active_theme = puca_tbay_get_part_theme();
        $files = glob( get_template_directory() . '/woocommerce/item-product/'.$active_theme.'/inner-countdown*.php' );
        if ( !empty( $files ) ) {
            foreach ( $files as $file ) {
                $str  = str_replace( "inner-countdown", '', str_replace( '.php', '', 'carousel-'.basename($file) ) );
                if( stripos($str, 'carousel-grid') === 0 ) {
                    $str2 = ucwords(str_replace('carousel-grid','Grid', $str ));
                    $str2 = ucwords(str_replace('-',' ', $str2 ));
                    $str3 = str_replace('carousel-','', $str );
                } else {
                    $str2 = ucwords(str_replace('-',' ', $str ));
                    $str3 = str_replace('carousel-','', $str );
                    $str3 = 'inner-countdown'.$str3;
                }
                
                $layouts[$str2] = $str3;
            }
        }

        return $layouts;
    }
}

/*Get layout product countdown*/
if ( !function_exists('puca_tbay_woo_get_product_countdown_not_layouts') ) {
    function puca_tbay_woo_get_product_countdown_not_layouts() {
        $layouts = array( 'grid');
        $active_theme = puca_tbay_get_part_theme();
        $files = glob( get_template_directory() . '/woocommerce/item-product/'.$active_theme.'/inner-countdown*.php' );
        if ( !empty( $files ) ) {
            foreach ( $files as $file ) {
                $str  = str_replace( "inner-countdown", '', str_replace( '.php', '', 'carousel-'.basename($file) ) );
                if( stripos($str, 'carousel-grid') === 0 ) {
                    $str3 = str_replace('carousel-','', $str );
                    array_push($layouts, $str3);
                }  
          
            }
        }

        return $layouts;
    }
}

/*Show Add to Cart on mobile*/
if ( !function_exists('puca_tbay_woocommerce_show_cart_mobile') ) {
    function puca_tbay_woocommerce_show_cart_mobile($active) {
        $active = puca_tbay_get_config('enable_add_cart_mobile', false);

        $active = (isset($_GET['add_cart_mobile'])) ? $_GET['add_cart_mobile'] : $active;

        return $active;
    }
}
add_filter( 'puca_show_cart_mobile', 'puca_tbay_woocommerce_show_cart_mobile' );

if ( ! function_exists( 'puca_tbay_body_classes_woocommerce_show_cart_mobile' ) ) {
    function puca_tbay_body_classes_woocommerce_show_cart_mobile( $classes ) {
        $class = '';
        $active = apply_filters( 'puca_show_cart_mobile', 10,2 );
        if( isset($active) && $active ) {  
            $class = 'tbay-show-cart-mobile';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter( 'body_class', 'puca_tbay_body_classes_woocommerce_show_cart_mobile' );
}

/*Show Quantity on mobile*/
if ( !function_exists('puca_tbay_woocommerce_show_quantity_mobile') ) {
    function puca_tbay_woocommerce_show_quantity_mobile($active) {
        $active = puca_tbay_get_config('enable_quantity_mobile', false);

        $active = (isset($_GET['quantity_mobile'])) ? $_GET['quantity_mobile'] : $active;

        return $active;
    }
}
add_filter( 'puca_show_quantity_mobile', 'puca_tbay_woocommerce_show_quantity_mobile' );

if ( ! function_exists( 'puca_tbay_body_classes_woocommerce_show_quantity_mobile' ) ) {
    function puca_tbay_body_classes_woocommerce_show_quantity_mobile( $classes ) {
        $class = '';
        $active = apply_filters( 'puca_show_quantity_mobile', 10,2 );
        if( isset($active) && $active ) {  
            $class = 'tbay-show-quantity-mobile';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter( 'body_class', 'puca_tbay_body_classes_woocommerce_show_quantity_mobile' );
}

/*Get title mobile in top bar mobile*/
if ( ! function_exists( 'puca_tbay_get_title_mobile' ) ) {
    function puca_tbay_get_title_mobile( $title = '') {
        $delimiter = ' / ';
        
        if ( is_product_category() || is_category() ) {
            $title = single_cat_title();
        }  elseif ( is_search() ) {
            $title = esc_html__('Search results for "','puca')  . get_search_query();
        } elseif ( is_tag() ) {
            $title = esc_html__('Posts tagged "', 'puca'). single_tag_title('', false) . '"';
        } else if ( is_product_tag() ) {
            $title = esc_html__('Product tagged "', 'puca'). single_tag_title('', false) . '"';
        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            $title = esc_html__('Articles posted by ', 'puca') . $userdata->display_name;
        } elseif ( is_404() ) {
            $title = esc_html__('Error 404', 'puca');
        } elseif( is_shop () ) {
            $post_id = wc_get_page_id('shop');
            if( isset($post_id) && !empty($post_id) ) {
                $title = get_the_title($post_id);
            } else {
                $title = esc_html__('shop','puca');                
            }
        } elseif (is_category()) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
            $title = single_cat_title('', false);
            
        } elseif (is_day()) {
            $title = get_the_time('d');
        } elseif (is_month()) {
            $title = get_the_time('F');
        } elseif (is_year()) {
            $title = get_the_time('Y');
        } elseif ( is_single()  && !is_attachment()) {
            $title = get_the_title();
        } elseif ( defined('PUCA_TBAY_PORTFOLIO_ACTIVED') && PUCA_TBAY_PORTFOLIO_ACTIVED && is_project_category() ) {
            $title = single_cat_title();
        } elseif ( defined('PUCA_TBAY_PORTFOLIO_ACTIVED') && PUCA_TBAY_PORTFOLIO_ACTIVED && is_projects_archive() ) {
            $projects_id = projects_get_page_id( 'projects' );
            if( isset($projects_id) && !empty($projects_id) ) {
                $title = get_the_title($projects_id);
            } 
        } else {
            $title = get_the_title();
        }
        
        return $title;
    }
    add_filter( 'puca_get_filter_title_mobile', 'puca_tbay_get_title_mobile' );
}

/**
 * Remove password strength check.
 */
if ( ! function_exists( 'puca_tbay_remove_password_strength' ) ) {
    function puca_tbay_remove_password_strength() {
        $active = puca_tbay_get_config('show_woocommerce_password_strength', true);

        if( isset($active) && !$active ) {
            wp_dequeue_script( 'wc-password-strength-meter' );
        }
    }
    add_action( 'wp_print_scripts', 'puca_tbay_remove_password_strength', 10 );
}

if( defined( 'YITH_WCWL' ) && ! function_exists( 'puca_yith_wcwl_ajax_update_count' ) ){
function puca_yith_wcwl_ajax_update_count(){

    $wishlist_count = YITH_WCWL()->count_products();

    wp_send_json( array(
    'count' => $wishlist_count
    ) );
    }
    add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'puca_yith_wcwl_ajax_update_count' );
    add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'puca_yith_wcwl_ajax_update_count' );
}


//Count product of category

if ( ! function_exists( 'puca_get_product_count_of_category' ) ) {
    function puca_get_product_count_of_category( $cat_id ) {

        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => -1,
            'tax_query'             => array(
                array(
                    'taxonomy'      => 'product_cat',
                    'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                    'terms'         => $cat_id,
                    'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                ),
                array(
                    'taxonomy'      => 'product_visibility',
                    'field'         => 'slug',
                    'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
                    'operator'      => 'NOT IN'
                )
            )
        );
        $loop = new WP_Query($args);

        return $loop->found_posts;
    }
}

/*Remove filter*/
if ( ! function_exists( 'puca_woocommerce_sub_categories' ) ) {
    /**
     * Output the start of a product loop. By default this is a UL.
     *
     * @param bool $echo Should echo?.
     * @return string
     */
    function puca_woocommerce_sub_categories( $echo = true ) {
        ob_start();

        wc_set_loop_prop( 'loop', 0 );
        
        $loop_start = apply_filters( 'puca_woocommerce_sub_categories', ob_get_clean() );

        if ( $echo ) {
            echo trim($loop_start); // WPCS: XSS ok.
        } else {
            return $loop_start;
        }
    }
}

add_filter( 'puca_woocommerce_sub_categories', 'woocommerce_maybe_show_product_subcategories' ); 

if ( ! function_exists( 'puca_is_product_variable_sale' ) ) {
    function puca_is_product_variable_sale() {

        global $product;

        if( $product->is_type( 'variable' ) && $product->is_on_sale()  ) {
            echo 'tbay-variable-sale';
        }
        
    }
}

/**
 * Display category image on category archive
 */
if ( ! function_exists( 'puca_woocommerce_category_image' ) ) {
    add_action( 'woocommerce_archive_description', 'puca_woocommerce_category_image', 2 );
    function puca_woocommerce_category_image() {
        if ( is_product_category() ){
            global $wp_query;
            $cat = $wp_query->get_queried_object();
            $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
            $image = wp_get_attachment_url( $thumbnail_id );
            if ( $image ) {
                echo '<img src="' . esc_url($image) . '" alt="' . esc_attr( $cat->name) . '" />';
            }
        }
    }
}

if ( !function_exists('puca_find_matching_product_variation') ) {
    function puca_find_matching_product_variation( $product, $attributes ) {

        foreach( $attributes as $key => $value ) {
            if( strpos( $key, 'attribute_' ) === 0 ) {
                continue;
            }

            unset( $attributes[ $key ] );
            $attributes[ sprintf( 'attribute_%s', $key ) ] = $value;
        }

        if( class_exists('WC_Data_Store') ) {

            $data_store = WC_Data_Store::load( 'product' );
            return $data_store->find_matching_product_variation( $product, $attributes );

        } else {

            return $product->get_matching_variation( $attributes );

        }

    }
}

if ( ! function_exists( 'puca_woo_show_product_loop_sale_flash' ) ) {
    function puca_get_default_attributes( $product ) {

        if( method_exists( $product, 'get_default_attributes' ) ) {

            return $product->get_default_attributes();

        } else {

            return $product->get_variation_default_attributes();

        }

    }
}

if ( ! function_exists( 'puca_woo_show_product_loop_sale_flash' ) ) {
    /*Change sales woo*/
    add_filter('woocommerce_sale_flash', 'puca_woo_show_product_loop_sale_flash', 10, 3);
    function puca_woo_show_product_loop_sale_flash($original, $post, $product) {

        $saleTag = $original;

        $format                 =  puca_tbay_get_config('sale_tags', 'custom');
        $enable_label_featured  =  puca_tbay_get_config('enable_label_featured', true);

        if ($format == 'custom') {
            $format = puca_tbay_get_config('sale_tag_custom', '- {percent-diff}%');
        } 

        $priceDiff = 0;
        $percentDiff = 0;
        $regularPrice = ''; 
        $salePrice = $percentage = $return_content = '';

        $decimals   =  wc_get_price_decimals();
        $symbol   =  get_woocommerce_currency_symbol();

        $_product_sale   = $product->is_on_sale();
        $featured        = $product->is_featured();

        if( $featured && $enable_label_featured ) {
            $return_content  = '<span class="featured">'. puca_tbay_get_config('custom_label_featured', esc_html__('Hot', 'puca')) .'</span>';
        }


        if( !empty($product) && $product->is_type( 'variable' ) ){
            $default_attributes = puca_get_default_attributes( $product );
            $variation_id       = puca_find_matching_product_variation( $product, $default_attributes );

            if( !empty($variation_id) ) {
                $variation      = wc_get_product($variation_id);

                $_product_sale  = $variation->is_on_sale();

                $regularPrice   = (float) get_post_meta($variation_id, '_regular_price', true);
                $salePrice      = (float) get_post_meta($variation_id, '_price', true);   
            } else {
                $_product_sale = false;
            }

        } elseif( !empty($product) && $product->is_type( 'grouped' ) ) {
            $_product_sale = false;
        } else {
            $salePrice = (float) get_post_meta($product->get_id(), '_price', true);
            $regularPrice = (float) get_post_meta($product->get_id(), '_regular_price', true);
        } 


        if (!empty($regularPrice) && !empty($salePrice ) && $regularPrice > $salePrice ) {
            $priceDiff = $regularPrice - $salePrice;
            $percentDiff = round($priceDiff / $regularPrice * 100);
            
            $parsed = str_replace('{price-diff}', number_format((float)$priceDiff, $decimals, '.', ''), $format);
            $parsed = str_replace('{symbol}', $symbol, $parsed);
            $parsed = str_replace('{percent-diff}', $percentDiff, $parsed);
            $percentage = '<span class="saled">'. $parsed .'</span>';
        }

        if( !empty($_product_sale ) && $_product_sale )  {
            $percentage .= $return_content;
        } else {
            $percentage = '<span class="saled">'. esc_html__( 'Sale', 'puca' ) . '</span>';
            $percentage .= $return_content;
        }

        echo '<span class="onsale">'. trim($percentage). '</span>';
    }
}

if ( ! function_exists( 'puca_woo_only_feature_product' ) ) {
    /*Change sales woo*/
    add_action( 'woocommerce_before_shop_loop_item_title', 'puca_woo_only_feature_product', 10 );
    add_action( 'woocommerce_before_single_product_summary', 'puca_woo_only_feature_product', 10 );
    function puca_woo_only_feature_product() {

        global $product;

        $_product_sale   = $product->is_on_sale();

        $featured        = $product->is_featured();

        if( !empty($product) && $product->is_in_stock() && $product->is_type( 'variable' ) ){
            
            $default_attributes = puca_get_default_attributes( $product );
            $variation_id = puca_find_matching_product_variation( $product, $default_attributes );

            if( !empty($variation_id) ) {
                $variation      = wc_get_product($variation_id);

                $_product_sale  = $variation->is_on_sale();             
            }
        }

        $return_content = '';
        if( $featured && !$_product_sale ) {

            $enable_label_featured  =  puca_tbay_get_config('enable_label_featured', true);

            if( $featured && $enable_label_featured ) {
                $return_content  .= '<span class="featured not-sale">'. puca_tbay_get_config('custom_label_featured', esc_html__('Hot', 'puca')) .'</span>';
            }  

        }

        echo '<span class="onsale">'. trim($return_content). '</span>';
    }
}

if ( ! function_exists( 'puca_woocommerce_single_ajax_add_to_cart' ) ) {
    add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'puca_woocommerce_single_ajax_add_to_cart');
    add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'puca_woocommerce_single_ajax_add_to_cart');
            
    function puca_woocommerce_single_ajax_add_to_cart() {

        $product_id         = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $product            = wc_get_product( $product_id );
        $quantity           = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
        $variation_id       = absint($_POST['variation_id']);
        $passed_validation  = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status     = get_post_status($product_id);
        $variation          = $_POST['variation'];


        if(!$variation_id){
            if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

                do_action('woocommerce_ajax_added_to_cart', $product_id);

                if ('yes' === get_option('woocommerce_cart_redirect_after_add')) { 
                    wc_add_to_cart_message(array($product_id => $quantity), true);
                }

                WC_AJAX :: get_refreshed_fragments();
            } else {

                $data = array(
                    'error' => true,
                    'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

                echo wp_send_json($data);
            }
        }  


        if ($passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) && 'publish' === $product_status) {

            do_action('woocommerce_ajax_added_to_cart', $product_id);

            if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }

            WC_AJAX :: get_refreshed_fragments();
        } else {

            $data = array(
                'error' => true,
                'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

            echo wp_send_json($data);
        }

        wp_die();
    }
}

/* ---------------------------------------------------------------------------
 * WooCommerce - Function More List Product Ajax
 * --------------------------------------------------------------------------- */
if(!function_exists('puca_list_post_ajax_fnc_more_post_ajax')){
    add_action('wp_ajax_nopriv_puca_list_post_ajax', 'puca_list_post_ajax_fnc_more_post_ajax');
    add_action('wp_ajax_puca_list_post_ajax', 'puca_list_post_ajax_fnc_more_post_ajax');

    function puca_list_post_ajax_fnc_more_post_ajax(){
        
        // prepare our arguments for the query
        $args = json_decode( stripslashes( $_POST['query'] ), true );
        
        $args['post_status'] = 'publish';

        
        // it is always better to use WP_Query but not here
        query_posts( $args );

        $mode = 'list';
     
        if( have_posts() ) :
      
            while( have_posts() ): the_post();
     
                wc_get_template( 'content-product.php', array('mode' => $mode));

     
            endwhile;
     
        endif;
        die; // here we exit the script and even no wp_reset_postdata() required!
    }
}

/* ---------------------------------------------------------------------------
 * WooCommerce - Function More Grid Product Ajax
 * --------------------------------------------------------------------------- */
if(!function_exists('puca_grid_post_ajax_fnc_more_post_ajax')){
    add_action('wp_ajax_nopriv_puca_grid_post_ajax', 'puca_grid_post_ajax_fnc_more_post_ajax');
    add_action('wp_ajax_puca_grid_post_ajax', 'puca_grid_post_ajax_fnc_more_post_ajax');

    function puca_grid_post_ajax_fnc_more_post_ajax(){
        
       // prepare our arguments for the query
        $args = json_decode( stripslashes( $_POST['query'] ), true );
        
        $args['post_status'] = 'publish';

        // it is always better to use WP_Query but not here
        query_posts( $args );

        $mode = 'grid';
     
        if( have_posts() ) :
      
            while( have_posts() ): the_post();
     
                wc_get_template( 'content-product.php', array('mode' => $mode));

     
            endwhile;
     
        endif;
        die; // here we exit the script and even no wp_reset_postdata() required!
    }
}

if ( ! function_exists( 'puca_gwp_affiliate_id' ) ) {
    function puca_gwp_affiliate_id(){
        return 2403;
    }
    add_filter('gwp_affiliate_id', 'puca_gwp_affiliate_id');
}

/*Add To Cart Redirect*/  
if(!function_exists('puca_woocommerce_buy_now_redirect')){
    function puca_woocommerce_buy_now_redirect( $url ) {

        if ( ! isset( $_REQUEST['puca_buy_now'] ) || $_REQUEST['puca_buy_now'] == false ) {
            return $url; 
        }

        if ( empty( $_REQUEST['quantity'] ) ) {
            return $url;
        }

        if ( is_array( $_REQUEST['quantity'] ) ) {
            $quantity_set = false;
            foreach ( $_REQUEST['quantity'] as $item => $quantity ) {
                if ( $quantity <= 0 ) {
                    continue;
                }
                $quantity_set = true;
            }

            if ( ! $quantity_set ) {
                return $url;
            }  
        } 

        $redirect = puca_tbay_get_config('redirect_buy_now', 'cart') ;

        switch ($redirect) {
            case 'cart':
                return wc_get_cart_url();   

            case 'checkout':
                return wc_get_checkout_url();  
    
            default:
                return wc_get_cart_url(); 
        }

    }
    add_filter( 'woocommerce_add_to_cart_redirect', 'puca_woocommerce_buy_now_redirect', 99 );
}
  

// Mobile add to cart message html
if ( ! function_exists( 'puca_tbay_add_to_cart_message_html_mobile' ) ) {
    function puca_tbay_add_to_cart_message_html_mobile(  $message ) {
        if ( isset( $_REQUEST['puca_buy_now'] ) && $_REQUEST['puca_buy_now'] == true ) {
            return __return_empty_string();
        }

        $active = puca_tbay_get_config('redirect_add_to_cart', false);

        if ( $active && wp_is_mobile() && ! intval( puca_tbay_get_config('enable_buy_now', false) ) ) {
            return __return_empty_string();     
        } else {
            return $message;
        }

    }
    add_filter( 'wc_add_to_cart_message_html', 'puca_tbay_add_to_cart_message_html_mobile' );
}

//Check Page Dokan

if ( ! function_exists( 'puca_woo_is_mvx_vendor_store' ) ) {
    function puca_woo_is_mvx_vendor_store() {

        if ( ! class_exists( 'MVX' ) ) {
            return false;
        }

        global $MVX;
        if ( empty( $MVX ) ) {
            return false;
        }

        if ( is_tax( $MVX->taxonomy->taxonomy_name ) ) {
            return true;
        }

        return false;
    }
}
/**
 * Check is vendor page
 *
 * @return bool
 */
if ( ! function_exists( 'puca_woo_is_vendor_page' ) ) {
    function puca_woo_is_vendor_page() {

        if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
            return true;
        }

        if ( class_exists( 'WCV_Vendors' ) && method_exists( 'WCV_Vendors', 'is_vendor_page' ) ) {
            return WCV_Vendors::is_vendor_page();
        }

        if ( puca_woo_is_mvx_vendor_store() ) {
            return true;
        }

        if ( function_exists( 'wcfm_is_store_page' ) && wcfm_is_store_page() ) {
            return true;
        }

        return false;
    }
}

//Check Shop Description
if ( ! function_exists( 'puca_woo_change_cat_title_des_img' ) ) {
    function puca_woo_change_cat_title_des_img() {

        $show_des  =   ( isset($_GET['enable_cat_title_des_img']) ) ? $_GET['enable_cat_title_des_img'] :  puca_tbay_get_config('enable_cat_title_des_img', false);

        return $show_des;

    }

    add_filter('puca_woo_cat_title_des_img',  'puca_woo_change_cat_title_des_img', 10 , 1);
}

if ( !function_exists('puca_tbay_page_shop_get_footer_layout') ) {
	function puca_tbay_page_shop_get_footer_layout( $footer ) {

        if( !is_shop() ) return $footer;
 
        $post_id = wc_get_page_id('shop');
        if ( isset($post_id) ) {
            $footer = get_post_meta( $post_id, 'tbay_page_footer_type', true );
            if ( $footer == 'global' ||  $footer == '') {
                return puca_tbay_get_config('footer_type', '');
            }
        }
        return $footer;
	}
	add_filter('puca_tbay_get_footer_layout', 'puca_tbay_page_shop_get_footer_layout', 10, 1);
}

if ( !function_exists('puca_tbay_page_shop_get_header_layout') ) {
	function puca_tbay_page_shop_get_header_layout( $header ) {
        
        if( !is_shop() ) return $header;
        
        return puca_tbay_page_shop_page_header_layout();

	}
	add_filter( 'puca_tbay_get_header_layout', 'puca_tbay_page_shop_get_header_layout', 10, 1 );
}

if ( !function_exists('puca_tbay_page_shop_page_header_layout') ) {
	function puca_tbay_page_shop_page_header_layout() {

		$post_id = wc_get_page_id('shop');

		$header = get_post_meta( $post_id, 'tbay_page_header_type', true );
		if ( $header == 'global' || $header == '' ) {
			return puca_tbay_get_config('header_type', 'v1');
		}
		return $header;
	}
}

if ( !function_exists('puca_dokan_theme_store_sidebar') ) {
    function puca_dokan_theme_store_sidebar() {
       if(  function_exists('dokan_get_option') && dokan_get_option( 'enable_theme_store_sidebar', 'dokan_appearance', 'off' ) === 'off' && dokan_is_store_page() ) {
           return true;
       } else {
           return false;
       }
    } 
}

if ( ! function_exists( 'puca_get_query_products' ) ) {
    function puca_get_query_products($categories = array(), $cat_operator = 'IN', $product_type = 'newest', $limit = '', $orderby = '', $order = '')
    {
        $atts = [
            'limit' => $limit,
            'orderby' => $orderby,
            'order' => $order
        ];
        
        if (!empty($categories)) {
            if (!is_array($categories)) {
                $atts['category'] = $categories;
            } else {
                $atts['category'] = implode(', ', $categories);
                $atts['cat_operator'] = $cat_operator;
            }
        }
        
        $type = 'products';

        $shortcode = new WC_Shortcode_Products($atts, $type);
        $args = $shortcode->get_query_args();
        
        $args = puca_get_attribute_query_product_type($args, $product_type);
        return new WP_Query($args);
    }
} 

if ( ! function_exists( 'puca_get_attribute_query_product_type' ) ) {
    function puca_get_attribute_query_product_type($args, $product_type)
    {
        global $woocommerce;

        switch ($product_type) {
            case 'best_selling':
                $args['meta_key']   = 'total_sales';
                $args['order']      = 'DESC';
                $args['orderby']    = 'meta_value_num';
                $args['ignore_sticky_posts']   = 1;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;

            case 'featured':
            case 'featured_product':
                $args['ignore_sticky_posts']    = 1;
                $args['meta_query']             = array();
                $args['orderby']                = 'date';
                $args['order']                  = 'DESC';
                $args['meta_query'][]           = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][]           = $woocommerce->query->visibility_meta_query();
                $args['tax_query'][]              = array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN'
                    )
                );
                break;

            case 'top_rated':
            case 'top_rate':
                $args['meta_key']       = '_wc_average_rating';
                $args['orderby']        = 'meta_value_num';
                $args['order']          = 'DESC';
                break;

            case 'newest':
            case 'recent_product':
                $args['orderby']    = 'date';
                $args['order']      = 'DESC';
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;

            case 'random_product':
            case 'rand':
                $args['orderby']    = 'rand';
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;

            case 'deals':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $args['meta_query'][] =  array(
                    'relation' => 'AND',
                    array(
                        'relation' => 'OR',
                        array(
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                        array(
                            'key'           => '_min_variation_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                    ),
                    array(
                        'key'           => '_sale_price_dates_to',
                        'value'         => time(),
                        'compare'       => '>',
                        'type'          => 'numeric'
                    ),
                );
                break;

            case 'on_sale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                break;
        }

        if( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $args['meta_query'][] =  array(
                'relation' => 'AND',
                array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                )
            );
        }

        $args['tax_query'][] = array(
            'relation' => 'AND',
            array(
               'taxonomy' =>   'product_visibility',
                'field'    =>   'slug',
                'terms'    =>   array('exclude-from-search', 'exclude-from-catalog'),
                'operator' =>   'NOT IN',
            )
        );

        return $args;
    }
}

/** Ajax Elementor Addon puca Product Tabs **/
if ( ! function_exists( 'puca_get_products_tab_ajax' ) ) {
	function puca_get_products_tab_ajax() {
		if ( ! empty( $_POST['atts'] ) ) {
            
			$atts                   = puca_clean( $_POST['atts'] );
            $product_type           = puca_clean( $_POST['value'] );
            $atts['product_type']   = $product_type; 

			$data = puca_elementor_products_ajax_template( $atts );
			echo json_encode( $data );
			die();
		}  
	}
	add_action( 'wp_ajax_puca_get_products_tab_shortcode', 'puca_get_products_tab_ajax' );
	add_action( 'wp_ajax_nopriv_puca_get_products_tab_shortcode', 'puca_get_products_tab_ajax' );
}

/** Ajax Elementor Addon Product Categories Tabs **/
if ( ! function_exists( 'puca_get_products_categories_tab_shortcode' ) ) {
	function puca_get_products_categories_tab_shortcode() {
		if ( ! empty( $_POST['atts'] ) ) {
            
			$atts               = puca_clean( $_POST['atts'] );  
            $categories         = puca_clean( $_POST['value'] );
            $type               = puca_clean( $_POST['type'] );
            $atts['categories'] = $categories;

            if( !empty( $type ) ) $atts['product_type'] = $type;

			$data = puca_elementor_products_ajax_template( $atts );
			echo json_encode( $data );
			die();
		} 
	}
	add_action( 'wp_ajax_puca_get_products_categories_tab_shortcode', 'puca_get_products_categories_tab_shortcode' );
	add_action( 'wp_ajax_nopriv_puca_get_products_categories_tab_shortcode', 'puca_get_products_categories_tab_shortcode' );
}

if ( ! function_exists( 'puca_elementor_products_ajax_template' ) ) {
	function puca_elementor_products_ajax_template( $settings ) {
 
        $loop = $product_type = $orderby = $limit = $order = $attr_row = $cat_operator = $layout_type = $data_carousel = $rows = $columns = $responsive = '';

        extract($settings);    
     
        $loop = puca_get_query_products($categories, $cat_operator, $product_type, $limit, $orderby, $order);

        if ( preg_match('/\\\\/m', $attr_row) ) {
            $attr_row = preg_replace('/\\\\/m', '', $attr_row);
        }  

        $active_theme = puca_tbay_get_part_theme();

		ob_start();  

        if( $loop->have_posts() ) :
            wc_get_template('layout-products/'. $active_theme .'/'. $layout_type .'.php', array( 'loop' => $loop, 'columns' => $columns, 'attr_row' => $attr_row, 'responsive' => $responsive, 'data_carousel' => $data_carousel, 'layout_type' => $layout_type, 'rows' => $rows ));  
        
        endif;

        wc_reset_loop();
		wp_reset_postdata();

        return [
            'html' => ob_get_clean(),
        ];
	}
}

if (! function_exists('puca_has_swatch')) {
    function puca_has_swatch($id, $attr_name, $value)
    {
        $swatches = array();

        $color = $image = $button = '';
        
        $term = get_term_by('slug', $value, $attr_name);
        if (is_object($term)) {
            $color      =   sanitize_hex_color(get_term_meta($term->term_id, 'product_attribute_color', true));
            $image      =   get_term_meta($term->term_id, 'product_attribute_image', true);
            $button      =   $term->name;
        }

        if( $color != '' ) {
            $swatches['color']  = $color;
            $swatches['type']   = 'color';
        } elseif( $image != '' ) {
            $swatches['image']  = $image;
            $swatches['type']   = 'image';
        } else {
            $swatches['button'] = $button;
            $swatches['type']   = 'button';
        }

        return $swatches;
    }
}


if (! function_exists('puca_get_option_variations')) {
    function puca_get_option_variations($attribute_name, $available_variations, $option = false, $product_id = false)
    {
        $swatches_to_show = array();
        foreach ($available_variations as $key => $variation) {
            $option_variation = array();
            $attr_key = 'attribute_' . $attribute_name;
            if (! isset($variation['attributes'][$attr_key])) {
                return;
            }

            $val = $variation['attributes'][$attr_key]; // red green black ..

            if (! empty($variation['image']['thumb_src'])) {
                $option_variation = array(
                    'variation_id' => $variation['variation_id'],
                    'image_src' => $variation['image']['thumb_src'],
                    'image_srcset' => $variation['image']['srcset'],
                    'image_sizes' => $variation['image']['sizes'],
                    'is_in_stock' => $variation['is_in_stock'],
                );
            }

            // Get only one variation by attribute option value
            if ($option) {
                if ($val != $option) {
                    continue;
                } else {
                    return $option_variation;
                }
            } else {
                // Or get all variations with swatches to show by attribute name
                
                $swatch = puca_has_swatch($product_id, $attribute_name, $val);
                $swatches_to_show[$val] = array_merge($swatch, $option_variation);
            }
        }

        return $swatches_to_show;
    }
}


/**
 * ------------------------------------------------------------------------------------------------
 * Show attribute swatches list
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('puca_swatches_list')) {
    function puca_swatches_list($attribute_name = false)
    {
        global $product;

        $id = $product->get_id();

        if (empty($id) || ! $product->is_type('variable')) {
            return false;
        }
        
        if (! $attribute_name) {
            $attribute_name = puca_get_swatches_attribute();
        }
        
        if (empty($attribute_name)) {
            return false;
        }

        $available_variations = $product->get_available_variations();

        if (empty($available_variations)) {
            return false;
        }

        $swatches_to_show = puca_get_option_variations($attribute_name, $available_variations, false, $id);


        if (empty($swatches_to_show)) {
            return false;
        }
 
        $terms = wc_get_product_terms($product->get_id(), $attribute_name, array( 'fields' => 'slugs' ));

        $swatches_to_show_tmp = $swatches_to_show;

        $swatches_to_show = array();

        foreach ($terms as $id => $slug) {
            if (!empty($swatches_to_show_tmp[$slug])) {
                $swatches_to_show[$slug] = $swatches_to_show_tmp[$slug];
            }
        }


        $out = '';
        $out .=  '<div class="tbay-swatches-wrapper"><ul data-attribute_name="attribute_'. $attribute_name .'">';

        foreach ($swatches_to_show as $key => $swatch) {
            $style = $class = '';

            $style .= '';

            $data = '';

            if (isset($swatch['image_src'])) {
                $class .= 'swatch-has-image';
                $data .= 'data-image-src="' . $swatch['image_src'] . '"';
                $data .= ' data-image-srcset="' . $swatch['image_srcset'] . '"';
                $data .= ' data-image-sizes="' . $swatch['image_sizes'] . '"';

                if (! $swatch['is_in_stock']) {
                    $class .= ' variation-out-of-stock';
                }
            }
            

            $term = get_term_by('slug', $key, $attribute_name);
            $slug   = $term->slug;

            $name = '';


            switch ($swatch['type']) {
                case 'color':
                    $style  = 'background-color:' .  $swatch['color'];
                    $class .= ' variable-item-span-color';
                    break;

                case 'image':
                    $img    = wp_get_attachment_image_src( $swatch['image'], 'woocommerce_thumbnail' );
                    $style  = 'background-image: url(' . $img['0'] . ')';
                    $class .= ' variable-item-span-image';
                    break;
                
                case 'button':
                    $name   = $swatch['button'];
                    $class .= ' variable-item-span-label';
                    break;
                
                default:
                    break;
            }


            $out .=  '<li><a href="javascript:void(0)" class="'. $class .' swatch swatch-'. strtolower($slug) .'" style="' . esc_attr($style) .'" ' . $data . '  data-toggle="tooltip">' . $name . '</a></li>';
        }

        $out .=  '</ul></div>';

        return $out;
    }
}


if (! function_exists('puca_get_swatches_attribute')) {
    function puca_get_swatches_attribute()
    {
        $custom = get_post_meta(get_the_ID(), '_puca_attribute_select', true);

        return empty($custom) ? puca_tbay_get_config('variation_swatch') : $custom;
    }
}


/*Hide Variation Selector on HomePage and Shop page*/
if (!function_exists('puca_tbay_woocommerce_enable_variation_swatch')) {
    function puca_tbay_woocommerce_enable_variation_swatch($active)
    {
        $active = puca_tbay_get_config('enable_variation_swatch', false);

        $active = (isset($_GET['variation-selector'])) ? $_GET['variation-selector'] : $active;

        if (class_exists('Woo_Variation_Swatches_Pro') && function_exists('wvs_pro_archive_variation_template')) {
            $active = false;
        }

        return $active;
    }
	add_filter('puca_enable_variation_swatch', 'puca_tbay_woocommerce_enable_variation_swatch');
}

if (! function_exists('puca_tbay_woocommerce_variable')) {

    /**
     * Output the variable product add to cart area.
     *
     * @subpackage  Product
     */
    function puca_tbay_woocommerce_variable()
    {
        global $product;

        $active = apply_filters('puca_enable_variation_swatch', 10, 2);

        if ($product->is_type('variable')  && class_exists('Woo_Variation_Swatches') && $active) {
            ?>

            <?php echo puca_swatches_list() ?>

            <?php
        }
    }
    add_action('woocommerce_before_shop_loop_item_title_2', 'puca_tbay_woocommerce_variable', 15);
}

/*YITH Wishlist*/
if ( ! function_exists( 'puca_custom_wishlist_icon_html' ) ) {
    function puca_custom_wishlist_icon_html($html ) {
        $icon               = get_option( 'yith_wcwl_add_to_wishlist_icon' );
        $custom_icon        = get_option( 'yith_wcwl_add_to_wishlist_custom_icon' );
        $skin = puca_tbay_get_theme();
        if ($skin === 'fashion3') {
            $icon_defalut = 'tb-icon tb-icon-zz-heart';
        } else { 
            $icon_defalut = 'icon-heart';
        }
        if ( ( class_exists('YITH_WCWL') && apply_filters( 'tbay_yith_wcwl_remove_text', true ) ) && 'custom' === $icon && empty($custom_icon) ) {
            return '<i class="'.$icon_defalut.'"></i>';
        } else {
            return $html;
        }
    }
    add_filter( 'yith_wcwl_add_to_wishlist_icon_html', 'puca_custom_wishlist_icon_html', 10, 1 );
}

if ( ! function_exists( 'puca_custom_add_to_wishlist_icon_html' ) ) {
    function puca_custom_add_to_wishlist_icon_html($html ) {
        $icon                       = get_option( 'yith_wcwl_added_to_wishlist_custom_icon' );
        $custom_icon          = get_option( 'yith_wcwl_added_to_wishlist_custom_icon' );
        $skin = puca_tbay_get_theme();
        if ($skin === 'fashion3') {
            $icon_defalut = 'tb-icon tb-icon-zz-heart';
        } else {
            $icon_defalut = 'icon-heart';
        }
        if ( ( class_exists('YITH_WCWL') && apply_filters( 'tbay_yith_wcwl_remove_text', true ) ) && 'custom' === $icon && empty($custom_icon) ) {
            return '<i class="'.$icon_defalut.'"></i>';
        } else { 
            return $html;
        }
    }
    add_filter( 'yith_wcwl_add_to_wishlist_heading_icon_html', 'puca_custom_add_to_wishlist_icon_html', 10, 1 );
}

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
    add_filter('yith_wcwl_remove_from_wishlist_label', 'puca_remove_wishlist_text', 10, 1);
}
if ( ! function_exists( 'puca_quantity_mini_cart' ) ) {

    add_action('wp_ajax_woocommerce_puca_quantity_mini_cart', 'puca_quantity_mini_cart');
    add_action('wp_ajax_nopriv_woocommerce_puca_quantity_mini_cart', 'puca_quantity_mini_cart');
    // WC AJAX can be used for frontend ajax requests.
    add_action('wc_ajax_puca_quantity_mini_cart', 'puca_quantity_mini_cart');
    function puca_quantity_mini_cart() {
        $cart_item_key = $_REQUEST['hash'];

        // Get the array of values owned by the product we're updating
        $product_values = WC()->cart->get_cart_item($cart_item_key);

        // Get the quantity of the item in the cart
        $product_quantity = apply_filters('woocommerce_stock_amount_cart_item', apply_filters('woocommerce_stock_amount', preg_replace("/[^0-9\.]/", '', filter_var($_REQUEST['quantity'], FILTER_SANITIZE_NUMBER_INT))), $cart_item_key);

        // Update cart validation
        $passed_validation  = apply_filters('woocommerce_update_cart_validation', true, $cart_item_key, $product_values, $product_quantity);    

        // Update the quantity of the item in the cart
        if ($passed_validation) {
            WC()->cart->set_quantity($cart_item_key, $product_quantity, true);
        } 

        // Return fragments
        ob_start();
        woocommerce_mini_cart();
        $mini_cart = ob_get_clean();

        // Fragments and mini cart are returned
        $data = array(
            'fragments' => apply_filters(
                'woocommerce_add_to_cart_fragments',
                array(
                    'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
                )
            ), 
            'cart_hash' => apply_filters('woocommerce_cart_hash', WC()->cart->get_cart_for_session() ? md5(json_encode(WC()->cart->get_cart_for_session())) : '', WC()->cart->get_cart_for_session())
        );   
    
        wp_send_json($data);   

        die();
    }
}