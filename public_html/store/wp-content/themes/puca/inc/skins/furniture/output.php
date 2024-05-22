<?php if ( ! defined('PUCA_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();
 
/*TopBar Color*/
$output['topbar_bg'] = array('
	#tbay-topbar, 
	#tbay-header #tbay-topbar
');
$output['topbar_text_color'] = array(
	'color' => puca_texttrim('
		#tbay-topbar, 
		#tbay-header.header-v19 .top-info
	')
);
$output['topbar_link_color'] = array(
	'color' => puca_texttrim('
		#tbay-topbar .tbay-login a, 
		#tbay-topbar .tbay-topcart a.mini-cart, 
		#tbay-topbar .top-info a, 
		#tbay-topbar .SumoSelect p
	')
);
$output['topbar_link_color_hover'] = array(
	'color' => puca_texttrim('
		#tbay-topbar .tbay-login a:hover, 
		#tbay-topbar .tbay-topcart a.mini-cart:hover, 
		#tbay-topbar .top-info a:hover, 
		#tbay-topbar .SumoSelect p
	')
);

/*Header Color*/
$output['header_bg'] = array('
	#tbay-header, 
	#tbay-header.header-v23, 
	#tbay-header.header-v24 .header-main
');
$output['header_text_color'] = array(
	'color' => puca_texttrim('
		.tbay-dropdown-cart .heading-title, 
		#tbay-top-cart .heading-title, 
		.tbay-bottom-cart .heading-title, 
		.cart-popup .heading-title, 
		.tbay-dropdown-cart .total, 
		#tbay-top-cart .total, 
		.tbay-bottom-cart .total, 
		.cart-popup .total, 
		#tbay-header .tbay-megamenu .widget .widgettitle, 
		#tbay-header .tbay-megamenu .widget .widget-title, 
		.tbay-offcanvas-main .dropdown-menu .widget-heading, 
		.tbay-offcanvas-main .dropdown-menu .widget-title, 
		.tbay-offcanvas-main .dropdown-menu .widgettitle, 
		#tbay-offcanvas-main .offcanvas-head, 
		.header-bottom-vertical, 
		.v17 .header-right, 
		.bottom-canvas, 
		.header-bottom-vertical, .v17 .header-right, 
		#tbay-offcanvas-main .copyright, 
		.top-contact .widget_text span, 
		body.v16 .header-top-left .top-copyright .copyright, 
		body.v17 .header-top-left .top-copyright .copyright, 
		body.v18 .top-copyright .copyright, .top-info,
		.tbay-search-form .select-category .SelectBox span,
		body.v17 .wishlist .count_wishlist, body.v17 #tbay-header .header-right, 
		body.v18 .header-bottom-vertical .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont, 
		body.v18 .top-contact .widget_text,
		#tbay-header.header-v19 .top-info
	')
);
$output['header_link_color'] = array(
	'color' => puca_texttrim('
		#tbay-header .list-inline.acount li a.login,
		#tbay-header .cart-dropdown .cart-icon i,
		.tbay-dropdown-cart .offcanvas-close, 
		#tbay-top-cart .offcanvas-close, 
		.tbay-bottom-cart .offcanvas-close, 
		.cart-popup .offcanvas-close,
		.header-right .tbay-search-form button, 
		.tbay-mainmenu button.btn-offcanvas,
		.tbay-offcanvas .offcanvas-head .btn-toggle-canvas, 
		.tbay-offcanvas-main .offcanvas-head .btn-toggle-canvas,
		.tbay-offcanvas-main .navbar-nav > li > a, 
		.tbay-offcanvas-main .dropdown-menu li a, 
		.tbay-login.offcanvas a,
		#tbay-offcanvas-main .copyright a, 
		#tbay-header .topbar-mobile .btn,
		#tbay-header.header-v14 .tbay-search-form button, 
		#tbay-header.header-v14 .cart-dropdown .mini-cart, 
		#tbay-header.header-v9 .tbay-search-form button, 
		#tbay-header.header-v9 .cart-dropdown .mini-cart, 
		#tbay-header.header-v10 .tbay-login a,
		.top-social .widget_tbay_socials_widget .social li a, 
		.top-info a, .tbay-login a, 
		.tbay-topcart a.mini-cart, 
		#tbay-header .tbay-currency .SumoSelect p, 
		#tbay-header.header-v23 .tbay-login .account-button, 
		#tbay-header.header-v23 .navbar-nav.megamenu > li > a, 
		#tbay-header.header-v23 .tbay-topcart .cart-dropdown > a, 
		#tbay-header.header-v24 .tbay-login .account-button, 
		#tbay-header.header-v24 .navbar-nav.megamenu > li > a, 
		#tbay-header.header-v24 .tbay-topcart a, 
		#tbay-header.header-v24 .tbay-search-min .btn-search-min,
		.caret, .navbar-nav.megamenu > li > a,
		body.v16 .header-top-left .account-button, body.v16 .header-top-left .tbay-login > a .copyright a, 
		body.v16 .header-top-left .mini-cart, body.v16 .header-top-left .tbay-search-form .btn-search-min, 
		body.v17 .header-top-left .account-button, body.v17 .header-top-left .tbay-login > a .copyright a, 
		body.v17 .header-top-left .mini-cart, body.v17 .header-top-left .tbay-search-form .btn-search-min, 
		body.v18  .account-button, body.v18 .tbay-login > a .copyright a, body.v18 .mini-cart, 
		body.v18 .tbay-search-form .btn-search-min, body.v17 .wishlist, 
		body.v18 .tbay-login a.account-button,body.v18 .navbar-nav > li > a,
		body.v17 .wishlist:hover .count_wishlist, .top-copyright .copyright a
	')
);

$output['header_link_color_active'] = array(
	'color' => puca_texttrim('
		#tbay-header .tbay-mainmenu a:hover,
		#tbay-header .tbay-mainmenu a:focus,
		#tbay-header .active > a,
		#tbay-header a:active,
		.tbay-offcanvas-main .dropdown-menu .menu-category-menu-container li a:hover,
		.tbay-offcanvas-main .dropdown-menu .menu-category-menu-container li.active a,
		#tbay-header .search-modal .btn-search-totop:hover,
		#tbay-header .cart-dropdown .cart-icon:hover i,
		#tbay-header #cart .mini-cart a:hover,
		.tbay-dropdown-cart .offcanvas-close:hover, 
		#tbay-top-cart .offcanvas-close:hover, 
		.tbay-bottom-cart .offcanvas-close:hover, 
		.cart-popup .offcanvas-close:hover,
		.header-right .dropdown .account-menu ul li a:hover, 
		.tbay-login .dropdown .account-menu ul li a:hover,
		.header-right .tbay-search-form button:hover, 
		.tbay-mainmenu button.btn-offcanvas:hover,
		.tbay-offcanvas .offcanvas-head .btn-toggle-canvas:hover, 
		.tbay-offcanvas-main .offcanvas-head .btn-toggle-canvas:hover,
		.tbay-offcanvas-main .navbar-nav > li > a:hover,
		.tbay-offcanvas-main .dropdown-menu li a:hover, .tbay-login.offcanvas a:hover, 
		#tbay-offcanvas-main .copyright a:hover, #tbay-offcanvas-main .copyright a:after, 
		#tbay-header .topbar-mobile .btn:hover, #tbay-header .topbar-mobile .btn:focus,
		#tbay-header.header-v14 .tbay-search-form button:hover, 
		#tbay-header.header-v14 .cart-dropdown .mini-cart:hover, 
		#tbay-header.header-v9 .tbay-search-form button:hover, 
		#tbay-header.header-v9 .cart-dropdown .mini-cart:hover, 
		#tbay-header.header-v10 .tbay-login a:hover,
		.top-social .widget_tbay_socials_widget .social li a:hover, 
		.top-info a:hover, .tbay-login a:hover, #tbay-header .tbay-currency .SumoSelect p:hover, 
		#tbay-header.header-v23 .tbay-login .account-button:hover, 
		#tbay-header.header-v23 .navbar-nav.megamenu > li > a:hover, 
		#tbay-header.header-v23 .tbay-topcart .cart-dropdown > a:hover, 
		.tbay-search-form .button-search:hover, .tbay-search-form .button-search:focus, 
		#tbay-header.header-v24 .tbay-login .account-button:hover, 
		#tbay-header.header-v24 .navbar-nav.megamenu > li > a:hover, 
		#tbay-header.header-v24 .tbay-topcart a:hover, 
		#tbay-header.header-v24 .tbay-search-min .btn-search-min:hover,
		.navbar-nav.megamenu > li:hover > a, .navbar-nav.megamenu > li:focus > a, .navbar-nav.megamenu > li.active > a,
		#tbay-header.header-v24 .tbay-login .account-button:hover, #tbay-header.header-v24 .navbar-nav.megamenu > li > a:hover, #tbay-header.header-v24 .tbay-topcart a:hover, #tbay-header.header-v24 .tbay-search-min .btn-search-min:hover,
		.navbar-nav.megamenu > li:hover > a i, .navbar-nav.megamenu > li:hover > a .caret, .navbar-nav.megamenu > li:focus > a i, .navbar-nav.megamenu > li:focus > a .caret, .navbar-nav.megamenu > li.active > a i, .navbar-nav.megamenu > li.active > a .caret,
		.tbay-offcanvas-main .navbar-nav li.active > a, .tbay-offcanvas-main .navbar-nav li:hover > a,
		.tbay-offcanvas-main .navbar-nav .open > a:hover, .tbay-offcanvas-main .navbar-nav .open > a:focus, .tbay-offcanvas-main .navbar-nav .open > a, .tbay-offcanvas-main .navbar-nav .active > a:hover, .tbay-offcanvas-main .navbar-nav .active > a:focus, .tbay-offcanvas-main .navbar-nav .active > a,.tbay-login.offcanvas a span:hover,
		body.v16 .header-top-left .account-button:hover, body.v16 .header-top-left .tbay-login > a .copyright a:hover, body.v16 .header-top-left .mini-cart:hover, body.v16 .header-top-left .tbay-search-form .btn-search-min:hover, body.v17 .header-top-left .account-button:hover, body.v17 .header-top-left .tbay-login > a .copyright a:hover, body.v17 .header-top-left .mini-cart:hover, body.v17 .header-top-left .tbay-search-form .btn-search-min:hover, body.v18 .account-button:hover, body.v18 .tbay-login > a .copyright a:hover, body.v18 .mini-cart:hover, body.v18 .tbay-search-form .btn-search-min:hover, body.v17 .wishlist:hover, .top-copyright .copyright a:hover, .navbar-nav.megamenu > li > a:hover i, .navbar-nav.megamenu > li > a:hover .caret, .navbar-nav.megamenu > li > a:active i, .navbar-nav.megamenu > li > a:active .caret
	'),
	'background' => puca_texttrim('
		.tbay-offcanvas-main .navbar-nav > li > a:before, 
		.top-copyright .copyright a:after, 
		.navbar-nav.megamenu > li > a:after
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
		#tbay-header.header-v23 .navbar-nav.megamenu > li > a, 
		#tbay-header .navbar-nav.megamenu > li > a .caret, 
		#tbay-header.header-v24 .navbar-nav.megamenu > li > a,
		#tbay-header .topbar-mobile .btn
	')
);

$main_menu_link_color_active = '';
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
		#tbay-header .navbar-nav.megamenu > li:hover > a i, 
		#tbay-header .navbar-nav.megamenu > li:hover > a, 
		#tbay-header .navbar-nav.megamenu > li:focus > a, 
		#tbay-header .navbar-nav.megamenu > li:hover > a .caret, 
		#tbay-header .navbar-nav.megamenu > li:focus > a i, 
		#tbay-header .navbar-nav.megamenu > li:focus > a .caret, 
		#tbay-header .navbar-nav.megamenu > li.active > a i, 
		#tbay-header .navbar-nav.megamenu > li.active > a .caret,
		#tbay-header .topbar-mobile .btn:hover,
		#tbay-header .topbar-mobile .btn:focus,
		.tbay-offcanvas-main .navbar-nav li.active > a, 
		.tbay-offcanvas-main .navbar-nav li:hover > a,
		.tbay-offcanvas-main .navbar-nav .open > a:hover, 
		.tbay-offcanvas-main .navbar-nav .open > a:focus, .tbay-offcanvas-main .navbar-nav .open > a, 
		.tbay-offcanvas-main .navbar-nav .active > a:hover, .tbay-offcanvas-main .navbar-nav .active > a:focus, 
		.tbay-offcanvas-main .navbar-nav .active > a,
		.verticle-menu .navbar-nav > li.show-demo > .dropdown-menu li:hover a, 
		.verticle-menu .navbar-nav > li.show-demo > .dropdown-menu li.active a,
		.tbay-offcanvas-main .dropdown-menu .menu-category-menu-container li a:hover,
		#tbay-header.header-v23 .navbar-nav.megamenu > li > a:hover, 
		#tbay-header.header-v24 .navbar-nav.megamenu > li > a:hover
	'),
	'background' => puca_texttrim('
		.tbay-offcanvas-main .navbar-nav > li > a:before, .navbar-nav.megamenu > li > a:after
	'),
	'border-color' => puca_texttrim('
		.navbar-nav.megamenu > li > ul.dropdown-menu li:hover > a,
		.navbar-nav.megamenu > li > ul.dropdown-menu li:focus > a,
		.navbar-nav.megamenu > li > ul.dropdown-menu li.active > a,
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
$output['footer_bg'] = array('#tbay-footer, .bottom-footer');
$output['footer_heading_color'] = array(
	'color' => puca_texttrim('
		#tbay-footer h1, #tbay-footer h2, #tbay-footer h3, #tbay-footer h4, #tbay-footer h5, #tbay-footer h6 ,#tbay-footer .widget-title
	')
);
$output['footer_text_color'] = array(
	'color' => puca_texttrim('
		#tbay-footer p, #tbay-footer .copyright, #tbay-footer .contact-info li, #tbay-footer .widget .subtitle
	')
);
$output['footer_link_color'] = array(
	'color' => puca_texttrim('
		#tbay-footer a,
		#tbay-footer .menu > li a, 
		#tbay-footer .feedback a,
		#tbay-footer .widget-newletter .input-group-btn input,
		#tbay-footer .widget-newletter .input-group-btn:before
	')
);
$output['footer_link_color_hover'] = array(
	'color' => puca_texttrim('
		#tbay-footer a:hover,
		#tbay-footer .menu > li:hover > a, #tbay-footer .widget-newletter .input-group-btn input:hover,
		#tbay-footer .widget-newletter .input-group-btn:hover:before
	'),
	'background' => puca_texttrim('
		.tbay-footer .none-menu ul.menu a:after, .copyright a:after
	')
);

/*Copyright Color */
$output['copyright_bg'] = array('.tbay-footer .tb-copyright');
$output['copyright_text_color'] = array(
	'color' => puca_texttrim('
		.tbay-copyright,.copyright,
		.tbay-footer .tb-copyright p, .tbay-footer .copyright
	')
);
$output['copyright_link_color'] = array(
	'color' => puca_texttrim('
		.tbay-copyright a,
		#tbay-footer .tb-copyright a, .tbay-footer .copyright a
	')
);
$output['copyright_link_color_hover'] = array(
	'color' => puca_texttrim('
		.tbay-copyright a:hover,
		#tbay-footer .tb-copyright a:hover, 
		.tbay-footer .copyright a:hover,
		.tbay-footer .copyright a:after
	')
);

return apply_filters( 'puca_get_output', $output);
