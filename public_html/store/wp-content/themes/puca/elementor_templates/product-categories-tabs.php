<?php 
/**
 * Templates Name: Elementor
 * Widget: Product Categories Tabs
 */
$style = $tab_title_center = '';
extract( $settings );

if( $tab_title_center === 'yes' ) {
    $this->add_render_attribute('wrapper', 'class', 'title-center');
}

if( !empty($_css_classes) ) {  
	$this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->add_render_attribute('wrapper', 'class', [$style, 'widget-categoriestabs']);

if( $ajax_tabs === 'yes' ) {
    $this->add_render_attribute('wrapper', 'class', ['tbay-product-categories-tabs-ajax', 'ajax-active']); 
}

if( empty($categories) ) return;

$this->settings_layout();

$this->add_render_attribute('wrapper', 'class', [ 'woocommerce', 'widget-products', 'widget-categoriestabs', $layout_type] );
$this->add_render_attribute('wrapper-content', 'class', ['widget-content', 'woocommerce'] );
 
$random_id = puca_tbay_random_key();
?>
 
<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
    <div <?php echo $this->get_render_attribute_string('wrapper-content'); ?>>

        <?php 
            $this->render_element_heading();
            $this->render_tabs_title($categories, $random_id);
            $this->render_product_tabs_content($categories, $random_id);
        ?>
    </div>
</div>