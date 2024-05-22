<?php

//remove heading tab single product
if(!function_exists('puca_product_description_heading')){
  add_filter('woocommerce_product_description_heading',
  'puca_product_description_heading');

  function puca_product_description_heading() {
      return '';
  }
}

// share box
if ( !function_exists('puca_tbay_woocommerce_share_box') ) {
    function puca_tbay_woocommerce_share_box() {
      if( !puca_tbay_get_config('enable_code_share',false) || !puca_tbay_get_config('show_product_social_share', false) ) return;

      if( puca_tbay_get_config('select_share_type') === 'custom' ) {
        $image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
        puca_custom_share_code( get_the_title(), get_permalink(), $image );
      } else {
          ?>
            <div class="tbay-woo-share">
              <p><?php esc_html_e('Share: ', 'puca'); ?></p>
              <div class="addthis_inline_share_toolbox"></div>
            </div>
          <?php
      }
      
    }
    add_filter( 'woocommerce_single_product_summary', 'puca_tbay_woocommerce_share_box', 100 );
}


/*Hook class single product*/

// Number of products per page
if ( !function_exists('puca_tbay_woocommerce_class_single_product') ) {
    function puca_tbay_woocommerce_class_single_product($styles) {
        global $product;
        $attachment_ids = $product->get_gallery_image_ids();
        $count = count( $attachment_ids);

        $images_layout   =  apply_filters( 'woo_images_layout_single_product', 10, 2 );

        $active_stick   = '';

        if( isset($images_layout) ) {

          if( isset($count) && $images_layout == 'stick' && ($count > 0) ) {
            $active_stick = 'active-stick';
          }

          switch ($images_layout) {
            case 'vertical-left':
              $styles = 'style-vertical';
              break;                
            case 'vertical-right':
              $styles = 'style-vertical vertical-right';
              break;          
            case 'horizontal-bottom':
              $styles = 'style-horizontal';
              break;             
            case 'horizontal-top':
              $styles = 'style-horizontal horizontal-top';
              break;          
            case 'stick':       
            case 'gallery':
            case 'slide':
            case 'carousel':
              $styles = 'style-'.$images_layout;
              break;
            default:
              $styles = 'style-vertical';
              break;
          }
        }

        $styles .= ' '.$active_stick;

        $cart_style = puca_get_mobile_form_cart_style();

        if ( $product->get_type() == 'external' ) { 
                $cart_style = 'default';
            }
  
        $styles .= ' form-cart-'. $cart_style; 

        return $styles;
    }
    add_filter( 'woo_class_single_product', 'puca_tbay_woocommerce_class_single_product' );
}

/*coder swallow2603*/
if ( !function_exists('puca_tbay_woocommerce_images_layout_product') ) {
    function puca_tbay_woocommerce_images_layout_product($images_layout) {
          $sidebar_configs        = puca_tbay_get_woocommerce_layout_configs();
          $thumbnail_image        = puca_tbay_get_config('thumbnail_image', 'default');

          if ( isset($_GET['thumbnail_image']) ) {
              $images_layout = $_GET['thumbnail_image'];
          }
          elseif($thumbnail_image == 'default' && isset($sidebar_configs['thumbnail'])) {
              $images_layout = $sidebar_configs['thumbnail'];

          }else {
              $images_layout = $thumbnail_image;
          }  

          if( class_exists( 'YITH_WCQV' ) && get_option( 'yith-wcqv-enable', 'yes' ) === 'yes' && YITH_WCQV_Frontend()->yith_is_quick_view() ) {
            return 'quick-view'; 
          }
          
          return $images_layout;
    }
    add_filter( 'woo_images_layout_single_product', 'puca_tbay_woocommerce_images_layout_product' );
}



