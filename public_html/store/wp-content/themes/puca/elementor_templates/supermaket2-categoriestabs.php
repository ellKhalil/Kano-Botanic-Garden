<?php 
/**
 * Templates Name: Elementor
 * Widget: Products Supermaket2 Category Tabs 2
 */

extract( $settings );

if( !empty($_css_classes) ) {  
	$this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->settings_layout();

$this->add_render_attribute('wrapper', 'class', ['widget-categoriestabs', 'widget-categoriestabs-market2', $style] );

$random_id = puca_tbay_random_key();

if( $ajax_tabs === 'yes' ) {
    $this->add_render_attribute('wrapper', 'class', ['tbay-product-categories-tabs-ajax', 'ajax-active']); 
}
?>

<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
    <?php $this->render_element_heading(); ?>
 
    <div class="widget-content woocommerce">

        <?php $this->render_supermaket2_tabs_title($random_id); ?>
        
        <?php $this->render_content_tab($random_id); ?>


    </div>

</div>