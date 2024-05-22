<?php 
    if ( has_nav_menu( 'primary' ) ) {
        $tbay_location = 'primary';
        $locations  = get_nav_menu_locations();
        $menu_id    = $locations[ $tbay_location ] ;
        $menu_obj   = wp_get_nav_menu_object( $menu_id );
        $menu_name  = puca_get_transliterate($menu_obj->slug);
    } else {
        $tbay_location = $menu_name = '';
    }
?>
<nav data-duration="400" class="menu hidden-xs hidden-sm tbay-megamenu slide animate navbar">
<?php
    $args = array(
        'theme_location' => 'primary',
        'container_class' => 'collapse navbar-collapse',
        'menu_class' => 'nav navbar-nav megamenu',
        'fallback_cb' => '',
        'menu_id' => 'primary-menu',
        'items_wrap'  => '<ul id="%1$s" class="%2$s" data-id="'. $menu_name .'">%3$s</ul>',
        'walker' => new puca_Tbay_Nav_Menu()
    );
    wp_nav_menu($args);
?>
</nav>