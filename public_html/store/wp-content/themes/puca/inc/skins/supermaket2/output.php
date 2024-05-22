<?php if ( ! defined('PUCA_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();
 
/*TopBar Color*/
$output['topbar_bg'] = array('
	.tbay-topbar,
	#tbay-header.header-v2 #tbay-topbar,
	#tbay-header.header-v3 .tbay-topbar,
	#tbay-header.header-v4 .tbay-topbar
');
$output['topbar_text_color'] = array(
	'color' => puca_texttrim('
		.tbay-topbar,
		#tbay-header.header-v3 .tbay-topbar,
		#tbay-header.header-v4 .tbay-topbar,
		.top-shipping p
	')
);
$output['topbar_link_color'] = array(
	'color' => puca_texttrim('
		.tbay-topbar a,
		#tbay-header.header-v3 .tbay-topbar a
		,#tbay-header.header-v4 .tbay-topbar a
	')
);
$output['topbar_link_color_hover'] = array(
	'color' => puca_texttrim('
		.tbay-topbar a:hover,
		#tbay-header.header-v3 .tbay-topbar a:hover,
		#tbay-header.header-v4 .tbay-topbar a:hover,
		#tbay-header .tbay-topbar a:hover
	')
);

/*Header Color*/
$output['header_bg'] = array('
	#tbay-header.header-default,
	#tbay-header,
	#tbay-header.header-v3
');
$output['header_text_color'] = array(
	'color' => puca_texttrim('
		#tbay-header,
		.SumoSelect > .CaptionCont,
		.tbay-search-form .select-category.input-group-addon,
		#tbay-header.header-v1 .tbay-topbar,
		#tbay-header.header-v3 .tbay-topbar,
		.top-shipping p,
		#tbay-header.header-v4 .tbay-topbar
	')
);
$output['header_link_color'] = array(
	'color' => puca_texttrim('
		#tbay-header a,
		.category-inside .category-inside-title,
		.search-modal .btn-search-totop,
		.tbay-search-form .button-search,
		.header-setting .tbay-login .account-button,
		#tbay-header.header-v4 .header-setting .top-cart .cart-dropdown > a, 
		#tbay-header.header-v4 .header-setting .top-cart .cart-dropdown .account-button, 
		#tbay-header.header-v4 .header-setting .top-wishlist > a, 
		#tbay-header.header-v4 .header-setting .top-wishlist .account-button, 
		#tbay-header.header-v4 .header-setting .tbay-login > a, 
		#tbay-header.header-v4 .header-setting .tbay-login .account-button,
		#tbay-header.header-v2 .header-setting .top-cart .cart-dropdown > a, 
		#tbay-header.header-v2 .header-setting .top-cart .cart-dropdown .account-button, 
		#tbay-header.header-v2 .header-setting .wishlist > a, 
		#tbay-header.header-v2 .header-setting .wishlist .account-button, 
		#tbay-header.header-v2 .header-setting .user-menu > a, 
		#tbay-header.header-v2 .header-setting .user-menu .account-button,
		#tbay-header.header-v2 .tbay-search-form .button-search,
		#tbay-header.header-v2 .category-inside .category-inside-content a,
		#tbay-header.header-v3 .tbay-topbar a,
		#tbay-header.header-v3 .navbar-nav.megamenu > li > a,
		#tbay-header.header-v3 .category-inside .category-inside-title, 
		#tbay-header.header-v3 .SumoSelect > .CaptionCont, 
		#tbay-header.header-v3 .tbay-search-form .button-search,
		#tbay-header.header-v3 .header-setting a, 
		#tbay-header.header-v3 .header-setting .account-button,
		#tbay-header.header-v4 .tbay-topbar a,
		#tbay-header.header-v4 .logo-in-theme .category-inside-content a,
		#tbay-header.header-v4 .megamenu > li > a
	')
);
$output['header_link_color_active'] = array(
	'color' => puca_texttrim('
		#tbay-header .active > a,
		.category-inside .category-inside-title:hover,
		.tbay-search-form .button-search:hover,
		.header-setting .tbay-login .account-button:hover,
		#tbay-header a:active,
		#tbay-header a:hover,
		#tbay-header.header-v2 .header-setting .tbay-topcart a:hover, 
		#tbay-header.header-v2 .header-setting .wishlist a:hover, 
		#tbay-header.header-v2 .header-setting .user-menu a:hover,
		#tbay-header.header-v2 .category-inside .category-inside-content a:hover,
		#tbay-header.header-v2 .category-inside .category-inside-title:hover,
		#tbay-header.header-v2 .tbay-search-form .button-search:hover,
		#tbay-header.header-v3 .tbay-topbar a:hover,
		#tbay-header.header-v3 .header-setting a:hover, 
		#tbay-header.header-v3 .header-setting .account-button:hover,
		#tbay-header.header-v3 .navbar-nav.megamenu > li > a:hover,
		#tbay-header.header-v3 .category-inside .category-inside-title:hover, 
		#tbay-header.header-v3 .SumoSelect > .CaptionCont:hover, 
		#tbay-header.header-v3 .tbay-search-form .button-search:hover,
		.navbar-nav.megamenu > li > a:before,
		#tbay-header.header-v4 .header-setting .top-cart .cart-dropdown > a:hover, 
		#tbay-header.header-v4 .header-setting .top-cart .cart-dropdown .account-button:hover, 
		#tbay-header.header-v4 .header-setting .top-wishlist > a:hover, 
		#tbay-header.header-v4 .header-setting .top-wishlist .account-button:hover, 
		#tbay-header.header-v4 .header-setting .tbay-login > a:hover, 
		#tbay-header.header-v4 .header-setting .tbay-login .account-button:hover,
		.search-modal .btn-search-totop:hover,
		#tbay-header.header-v4 .logo-in-theme .category-inside-content a:hover,
		#tbay-header.header-v4 .search-modal .btn-search-totop:hover,
		#tbay-header.header-v4 .megamenu > li > a:hover,
		.SumoSelect > .CaptionCont > span:hover,
		#tbay-header .tbay-topbar a:hover
	')
);

/*Menu Color */
$output['main_menu_link_color'] = array(
	'color' => puca_texttrim('
		.dropdown-menu .menu li a,
		.navbar-nav.megamenu .dropdown-menu > li > a,
		.navbar-nav.megamenu > li > a,
		.tbay-offcanvas-main .navbar-nav > li > a,
		#tbay-header.header-v3 .navbar-nav.megamenu > li > a,
		#tbay-header.header-v4 .megamenu > li > a
	')
);

$main_menu_link_color_active = '';
$output['main_menu_link_color_active'] = array(
	'color' => puca_texttrim('
		.navbar-nav.megamenu > li.active > a,
		.navbar-nav.megamenu > li:hover > a,
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
		.tbay-offcanvas-main .navbar-nav li:hover > a,
		#tbay-header.header-v3 .navbar-nav.megamenu > li.active > a,
		#tbay-header.header-v3 .navbar-nav.megamenu > li:hover > a,
		#tbay-header.header-v3 .navbar-nav.megamenu > li:focus > a,
		#tbay-header.header-v4 .megamenu > li.active > a,
		#tbay-header.header-v4 .megamenu > li:hover > a,
		#tbay-header.header-v4 .megamenu > li:focus > a,
		.navbar-nav.megamenu .dropdown-menu .widget ul li.active a
	'),
	'background' => puca_texttrim('
		.navbar-nav.megamenu > li > a:before,
		.verticle-menu .navbar-nav > li.active, .verticle-menu .navbar-nav > li:hover
	'),
);

/*Footer Color */
$output['footer_bg'] = array('
	.bottom-footer, .bg-footer, #tbay-footer
');
$output['footer_heading_color'] = array(
	'color' => puca_texttrim('
		#tbay-footer h1, #tbay-footer h2, #tbay-footer h3, 
		#tbay-footer h4, #tbay-footer h5, #tbay-footer h6 ,#tbay-footer .widget-title
	')
);
$output['footer_text_color'] = array(
	'color' => puca_texttrim('
		#tbay-footer, .tbay-footer .copyright,
		#tbay-footer .widget-newletter,
		.info-bottom, .feedback p,
		.tbay-footer .widget .widget-title .subtitle, 
		.tbay-footer .widget .widgettitle .subtitle, 
		.tbay-footer .widget .widget-heading .subtitle
	')
);
$output['footer_link_color'] = array(
	'color' => puca_texttrim('
		#tbay-footer a,
		#tbay-footer .contact-help a,
		#tbay-footer .menu > li a
	')
);
$output['footer_link_color_hover'] = array(
	'color' => puca_texttrim('
		#tbay-footer a:hover,
		#tbay-footer .contact-help a:hover,
		#tbay-footer .menu > li:hover > a
	')
);

/*Copyright Color */
$output['copyright_bg'] = array('.tbay-copyright, #tbay-footer .tb-copyright');
$output['copyright_text_color'] = array(
	'color' => puca_texttrim('
		#tbay-footer .tbay-copyright,
		.tbay-footer .tb-copyright p
	')
);
$output['copyright_link_color'] = array(
	'color' => puca_texttrim('
		#tbay-footer .tbay-copyright a,
		#tbay-footer .tb-copyright a,
		.tbay-copyright .wpb_text_column a
	')
);
$output['copyright_link_color_hover'] = array(
	'color' => puca_texttrim('
		#tbay-footer .tbay-copyright a:hover, 
		#tbay-footer .tb-copyright a:hover, 
		.tbay-copyright .wpb_text_column a:hover
	')
);

return apply_filters( 'puca_get_output', $output);
