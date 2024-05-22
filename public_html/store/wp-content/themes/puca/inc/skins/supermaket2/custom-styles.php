<?php
//convert hex to rgb
if ( !function_exists ('puca_tbay_getbowtied_hex2rgb') ) {
	function puca_tbay_getbowtied_hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);
		
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		return implode(",", $rgb); // returns the rgb values separated by commas
		//return $rgb; // returns an array with the rgb values
	}
}

if ( !function_exists ('puca_tbay_color_lightens_darkens') ) {
	/**
	 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.7
	 * @param str $hex Colour as hexadecimal (with or without hash);
	 * @percent float $percent Decimal ( 0.2 = lighten by 20%(), -0.4 = darken by 40%() )
	 * @return str Lightened/Darkend colour as hexadecimal (with hash);
	 */
	function puca_tbay_color_lightens_darkens( $hex, $percent ) {
		
		// validate hex string
		if( empty($hex) ) return $hex;
		
		$hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
		$new_hex = '#';
		
		if ( strlen( $hex ) < 6 ) {
			$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
		}
		
		// convert to decimal and change luminosity
		for ($i = 0; $i < 3; $i++) {
			$dec = substr( $hex, $i*2, 2 );
			$dec = intval( $dec, 16 );
			$dec = min( max( 0, $dec + $dec * $percent ), 255 ); 
			$new_hex .= str_pad( sprintf("%02x", $dec) , 2, 0, STR_PAD_LEFT );
		}	
		
		return $new_hex;
	}
}

if ( !function_exists ('puca_tbay_default_theme_primary_color') ) {
	function puca_tbay_default_theme_primary_color() {

		$theme_variable = array();

		$theme_variable['main_color'] 			    	= '#f61565';

		return apply_filters( 'puca_get_default_theme_color', $theme_variable);
	}
}

if ( !function_exists ('puca_tbay_default_theme_primary_fonts') ) {
	function puca_tbay_default_theme_primary_fonts() {

		$theme_variable = array();

		$theme_variable['main_font'] 			    	= 'Lato';

		$theme_variable['secondary_font'] 				= 'Roboto';

		return apply_filters( 'puca_get_default_theme_fonts', $theme_variable);
	}
}

if (!function_exists('puca_tbay_check_empty_customize')) {
    function puca_check_empty_customize($option, $default){
        if( !is_array( $option ) ) {
            if( !empty($option) && $option !== 'Array' ) {
                echo trim( $option );
            } else {
                echo trim( $default );
            }
        } else {
            if( !empty($option['background-color']) ) {
                echo trim( $option['background-color'] );
            } else {
                echo trim( $default );
            }
        } 
    }
}

if (!function_exists('puca_tbay_theme_primary_color')) {
    function puca_tbay_theme_primary_color()
    {
        $default                        = puca_tbay_default_theme_primary_color();

        $main_color                     = puca_tbay_get_config(('main_color'),$default['main_color']);

        /*Theme Color*/
        ?>
        :root {
            --tb-theme-color: <?php puca_check_empty_customize( $main_color, $default['main_color'] ); ?>;
            --tb-theme-color-hover: <?php puca_check_empty_customize( puca_tbay_color_lightens_darkens($main_color, -0.15), puca_tbay_color_lightens_darkens($default['main_color'], -0.15) ); ?>;

        } 
        <?php
    }
}

