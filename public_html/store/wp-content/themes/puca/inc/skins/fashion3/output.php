<?php if ( ! defined('PUCA_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();
 
/*TopBar Color*/
$output['topbar_bg'] = array('
	#tbay-topbar .top-bar,
	#tbay-header .header-bottom-main,
	#tbay-header .header-category-logo,
	#tbay-header.header-v4 .top-bar,
	.header-bottom-main,
	#tbay-header.header-v10 .top-bar
');
$output['topbar_text_color'] = array(
	'color' => puca_texttrim('
		#tbay-topbar .top-bar,
		#tbay-header .header-bottom-main ,
		#tbay-header .header-category-logo,
		#tbay-header.header-v4 .top-bar,
		#tbay-header.header-v10 .top-bar .shipping-main .textwidget,
		.widget-categories.widget-grid .item-cat .cat-name span,
	')
);
$output['topbar_link_color'] = array(
	'color' => puca_texttrim('
		#tbay-topbar .top-bar a,
		#tbay-header .header-bottom-main a, 
		#tbay-header .header-category-logo a,
		#tbay-header.header-v13 .header-category-logo .widget_tbay_list_categories .item-cat .cat-name
	')
);
$output['topbar_link_color_hover'] = array(
	'color' => puca_texttrim('
		#tbay-topbar .top-bar a:hover,
		#tbay-header .header-bottom-main a:hover,
		#tbay-header .header-category-logo a:hover,
		#tbay-header.header-v13 .header-category-logo .widget_tbay_list_categories .item-cat .cat-name:hover
	')
);

/*Header Color*/
$output['header_bg'] = array('
	#tbay-header .header-main,
	#tbay-header.header-v4 #tbay-topbar >.container-full,
	#tbay-header.header-v9 .header-mainmenu,
	#tbay-header.header-v14 .header-left .content
');
$output['header_text_color'] = array(
	'color' => puca_texttrim('
		#tbay-header,
		#tbay-header p,
		#tbay-header.header-v4 #tbay-topbar >.container-full,
		#tbay-header.header-v14 .header-left .content,
		.tbay-offcanvas-main .dropdown-menu .widgettitle
	')
);
$output['header_link_color'] = array(
	'color' => puca_texttrim('
		#tbay-header a,
		#tbay-header .list-inline.acount li a.login,
		#tbay-header .tbay-login i, 
		#tbay-header .search-modal .btn-search-totop,
		#tbay-header .cart-dropdown .cart-icon i,
		#tbay-header.header-v5 .active-mobile button,
		#tbay-header.header-v7 .tbay-mainmenu .active-mobile button,
		#tbay-header #cart .mini-cart .qty,
		#tbay-header.header-v14 .header-left .content a
	')
);
$output['header_link_color_active'] = array(
	'color' => puca_texttrim('
		#tbay-header .active > a,
		#tbay-header a:hover,
		#tbay-header .tbay-login i:hover,
		#tbay-header a:active,
		#tbay-header .search-modal .btn-search-totop:hover,
		#tbay-header .cart-dropdown .cart-icon:hover i,
		#tbay-header .cart-dropdown:hover .qty,
		#tbay-header.header-v5 .active-mobile button:hover,
		#tbay-header.header-v7 .tbay-mainmenu .active-mobile button:hover,
		#tbay-header #cart .mini-cart a:hover,
		#tbay-header.header-v14 .header-left .content a:hover
	')
);

/*Menu Color */
$output['main_menu_link_color'] = array(
	'color' => puca_texttrim('
		.dropdown-menu .menu li a,
		.navbar-nav.megamenu .dropdown-menu > li > a,
		.navbar-nav.megamenu > li > a,
		.tbay-offcanvas-main .navbar-nav > li > a
	')
);

$output['main_menu_link_color_active'] = array(
	'color' => puca_texttrim('
		.navbar-nav.megamenu > li.active > a,
		.navbar-nav.megamenu > li > a:hover,
		.navbar-nav.megamenu > li > a:active,
		.navbar-nav.megamenu .dropdown-menu > li.active > a,
		.navbar-nav.megamenu .dropdown-menu > li > a:hover,
		.dropdown-menu .menu li a:hover,
		.dropdown-menu .menu li.active > a,
		.tbay-offcanvas-main .navbar-nav > li.active > a,
		.tbay-offcanvas-main .navbar-nav > li.hover > a,
		.tbay-offcanvas-main  .dropdown-menu > li.active > a,
		.tbay-offcanvas-main  .dropdown-menu > li > a:hover,
		.tbay-offcanvas-main .navbar-nav li.active > a, 
		.tbay-offcanvas-main .navbar-nav li:hover > a
	'),
	'background' => puca_texttrim('
		.navbar-nav.megamenu > li > a:before,
		.verticle-menu .navbar-nav > li.active, .verticle-menu .navbar-nav > li:hover
	'),
);

/*Footer Color */
$output['footer_bg'] = array('#tbay-footer, .bottom-footer');
$output['footer_heading_color'] = array(
	'color' => puca_texttrim('#tbay-footer h1, #tbay-footer h2, #tbay-footer h3, 
	#tbay-footer h4, #tbay-footer h5, #tbay-footer h6 ,#tbay-footer .widget-title, #tbay-footer h3.widget-title, #tbay-footer .widgettitle')
);
$output['footer_text_color'] = array(
	'color' => puca_texttrim('#tbay-footer')
);
$output['footer_link_color'] = array(
	'color' => puca_texttrim('#tbay-footer a')
);
$output['footer_link_color_hover'] = array(
	'color' => puca_texttrim('
		#tbay-footer a:hover,#tbay-footer .vc_wp_custommenu .menu > li:hover > a,
		#tbay-footer .menu > li:hover > a
	')
);

/*Copyright Color */
$output['copyright_bg'] = array('.tbay-copyright, .tbay-footer .tb-copyright');
$output['copyright_text_color'] = array(
	'color' => puca_texttrim('.tbay-copyright,
	.tbay-footer .tb-copyright p')
);
$output['copyright_link_color'] = array(
	'color' => puca_texttrim('.tbay-copyright a,
	#tbay-footer .tb-copyright a')
);
$output['copyright_link_color_hover'] = array(
	'color' => puca_texttrim('.tbay-copyright a:hover,
	#tbay-footer .tb-copyright a:hover')
);

return apply_filters( 'puca_get_output', $output);
