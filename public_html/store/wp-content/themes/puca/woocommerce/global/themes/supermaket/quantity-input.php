<?php

/* translators: %s: Quantity. */
$label = !empty($args['product_name']) ? sprintf(esc_html__('%s quantity', 'puca'), wp_strip_all_tags($args['product_name'])) : esc_html__('Quantity', 'puca');

?>
<div class="quantity <?php echo esc_attr($type); ?>">
	<?php
    /**
     * Hook to output something before the quantity input field.
     *
     * @since 7.2.0
     */
    do_action('woocommerce_before_quantity_input_field');
    ?>
	<label class="screen-reader-text" for="<?php echo esc_attr($input_id); ?>"><?php echo esc_html($label); ?></label>
	<div class="box">
		<button class="minus" type="button" value="&#160;"><i class="icon-minus icons"></i></button>
		<input 
			type="<?php echo esc_attr($type); ?>"
			<?php echo esc_attr($readonly ? 'readonly="readonly"' : ''); ?>
			id="<?php echo esc_attr($input_id); ?>"
			class="<?php echo esc_attr(join(' ', (array) $classes)); ?>"
			min="<?php echo esc_attr($min_value); ?>" 
			max="<?php echo esc_attr(0 < $max_value ? $max_value : ''); ?>" 
			name="<?php echo esc_attr($input_name); ?>" 
			value="<?php echo esc_attr($input_value); ?>" 
			title="<?php echo esc_attr_x('Qty', 'Product quantity input tooltip', 'puca'); ?>" 
			size="4" 
			<?php if (!$readonly): ?>
				step="<?php echo esc_attr($step); ?>" 
				placeholder="<?php echo esc_attr($placeholder); ?>"
				inputmode="<?php echo esc_attr($inputmode); ?>" 
				autocomplete="<?php echo esc_attr(isset($autocomplete) ? $autocomplete : 'on'); ?>"
			<?php endif; ?>
		/>
			<button class="plus" type="button" value="&#160;"><i class="icon-plus icons"></i></button>
	</div>
	<?php
    /**
     * Hook to output something after quantity input field.
     *
     * @since 3.6.0
     */
    do_action('woocommerce_after_quantity_input_field');
    ?>
</div>