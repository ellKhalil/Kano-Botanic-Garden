<?php 
/**
 * Templates Name: Elementor
 * Widget: Products Tabs
 */
$style = '';
$rows_default = 1;
extract( $settings );

if( !empty($_css_classes) ) {  
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->settings_layout();

$random_id = puca_tbay_random_key();

$this->add_render_attribute('wrapper', 'class', [$style, 'widget-product-tabs']);
$this->add_render_attribute('wrapper', 'class', ['widget-products', 'widget-product-tabs', 'widget-'. $layout_type] );

if ($ajax_tabs === 'yes') {
    $attr_row = $this->get_render_attribute_string('row'); 

    $rows = ( !empty($rows) ) ? $rows : $rows_default;
    $json = array(
        'categories'                    => $categories,
        'cat_operator'                  => $cat_operator,
        'limit'                         => $limit,
        'orderby'                       => $orderby, 
        'order'                         => $order,
        'attr_row'                      => $attr_row, 
        'layout_type'                   => $layout_type,
        'rows'                          => $rows,  
    );    

    $json = apply_filters( 'puca_ajax_elementor_product_tabs', $json, 10, 1 );

    $encoded_settings  = wp_json_encode( $json ); 

    $tabs_data = 'data-atts="'. esc_attr( $encoded_settings ) .'"';

    $this->add_render_attribute('wrapper', 'class', ['tbay-product-tabs-ajax', 'ajax-active']); 
} else {
    $tabs_data = ''; 
}

?>
<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
    

    
    <div class="tabs-container tab-heading text-center clearfix tab-v8">
        <?php $this->render_element_heading(); ?>
        <ul class="product-tabs-title tabs-list nav nav-tabs" <?php echo trim($tabs_data); ?>>
            <?php $_count = 0;?>
            <?php foreach ($list_product_tabs as $key) {
                $active = ($_count==0) ? 'active' : '';

                $product_tabs = $key['product_tabs'];
                $title = $this->get_title_product_type($product_tabs);
                if(!empty($key['product_tabs_title']) ) {
                    $title = $key['product_tabs_title'];
                }

                $this->render_product_tabs($product_tabs, $key['_id'], $random_id, $title, $active);

                $_count++;   
            }
            ?>
        </ul>
    </div>

    <?php $this->render_product_tabs_content($list_product_tabs, $random_id); ?>

    <?php $this->render_item_button(); ?>

</div>