<?php
/**
 * puca functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Puca
 * @since Puca 1.5
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Puca 1.5
 */
define( 'PUCA_THEME_VERSION', '1.5' );

/**
 * ------------------------------------------------------------------------------------------------
 * Define constants.
 * ------------------------------------------------------------------------------------------------
 */
define( 'PUCA_THEME_DIR', 		get_template_directory_uri() );
define( 'PUCA_THEMEROOT', 		get_template_directory() );
define( 'PUCA_IMAGES', 			PUCA_THEME_DIR . '/images' );
define( 'PUCA_SCRIPTS', 		PUCA_THEME_DIR . '/js' );
define( 'PUCA_SCRIPTS_SKINS', 	PUCA_SCRIPTS . '/skins' );
define( 'PUCA_STYLES', 			PUCA_THEME_DIR . '/css' );
define( 'PUCA_STYLES_SKINS', 	PUCA_STYLES . '/skins' );

define( 'PUCA_INC', 				'/inc' );
define( 'PUCA_MERLIN', 				PUCA_INC . '/merlin' );
define( 'PUCA_CLASSES', 			PUCA_INC . '/classes' );
define( 'PUCA_VENDORS', 			PUCA_INC . '/vendors' );
define( 'PUCA_ELEMENTOR', 		         PUCA_THEMEROOT . '/inc/vendors/elementor' );
define( 'PUCA_ELEMENTOR_TEMPLATES',     PUCA_THEMEROOT . '/elementor_templates' );
define( 'PUCA_WIDGETS', 			PUCA_INC . '/widgets' );

define( 'PUCA_ASSETS', 			PUCA_THEME_DIR . '/inc/assets' );
define( 'PUCA_ASSETS_IMAGES', 	PUCA_ASSETS    . '/images' );

define( 'PUCA_MIN_JS', 	'' );



if ( ! isset( $content_width ) ) {
	$content_width = 660;
}


if ( ! function_exists( 'puca_tbay_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Puca 1.3.6
 */
function puca_tbay_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on puca, use a find and replace
	 * to change 'puca' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'puca', PUCA_THEMEROOT . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( "post-thumbnails" );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	$font_source = puca_tbay_get_config('show_typography', false);
	if( !$font_source ) {
		add_editor_style( array( 'css/editor-style.css', puca_fonts_url() ) );
	}


	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );


	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	add_theme_support( "woocommerce" );
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio'
	) );

	$color_scheme  = puca_tbay_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'puca_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

    if( apply_filters('puca_remove_widgets_block_editor', true) ) {
        remove_theme_support( 'block-templates' );
        remove_theme_support( 'widgets-block-editor' );

        /*Remove extendify--spacing--larg CSS*/
        update_option('use_extendify_templates', '');
    }
	
	puca_tbay_get_load_plugins();
}
endif; // puca_tbay_setup
add_action( 'after_setup_theme', 'puca_tbay_setup' );


function puca_tbay_include_files($path) {
    $files = glob( $path );
    if ( ! empty( $files ) ) {
        foreach ( $files as $file ) {
            include $file;
        }
    }
}

/**
 * Enqueue scripts and styles.
 *
 * @since Puca 1.3.6
 */