if ( !function_exists ('puca_tbay_custom_styles') ) {
	function puca_tbay_custom_styles() {

		ob_start();	

		puca_tbay_theme_primary_color();

		$default_fonts 		= puca_tbay_default_theme_primary_fonts();

		if (!defined('PUCA_TBAY_FRAMEWORK_ACTIVED')) {
			?>
			:root {
                --tb-text-primary-font: <?php echo trim($default_fonts['main_font']); ?>;
                --tb-text-second-font: <?php echo trim($default_fonts['secondary_font']); ?>;
            }  
			<?php
		} else {
			$logo_img_width        		= puca_tbay_get_config( 'logo_img_width' );
			$logo_padding        		= puca_tbay_get_config( 'logo_padding' );

			$logo_tablets_img_width 	= puca_tbay_get_config( 'logo_tablets_img_width' );
			$logo_tablets_padding 		= puca_tbay_get_config( 'logo_tablets_padding' );		

			$logo_img_width_mobile 		= puca_tbay_get_config( 'logo_img_width_mobile' );
			$logo_mobile_padding 		= puca_tbay_get_config( 'logo_mobile_padding' );


			$custom_css 			= puca_tbay_get_config( 'custom_css' );
			$css_desktop 			= puca_tbay_get_config( 'css_desktop' );
			$css_tablet 			= puca_tbay_get_config( 'css_tablet' );
			$css_wide_mobile 		= puca_tbay_get_config( 'css_wide_mobile' );
			$css_mobile         	= puca_tbay_get_config( 'css_mobile' );

			$show_typography         	= puca_tbay_get_config( 'show_typography', false );

			if ($show_typography) {
	            $font_source 			= puca_tbay_get_config('font_source');
	            $primary_font 			= puca_tbay_get_config('main_font')['font-family'];
	            $main_google_font_face = puca_tbay_get_config('main_google_font_face');
	            $main_custom_font_face = puca_tbay_get_config('main_custom_font_face');

	            $second_font					= puca_tbay_get_config('secondary_font')['font-family'];
	            $secondary_google_font_face 	= puca_tbay_get_config('secondary_google_font_face');
	            $secondary_custom_font_face 	= puca_tbay_get_config('secondary_custom_font_face');

	            if ($font_source  == "2" && $main_google_font_face) {
	                $primary_font = $main_google_font_face;
	                $second_font = $secondary_google_font_face;
	            } elseif ($font_source  == "3" && $main_custom_font_face) {
	                $primary_font = $main_custom_font_face;
	                $second_font = $secondary_custom_font_face;
	            } ?>
				:root {
					--tb-text-primary-font: <?php puca_check_empty_customize( $primary_font, $default_fonts['main_font'] ); ?>;
					--tb-text-second-font: <?php puca_check_empty_customize( $second_font, $default_fonts['secondary_font'] ); ?>;
				}  
				<?php
	        } else {
				?>
				:root { 
					--tb-text-primary-font: <?php echo trim($default_fonts['main_font']); ?>;
					--tb-text-second-font: <?php echo trim($default_fonts['secondary_font']); ?>;
	            }
				<?php
			}
			?>
			
			/* Menu Link Color Active */
			<?php if ( puca_tbay_get_config('main_menu_link_color_active') != "" ) : ?>
			.verticle-menu .navbar-nav > li.active > a, .verticle-menu .navbar-nav > li:hover > a {
				color: #fff !important;
			}
			<?php endif; ?>
 
			/* Woocommerce Breadcrumbs */
			<?php if ( puca_tbay_get_config('breadcrumbs') == "0" ) : ?>
			.woocommerce .woocommerce-breadcrumb,
			.woocommerce-page .woocommerce-breadcrumb
			{
				display:none;
			}
			<?php endif; ?>

			<?php if ( $logo_img_width != "" ) : ?>
			.site-header .logo img {
	            max-width: <?php echo esc_html( $logo_img_width ); ?>px;
	        } 
	        <?php endif; ?>

	        <?php if ( $logo_padding != "" ) : ?>
	        .site-header .logo img {  
	            padding-top: <?php echo esc_html( $logo_padding['padding-top'] ); ?>;
	            padding-right: <?php echo esc_html( $logo_padding['padding-right'] ); ?>;
	            padding-bottom: <?php echo esc_html( $logo_padding['padding-bottom'] ); ?>;
	            padding-left: <?php echo esc_html( $logo_padding['padding-left'] ); ?>;
	        }
	        <?php endif; ?>
	        
	        @media (max-width: 1024px) {

	        	<?php if ( $logo_tablets_img_width != "" ) : ?>
	            /* Limit logo image height for tablets according to tablets header height */
	            .logo-tablet a img {
	               	max-width: <?php echo esc_html( $logo_tablets_img_width ); ?>px;
	            }     
	            <?php endif; ?>       

	            <?php if ( $logo_tablets_padding != "" ) : ?>
	            .logo-tablet a img {
		            padding-top: <?php echo esc_html( $logo_tablets_padding['padding-top'] ); ?>;
		            padding-right: <?php echo esc_html( $logo_tablets_padding['padding-right'] ); ?>;
		            padding-bottom: <?php echo esc_html( $logo_tablets_padding['padding-bottom'] ); ?>;
		            padding-left: <?php echo esc_html( $logo_tablets_padding['padding-left'] ); ?>;
	            }
	            <?php endif; ?>

	        }	  

	        @media (max-width: 768px) {

	        	<?php if ( $logo_img_width_mobile != "" ) : ?>
	            /* Limit logo image height for mobile according to mobile header height */
	            .mobile-logo a img {
	               	max-width: <?php echo esc_html( $logo_img_width_mobile ); ?>px;
	            }     
	            <?php endif; ?>       

	            <?php if ( $logo_mobile_padding != "" ) : ?>
	            .mobile-logo a img {
		            padding-top: <?php echo esc_html( $logo_mobile_padding['padding-top'] ); ?>;
		            padding-right: <?php echo esc_html( $logo_mobile_padding['padding-right'] ); ?>;
		            padding-bottom: <?php echo esc_html( $logo_mobile_padding['padding-bottom'] ); ?>;
		            padding-left: <?php echo esc_html( $logo_mobile_padding['padding-left'] ); ?>;
	            }
	            <?php endif; ?>

	           <?php if ( puca_tbay_get_config('main_color') != "" ) : ?>
		            .flex-control-nav .slick-arrow:hover.owl-prev:after, .flex-control-nav .slick-arrow:hover.owl-next:after {
						color: #fff !important;
					}
				<?php endif; ?>
	        }

			/* Custom CSS */
	        <?php 
	        if( $custom_css != '' ) {
	            echo trim($custom_css);
	        }
	        if( $css_desktop != '' ) {
	            echo '@media (min-width: 1024px) { ' . ($css_desktop) . ' }'; 
	        }
	        if( $css_tablet != '' ) {
	            echo '@media (min-width: 768px) and (max-width: 1023px) {' . ($css_tablet) . ' }'; 
	        }
	        if( $css_wide_mobile != '' ) {
	            echo '@media (min-width: 481px) and (max-width: 767px) { ' . ($css_wide_mobile) . ' }'; 
	        }
	        if( $css_mobile != '' ) {
	            echo '@media (max-width: 480px) { ' . ($css_mobile) . ' }'; 
	        }
	        
		}?>

	<?php
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) {
			if (!empty($line)) {
				$new_lines[] = trim($line);
			}
		}

		$custom_css = implode($new_lines);

		return $custom_css;
	}
}

?>