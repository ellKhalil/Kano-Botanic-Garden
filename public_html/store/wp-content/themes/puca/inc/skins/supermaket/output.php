<?php if ( ! defined('PUCA_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();
 
/*TopBar Color*/
$output['topbar_bg'] = array('
	#tbay-header .header-mainmenu,
	#tbay-header.header-v2 .header-mainmenu,
	#tbay-header.header-v3 .header-mainmenu
');
$output['topbar_text_color'] = array(
	'color' => puca_texttrim('
		#tbay-header.header-v2 .header-mainmenu p, 
		#tbay-header.header-v3 .header-mainmenu p
	')
);
$output['topbar_link_color'] = array(
	'color' => puca_texttrim('
		#tbay-header.header-v2 .header-topmenu > div > a, 
		#tbay-header.header-v3 .header-topmenu > div > a,
		#tbay-header.header-v2 .header-topmenu .tbay-menu-top > li > a,
		#tbay-header.header-v3 .header-topmenu .tbay-menu-top > li > a,
		#tbay-header.header-v2 .header-mainmenu .tbay-login .account-button,
		#tbay-header.header-v3 .header-mainmenu .tbay-login .account-button,
		#tbay-header.header-v2 .header-mainmenu .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont,
		#tbay-header.header-v3 .header-mainmenu .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont
	')
);
$output['topbar_link_color_hover'] = array(
	'color' => puca_texttrim('
		#tbay-header.header-v2 .header-topmenu > div > a:hover,
		#tbay-header.header-v3 .header-topmenu > div > a:hover,
		#tbay-header.header-v2 .header-topmenu .tbay-menu-top > li:hover > a, #tbay-header.header-v2 .header-topmenu .tbay-menu-top > li:focus > a, #tbay-header.header-v2 .header-topmenu .tbay-menu-top > li.active > a, #tbay-header.header-v3 .header-topmenu .tbay-menu-top > li:hover > a, #tbay-header.header-v3 .header-topmenu .tbay-menu-top > li:focus > a, #tbay-header.header-v3 .header-topmenu .tbay-menu-top > li.active > a,
		#tbay-header.header-v2 .header-mainmenu .tbay-login .account-button:hover,
		#tbay-header.header-v3 .header-mainmenu .tbay-login .account-button:hover,
		#tbay-header.header-v2 .header-mainmenu .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover,
		#tbay-header.header-v3 .header-mainmenu .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li:hover > a,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li:focus > a,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li.active > a,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li:hover:before,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li:focus:before,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li.active:before
	'),
	'border-color' => puca_texttrim('
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li:hover > a,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li:focus > a,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li.active > a,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li:hover:before,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li:focus:before,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li.active:before 
	')
);

/*Header Color*/
$output['header_bg'] = array('
	#tbay-header .header-main,
	#tbay-header.header-v4 #tbay-topbar >.container-full,
	#tbay-header.header-v14 .header-left .content
');
$output['header_text_color'] = array(
	'color' => puca_texttrim('
		#tbay-header .header-main .header-right .top-cart-wishlist .mini-cart-text,
		#tbay-header .header-main .header-right .tbay-login .well-come,
		#tbay-header .header-main .header-right .top-cart-wishlist .qty,
		#tbay-header.header-v3 .header-main .header-right .top-cart-wishlist .cart-icon i
	')
);
$output['header_link_color'] = array(
	'color' => puca_texttrim('
		#tbay-header a,
		#tbay-header .list-inline.acount li a.login, 
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
		#tbay-header a:active,
		#tbay-header .search-modal .btn-search-totop:hover,
		#tbay-header .cart-dropdown .cart-icon:hover i,
		#tbay-header .cart-dropdown:hover .qty,
		#tbay-header .header-main .header-right .top-cart-wishlist a:hover .mini-cart-text,
		#tbay-header .header-main .header-right .top-cart-wishlist a:hover .qty
	')
);

/*Menu Color */
$output['main_menu_link_color'] = array(
	'color' => puca_texttrim('
		.dropdown-menu .menu li a,
		.navbar-nav.megamenu .dropdown-menu > li > a,
		.navbar-nav.megamenu > li > a,
		.tbay-offcanvas-main .navbar-nav > li > a,
		#tbay-header .dropdown-menu .menu li a,
		#tbay-header .navbar-nav.megamenu .dropdown-menu > li > a,
		#tbay-header .navbar-nav.megamenu > li > a,
		#tbay-header .tbay-offcanvas-main .navbar-nav > li > a,
		#tbay-header.header-v2 .header-main .navbar-nav.megamenu > li > a, 
		#tbay-header.header-v3 .header-main .navbar-nav.megamenu > li > a
	')
);

$output['main_menu_background_color_hover'] = array(
	'background' => puca_texttrim('
		#tbay-header.header-v1 .navbar-nav.megamenu > li:hover > a,
		#tbay-header.header-v1 .navbar-nav.megamenu > li:focus > a,
		#tbay-header.header-v1 .navbar-nav.megamenu > li.active > a,
		.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover
	')
);

$output['main_menu_link_color_active'] = array(
	'color' => puca_texttrim('
		#tbay-header .navbar-nav.megamenu > li.active > a,
		#tbay-header .navbar-nav.megamenu > li > a:hover,
		#tbay-header .navbar-nav.megamenu > li > a:active,
		#tbay-header .navbar-nav.megamenu .dropdown-menu > li.active > a,
		#tbay-header .navbar-nav.megamenu .dropdown-menu > li > a:hover,
		#tbay-header .dropdown-menu .menu li a:hover,
		#tbay-header .dropdown-menu .menu li.active > a,
		#tbay-header .tbay-offcanvas-main .navbar-nav > li.active > a,
		#tbay-header .tbay-offcanvas-main .navbar-nav > li.hover > a,
		#tbay-header .tbay-offcanvas-main  .dropdown-menu > li.active > a,
		#tbay-header .tbay-offcanvas-main  .dropdown-menu > li > a:hover,
		#tbay-header .tbay-offcanvas-main .navbar-nav li.active > a, 
		#tbay-header .tbay-offcanvas-main .navbar-nav li:hover > a,
		#tbay-header .navbar-nav.megamenu > li:hover:before,
		#tbay-header .navbar-nav.megamenu > li:focus:before,
		#tbay-header .navbar-nav.megamenu > li.active:before,
		.navbar-nav.megamenu > li > ul.dropdown-menu li:hover:before, 
		.navbar-nav.megamenu > li > ul.dropdown-menu li:focus:before, 
		.navbar-nav.megamenu > li > ul.dropdown-menu li.active:before,
		.navbar-nav.megamenu .dropdown-menu .widget ul li.active:before, 
		.navbar-nav.megamenu .dropdown-menu .widget ul li:hover:before
	'),
	'background' => puca_texttrim('
		.navbar-nav.megamenu > li > a:before,
		.verticle-menu .navbar-nav > li.active, .verticle-menu .navbar-nav > li:hover
	'),
	'border-color' => puca_texttrim('
		.navbar-nav.megamenu > li > ul.dropdown-menu li:hover > a,
		.navbar-nav.megamenu > li > ul.dropdown-menu li:focus > a,
		.navbar-nav.megamenu > li > ul.dropdown-menu li.active > a,
		#tbay-header.header-v2 .header-main .navbar-nav.megamenu > li:hover > a, 
		#tbay-header.header-v2 .header-main .navbar-nav.megamenu > li:focus > a,
		#tbay-header.header-v2 .header-main .navbar-nav.megamenu > li.active > a,
		#tbay-header.header-v3 .header-main .navbar-nav.megamenu > li:hover > a,
		#tbay-header.header-v3 .header-main .navbar-nav.megamenu > li:focus > a,
		#tbay-header.header-v3 .header-main .navbar-nav.megamenu > li.active > a,
		.navbar-nav.megamenu .dropdown-menu .widget ul li.active,
		.navbar-nav.megamenu .dropdown-menu .widget ul li:hover,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li:hover > a,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li:focus > a,
		#tbay-header .header-topmenu .tbay-menu-top .dropdown-menu > li.active > a,
		#tbay-header .header-main .header-right .top-cart-wishlist a:hover .cart-icon,
		#tbay-header .header-main .header-right .tbay-login:hover .account-button,
		#tbay-main-content .tbay_custom_menu > .widget.widget_nav_menu .menu > li > a:hover, 
		#tbay-main-content .tbay_custom_menu > .widget.widget_nav_menu .menu > li > a:focus
	')
);

/*Footer Color */
$output['footer_bg'] = array('
		#tbay-footer, .bottom-footer
	');
$output['footer_heading_color'] = array(
	'color' => puca_texttrim('
		#tbay-footer h1, #tbay-footer h2, #tbay-footer h3, #tbay-footer h4, 
		#tbay-footer h5, #tbay-footer h6 ,#tbay-footer .widget-title, 
		#tbay-footer h3.widget-title, #tbay-footer .widgettitle
	')
);
$output['footer_text_color'] = array(
	'color' => puca_texttrim('#tbay-footer')
);
$output['footer_link_color'] = array(
	'color' => puca_texttrim('#tbay-footer a,
	#tbay-footer .menu > li a')
);
$output['footer_link_color_hover'] = array(
	'color' => puca_texttrim('#tbay-footer a:hover,#tbay-footer .tagcloud a:hover,
	#tbay-footer .menu > li:hover > a')
);

/*Copyright Color */
$output['copyright_bg'] = array('.tbay-footer .tb-copyright');
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