function puca_tbay_scripts() { 

	$menu_option = apply_filters( 'puca_menu_mobile_option', 10,2 );

	$suffix = (puca_tbay_get_config('minified_js', false)) ? '.min' : PUCA_MIN_JS;

	// load bootstrap style
	if( is_rtl() ){
		wp_enqueue_style( 'bootstrap', PUCA_STYLES . '/bootstrap-rtl.css', array(), '3.2.0' );
	}else{
		wp_enqueue_style( 'bootstrap', PUCA_STYLES . '/bootstrap.css', array(), '3.2.0' );
	}
	
	$skin = puca_tbay_get_theme();
	// Load our main stylesheet.
	if( is_rtl() ){
		
		if ( $skin != 'default' && $skin ) {
			$css_path =  PUCA_STYLES_SKINS . '/'.$skin.'/template.rtl.css';
		} else {
			$css_path =  PUCA_STYLES . '/template.rtl.css';
		}
	}
	else{
		if ( $skin != 'default' && $skin ) {
			$css_path =  PUCA_STYLES_SKINS . '/'.$skin.'/template.css';
		} else {
			$css_path =  PUCA_STYLES . '/template.css';
		}
	}

	$css_array = array();

    if( puca_elementor_is_activated() ) {
        array_push($css_array, 'elementor-frontend'); 
    } 

	wp_enqueue_style( 'puca-template', $css_path, $css_array, PUCA_THEME_VERSION );
	
	$vc_style = puca_tbay_print_vc_style(); 

	wp_add_inline_style( 'puca-template', $vc_style );

	wp_enqueue_style( 'puca-style', PUCA_THEME_DIR . '/style.css', array(), PUCA_THEME_VERSION );
	
	//load font awesome
	wp_enqueue_style( 'font-awesome', PUCA_STYLES . '/font-awesome.css', array(), '4.7.0' );
	
	//load font custom icon tbay
	wp_enqueue_style( 'font-tbay', PUCA_STYLES . '/font-tbay-custom.css', array(), '1.0.0' );

	//load simple-line-icons
	wp_enqueue_style( 'simple-line-icons', PUCA_STYLES . '/simple-line-icons.css', array(), '2.4.0' );

	// load animate version 3.5.0
	wp_enqueue_style( 'animate-css', PUCA_STYLES . '/animate.css', array(), '3.5.0' );

	
	wp_enqueue_script( 'puca-skip-link-fix', PUCA_SCRIPTS . '/skip-link-fix' . $suffix . '.js', array(), PUCA_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	} 

	/*mmenu menu*/ 
	if( $menu_option == 'smart_menu' ){
		wp_enqueue_script( 'jquery-mmenu', PUCA_SCRIPTS . '/jquery.mmenu' . $suffix . '.js', array( 'jquery', 'underscore' ),'7.0.5', true );
	}

	/*Treeview menu*/
	wp_enqueue_style( 'jquery-treeview',  PUCA_STYLES . '/jquery.treeview.css', array(), '1.0.0' );

	/*hc sticky*/
	wp_register_script( 'hc-sticky', PUCA_SCRIPTS . '/hc-sticky' . $suffix . '.js', array( 'jquery' ) , '2.1.0', true );

	wp_enqueue_script( 'bootstrap', PUCA_SCRIPTS . '/bootstrap' . $suffix . '.js', array( 'jquery' ), '3.3.7', true );
	wp_enqueue_script( 'js-cookie', PUCA_SCRIPTS . '/js.cookie' . $suffix . '.js', array(), '2.1.4', true ); 
	wp_enqueue_script( 'detectmobilebrowser', PUCA_SCRIPTS . '/detectmobilebrowser' . $suffix . '.js', array(), '1.0.6', true );

	wp_enqueue_script('waypoints', PUCA_SCRIPTS . '/jquery.waypoints' . $suffix . '.js', array(), '4.0.0', true);

	/*slick jquery*/
    wp_register_script( 'slick', PUCA_SCRIPTS . '/slick' . $suffix . '.js', array(), '1.0.0', true );
	wp_register_script('puca-custom-slick', PUCA_SCRIPTS . '/custom-slick' . $suffix . '.js', array( 'slick' ), PUCA_THEME_VERSION, true);

	// Add js Sumoselect version 3.0.2
	wp_register_style('sumoselect', PUCA_STYLES . '/sumoselect.css', array(), '1.0.0', 'all');
	wp_register_script('jquery-sumoselect', PUCA_SCRIPTS . '/jquery.sumoselect' . $suffix . '.js', array(), '3.0.2', TRUE);	

	wp_dequeue_script('wpb_composer_front_js');
	wp_enqueue_script( 'wpb_composer_front_js');

    wp_register_script( 'jquery-shuffle', PUCA_SCRIPTS . '/jquery.shuffle' . $suffix . '.js', array( 'jquery' ), '3.0.0', true ); 
    wp_register_script( 'jquery-magnific-popup', PUCA_SCRIPTS . '/jquery.magnific-popup' . $suffix . '.js', array( 'jquery' ), '1.0.0', true );    

    wp_register_style( 'magnific-popup', PUCA_STYLES . '/magnific-popup.css', array(), '1.0.0' );

	wp_register_script( 'jquery-countdowntimer', PUCA_SCRIPTS . '/jquery.countdowntimer' . $suffix . '.js', array( 'jquery' ), '1.0', true );

	wp_register_style( 'jquery-fancybox', PUCA_STYLES . '/jquery.fancybox.css', array(), '3.2.0' );
	wp_register_script( 'jquery-fancybox', PUCA_SCRIPTS . '/jquery.fancybox' . $suffix . '.js', array( 'jquery' ), '2.1.7', true );

	wp_register_script( 'puca-script',  PUCA_SCRIPTS . '/functions' . $suffix . '.js', array(), PUCA_THEME_VERSION, true );

	wp_register_script( 'puca-skins-script', PUCA_SCRIPTS_SKINS . '/'.$skin . $suffix . '.js', array( 'puca-script' ), PUCA_THEME_VERSION, true );

	if ( wp_is_mobile() ) {
		wp_enqueue_script( 'jquery-fastclick', PUCA_SCRIPTS . '/jquery.fastclick' . $suffix . '.js', array( 'jquery' ), '1.0.6', true );
	}

	wp_enqueue_script( 'puca-skins-script' );
	if ( puca_tbay_get_config('header_js') != "" ) {
		wp_add_inline_script( 'puca-script', puca_tbay_get_config('header_js'), 'after' );
	}

	wp_enqueue_style( 'puca-style', PUCA_THEME_DIR . '/style.css', array(), '1.0' );

	$config = puca_localize_translate();

	wp_localize_script( 'puca-script', 'puca_settings', $config );

}
add_action( 'wp_enqueue_scripts', 'puca_tbay_scripts', 100 );

