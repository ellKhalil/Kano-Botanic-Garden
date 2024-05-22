<?php
/**
 * Templates Name: Elementor
 * Widget: List Nav
 */

$available_menus = $this->get_available_menus();
if (!$available_menus) {
    return;
}


$settings = $this->get_active_settings();

extract($settings);

$args = [
	'echo'        => false, 
	'menu'        => $menu,
	'container_class' => 'menu-vertical-container',
	'walker'      => new Puca_Tbay_Custom_Nav_Menu(), 
	'fallback_cb' => '__return_empty_string',
	'container'   => '',
];  

$args['menu_class']     = 'menu-vertical nav';
// General Menu. 
$menu_html = wp_nav_menu($args);

// Dropdown Menu.
$args['menu_id'] = 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id();

if (empty($menu_html)) {
	return;
}
?>
<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
	<?php $this->render_element_heading(); ?>
	<nav <?php echo $this->get_render_attribute_string('main-menu'); ?>><?php echo trim($menu_html); ?></nav>

</div>