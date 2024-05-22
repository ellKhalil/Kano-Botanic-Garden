<?php   
	global $woocommerce; 
	$_id = puca_tbay_random_key();
?>
<div class="tbay-topcart">
 <div id="cart-<?php echo esc_attr($_id); ?>" class="cart-dropdown cart-popup dropdown version-1">
        <a class="dropdown-toggle mini-cart" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0" href="#" title="<?php esc_attr_e('View your shopping cart', 'puca'); ?>">
            
			<span class="text-skin cart-icon">
				<i class="tb-icon tb-icon-zz-bag"></i>
			</span>
			<span class="title-mini-cart"><?php echo esc_html__('Shopping bag','puca')?></span>
			
			<span class="mini-cart-items"><?php echo sprintf('%d',$woocommerce->cart->cart_contents_count);?></span>
            
        </a>            
        <div class="dropdown-menu"><div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div></div>
    </div>
</div>    