if ( !function_exists('puca_tbay_woocommerce_tabs_position_product') ) {
    function puca_tbay_woocommerce_tabs_position_product($tabs_position) {

        if ( is_singular( 'product' ) ) {
          $sidebar_configs        = puca_tbay_get_woocommerce_layout_configs();
 
          $single_tabs_position   = puca_tbay_get_config('single_tabs_position', 'default');

          if ( isset($_GET['tabs_position']) ) {
              $tabs_position = $_GET['tabs_position'];
          }
          elseif($single_tabs_position == 'default' && isset($sidebar_configs['tabs_position'])) {
              $tabs_position = $sidebar_configs['tabs_position'];

          }else {
              $tabs_position = $single_tabs_position;
          }  
          
          return $tabs_position;
        }
    }
    add_filter( 'woo_tabs_position_layout_single_product', 'puca_tbay_woocommerce_tabs_position_product' );
}


/**
* Function For Multi Layouts Single Product 
*/
//-----------------------------------------------------
/**
 * Output the product images.
 *
 * @subpackage  Product/images
 */

function woocommerce_show_product_images() { 
    $images_layout   =  apply_filters( 'woo_images_layout_single_product', 10, 2 );
    if( isset($images_layout) ) {
      if( $images_layout === 'quick-view' ) {
        wc_get_template( 'single-product/quick-view-image.php' );
      } else if( $images_layout === 'default' || $images_layout == '' ) {
        wc_get_template( 'single-product/product-image.php' );
      } else {
        wc_get_template( 'single-product/images/product-image-'.$images_layout.'.php' );
      }
    }

}


function woocommerce_show_product_thumbnails() {

  $images_layout   =  apply_filters( 'woo_images_layout_single_product', 10, 2 );


  if( isset($images_layout) ) {

    if( $images_layout == 'default' ||  $images_layout == 'horizontal-top' ||  $images_layout == 'horizontal-bottom' || $images_layout == 'vertical-left' || $images_layout == 'vertical-right' || $images_layout === 'quick-view') {
        wc_get_template( 'single-product/product-thumbnails.php' );
    } else {
        wc_get_template( 'single-product/thumbnails/product-thumbnails-'.$images_layout.'.php' );
    }
  }

}

/**
* Function For Multi Layouts Single Product 
*/
//-----------------------------------------------------
/**
 * Output the product images.
 *
 * @subpackage  Product/images
 */

if ( !function_exists('puca_remove_hook_single_product') ) {
  function puca_remove_hook_single_product() {

      $images_layout   =  apply_filters( 'woo_images_layout_single_product', 10, 2 );

      $tabs_position   =  apply_filters( 'woo_tabs_position_layout_single_product', 10, 2 );

      if( isset($tabs_position) ) {


        switch ($tabs_position) {
            case 'bottom':
                break;          

            case 'right':
                remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );              

                add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 100 );

                wp_enqueue_script( 'hc-sticky' );

                break;

            default:

        }

      }

  }
  add_action('woocommerce_before_single_product', 'puca_remove_hook_single_product',30);
}

/*product tabs right body class*/
if ( ! function_exists( 'puca_woo_product_body_class_tabs_right' ) ) {
  function puca_woo_product_body_class_tabs_right( $classes ) {

    $tabs_position   =  apply_filters( 'woo_tabs_position_layout_single_product', 10, 2 );


    if( isset($tabs_position) && $tabs_position == 'right' ) {
      $classes[] = 'tbay-body-product-tabs-right';
    }

    return $classes;

  }
  add_filter( 'body_class', 'puca_woo_product_body_class_tabs_right',99 );
}



if ( !function_exists('puca_tbay_woocommerce_tabs_style_product') ) {
    function puca_tbay_woocommerce_tabs_style_product($tabs_layout) {

        if ( is_singular( 'product' ) ) {
          $sidebar_configs  = puca_tbay_get_woocommerce_layout_configs();
          $tabs_style       = puca_tbay_get_config('style_single_tabs_style', 'default');

          if ( isset($_GET['tabs_product']) ) {
              $tabs_layout = $_GET['tabs_product'];
          }
          elseif($tabs_style == 'default' && isset($sidebar_configs['tabs'])) {
              $tabs_layout = $sidebar_configs['tabs'];

          }else { 
              $tabs_layout = $tabs_style;
          }  

          return $tabs_layout;
        }
    }
    add_filter( 'woo_tabs_style_single_product', 'puca_tbay_woocommerce_tabs_style_product' );
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
                     data-date="<?php echo gmdate('m', $time_sale).'-'.gmdate('d', $time_sale).'-'.gmdate('Y', $time_sale).'-'. gmdate('H', $time_sale) . '-' . gmdate('i', $time_sale) . '-' .  gmdate('s', $time_sale) ; ?>">
                </div>
              </div> 
            </div> 
        <?php endif; ?> 
        <?php
    }
}

