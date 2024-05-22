<?php

$link = $google_fonts = $google_fonts_data = $font_container = $font_container_data = $empty_text = $only_image = $number = $el_class = $css = $css_animation = $loop_type = $auto_type = $autospeed_type = $disable_mobile = '';

extract( $this->getAttributes( $atts ) );

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

extract( $this->getStyles( $el_class . $this->getCSSAnimation( $css_animation ), $css, $google_fonts_data, $font_container_data, $atts ) );

$args                       =  puca_tbay_get_products_recently_viewed($number);
$products_list              =  puca_tbay_wc_track_user_get_cookie();
$all                        =  count($products_list);
$count                      =  (int)$args;
$args                       =  apply_filters('puca_list_recently_viewed_products_args', $args);

$loop                       = new WP_Query($args);

if ( ! empty( $styles ) ) {
	$style = 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
} else {
	$style = '';
}

//parse link
$link = ('||' === $link) ? '' : $link;
$link = vc_build_link($link);
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = $link['target'];
$a_rel = $link['rel'];
if (! empty($a_rel)) {
    $a_rel = ' rel="' . esc_attr(trim($a_rel)) . '"';
}

if( isset($responsive_type) && $responsive_type == 'yes') {
    $screen_desktop          =      isset($screen_desktop) ? $screen_desktop : 4;
    $screen_desktopsmall     =      isset($screen_desktopsmall) ? $screen_desktopsmall : 3;
    $screen_tablet           =      isset($screen_tablet) ? $screen_tablet : 3;
    $screen_mobile           =      isset($screen_mobile) ? $screen_mobile : 1;
} else {
    $screen_desktop          =      $columns;
    $screen_desktopsmall     =      3;
    $screen_tablet           =      3;
    $screen_mobile           =      1;  
}

$active_theme = puca_tbay_get_part_theme();

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter = 'tbay-addon tbay-addon-products product-recently-viewed tbay-addon-'. $layout_type .'';
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

$class_empty = ($loop->have_posts()) ? '' : 'content-empty';
?>

<div class="<?php echo esc_attr($css_class); ?>">

    <div class="wrapper-title-recently">
        <?php if ((isset($subtitle) && $subtitle) || (isset($title) && $title)): ?>
            <h3 class="tbay-addon-title" <?php echo trim($style); ?>>
                <?php if (isset($title) && $title): ?>
                    <span><?php echo trim($title); ?></span>
                <?php endif; ?>
                <?php if (isset($subtitle) && $subtitle): ?>
                    <span class="subtitle"><?php echo trim($subtitle); ?></span>
                <?php endif; ?>
            </h3>
        <?php endif; ?>

        <?php if (isset($check_link_rv) && $check_link_rv == 'yes' && '' !== $link && $all > $count) : ?>
            <a href="<?php echo esc_url($a_href); ?>" class="show-all" title="<?php echo esc_attr($a_title); ?>" target="<?php echo esc_attr($a_target); ?>"<?php echo trim($a_rel); ?>><?php echo trim($a_title); ?></a>
        <?php endif; ?>
    </div>

    
    <div class="tbay-addon-content woocommerce <?php echo esc_attr($class_empty); ?>">
        <?php if ($loop->have_posts()) : ?>
            
                <div class="<?php echo esc_attr($layout_type); ?>-wrapper">

                    <?php  wc_get_template( 'layout-products/'.$active_theme.'/'.$layout_type.'.php' , array( 'product_item'=> $product_item, 'loop' => $loop, 'data_loop' => $loop_type, 'data_auto' => $auto_type, 'data_autospeed' => $autospeed_type, 'columns' => $columns, 'rows' => $rows, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'screen_desktop' => $screen_desktop,'screen_desktopsmall' => $screen_desktopsmall,'screen_tablet' => $screen_tablet,'screen_mobile' => $screen_mobile, 'number' => $number, 'responsive_type' => $responsive_type, 'disable_mobile' => $disable_mobile ) ); ?>

                </div>
        <?php else: ?>
            <?php echo trim($empty_text); ?>
        <?php endif; ?>    
    </div>

</div>
