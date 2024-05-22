<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $woocommerce;

wp_dequeue_script('photoswipe-ui-default');
wp_dequeue_script('photoswipe');

wp_enqueue_script('jquery-magnific-popup');
wp_enqueue_style('magnific-popup');
wp_enqueue_script( 'slick' );
wp_enqueue_script( 'puca-custom-slick' );

$post_thumbnail_id = $product->get_image_id();

$attachment_ids = $product->get_gallery_image_ids();
$class_thumbnail = '';
if( empty($attachment_ids) ) {
	$class_thumbnail = 'no-gallery-image';
}

?>
<div class="images <?php echo esc_attr($class_thumbnail); ?>">
		<?php do_action( 'tbay_product_video' ); ?>
	<?php
		if ( has_post_thumbnail() ) 
		{

			$attachment_ids = $product->get_gallery_image_ids();

			
			$attachment_count = count( $attachment_ids);
			
			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
			$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'woocommerce_single' ), array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
			) );
			
			$fullimage        = get_the_post_thumbnail( $post->ID, 'full', array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
			) );

			$imgfull_src 	 = wp_get_attachment_image_url( get_post_thumbnail_id(),'full');
			$image_src   	 = wp_get_attachment_image_url( get_post_thumbnail_id(), 'woocommerce_single');

			$image_data = wp_get_attachment_metadata( get_post_thumbnail_id() );
			$width 		= $image_data['width'];
			$height 	= $image_data['height'];

			$alt         = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
			$image_title = get_the_title(get_post_thumbnail_id());
			$image_alt   = $alt ? $alt : $image_title;

			// tbay FOR SLIDER
			$html  = '<section id="product-sliders-gallery" class="slider tbay-slider-for">';
			
			$html .= sprintf(
				'<div class="zoom"><img alt="%s" class="skip-lazy" src="%s"/><a href="%s" data-caption="%s" data-width="%s" data-height="%s" class="tbay-popup slider-gallery"></a></div>',
				$image_alt,
				$image_src,
				$imgfull_src,
				$image_alt,
				$width,
				$height
			); 
			
			foreach( $attachment_ids as $attachment_id ) {
				$imgfull_src 	 = wp_get_attachment_image_url( $attachment_id,'full');
				$image_src   	 = wp_get_attachment_image_url( $attachment_id, 'woocommerce_single');
	
				$image_data = wp_get_attachment_metadata( $attachment_id );
				$width 		= $image_data['width'];
				$height 	= $image_data['height'];
	
				$alt         = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
				$image_title = get_the_title( $attachment_id) ;
				$image_alt   = $alt ? $alt : $image_title;

			   $html .= sprintf(
					'<div class="zoom"><img alt="%s" class="skip-lazy" src="%s" /><a href="%s" data-caption="%s" data-width="%s" data-height="%s" class="tbay-popup slider-gallery"></a></div>',
					$image_alt,
					$image_src,
					$imgfull_src,
					$image_alt,
					$width,
					$height
				);
			}
			
			$html .= '</section>';
			
			echo apply_filters(
				'woocommerce_single_product_image_html', $html, $post_thumbnail_id
			);
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_html__( 'Placeholder', 'puca' ) ), $post->ID );
		}

		do_action( 'woocommerce_product_thumbnails' );
	?>
	<?php 
		do_action( 'puca_woocommerce_after_product_thumbnails' );
	?>
</div>