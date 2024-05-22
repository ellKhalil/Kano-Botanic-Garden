<?php


defined( 'ABSPATH' ) || exit;

global $product;
?>

<div class="product-item">
	<a title="<?php the_title_attribute(); ?>" href="<?php echo the_permalink(); ?>" class="product-image">
		<?php
			echo woocommerce_get_product_thumbnail();
		?>
	</a>
	<h3 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p class="price"><?php echo trim($product->get_price_html()); ?></p>
</div>