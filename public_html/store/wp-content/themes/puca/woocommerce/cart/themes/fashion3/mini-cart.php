<?php
$_id = puca_tbay_random_key();
?>

<?php do_action('woocommerce_before_mini_cart'); ?>
<div class="mini_cart_content">
	<div class="mini_cart_inner">
		<div class="mcart-border">
			<?php if ( ! WC()->cart->is_empty() ) : ?>
				<ul class="cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
					<?php
					foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item) {
						$_product     = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
						$product_id   = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

						if($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {

							$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
							$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_gallery_thumbnail'), $cart_item, $cart_item_key );
							$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

							?>
							<li id="mcitem-<?php echo esc_attr($_id);?>-<?php echo esc_attr($cart_item_key); ?>">
								<div class="product-image">
									<?php if ( empty( $product_permalink ) ) : ?>
										<?php echo trim($thumbnail); ?>
									<?php else : ?>
										<a href="<?php echo esc_url( $product_permalink ); ?>">
											<?php echo trim($thumbnail); ?>
										</a>
									<?php endif; ?>
								</div>	

								<div class="product-details">

									<?php if ( empty( $product_permalink ) ) : ?>
										<?php echo wp_kses_post( $product_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<?php else : ?>
										<a href="<?php echo esc_url( $product_permalink ); ?>">
											<?php echo wp_kses_post( $product_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</a>
									<?php endif; ?>

									<div class="group">
										<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
										<div class="group-content">
											<?php 
												if (puca_tbay_get_config('show_mini_cart_qty', false)) {
													if ($_product->is_sold_individually()) :
														$product_quantity = sprintf('<input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key); else :
														$product_quantity = woocommerce_quantity_input(
															array(
																'input_name'   => 'cart[' . $cart_item_key . '][qty]',
																'input_value'  => $cart_item['quantity'],
																'max_value'    => $_product->get_max_purchase_quantity(),
																'min_value'    => '0',
																'product_name' => $product_name
															),
															$_product,
															false
														);
													endif;

													echo '<span class="quantity-wrap">' . apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item) . '</span>'; // PHPCS: XSS ok.
												} else {
													?>
													<span class="quantity">
														(x<?php echo apply_filters('woocommerce_widget_cart_item_quantity',  sprintf('%s', $cart_item['quantity']) , $cart_item, $cart_item_key); ?>)
													</span>
													<?php
												}
											?>

											<?php echo apply_filters('woocommerce_widget_cart_item_quantity',  sprintf('%s', $product_price) , $cart_item, $cart_item_key); ?>
										</div>
									</div>

									<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									    '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-product_sku="%s" data-cart_item_key="%s"><i class="tb-icon tb-icon-zz-cancel-1"></i></a>',
									    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									    esc_html__( 'Remove this item', 'puca' ),
									    esc_attr( $product_id ), 
									    esc_attr( $_product->get_sku() ),
									    esc_attr( $cart_item_key )
									), $cart_item_key ); 
									?>

								</div>
							</li>
							<?php
						}
					}
					?>
				</ul><!-- end product list -->
			<?php else: ?>
				<ul class="cart_empty <?php echo esc_attr($args['list_class']); ?>">
					<li><?php esc_html_e('You have no items in your shopping cart', 'puca'); ?></li>
					<li class="total"><a class="button wc-continue" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"> <?php esc_html_e( 'Continue Shopping', 'puca' ) ?> </a></li>
				</ul>
			<?php endif; ?>

			<?php if(sizeof(WC()->cart->get_cart()) > 0) : ?>
				<div class="group-button">
					<p class="total">
						<?php do_action('woocommerce_widget_shopping_cart_total'); ?>
					</p>

					<?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>

					<p class="buttons">
						<a href="<?php echo esc_url( wc_get_checkout_url() );?>" class="button checkout"><?php esc_html_e('Checkout', 'puca'); ?></a>
						<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button view-cart"><?php esc_html_e('View Cart', 'puca'); ?></a>	
					</p>
				</div>
			<?php endif; ?>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<?php do_action('woocommerce_after_mini_cart'); ?>