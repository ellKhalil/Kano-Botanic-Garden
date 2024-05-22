<?php 

if ( !function_exists('puca_tbay_private_size_image_setup') ) {
	function puca_tbay_private_size_image_setup() {

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		*/

		update_option('puca_avatar_post_carousel', 100, 100, true);
		add_image_size('puca_avatar_post_carousel', 100, 100, true); //(cropped)

		if( !puca_tbay_get_global_config('config_media',false) ) {
			// Post Thumbnails Size
			set_post_thumbnail_size(570, 320, true); // Unlimited height, soft crop
			update_option('thumbnail_size_w', 570);
			update_option('thumbnail_size_h', 320);						

			update_option('medium_size_w', 370);
			update_option('medium_size_h', 270);
			add_image_size( 'medium', 370, 270, true );
		}

	}
	add_action( 'after_setup_theme', 'puca_tbay_private_size_image_setup' );
}

if ( !function_exists('puca_tbay_private_menu_setup') ) {
	function puca_tbay_private_menu_setup() {

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary' 		=> esc_html__( 'Primary Menu', 'puca' ),
			'mobile-menu' 	=> esc_html__( 'Mobile Menu','puca' ),
			'topmenu'  		=> esc_html__( 'Top Menu', 'puca' ),
			'nav-account'  	=> esc_html__( 'Nav Account', 'puca' ),
			'footer-menu'  	=> esc_html__( 'Footer Menu', 'puca' ),
			'category-menu'  	=> esc_html__( 'Categories Menu', 'puca' ),
			'category-menu-image'  	=> esc_html__( 'Categories Menu Image', 'puca' )
		) );

	}
	add_action( 'after_setup_theme', 'puca_tbay_private_menu_setup' );
}

/**
 *  Include Load Google Front
 */

if ( !function_exists('puca_fonts_url') ) {
	function puca_fonts_url() {
		/**
		 * Load Google Front
		 */

	    $fonts_url = '';

	    /* Translators: If there are characters in your language that are not
	    * supported by Montserrat, translate this to 'off'. Do not translate
	    * into your own language.
	    */
	    $Lato 		= _x( 'on', 'Lato font: on or off', 'puca' );
	    $abril    	= _x( 'on', 'Abril Fatface font: on or off', 'puca' );
	 
	    if ( 'off' !== $Lato ) {
	        $font_families = array();
	 
	        if ( 'off' !== $Lato ) {
	            $font_families[] = 'Lato:100,100i,300,300i,400,400i,700,700i,900,900i';
	        }
			
	 		if ( 'off' !== $abril ) {
	            $font_families[] = 'Abril+Fatface';
	        }
	 		
	        $query_args = array(
	            'family' => ( implode( '%7C', $font_families ) ),
	            'subset' => urlencode( 'latin,latin-ext' ),
	            'display' => urlencode( 'swap' ),
	        );
	 		
	 		$protocol = is_ssl() ? 'https:' : 'http:';
	        $fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
	    }
	 
	    return esc_url_raw( $fonts_url );
	}
}

if ( !function_exists('puca_tbay_fonts_url') ) {
	function puca_tbay_fonts_url() {  
		$protocol 		  = is_ssl() ? 'https:' : 'http:';
		$show_typography  = puca_tbay_get_config('show_typography', false);
		$font_source 	  = puca_tbay_get_config('font_source', "1");
		$font_google_code = puca_tbay_get_config('font_google_code');
		if( !$show_typography ) {
			wp_enqueue_style( 'puca-theme-fonts', puca_fonts_url(), array(), null );
		} else if ( $font_source == "2" && !empty($font_google_code) ) {
			wp_enqueue_style( 'puca-theme-fonts', $font_google_code, array(), null );
		}
	}
	add_action('wp_enqueue_scripts', 'puca_tbay_fonts_url');
}

/**
 * Register Sidebar
 *
 */