/*product nav*/
if ( !function_exists('puca_render_product_nav') ) {
  function puca_render_product_nav($post, $position){
      if($post){
          $img = '';
          if(has_post_thumbnail($post)){
              $img = get_the_post_thumbnail($post, 'woocommerce_gallery_thumbnail');
          }

          $img_left = $img_right = '';
          if( $position == 'left' ) {
            $img_left = $img;
          } elseif( $position == 'right' ) {
            $img_right = $img;
          }

          $link = get_permalink($post);
          echo "<div class='". esc_attr( $position ) ." psnav'>";
          echo "<a class='img-link' href=". esc_url($link) .">";
           echo trim($img_left);   
          echo "</a>"; 
          echo "  <div class='product_single_nav_inner single_nav'>
                      <a href=". esc_url($link) .">
                          <span class='name-pr'>". esc_html($post->post_title) ."</span>
                      </a>
                  </div>";
          echo "<a class='img-link' href=". esc_url($link) .">";        
            echo trim($img_right);
          echo "</a>"; 
          echo "</div>";
      }
  }
}

if ( !function_exists('puca_woo_product_nav') ) {
  function puca_woo_product_nav(){
        if ( puca_tbay_get_config('show_product_nav', false) ) {
            $prev = get_previous_post();
            $next = get_next_post();

            echo '<div class="product-nav pull-right">';  
            echo '<div class="link-images visible-lg">';
            puca_render_product_nav($prev, 'left');
            puca_render_product_nav($next, 'right');
            echo '</div>';

            echo '</div>';
        }
  }
  add_action( 'woocommerce_before_single_product', 'puca_woo_product_nav', 1 );
}


if(!function_exists('puca_woo_one_page_cart_button_text')){
  function puca_woo_one_page_cart_button_text() {
    return esc_html__( 'Shop Now', 'puca' );
  }
}

if ( !function_exists('puca_tbay_woocommerce_product_menu_bar') ) {
    function puca_tbay_woocommerce_product_menu_bar($menu_bar) {
          $menu_bar   = puca_tbay_get_config('show_product_menu_bar', false);

          if ( isset($_GET['product_menu_bar']) ) {
              $menu_bar = $_GET['product_menu_bar'];
          }

          return $menu_bar;
    }
    add_filter( 'woo_product_menu_bar', 'puca_tbay_woocommerce_product_menu_bar' );
}

/*product one page*/
if(!function_exists('puca_woo_product_single_one_page')){
    if(!wp_is_mobile() ) {
      add_action( 'woocommerce_before_single_product', 'puca_woo_product_single_one_page', 30 );
    }

    function puca_woo_product_single_one_page() {

        $menu_bar   =  apply_filters( 'woo_product_menu_bar', 10, 2 );

        if( isset($menu_bar) && $menu_bar ) {
          global $product;
          $id = $product->get_id();
          wp_enqueue_script( 'jquery-onepagenav' );
          ?>

          <ul id="onepage-single-product" class="nav nav-pills">
            <li class="current"><a href="#main-container"><?php esc_html_e('Product Preview','puca'); ?></a></li>
            <li class="shop-now"><a href="#shop-now"><?php esc_html_e('Shop Now','puca'); ?></a></li>

            <?php if( puca_tbay_get_config('show_product_review_tab', true) ) : ?>
              <li><a href="#woocommerce-tabs"><?php esc_html_e('Reviews','puca'); ?></a></li>
            <?php endif; ?>

            <?php if( puca_tbay_get_config('show_product_releated', true) ) : ?>
              <li><a href="#product-related"><?php esc_html_e('Related products','puca'); ?></a></li>  
            <?php endif; ?>        
          </ul>

          <?php
          
        }
    }
}

