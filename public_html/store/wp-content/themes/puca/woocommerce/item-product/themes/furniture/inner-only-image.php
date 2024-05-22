<?php 
	global $product;
?>
<div class="product-block inner-only-image <?php puca_is_product_variable_sale(); ?>" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
	<div class="product-content">
		<div class="block-inner">
			<figure class="image">
				<a title="<?php the_title_attribute(); ?>" href="<?php echo the_permalink(); ?>" class="product-image">
					<?php
						echo woocommerce_template_loop_product_thumbnail();
					?>
				</a>
			</figure>
			
		</div>
    </div>
    
</div>
