<?php
/**
 * Templates Name: Elementor
 * Widget: Product Recently Viewed
 */

extract($settings);

if (isset($limit) && !((bool) $limit)) {
    return;
}

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->settings_layout();

$this->add_render_attribute('wrapper', 'class', ['tbay-addon-products', 'product-recently-viewed', 'tbay-addon-'. $layout_type]);
?>

<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>

    
	
	<div class="wrapper-title-recently">
		<?php $this->render_element_heading(); ?> 
		<?php $this->render_btn_readmore($limit); ?>
	</div>
    <?php
		$class = ($product_item == 'inner-only-image') ? $product_item : ''
	?>
	
	<div class="tbay-addon-content woocommerce <?php echo esc_attr($class); ?>">
		<div class="<?php echo esc_attr($layout_type); ?>-wrapper">
			<?php $this->render_content_main(); ?>    
		</div> 
	</div>

	
</div>