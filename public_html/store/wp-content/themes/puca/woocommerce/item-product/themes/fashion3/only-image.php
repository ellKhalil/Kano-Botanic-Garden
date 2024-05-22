<?php 
global $product;
$rating	= wc_get_rating_html( $product->get_average_rating());
$flash_sales 	= isset($flash_sales) ? $flash_sales : false;
$end_date 		= isset($end_date) ? $end_date : '';

$class = array(); 
$class_flash_sale = puca_tbay_class_flash_sale($flash_sales);
array_push($class, $class_flash_sale);
?>   
<div class="product-block only-image <?php puca_is_product_variable_sale(); ?>" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
	<div class="product-content">
		<div class="block-inner">
			<figure class="image">
				<a title="<?php the_title_attribute(); ?>" href="<?php echo the_permalink(); ?>" class="product-image">
					<?php
						/**
						* woocommerce_before_shop_loop_item_only_img hook
						*
						* @hooked puca_tbay_product_display_image_mode - 10
						*/ 
						do_action( 'woocommerce_before_shop_loop_item_only_img' );
					?>
				</a>
				
			</figure>

		</div>
		
    </div>
</div>
  