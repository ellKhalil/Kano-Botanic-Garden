<?php

$el_class = $css = $css_animation = $disable_mobile = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts ); 
$loop_type = $auto_type = $autospeed_type = '';

$cat_operator = 'IN';
extract( $atts );
$_id = puca_tbay_random_key();

if (isset($categoriestabs) && !empty($categoriestabs)):
    $categoriestabs = (array) vc_param_group_parse_atts( $categoriestabs );

$i = 0;

if( isset($responsive_type) ) {
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

$cat_array = array();
$args = array(
    'type' => 'post',
    'child_of' => 0,
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => false,
    'hierarchical' => 1,
    'taxonomy' => 'product_cat'
);

$categories = get_categories( $args );
puca_tbay_get_category_childs( $categories, 0, 0, $cat_array );

$cat_array_id   = array();
foreach ($cat_array as $key => $value) {
    $cat_array_id[]   = $value;
}

$active_theme = puca_tbay_get_part_theme();

$css = isset( $atts['css'] ) ? $atts['css'] : '';
$el_class = isset( $atts['el_class'] ) ? $atts['el_class'] : '';

$class_to_filter = 'widget widget-products widget-categoriestabs ';

if( (isset($tab_title_center) && $tab_title_center == 'yes') ) {
    $class_to_filter .= 'title-center '; 
}

if( $ajax_tabs === 'yes' ) { 
    $el_class           .= ' tbay-product-categories-tabs-ajax ajax-active';

    $responsive = array(
        'desktop'       => $screen_desktop,
        'desktopsmall'  => $screen_desktopsmall,
        'tablet'        => $screen_tablet,
        'mobile'        => $screen_mobile,
    );

    $data_carousel = array(
        'nav_type'          => $nav_type,
        'pagi_type'         => $pagi_type,
        'loop_type'         => $loop_type,
        'auto_type'         => $auto_type,
        'autospeed_type'    => $autospeed_type,
        'disable_mobile'    => $disable_mobile,
        'rows'              => $rows,
    );

    
    $json = array(
        'cat_operator'                  => $cat_operator,
        'limit'                         => $number,
        'responsive'                    => $responsive, 
        'columns'                       => $columns, 
        'layout_type'                   => $layout_type,
        'product_type'                  => $type_product,
        'data_carousel'                 => $data_carousel,
    ); 

    $json = apply_filters( 'puca_ajax_vc_categoriestabs', $json, 10, 1 );

    $encoded_settings  = wp_json_encode( $json );

    $tabs_data = 'data-atts="'. esc_attr( $encoded_settings ) .'"';
} else {
    $tabs_data = '';
}

$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

?>

    <div class="<?php echo esc_attr($css_class); ?>">
        <?php if( (isset($subtitle) && $subtitle) || (isset($title) && $title)  ): ?>
            <h3 class="widget-title">
                <?php if ( isset($title) && $title ): ?>
                    <span><?php echo esc_html( $title ); ?></span>
                <?php endif; ?>
                <?php if ( isset($subtitle) && $subtitle ): ?>
                    <span class="subtitle"><?php echo esc_html($subtitle); ?></span>
                <?php endif; ?>
            </h3>
        <?php endif; ?>
        <div class="widget-content woocommerce">
            <ul role="tablist" class="product-categories-tabs-title tabs-list nav nav-tabs" <?php echo trim($tabs_data); ?>>
                <?php foreach ($categoriestabs as $tab) : ?>

                    <?php
                    $iconClass = ( isset($tab['icon_font']) ) ? $tab['icon_font'] :  '';
                    if( !in_array($tab['category'], $cat_array_id) ) {
                        $cat_category    = 'all-categories';
                        $cat_name        = esc_html__('All Categories','puca');
                        $slug            = '';
                    } else {
                        $cat_category    = $tab['category'];
                        $category        = get_term_by( 'id', $cat_category, 'product_cat' );
                        $cat_name        = $category->name;
                        $slug            = puca_get_transliterate($category->slug);
                    }

                    ?> 
 
                    <?php 
                        $li_class = ($i == 0 ? ' class=active' : '');
                    ?>
                    <li <?php echo esc_attr( $li_class ); ?>>
                        <a href="#tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($i); ?>" data-value="<?php echo esc_attr($slug); ?>" data-toggle="tab">
                            <?php if ( isset($tab['image']) && !empty($tab['image']) ): ?>
                                <?php $img = wp_get_attachment_image_src($tab['image'], 'full'); ?>
                                <?php if ( isset($img[0]) ) { ?>
                                    <img src="<?php echo esc_url( $img[0] );?>" alt="<?php echo esc_attr( $title ); ?>"  />
                                <?php } ?>
                            <?php elseif ( !empty( $iconClass) ): ?>
                                <i class="<?php echo esc_attr($iconClass); ?>"></i>
                            <?php endif; ?>
                            <?php echo esc_html($cat_name); ?>
                        </a>
                    </li>

                <?php $i++; endforeach; ?>
            </ul>
            <div class="widget-inner">
                <?php if( !empty($image_cat) ) : ?>
                    <?php $img = wp_get_attachment_image_src($image_cat,'full'); ?>
                    <div class="col-lg-3 hidden-md hidden-sm hidden-xs <?php echo esc_attr( $image_float );?>">
                        <img src="<?php echo esc_url($img[0]); ?>">
                    </div>
                <?php endif; ?>
                <div class="tab-content-wrapper <?php echo !empty($image_cat) ? 'col-lg-9 col-xs-12' : ''; ?>">
                    <div class="tbay-addon-content tab-content">
                        <?php $_count = 0; foreach ($categoriestabs as $tab) : ?>
 

                            <?php 
                                $tab_active = ($_count == 0) ? ' active active-content current' : '';
                            ?>

                            <div id="tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($_count); ?>" class="tab-pane <?php echo esc_attr( $tab_active );  ?>">

                                <?php 
                                    if( !in_array($tab['category'], $cat_array_id) ) {
                                        $loop            = puca_tbay_get_products( -1 , $type_product, 1, $number );
                                        $link            = get_permalink( wc_get_page_id( 'shop' ) );
                                    } else {
                                        $category   = get_term_by( 'id', $tab['category'], 'product_cat' );
                                        $cat_category = $category->slug;
                                        $link       = get_category_link( $tab['category'] );

                                        $loop       = puca_tbay_get_products( array($cat_category), $type_product, 1, $number );
                                    }   
                                ?>
                                <?php if( $_count === 0 || $ajax_tabs !== 'yes' ) : ?> 

                                <?php 
                                    wc_get_template( 'layout-products/'.$active_theme.'/'.$layout_type.'.php' , array( 'loop' => $loop, 'data_loop' => $loop_type, 'data_auto' => $auto_type, 'data_autospeed' => $autospeed_type, 'columns' => $columns, 'rows' => $rows, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'responsive_type' => $responsive_type,'screen_desktop' => $screen_desktop,'screen_desktopsmall' => $screen_desktopsmall,'screen_tablet' => $screen_tablet,'screen_mobile' => $screen_mobile, 'number' => $number, 'disable_mobile' => $disable_mobile ) );
                                ?>

                                <?php endif; ?>

                                <?php if($layout_type != 'carousel') { ?>
                                    <a href="<?php echo esc_url( $link ); ?>" class="btn btn-block btn-view-all"><?php echo esc_html__('view all', 'puca'); ?><i class="icon-arrow-right icons"></i></a>
                                <?php } ?>

                            </div>

                        <?php $_count++; endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>