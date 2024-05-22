<?php

$tabs_style = $el_class = $css = $css_animation = $disable_mobile = '';
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

$class_to_filter = 'widget widget-products widget-categoriestabs widget-categoriestabs-market2 '. $tabs_style .' ';

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
        'data_carousel'                 => $data_carousel,
    );

    $json = apply_filters( 'puca_ajax_vc_supermaket2_categoriestabs', $json, 10, 1 );

    $encoded_settings  = wp_json_encode( $json );

    $tabs_data = 'data-atts="'. esc_attr( $encoded_settings ) .'"';
} else {
    $tabs_data = '';
}

$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts ); 

?>


<?php 
    /*Tabs style 1*/
    if( isset($tabs_style) && $tabs_style == 'style1' ) : 
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
                <?php $_count = 0; foreach ($categoriestabs as $tab) : ?>

                <?php 

                    $type_product = $tab['producttabs']; 
                    if( !in_array($tab['category'], $cat_array_id) ) {
                        $slug            = '';
                    } else {
                        $category   = get_term_by( 'id', $tab['category'], 'product_cat' );
                        $slug       = puca_get_transliterate($category->slug);   
                    }


                    if( isset($show_catname_tabs) && $show_catname_tabs == 'yes' ) {

                        if( !in_array($tab['category'], $cat_array_id) ) {
                            $tab_name = esc_html__('All category','puca');
                        } else {
                            $tab_name   = $category->name;      
                        }

                    } else {
                        $tab_slug = (isset($tab['producttabs'])) ? $tab['producttabs'] : '';
                        switch ($tab_slug) {
                            case 'recent_product':
                                $tab_name = esc_html__('New Arrivals', 'puca');
                                break;                            
                            case 'featured_product':
                                $tab_name = esc_html__('Featured Products', 'puca');
                                break;                           
                            case 'best_selling':
                                $tab_name = esc_html__('Best Sellers', 'puca');
                                break;                            
                            case 'top_rate':
                                $tab_name = esc_html__('Top Rated', 'puca');
                                break;                            
                            case 'on_sale':
                                $tab_name = esc_html__('On Sale', 'puca');
                                break;
                            
                            default:
                                $tab_name = esc_html__('New Arrivals', 'puca');
                                break;
                        }
                    }
                
                ?> 

                <?php 
                    $li_class = ($_count == 0 ? ' class=active' : '');
                ?>
                <li <?php echo esc_attr( $li_class ); ?>>
                    <a href="#tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($_count); ?>" data-value="<?php echo esc_attr($slug); ?>" data-type="<?php echo esc_attr($type_product); ?>" data-toggle="tab">
                        <?php echo esc_html($tab_name); ?>
                    </a>
                </li>

                <?php $_count++; endforeach; ?>
            </ul>
            <div class="widget-inner">

                <div class="tab-content-product">
                    <div class="tbay-addon-content tab-content">
                        <?php $_count = 0; foreach ($categoriestabs as $tab) : ?>

                            <?php 
                                $tab_active = ($_count == 0) ? ' active active-content current' : '';
                            ?>

                            <div id="tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($_count); ?>" class="tab-pane animated fadeIn <?php echo esc_attr( $tab_active ); ?>">

                                <div class="tab-menu-banner-brand">
                                    
                                    <div class="row">

                                        <div class="col-sm-6 col-md-4 hidden-xs tab-menu">
                                            <div class="tab-menu-wrapper">
                                                <?php 
                                                    $menu_id = $tab['nav_menu'];
                                                    puca_get_custom_menu($menu_id);
                                                ?>
                                            </div>
                                        </div>                        


                                        <?php 
                                            $banner = $tab['banner'];

                                            $img = wp_get_attachment_image_src($banner,'full'); 
                                        ?>

                                        <?php if ( !empty($img) && isset($img[0]) ): ?>
                                            <div class="col-sm-6 col-md-4 hidden-xs tab-banner">
                                            <?php if(isset($tab['banner_link']) && !empty($tab['banner_link'])) : ?>
                                                <?php 
                                                    $link   = $tab['banner_link'];    
                                                ?>
                                                <div class="img-banner">
                                                    <a href="<?php echo esc_url($link); ?>">
                                                        <?php 
                                                            $image_alt  = get_post_meta( $banner, '_wp_attachment_image_alt', true);
                                                        ?>
                                                        <img src="<?php echo esc_url($img[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                                    </a>
                                                </div>
                                            <?php else : ?>
                                                <div class="img-banner">
                                                    <?php 
                                                        $image_alt  = get_post_meta( $banner, '_wp_attachment_image_alt', true);
                                                    ?>
                                                    <img src="<?php echo esc_url($img[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                                </div>
                                            <?php endif; ?>
                                            </div>  
                                        <?php endif; ?>
                      

                                        <?php $gallerys = $tab['gallerys']; ?>
                                        <?php if( isset($gallerys) && !empty($gallerys) ) : ?>
                                        <div class="col-md-4 hidden-sm hidden-xs tab-gallery">
                                            <div class="gallery-content">
                                            <?php $gallerys = $gallerys ? explode(',', $gallerys) : array(); ?>
                                            <?php foreach ($gallerys as $value) { ?>
                                                <?php $img = wp_get_attachment_image_src($value,'full'); ?>
                                                <?php if ( !empty($img) && isset($img[0]) ): ?>
                                                    <div class="image">
                                                        <?php 
                                                            $image_alt  = get_post_meta( $value, '_wp_attachment_image_alt', true);
                                                        ?>
                                                        <img src="<?php echo esc_url($img[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                                    </div>
                                                <?php endif; ?>
                                            <?php } ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                    </div>

                                </div>

                                <div class="tab-ajax-content">
                                    <?php 
                                        if( $_count === 0 || $ajax_tabs !== 'yes' ) {
                                            $type = $tab['producttabs'];

                                            if( !in_array($tab['category'], $cat_array_id) ) {
                                                $loop            = puca_tbay_get_products( -1 , $type, 1, $number );
                                            } else {
                                                $category       = get_term_by( 'id', $tab['category'], 'product_cat' );
                                                $cat_category   = $category->slug;
                                                $loop           = puca_tbay_get_products( array($cat_category), $type, 1, $number );
                                            }


                                            wc_get_template( 'layout-products/'.$active_theme.'/'.$layout_type.'.php' , array( 'loop' => $loop, 'data_loop' => $loop_type, 'data_auto' => $auto_type, 'data_autospeed' => $autospeed_type, 'columns' => $columns, 'rows' => $rows, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'responsive_type' => $responsive_type,'screen_desktop' => $screen_desktop,'screen_desktopsmall' => $screen_desktopsmall,'screen_tablet' => $screen_tablet,'screen_mobile' => $screen_mobile, 'number' => $number, 'disable_mobile' => $disable_mobile ) );
                                        }

                                    ?>
                                </div>

                            </div>

                        <?php $_count++; endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php 
    /*Tabs style 2*/
    elseif( isset($tabs_style) && $tabs_style == 'style2' ) : 
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
                <?php $_count = 0; foreach ($categoriestabs as $tab) : ?>

                <?php 

                    if( isset($show_catname_tabs) && $show_catname_tabs == 'yes' ) {

                        if( !in_array($tab['category'], $cat_array_id) ) {
                            $tab_name = esc_html__('All category','puca');
                            $slug            = '';
                        } else {
                            $category   = get_term_by( 'id', $tab['category'], 'product_cat' );
                            $tab_name   = $category->name;     
                            $slug       = puca_get_transliterate($category->slug);       
                        }


                    } else {
                        $tab_slug = (isset($tab['producttabs'])) ? $tab['producttabs'] : '';
                        switch ($tab_slug) {
                            case 'recent_product':
                                $tab_name = esc_html__('New Arrivals', 'puca');
                                break;                            
                            case 'featured_product':
                                $tab_name = esc_html__('Featured Products', 'puca');
                                break;                           
                            case 'best_selling':
                                $tab_name = esc_html__('Best Seller', 'puca');
                                break;                            
                            case 'top_rate':
                                $tab_name = esc_html__('Top Rated', 'puca');
                                break;                            
                            case 'on_sale':
                                $tab_name = esc_html__('On Sale', 'puca');
                                break;
                            
                            default:
                                $tab_name = esc_html__('New Arrivals', 'puca');
                                break;
                        }
                    }
                
                ?> 
                <?php 
                    $li_class = ($_count == 0 ? ' class="active"' : '');
                ?>
                <li <?php echo trim( $li_class ); ?>>
                    <a href="#tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($_count); ?>" data-value="<?php echo esc_attr($slug); ?>" data-toggle="tab">
                        <?php echo esc_html($tab_name); ?>
                    </a>
                </li>

                <?php $_count++; endforeach; ?>
            </ul>
            <div class="widget-inner">

                <div class="tab-content-product">
                    <div class="tbay-addon-content tab-content">
                        <?php $_count = 0; foreach ($categoriestabs as $tab) : ?>


                            <?php 

                                $type_product = $tab['producttabs'];

                                if( !in_array($tab['category'], $cat_array_id) ) {
                                    $loop            = puca_tbay_get_products( -1 , $type_product, 1, $number );
                                } else {
                                    $category       = get_term_by( 'id', $tab['category'], 'product_cat' );
                                    $cat_category   = $category->slug;
                                    $loop           = puca_tbay_get_products( array($cat_category), $type_product, 1, $number );
                                }


                                $tab_active = ($_count == 0) ? ' active active-content current' : '';
                            ?>

                            <div id="tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($_count); ?>" class="tab-pane <?php echo esc_attr( $tab_active ); ?>">

                                <div class="row">


                                    <div class="tab-left hidden-sm hidden-xs col-md-6 tab-banner-menu-gallery">

                                        <?php 
                                            $banner = $tab['banner'];
                                            $link   = $tab['banner_link'];

                                            $img = wp_get_attachment_image_src($banner,'full'); 
                                        ?>
                                        <?php if ( !empty($img) && isset($img[0]) ): ?>
                                            <div class="hidden-xs tab-banner">
                                            <?php if(isset($link) && !empty($link)) : ?>
                                                <div class="img-banner">
                                                    <a href="<?php echo esc_url($link); ?>">
                                                        <?php 
                                                            $image_alt  = get_post_meta( $banner, '_wp_attachment_image_alt', true);
                                                        ?>
                                                        <img src="<?php echo esc_url($img[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                                    </a>
                                                </div>
                                            <?php else : ?>
                                                <div class="img-banner">
                                                    <?php 
                                                        $image_alt  = get_post_meta( $banner, '_wp_attachment_image_alt', true);
                                                    ?>
                                                    <img src="<?php echo esc_url($img[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                                </div>
                                            <?php endif; ?>
                                            </div> 
                                        <?php endif; ?>

                                        <div class="menu-gallery">

                                            <div class="tab-menu-wrapper">
                                                <?php 
                                                    $menu_id = $tab['nav_menu'];
                                                    puca_get_custom_menu($menu_id);
                                                ?>
                                            </div>  


                                            <?php $gallerys = $tab['gallerys']; ?>
                                            <?php if( isset($gallerys) && !empty($gallerys) ) : ?>
                                            <div class="tab-gallery">

                                                <?php $gallerys = $gallerys ? explode(',', $gallerys) : array(); ?>
                                                <?php foreach ($gallerys as $value) { ?>
                                                    <?php $img = wp_get_attachment_image_src($value,'full'); ?>
                                                    <?php if ( !empty($img) && isset($img[0]) ): ?>
                                                        <div class="image">
                                                            <?php 
                                                                $image_alt  = get_post_meta( $value, '_wp_attachment_image_alt', true);
                                                            ?>
                                                            <img src="<?php echo esc_url($img[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                                        </div>
                                                    <?php endif; ?>
                                                <?php } ?>
                                            </div>
                                            <?php endif; ?>

                                        </div>
    

                                    </div>

                                    <div class="tab-ajax-content tab-right col-sm-12 col-md-6">
                                        <?php 
                                            if ($_count === 0 || $ajax_tabs !== 'yes') {
                                                wc_get_template( 'layout-products/'.$active_theme.'/'.$layout_type.'.php' , array( 'loop' => $loop, 'data_loop' => $loop_type, 'data_auto' => $auto_type, 'data_autospeed' => $autospeed_type, 'columns' => $columns, 'rows' => $rows, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'responsive_type' => $responsive_type,'screen_desktop' => $screen_desktop,'screen_desktopsmall' => $screen_desktopsmall,'screen_tablet' => $screen_tablet,'screen_mobile' => $screen_mobile, 'number' => $number, 'disable_mobile' => $disable_mobile ) );
                                            }  
                                        ?>
                                    </div>
                                </div>



                            </div>

                        <?php $_count++; endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; /*End check style tabs*/ ?>

<?php endif; /*close without tabs*/ ?>