if ( !function_exists('puca_tbay_widgets_init') ) {
	function puca_tbay_widgets_init() {

		register_sidebar( array(
			'name'          => esc_html__( 'Top Shipping', 'puca' ),
			'id'            => 'top-shipping',
			'description'   => esc_html__( 'Add widgets here to appear in Top Shipping.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );		    	
		
		register_sidebar( array(
			'name'          => esc_html__( 'Top Contact', 'puca' ),
			'id'            => 'top-contact',
			'description'   => esc_html__( 'Add widgets here to appear in Top Contact.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Product Top Shop Full Width', 'puca' ),
			'id'            => 'product-top-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );				

		register_sidebar( array(
			'name'          => esc_html__( 'Product Top Shop Multi Viewed', 'puca' ),
			'id'            => 'product-top-multi-viewed-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Product Canvas Sidebar', 'puca' ),
			'id'            => 'product-canvas-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );				

		register_sidebar( array(
			'name'          => esc_html__( 'Blog Top Search Sidebar Left,Right Main v4,v5', 'puca' ),
			'id'            => 'blog-top-search',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );					

		register_sidebar( array(
			'name'          => esc_html__( 'Blog Top Sidebar Left,Right Main v4', 'puca' ),
			'id'            => 'blog-top-sidebar1',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );				

		register_sidebar( array(
			'name'          => esc_html__( 'Blog Top Sidebar Left,Right Main v5', 'puca' ),
			'id'            => 'blog-top-sidebar2',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Blog Main V4,5 left sidebar', 'puca' ),
			'id'            => 'blog-left-sidebar-45',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		
		register_sidebar( array(
			'name'          => esc_html__( 'Blog Main V4,5 right sidebar', 'puca' ),
			'id'            => 'blog-right-sidebar-45',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar Default', 'puca' ),
			'id'            => 'sidebar-default',
			'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		
		register_sidebar( array(
			'name'          => esc_html__( 'Blog left sidebar', 'puca' ),
			'id'            => 'blog-left-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Blog right sidebar', 'puca' ),
			'id'            => 'blog-right-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Product left sidebar', 'puca' ),
			'id'            => 'product-left-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Product right sidebar', 'puca' ),
			'id'            => 'product-right-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer', 'puca' ),
			'id'            => 'footer',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'puca' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		
	}
	add_action( 'widgets_init', 'puca_tbay_widgets_init' );
}

if ( !function_exists( 'puca_tbay_autocomplete_search' ) ) { 
    function puca_tbay_autocomplete_search() {
    	wp_enqueue_script('jquery-ui-autocomplete');
        if ( puca_tbay_get_global_config('autocomplete_search') ) {
            add_action( 'wp_ajax_puca_autocomplete_search', 'puca_tbay_autocomplete_suggestions' );
            add_action( 'wp_ajax_nopriv_puca_autocomplete_search', 'puca_tbay_autocomplete_suggestions' );
        }
    }
}
add_action( 'init', 'puca_tbay_autocomplete_search' );

if ( !function_exists( 'puca_tbay_autocomplete_suggestions' ) ) {
    function puca_tbay_autocomplete_suggestions() {
		// Query for suggestions
		$search_keyword  = $_REQUEST['term'];

		$args = array(
		    's'                   => $search_keyword,
		    'post_status'         => 'publish',
		    'orderby'         	  => 'relevance',
		    'posts_per_page'      => -1,
		    'ignore_sticky_posts' => 1,
		    'suppress_filters'    => false,
		);

		if ( isset($_REQUEST['post_type']) && $_REQUEST['post_type'] != 'all') {
        	$args['post_type'] = $_REQUEST['post_type'];
        } 

        if( isset($_REQUEST['post_type']) && $_REQUEST['post_type'] !== 'post' && class_exists( 'WooCommerce' ) ) {
			$args['meta_query'] = WC()->query->get_meta_query();
			$args['tax_query'] 	= WC()->query->get_tax_query();

			if ( apply_filters( 'puca_search_query_in', puca_tbay_get_config('search_query_in', 'title') === 'all' ) ) {
                add_filter( 'posts_search', 'puca_product_ajax_search_sku', 9 );
            } else {
                add_filter('posts_search', 'puca_product_search_title', 20, 2);
            }
		}

		if ( class_exists( 'WooCommerce' ) && isset($_REQUEST['post_type']) && $_REQUEST['post_type'] == 'product'  ) {
			
			$product_visibility_term_ids = wc_get_product_visibility_term_ids();
			$args['tax_query']['relation'] = 'AND';

			$args['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => $product_visibility_term_ids['exclude-from-search'],
				'operator' => 'NOT IN',
			); 
			
            if ( ! empty( $_REQUEST['category'] ) ) {
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => strip_tags( $_REQUEST['category'] ),
                );
            }
		}


		$posts = get_posts( $args );

		$style = '';    
		if ( isset($_REQUEST['style']) ) {
		    $style  = $_REQUEST['style'];
		}
        $suggestions = array();
        $show_image = puca_tbay_get_config('show_search_product_image', true);
        $show_price = puca_tbay_get_config('search_type') == 'product' ? puca_tbay_get_config('show_search_product_price') : false;
        $number 	= puca_tbay_get_config('search_max_number_results', 5); 
        global $post;
        $count = count($posts);
        
        $view_all = ( ($count - $number ) > 0 ) ? true : false;
        $index = 0;
        foreach ($posts as $post): setup_postdata($post);
            
            if( $index == $number ) break;

            $suggestion = array();
            $suggestion['label'] = esc_html($post->post_title);
            $suggestion['style'] = $style;
            $suggestion['link'] = get_permalink();
            $suggestion['result'] = $count.' '. esc_html__('result found with', 'puca') .' "'.$search_keyword.'" ';

            $suggestion['view_all'] = $view_all;

            if ( $show_image && has_post_thumbnail( $post->ID ) ) {
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'woocommerce_thumbnail' );
                $suggestion['image'] = $image[0];
            } else {
                $suggestion['image'] = '';
            }
            if ( $show_price ) {
            	$product = new WC_Product( get_the_ID() );
                $suggestion['price'] = $product->get_price_html();
            } else {
                $suggestion['price'] = '';
            }

			if( isset($_REQUEST['post_type']) && $_REQUEST['post_type'] === 'product' ) {
				$suggestion['sku'] = ( puca_tbay_get_config('search_query_in', 'title') === 'all' && puca_tbay_get_config('search_sku_ajax', false) && $product->get_sku() ) ? esc_html__( 'SKU:', 'puca' ) . ' ' . $product->get_sku() : '';
			}

            $suggestions[]= $suggestion;

            $index++;
        endforeach;
        $response = esc_html($_GET["callback"]) . "(" . json_encode($suggestions) . ")";
        echo trim($response);
     
        exit;
    }
}

// Change Product Buttons
function puca_product_buttons(){
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
add_action('woocommerce_after_add_to_cart_button', 'puca_product_buttons', 10);

if ( !function_exists('puca_tbay_get_blog_layout_configs') ) {
	function puca_tbay_get_blog_layout_configs() {
		$page = 'archive';
		if ( is_singular( 'post' ) ) {
            $page = 'single';
    } else {
			$left2 = puca_tbay_get_config('blog_'.$page.'_left_sidebar45');
			$right2 = puca_tbay_get_config('blog_'.$page.'_right_sidebar45'); 	
    }

		$left = puca_tbay_get_config('blog_'.$page.'_left_sidebar');
		$right = puca_tbay_get_config('blog_'.$page.'_right_sidebar');



		if ( !is_singular( 'post' ) ) {

				$blog_archive_layout =  ( isset($_GET['blog_archive_layout']) )  ? $_GET['blog_archive_layout'] : puca_tbay_get_config('blog_archive_layout', 'main-v1');
				if( isset($blog_archive_layout) ) {

	        	switch ( $blog_archive_layout ) {
							case 'main-v1':
						 		$configs['main'] 						= array( 'class' => 'style-grid archive-full' );
						 		$configs['columns'] 				= 3;
						 		$configs['image_sizes'] 		= 'post-thumbnail';
						 		break;							 	
						 	case 'main-v2':
						 		$configs['main'] 						= array( 'class' => 'style-grid archive-full style-center' );
						 		$configs['columns'] 				= 1;
						 		$configs['image_sizes'] 		= 'full';
						 		break;							 	
						 	case 'main-v3':
						 		$configs['main'] 						= array( 'class' => 'archive-full' );
						 		$configs['columns'] 				= 2;
						 		$configs['image_sizes'] 		= 'post-thumbnail';
						 		break;							 	
						 	case 'main-v4':
						 		$configs['main'] 						= array( 'class' => 'archive-full' );
						 		$configs['container_full'] 	= true;
						 		$configs['columns'] 				= 4;
						 		$configs['image_sizes'] 		= 'post-thumbnail';
						 		break;							 	
						 	case 'left-main-v1':
						 		$configs['left'] = array( 'sidebar' => $left, 'class' => 'col-xs-12 col-md-12 col-lg-4'  );
						 		$configs['main'] 										= array( 'class' => 'style-grid col-xs-12 col-md-12 col-lg-8' );
						 		$configs['columns'] 								= 2;
						 		$configs['image_sizes'] 						= 'post-thumbnail';
						 		break;							 	
						 	case 'main-right-v1':
						 		$configs['right'] 			= array( 'sidebar' => $right,  'class' => 'col-xs-12 col-md-12 col-lg-4' ); 
						 		$configs['main'] 				= array( 'class' => 'style-grid col-xs-12 col-md-12 col-lg-8' );
						 		$configs['columns'] 				= 2;
						 		$configs['image_sizes'] 		= 'post-thumbnail';
						 		break;			
						 	case 'left-main-v2':
						 		$configs['left'] 						= array( 'sidebar' => $left, 'class' => 'col-xs-12 col-md-12 col-lg-4'  );
						 		$configs['main'] 						= array( 'class' => 'style-grid style-center col-xs-12 col-md-12 col-lg-8' );
						 		$configs['columns'] 				= 1;
						 		$configs['image_sizes'] 		= 'full';
						 		break;		
						 	case 'main-right-v2':
						 		$configs['right'] 					= array( 'sidebar' => $right,  'class' => 'col-xs-12 col-md-12 col-lg-4' ); 
						 		$configs['main'] 						= array( 'class' => 'style-grid style-center col-xs-12 col-md-12 col-lg-8' );
						 		$configs['columns'] 				= 1;
						 		$configs['image_sizes'] 		= 'full';
						 		break;							 	
						 	case 'left-main-v3':
						 		$configs['left'] 						= array( 'sidebar' => $left, 'class' => 'col-xs-12 col-md-12 col-lg-4'  );
						 		$configs['main'] 						= array( 'class' => 'style-list col-xs-12 col-md-12 col-lg-8' );
						 		$configs['columns'] 				= 1;
						 		$configs['image_sizes'] 		= 'post-thumbnail';
						 		break;		
						 	case 'main-right-v3':
						 		$configs['right'] 					= array( 'sidebar' => $right,  'class' => 'col-xs-12 col-md-12 col-lg-4' ); 
						 		$configs['main'] 						= array( 'class' => 'style-list col-xs-12 col-md-12 col-lg-8' );
						 		$configs['columns'] 				= 1;
						 		$configs['image_sizes'] 		= 'post-thumbnail';
								break;
						 	case 'left-main-v4':
						 		$configs['left'] 						= array( 'sidebar' => $left2, 'class' => 'col-xs-12 col-md-12 col-lg-4'  );
						 		$configs['main']	 						= array( 'class' => 'style-gird col-xs-12 col-md-12 col-lg-8' );
						 		$configs['blog_top_sidebar1'] 	= true;
						 		$configs['blog_top_search'] 	= true;
						 		$configs['columns'] 					= 2;
						 		$configs['image_sizes'] 			= 'post-thumbnail';	
						 		break;		
						 	case 'main-right-v4':
						 		$configs['right'] 						= array( 'sidebar' => $right2,  'class' => 'col-xs-12 col-md-12 col-lg-4' ); 
						 		$configs['main'] 							= array( 'class' => 'style-gird col-xs-12 col-md-12 col-lg-8' );
						 		$configs['blog_top_sidebar1'] 	= true;
						 		$configs['blog_top_search'] 	= true;
						 		$configs['columns'] 					= 2;
						 		$configs['image_sizes'] 			= 'post-thumbnail';	
						 		break;								 	
						 	case 'left-main-v5':
						 		$configs['left'] 							= array( 'sidebar' => $left2, 'class' => 'col-xs-12 col-md-12 col-lg-4'  );
						 		$configs['main'] 							= array( 'class' => 'col-xs-12 col-md-12 col-lg-8' );
						 		$configs['blog_top_sidebar2'] = true;
						 		$configs['blog_top_search'] 	= true;
						 		$configs['columns'] 					= 2;
						 		$configs['image_sizes'] 			= 'post-thumbnail';	
						 		break;		
						 	case 'main-right-v5':
						 		$configs['right'] 						= array( 'sidebar' => $right2,  'class' => 'col-xs-12 col-md-12 col-lg-4' ); 
						 		$configs['main'] 							= array( 'class' => 'col-xs-12 col-md-12 col-lg-8' );
						 		$configs['blog_top_sidebar2'] = true;
						 		$configs['blog_top_search'] 	= true;
						 		$configs['columns'] 					= 2;
						 		$configs['image_sizes'] 			= 'post-thumbnail';	
						 		break;		
						 	default:
						 		$configs['main'] = array( 'class' => 'archive-full' );
						 		break;
	        }

	      }

		} else {

				$blog_single_layout =	( isset($_GET['blog_single_layout']) ) ? $_GET['blog_single_layout']  :  puca_tbay_get_config('blog_single_layout', 'left-main');

				if( isset($blog_single_layout) ) {

					switch ( $blog_single_layout ) {
					 	case 'left-main':
					 		$configs['left'] = array( 'sidebar' => $left, 'class' => 'col-xs-12 col-md-12 col-lg-4'  );
					 		$configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-8' );
					 		break;
					 	case 'main-right':
					 		$configs['right'] = array( 'sidebar' => $right,  'class' => 'col-xs-12 col-md-12 col-lg-4' ); 
					 		$configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-8' );
					 		break;
				 		case 'main':
				 			$configs['main'] = array( 'class' => 'col-xs-12 col-md-12' );
				 			break;
			 			case 'left-main-right':
			 				$configs['left'] = array( 'sidebar' => $left,  'class' => 'col-xs-12 col-md-12 col-lg-4'  );
					 		$configs['right'] = array( 'sidebar' => $right, 'class' => 'col-xs-12 col-md-12 col-lg-4' ); 
					 		$configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-4' );
			 				break;
					 	default:
					 		$configs['main'] = array( 'class' => 'col-xs-12 col-md-12' );
					 		break;
					 }

				}
		}


		return $configs; 
	}
}