/*product one page body class*/
if ( ! function_exists( 'puca_woo_product_body_class_single_one_page' ) ) {
  function puca_woo_product_body_class_single_one_page( $classes ) {

    $menu_bar   =  apply_filters( 'woo_product_menu_bar', 10, 2 );

    if( isset($menu_bar) && $menu_bar ) {
      $classes[] = 'tbay-body-menu-bar';
    }
    return $classes;

  }
  add_filter( 'body_class', 'puca_woo_product_body_class_single_one_page',99 );
}


if(!function_exists('puca_add_product_id_before_add_to_cart_form')){
add_action('woocommerce_before_add_to_cart_button','puca_add_product_id_before_add_to_cart_form', 99);
  function  puca_add_product_id_before_add_to_cart_form() {
      global $product;
      $id = $product->get_id();

      ?> 

      <?php if( intval( puca_tbay_get_config('enable_buy_now', false) ) && $product->get_type() !== 'external' ) : ?>
        <div id="shop-now" class="has-buy-now">
      <?php else: ?> 
        <div id="shop-now">
      <?php endif; ?>

      <?php
  }
}

if(!function_exists('puca_close_after_add_to_cart_form')){
  add_action('woocommerce_after_add_to_cart_button','puca_close_after_add_to_cart_form', 99);
  function  puca_close_after_add_to_cart_form() {
      ?>
        </div>
      <?php
  }
}

/** 
 * remove on single product panel 'Additional Information' since it already says it on tab.
 */
add_filter('woocommerce_product_additional_information_heading', 'puca_supermaket_product_additional_information_heading');
 
function puca_supermaket_product_additional_information_heading() {
    echo '';
}

if(!function_exists('puca_related_products_args')){
  add_filter( 'woocommerce_output_related_products_args', 'puca_related_products_args' );
    function puca_related_products_args( $args ) {

    $args['posts_per_page'] = puca_tbay_get_config('number_product_releated', 4); // 4 related products

    return $args;
  }
}


// define the woocommerce_before_add_to_cart_button callback 
if(!function_exists('puca_action_woocommerce_before_add_to_cart_button')){
  function puca_action_woocommerce_before_add_to_cart_button(  ) { 
      $content = puca_tbay_get_config('html_before_add_to_cart_btn');
      echo do_shortcode($content);
  }
  add_action( 'woocommerce_before_add_to_cart_form', 'puca_action_woocommerce_before_add_to_cart_button', 10, 0 ); 
}
// define the woocommerce_before_add_to_cart_button callback 
if(!function_exists('puca_action_woocommerce_after_add_to_cart_button')){
  function puca_action_woocommerce_after_add_to_cart_button(  ) { 
      $content = puca_tbay_get_config('html_after_add_to_cart_btn');
      echo do_shortcode($content); 
  }
  add_action( 'woocommerce_after_add_to_cart_form', 'puca_action_woocommerce_after_add_to_cart_button', 999, 0 ); 
}

if(!function_exists('puca_action_woocommerce_before_inner_product_summary')){
  function puca_action_woocommerce_before_inner_product_summary(  ) { 
      $content = puca_tbay_get_config('html_before_inner_product_summary');
      echo do_shortcode($content); 
  }
  add_action( 'woocommerce_single_product_summary', 'puca_action_woocommerce_before_inner_product_summary', 1 ); 
}

if(!function_exists('puca_action_woocommerce_after_inner_product_summary')){ 
  function puca_action_woocommerce_after_inner_product_summary(  ) { 
      $content = puca_tbay_get_config('html_after_inner_product_summary');
      echo do_shortcode($content); 
  }
  add_action( 'woocommerce_single_product_summary', 'puca_action_woocommerce_after_inner_product_summary', 999 ); 
}