if (!function_exists('puca_localize_translate')) {
    function puca_localize_translate()
    {
		global $wp_query; 

		$puca_hash_transient = get_transient( 'puca-hash-time' );
		if ( false === $puca_hash_transient ) {
			$puca_hash_transient = time();
			set_transient( 'puca-hash-time', $puca_hash_transient );
		}

		$position = apply_filters( 'puca_cart_position', 10,2 );
		$tbay_header = apply_filters( 'puca_tbay_get_header_layout', puca_tbay_get_config('header_type', 'v1') );
		$config = array(
			'storage_key'  		=> apply_filters( 'puca_storage_key', 'puca_' . md5( get_current_blog_id() . '_' . get_site_url( get_current_blog_id(), '/' ) . get_template() . $puca_hash_transient ) ), 
			'active_theme' 			=> puca_tbay_get_config('active_theme', 'fashion'),
			'keep_header' 			=> puca_tbay_get_config('keep_header', false),  
			'tbay_header' 			=> $tbay_header,
			'cart_position' 		=> $position, 
			'ajaxurl'				=> admin_url( 'admin-ajax.php' ), 
			'cancel' 				=> esc_html__('cancel', 'puca'),
			'search' 				=> esc_html__('Search', 'puca'), 
			'posts' 				=> json_encode( $wp_query->query_vars ),
			'view_all' 				=> esc_html__('View All', 'puca'),
			'no_results' 			=> esc_html__('No results found', 'puca'),
			'current_page' 			=> get_query_var( 'paged' ) ? get_query_var('paged') : 1,  
			'max_page' 				=> $wp_query->max_num_pages,
		);
	
		/*Element ready default callback*/
		if( puca_elementor_is_activated() ) { 
			$config['elements_ready'] = array(
				'slick'               => puca_elements_ready_slick(),
				'ajax_tabs'           => puca_elements_ajax_tabs(),
				'countdowntimer'      => puca_elements_ready_countdown_timer(),	 
				'layzyloadimage'      => puca_elements_ready_layzyload_image(),	
				'counterup'      	  => puca_elements_ready_counter_up(),	
			);

			$config['combined_css'] = puca_get_elementor_css_print_method();
		}

		$is_slicklayoutslide = false;
		
		if( puca_is_woocommerce_activated() ) {
			$images_layout   =  apply_filters( 'woo_images_layout_single_product', 10, 2 );
			if( $images_layout === 'carousel' || $images_layout === 'slide' ) {
				$is_slicklayoutslide = true;
			}

			$config['woo_mode'] 				= puca_tbay_woocommerce_get_display_mode();
			$config['ajax_single_add_to_cart'] 	= (bool) puca_tbay_get_config('ajax_single_add_to_cart', false);
			$config['ajax_update_quantity'] 	= (bool) puca_tbay_get_config('ajax_update_quantity', false);
			$config['wc_ajax_url']          =  WC_AJAX::get_endpoint('%%endpoint%%');
			$config['enable_ajax_add_to_cart'] 	= ( get_option('woocommerce_enable_ajax_add_to_cart') === 'yes' ) ? true : false; 
			$config['single_product']     = apply_filters('puca_active_single_product', is_product(), 10, 2);   
			$config['is_layoutslide']     = apply_filters('puca_is_slicklayoutslide', $is_slicklayoutslide, 10, 2);   
			$config['quantity_mode'] 			= puca_tbay_woocommerce_quantity_mode_active();
		}

		return apply_filters('puca_localize_translate', $config);
    }
}

