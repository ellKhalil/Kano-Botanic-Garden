<?php if ( has_nav_menu( 'primary' ) ) : ?>

    <?php 
        $tbay_location = 'primary';
        $locations  = get_nav_menu_locations();
        $menu_id    = $locations[ $tbay_location ] ;
        $menu_obj   = wp_get_nav_menu_object( $menu_id );
        $menu_name = $menu_obj->slug;
    ?>
    <nav data-duration="400" class="menu hidden-xs hidden-sm tbay-megamenu slide animate navbar">
    <?php
        $args = array(
            'theme_location' => 'primary',
            'container_class' => 'collapse navbar-collapse',
            'menu_class' => 'nav navbar-nav',
            'fallback_cb' => '',
            'menu_id' => 'primary-menu-vertical',
            'items_wrap'  => '<ul id="%1$s" class="%2$s" data-id="'. $menu_name .'">%3$s</ul>',
			'walker' => new puca_Tbay_Nav_Menu()
        );
        wp_nav_menu($args);
    ?>
    </nav>
    <div class="header-bottom-vertical">
        <?php if ( !(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('PUCA_WOOCOMMERCE_ACTIVED') && PUCA_WOOCOMMERCE_ACTIVED ): ?>
            <!-- Cart -->
            <div class="top-cart hidden-xs">
                <?php puca_tbay_get_woocommerce_mini_cart(); ?>
            </div>
        <?php endif; ?>
        <?php
            if( class_exists( 'WOOCS' ) ) {
                ?>
                <div class="tbay-currency">
                    <?php esc_html_e('Currency:  ','puca'); ?>
                        <?php 
                            wp_enqueue_style('sumoselect');
                            wp_enqueue_script('jquery-sumoselect'); 
                            echo do_shortcode( '[woocs]' ); 
                        ?>
                </div>
                <?php
            }
        ?>
        <?php puca_tbay_get_page_templates_parts('menu-account','offcanvas'); ?>
    </div>        
<?php endif; ?>