if(!function_exists('puca_action_woocommerce_after_product_summary')){ 
  function puca_action_woocommerce_after_product_summary(  ) { 
      $content = puca_tbay_get_config('html_after_product_summary');
      echo do_shortcode($content); 
  }
  add_action( 'woocommerce_after_single_product', 'puca_action_woocommerce_after_product_summary', 10 ); 
}

if(!function_exists('puca_action_woocommerce_before_product_summary')){ 
  function puca_action_woocommerce_before_product_summary(  ) { 
      $content = puca_tbay_get_config('html_before_product_summary');
      echo do_shortcode($content); 
  }
  add_action( 'woocommerce_before_single_product', 'puca_action_woocommerce_before_product_summary', 1 ); 
}


/*Add The WooCommerce Total Sales Count*/
if(!function_exists('puca_single_product_add_total_sales_count')){ 
  function puca_single_product_add_total_sales_count() { 
    global $product;

     if( !intval( puca_tbay_get_config('enable_total_sales', true) ) || $product->get_type() === 'external' || $product->get_type() === 'grouped' )  return;

    $count = (float) get_post_meta($product->get_id(),'total_sales', true); 

    $text = sprintf( '<span class="rate-sold"><span class="count">%s</span> <span class="sold-text">%s</span></span>',
        number_format_i18n($count),
        esc_html__('sold', 'puca')
    );

    echo trim($text);
  }
  add_action( 'puca_woo_after_single_rating', 'puca_single_product_add_total_sales_count', 10 ); 
}

if(!function_exists('puca_woocommerce_buy_now')){
  function puca_woocommerce_buy_now(  ) { 
        global $product;
        if ( ! intval( puca_tbay_get_config('enable_buy_now', false) ) ) {
            return; 
        }

        if ( $product->get_type() == 'external' ) { 
            return;
        }

        $class = 'tbay-buy-now button';

        if( !empty($product) && $product->is_type( 'variable' ) ){
            $default_attributes = puca_get_default_attributes( $product );
            $variation_id = puca_find_matching_product_variation( $product, $default_attributes );

            if( empty($variation_id) ) {
                $class .= ' disabled';
            } 
        }
 
        echo sprintf( '<button class="'. $class .'">%s</button>', esc_html__('Buy Now', 'puca') );
        echo '<input type="hidden" value="0" name="puca_buy_now" />';
  } 
  add_action( 'woocommerce_after_add_to_cart_button', 'puca_woocommerce_buy_now', 8 ); 
}

if ( !function_exists('puca_photo_reviews_thumbnail_image') ) {
  function puca_photo_reviews_thumbnail_image() {
    $thumbnail_cropping    	= get_option( 'puca_photo_reviews_thumbnail_image_cropping', 'yes');
    $cropping    			= ($thumbnail_cropping == 'yes') ? true : false;

    return array(
        'width'  => get_option( 'puca_photo_reviews_thumbnail_image_width', 100),
        'height' => get_option( 'puca_photo_reviews_thumbnail_image_height', 100),
        'crop'   => $cropping,
    );		
  }
}

if ( !function_exists('puca_woocommerce_photo_reviews_reduce_array') ) {
  function puca_woocommerce_photo_reviews_reduce_array( $reduce ) {

    array_push($reduce,'tbay_photo_reviews_thumbnail_image');

    return $reduce;

  }

  add_filter('woocommerce_photo_reviews_reduce_array', 'puca_woocommerce_photo_reviews_reduce_array', 10 ,1);
}

/*Photo Reviews Size*/
if(!function_exists('puca_photo_reviews_thumbnail_photo_size')){ 
  function puca_photo_reviews_thumbnail_photo_size($image_src, $image_post_id) { 
    $img_src     = wp_get_attachment_image_src($image_post_id, 'tbay_photo_reviews_thumbnail_image');

    return $img_src[0];
  }
  add_filter( 'woocommerce_photo_reviews_thumbnail_photo', 'puca_photo_reviews_thumbnail_photo_size', 10, 2 );
}