if ( !function_exists('puca_tbay_footer_scripts') ) {
	function puca_tbay_footer_scripts() {
		if ( puca_tbay_get_config('footer_js') != "" ) {
			$footer_js = puca_tbay_get_config('footer_js');
			echo trim($footer_js);
		}
	}
	add_action('wp_footer', 'puca_tbay_footer_scripts');
}

if ( !function_exists('puca_tbay_remove_fonts_redux_url') ) {
	function puca_tbay_remove_fonts_redux_url() {  
		$show_typography  = puca_tbay_get_config('show_typography', false);
		if( !$show_typography ) {
			wp_dequeue_style( 'redux-google-fonts-puca_tbay_theme_options' );
		} 
	}
	add_action('wp_enqueue_scripts', 'puca_tbay_remove_fonts_redux_url', 9999);
}


add_action( 'admin_enqueue_scripts', 'puca_tbay_load_admin_styles' );
function puca_tbay_load_admin_styles() {
	wp_enqueue_style( 'puca-custom-admin', PUCA_STYLES . '/admin/custom-admin.css', false, '1.0.0' );
}  

/**
 * Display descriptions in main navigation.
 *
 * @since Puca 1.3.6
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function puca_tbay_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'puca_tbay_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Puca 1.3.6
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function puca_tbay_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'puca_tbay_search_form_modify' );


function puca_tbay_get_config($name, $default = '') {
	global $tbay_options;
    if ( isset($tbay_options[$name]) ) {
        return $tbay_options[$name];
    }
    return $default;
}

if ( ! function_exists( 'puca_tbay_get_global_config' ) ) :
	function puca_tbay_get_global_config($name, $default = '') {
		$options = get_option( 'puca_tbay_theme_options', array() );
		if ( isset($options[$name]) ) {
			return $options[$name];
		}
		return $default;
	}
endif;



if ( ! function_exists( 'puca_time_link' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 */
function puca_time_link() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ), 
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	// Wrap the time string in a link, and preface it with 'Posted on'.
	return sprintf( 
		/* translators: %s: post date */
		__( '<span class="screen-reader-text">Posted on</span> %s', 'puca' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
}
endif;

/**
 * Check if Gutenberg is active
 */
function puca_is_gutenberg_active() {
	global $wp_version;

	if ( version_compare( $wp_version, '5', '>=' ) ) {
		return true;
	}

	return false;
}

require_once( get_parent_theme_file_path( PUCA_VENDORS . '/gutenberg/functions.php') );


function puca_tbay_get_load_plugins() {

	$plugins[] =(array(
		'name'                     => 'Cmb2',
	    'slug'                     => 'cmb2',
	    'required'                 => true,
	));

	$plugins[] =(array(
		'name'                     => 'WooCommerce',
	    'slug'                     => 'woocommerce',
	    'required'                 => true,
	));

	$plugins[] =(array(
		'name'                     => 'MailChimp',
	    'slug'                     => 'mailchimp-for-wp',
	    'required'                 =>  true
	));	

	$plugins[] =(array(
		'name'                     => 'Contact Form 7',
	    'slug'                     => 'contact-form-7',
	    'required'                 => true,
	));

	if( puca_tbay_get_theme() !== 'fashion3' ) {
		$plugins[] =(array(
			'name'                     => 'WPBakery Page Builder',
			'slug'                     => 'js_composer',
			'required'                 => true,
			'source'         		   => esc_url( 'plugins.thembay.com/js_composer.zip' ),
		));
	} 
	 
	
	$plugins[] =(array(
		'name'                     => 'Tbay Framework Pro For Themes',
		'slug'                     => 'tbay-framework-pro',
		'required'                 => true ,
		'source'         		   => esc_url( 'plugins.thembay.com/tbay-framework-pro.zip' ),
	));

	$plugins[] =(array(
	    'name'                     => 'Redux Framework',
	    'slug'                     => 'redux-framework',
	    'required'                 => true ,
	));

	$plugins[] =(array(
		'name'                     => 'WooCommerce Variation Swatches',
	    'slug'                     => 'woo-variation-swatches',
	    'required'                 =>  true,
	    'source'         		   => esc_url( 'https://downloads.wordpress.org/plugin/woo-variation-swatches.zip' ),
	));		

	$plugins[] =(array(
		'name'                     => 'WooCommerce Products Filter',
	    'slug'                     => 'woocommerce-products-filter',
	    'required'                 =>  true,
	    'source'         		   => esc_url( 'plugins.thembay.com/woocommerce-products-filter.zip' ),
	));	

	$plugins[] =(array(
		'name'                     => 'YITH WooCommerce Quick View',
	    'slug'                     => 'yith-woocommerce-quick-view',
	    'required'                 =>  true
	));
	
	$plugins[] =(array(
		'name'                     => 'YITH WooCommerce Wishlist',
	    'slug'                     => 'yith-woocommerce-wishlist',
	    'required'                 =>  true
	));

	$plugins[] =(array(
		'name'                     => 'YITH Woocommerce Compare',
        'slug'                     => 'yith-woocommerce-compare',
        'required'                 => true
	));	

	$plugins[] =(array(
		'name'                     => 'YITH WooCommerce Brands Add-On',
        'slug'                     => 'yith-woocommerce-brands-add-on',
        'required'                 => true
	));

	$plugins[] =(array(
		'name'                     => 'Revolution Slider',
        'slug'                     => 'revslider',
        'required'                 => true ,
        'source'         		   => esc_url( 'plugins.thembay.com/revslider.zip' ),
	));

	$plugins[] =(array(
		'name'                     => 'Elementor Page Builder',
        'slug'                     => 'elementor',
        'required'                 => true
	));	
	 
	tgmpa( $plugins );
}


require_once( get_parent_theme_file_path( PUCA_INC . '/plugins/class-tgm-plugin-activation.php') );

/**Include Merlin Import Demo**/
require_once( get_parent_theme_file_path( PUCA_MERLIN . '/vendor/autoload.php') );
require_once( get_parent_theme_file_path( PUCA_MERLIN . '/class-merlin.php') );
require_once( get_parent_theme_file_path( PUCA_INC . '/merlin-config.php') );

require_once( get_parent_theme_file_path( PUCA_INC . '/functions-helper.php') );
require_once( get_parent_theme_file_path( PUCA_INC . '/functions-frontend.php') );
require_once( get_parent_theme_file_path( PUCA_INC . '/skins/'.puca_tbay_get_theme().'/functions.php') );

/**
 * Implement the Custom Header feature.
 *
 */
require_once( get_parent_theme_file_path( PUCA_INC . '/custom-header.php') );
/**
 * Classess file
 *
 */

require_once( get_parent_theme_file_path( PUCA_CLASSES . '/megamenu.php') );
require_once( get_parent_theme_file_path( PUCA_CLASSES . '/custommenu.php') );
require_once( get_parent_theme_file_path( PUCA_CLASSES . '/mmenu.php') );

/**
 * Custom template tags for this theme.
 *
 */

require_once( get_parent_theme_file_path( PUCA_INC . '/template-tags.php') );


if ( defined( 'TBAY_FRAMEWORK_REDUX_ACTIVED' ) ) {
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/redux-framework/redux-config.php') );
	define( 'PUCA_REDUX_FRAMEWORK_ACTIVED', true );
}

if( puca_is_cmb2() ) {
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/cmb2/page.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/cmb2/post.php') );
	define( 'PUCA_CMB2_ACTIVED', true );
}
if( puca_is_woocommerce_activated() ) {
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/functions.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/wc-admin.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/single-functions.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/wc-recently-viewed.php') );

	/**compatible**/ 
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/compatible/wc-dokan.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/compatible/wcfm-multivendor.php') );
    require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/compatible/mvx-vendor.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/compatible/wc-vendors.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/compatible/wc-advanced-free-shipping.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/compatible/yith-wcqv.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/compatible/estimated-delivery.php') );

	/**Modules**/
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/modules/form-login.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/modules/size-guid.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/modules/delivery-return.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/modules/aska-question.php') );
	

	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/compatible/nextend-social-login.php') );
	
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/woocommerce/compatible/variation-swatches-pro.php') );
	define( 'PUCA_WOOCOMMERCE_ACTIVED', true );
}
if( puca_is_vc_Manager() ) {
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/visualcomposer/functions.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/visualcomposer/vc-map-posts.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/visualcomposer/vc-map-theme.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/visualcomposer/vc-map-woocommerce.php') );
	define( 'PUCA_VISUALCOMPOSER_ACTIVED', true );
} 
if( defined('TBAY_FRAMEWORK_REDUX_ACTIVED') ) {
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/custom_menu.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/list-categories.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/popular_posts.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/popular_posts2.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/popup_newsletter.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/posts.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/recent_comment.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/recent_post.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/single_image.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/top_rate.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/socials.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/video.php') );
	require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/woo-carousel.php') );
	define( 'PUCA_TBAY_FRAMEWORK_ACTIVED', true );
	if( puca_elementor_is_activated() ) {  
        require_once( get_parent_theme_file_path( PUCA_WIDGETS . '/template_elementor.php') );
    }
}
 
if( puca_is_Projects() ) {
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/portfolio/functions.php') );
	define( 'PUCA_TBAY_PORTFOLIO_ACTIVED', true );
}



/**
 * Customizer additions.
 *
 */

require_once( get_parent_theme_file_path( PUCA_INC . '/skins/'.puca_tbay_get_theme().'/customizer.php') );

require_once( get_parent_theme_file_path( PUCA_INC . '/skins/'.puca_tbay_get_theme().'/custom-styles.php') );

if( puca_elementor_is_activated() ) {
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/elementor/class-elementor.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/elementor/class-elementor-pro.php') );
	require_once( get_parent_theme_file_path( PUCA_VENDORS . '/elementor/icons/icons.php') );
}