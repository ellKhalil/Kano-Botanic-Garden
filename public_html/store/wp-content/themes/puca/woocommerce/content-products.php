<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;
	
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid

if( !empty($columns) ) {
	$woocommerce_loop['columns'] = $columns;
} else if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

$active_theme = puca_tbay_get_part_theme();

// Increase loop count

// Extra post classes
$classes = array('grid');
?>
<div <?php wc_product_class( $classes, $product ); ?>>
	<?php $product_item = isset($product_item) ? $product_item : 'inner'; ?>
 	<?php wc_get_template_part( 'item-product/'.$active_theme.'/'.$product_item ); ?>
</div>