if(!function_exists('puca_photo_reviews_large_photo_size')){ 
  function puca_photo_reviews_large_photo_size($image_src, $image_post_id) { 
    $img_src     = wp_get_attachment_image_src($image_post_id, 'full');

    return $img_src[0];
  }
  add_filter( 'woocommerce_photo_reviews_large_photo', 'puca_photo_reviews_large_photo_size', 10, 2 );
}

/*The list images review*/
if ( ! function_exists( 'puca_tbay_the_list_images_review' ) ) {
  function puca_tbay_the_list_images_review() {
      global $product;

      if ( ! is_product() || ( ! class_exists( 'VI_Woo_Photo_Reviews' ) && ! class_exists( 'VI_WooCommerce_Photo_Reviews' ) ) ) {
          return;
      }

      wp_enqueue_script('jquery-magnific-popup');
      wp_enqueue_style('magnific-popup');

      $product_title = $product->get_title();
      $product_single_layout  =   puca_tbay_get_product_single_layout();
      $args     = array(
          'post_type'    => 'product',
          'type'         => 'review',
          'status'       => 'approve',
          'post_id'      => $product->get_id(),
          'meta_key'     => 'reviews-images'
      ); 

      $comments = get_comments( $args );
      $skin = puca_tbay_get_theme();
      if (is_array($comments) || is_object($comments)) {
          $outputs = '<div id="list-review-images">';
          
          if ($skin !='fashion3') {
            $outputs .= '<h4>'. esc_html__('Images from customers:', 'puca') .'</h4>';
          } 
          $outputs .= '<ul id="imageReview" class="collapse in">';

          $i = 0;
          foreach ( $comments as $comment ) {
            $comment_id     = $comment->comment_ID;
            $image_post_ids = get_comment_meta($comment_id, 'reviews-images', true);
            $content        = get_comment( $comment_id )->comment_content;
            $author         = '<span class="author">'. get_comment( $comment_id )->comment_author .'</span>';
            $rating         = intval( get_comment_meta( $comment_id, 'rating', true ) );

            if ( $rating && wc_review_ratings_enabled() ) {
                $rating_content = wc_get_rating_html( $rating );
            } else {
                $rating_content = '';
            } 

            $caption = '<span class="header-comment">' . $rating_content . $author . '</span><span class="title-comment">'. $content .'</span>';

              if (is_array($image_post_ids) || is_object($image_post_ids)) {
                  foreach ( $image_post_ids as $image_post_id ) {
                      if ( ! wc_is_valid_url( $image_post_id ) ) {
                          $image_data = wp_get_attachment_metadata($image_post_id);
                          $alt        = get_post_meta( $image_post_id, '_wp_attachment_image_alt', true );
                          $image_alt  = $alt ? $alt : $product_title;

                          $width 		= $image_data['width'];
                          $height 	= $image_data['height'];

                          $img_src = apply_filters( 'woocommerce_photo_reviews_thumbnail_photo', wp_get_attachment_thumb_url( $image_post_id ), $image_post_id, $comment );

                          $img_src_open = apply_filters( 'woocommerce_photo_reviews_large_photo', wp_get_attachment_thumb_url( $image_post_id ), $image_post_id, $comment );

                          $outputs .= '<li class="review-item"><a class="review-gallery" data-caption="'. esc_attr($caption) .'" data-width="'. esc_attr($width) .'" data-height="'. esc_attr($height) .'"  href="'. esc_url($img_src_open) .'"><img class="review-images"
                          src="' . esc_url($img_src) .'" alt="'. apply_filters( 'woocommerce_photo_reviews_image_alt', $image_alt, $image_post_id, $comment ) .'"/></a></li>';

                          $i++;
                      }
                  }
              }
          } 

          $more = '';

          if ( ( ($product_single_layout === 'left-main') || ($product_single_layout === 'main-right') ) && ($i > 4) ) {
              $i      = $i - 4;
              $more   = '<div class="more">'. $i .'+</div>';
          }
          elseif ($i > 6) {
              $i      = $i - 6;
              $more   = '<div class="more">'. $i .'+</div>';
          }

          $outputs .= $more;

          $outputs .= '</ul>';
          if ($skin === 'fashion3') {
            $outputs .= '<a  data-toggle="collapse" href="#imageReview" class="toogle-img-review"> '. $i. esc_html__(' Images from purchased customers', 'puca') .'</a>';
          } 
          $outputs .= '</div>';
      }

      if( $i === 0 ) {
          return;
      }

      echo trim($outputs);
  }
  add_action( 'woocommerce_before_single_product_summary', 'puca_tbay_the_list_images_review', 100 );
}

if ( !function_exists( 'puca_get_photo_reviews_thumbnail_size' ) ) {
	function puca_get_photo_reviews_thumbnail_size($image_src, $image_post_id) {
		$img_src     = wp_get_attachment_image_src($image_post_id, 'puca_photo_reviews_thumbnail_image');

		return $img_src[0];
	}
	add_filter( 'woocommerce_photo_reviews_thumbnail_photo', 'puca_get_photo_reviews_thumbnail_size', 10, 2 );
}

if ( !function_exists( 'puca_get_photo_reviews_large_size' ) ) {
	function puca_get_photo_reviews_large_size($image_src, $image_post_id) {
		$img_src     = wp_get_attachment_image_src($image_post_id, 'full');

		return $img_src[0];
	}
	add_filter( 'woocommerce_photo_reviews_large_photo', 'puca_get_photo_reviews_large_size', 10, 2 );
}

if ( !function_exists( 'puca_photo_reviews_reduce_array' ) ) {
	function puca_photo_reviews_reduce_array( $reduce ) {
		array_push($reduce,'puca_photo_reviews_thumbnail_image');
		return $reduce;
	}
		/** Change size image photo reivew */
	add_filter('woocommerce_photo_reviews_reduce_array', 'puca_photo_reviews_reduce_array', 10 ,1);
}

if ( !function_exists( 'puca_mobile_add_add_to_cart_button_content' ) ) {
	function puca_mobile_add_add_to_cart_button_content() {
		if( apply_filters( 'puca_catalog_mode', 10,2 ) ) return;

		global $product;
		?>
		<div id="mobile-close-infor"><i class="icon-close icons"></i></div>
		<div class="mobile-infor-wrapper">
			<div class="media">
				<div class="media-left">
					<?php echo trim($product->get_image('woocommerce_gallery_thumbnail')); ?>
				</div>
				<div class="media-body">
					<div class="infor-body">
						<?php puca_mobile_infor_body( $product ); ?>
					</div> 
				</div>
			</div>
		</div>
		<?php
	}	 
}	 

if ( !function_exists( 'puca_mobile_infor_body' ) ) {
function puca_mobile_infor_body( $product ) {
    puca_mobile_infor_body_content( $product );
  }
}

if ( !function_exists( 'puca_mobile_infor_body_content' ) ) {
  function puca_mobile_infor_body_content( $product ) {
      echo '<p class="price">'. trim($product->get_price_html()) . '</p>'; 
      echo wc_get_stock_html( $product );
  }
}

if ( !function_exists( 'puca_mobile_add_before_add_to_cart_button' ) ) {
	function puca_mobile_add_before_add_to_cart_button( ) {
		if( !is_product() || apply_filters( 'puca_catalog_mode', 10,2 ) ) return;

		if( puca_get_mobile_form_cart_style() === 'default' ) return;
		
		global $product;
		 
	  if ( $product->get_type() !== 'simple' ) return;

		puca_mobile_add_add_to_cart_button_content();
	}

	add_action( 'woocommerce_before_add_to_cart_button', 'puca_mobile_add_before_add_to_cart_button', 10, 1 );
}


if ( !function_exists( 'puca_mobile_add_before_variations_form' ) ) {
	function puca_mobile_add_before_variations_form( ) {
		if( !is_product() || apply_filters( 'puca_catalog_mode', 10,2 ) ) return;

		if( puca_get_mobile_form_cart_style() === 'default' ) return;

		puca_mobile_add_add_to_cart_button_content();
	}
	add_action( 'woocommerce_before_variations_form', 'puca_mobile_add_before_variations_form', 10, 1 ); 
}


if ( !function_exists( 'puca_mobile_before_grouped_product_list' ) ) {
	function puca_mobile_before_grouped_product_list( ) {
		if( !is_product() || apply_filters( 'puca_catalog_mode', 10,2 ) ) return;

		if( puca_get_mobile_form_cart_style() === 'default' ) return;

		global $product;
		 
	    if ( $product->get_type() !== 'grouped' ) return;

		puca_mobile_add_add_to_cart_button_content();
	}
	add_action( 'woocommerce_grouped_product_list_before', 'puca_mobile_before_grouped_product_list', 10, 1 );
}


if ( !function_exists( 'puca_mobile_add_btn_after_add_to_cart_form' ) ) {
	function puca_mobile_add_btn_after_add_to_cart_form() {
		if( !is_product() || apply_filters( 'puca_catalog_mode', 10,2 ) ) return;

		if( puca_get_mobile_form_cart_style() === 'default' ) return;

		global $product;

	    if ( $product->get_type() == 'external' ) { 
	        return;
		}

		$class = '';
		if( puca_tbay_get_config('enable_buy_now', false) ) {
			$class .= ' has-buy-now';
		}  
		
		?>
		<div id="mobile-close-infor-wrapper"></div>
		<div class="mobile-btn-cart-click <?php echo esc_attr($class); ?>">
			<div id="tbay-click-addtocart"><?php esc_html_e('Add to cart', 'puca') ?></div>
			<?php if( puca_tbay_get_config('enable_buy_now', false) ) : ?>
				<div id="tbay-click-buy-now"><?php esc_html_e('Buy Now', 'puca') ?></div>
			<?php endif; ?> 
		</div>
		<?php
	}
	add_action( 'woocommerce_after_add_to_cart_form', 'puca_mobile_add_btn_after_add_to_cart_form', 10, 1 ); 
}


if ( !function_exists( 'puca_mobile_add_before_add_to_cart_form' ) ) {
	function puca_mobile_add_before_add_to_cart_form( ) {
		if( !is_product() || apply_filters( 'puca_catalog_mode', 10,2 ) ) return;

		if( puca_get_mobile_form_cart_style() === 'default' ) return;

		global $product;
		if( !$product->is_type( 'variable' ) ) return; 

		$attributes = $product->get_variation_attributes();
		$selected_attributes 	= $product->get_default_attributes();
		if( sizeof( $attributes ) === 0 ) return;

		$default_attributes = $names = array();

		foreach ( $attributes as $key => $value ) {
			array_push($names, wc_attribute_label( $key ));

			if( isset($selected_attributes[$key]) && !empty($selected_attributes[$key]) )  {
				$default = get_term_by('slug', $selected_attributes[$key], $key)->name;
			} else {   
				$default = esc_html__('Choose an option ', 'puca');
			}

			array_push($default_attributes, $default);
		}
		
		?>
		<div class="mobile-attribute-list">
			<div class="list-wrapper">
				<div class="name">
					<?php echo esc_html(implode( ', ', $names )); ?>
				</div>
				<div class="value">
					<?php echo esc_html(implode( '/ ', $default_attributes )); ?>
				</div>
			</div>
			<div id="attribute-open"><i class="icon-arrow-right icons"></i></div>
		</div>
		<?php
	}
	add_action( 'woocommerce_before_add_to_cart_form', 'puca_mobile_add_before_add_to_cart_form', 20, 1 ); 
}

if ( !function_exists( 'puca_product_popup_group_buttons' ) ) {
  add_action( 'woocommerce_single_product_summary', 'puca_product_popup_group_buttons', 35 );
  function puca_product_popup_group_buttons()
  {
      global $product; 
      
      $product_id = method_exists($product, 'get_id') === true ? $product->get_id() : $product->ID;

      if( !puca_product_active_button_popup_groups($product_id) ) return; 
      ?>
      <ul class="tbay-button-popup-wrap">
        <?php 
          puca_the_size_guide($product_id); 
          puca_the_delivery_return($product_id);
          puca_the_aska_question($product_id);
        ?>
      </ul>
    <?php
  }
}