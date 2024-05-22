<?php if (!(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && has_nav_menu('nav-account')) : ?>

<div class="tbay-login">

	<?php if (is_user_logged_in()) { ?>
		<?php $current_user = wp_get_current_user(); ?>
		<div class="dropdown">
			<a class="account-button" href="javascript:void(0);"><i class="tb-icon tb-icon-zz-user"></i></a>
			<div class="account-menu">
			<?php if (has_nav_menu('nav-account')) { ?>
				<?php
                $args = [
                    'theme_location' => 'nav-account',
                    'container_class' => '',
                    'menu_class' => 'menu-topbar',
                ];
                wp_nav_menu($args);
                ?> 
			<?php } ?>
			</div>
		</div>
	<?php } elseif (!(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('PUCA_WOOCOMMERCE_ACTIVED') && PUCA_WOOCOMMERCE_ACTIVED && !empty(get_option('woocommerce_myaccount_page_id'))) { ?>       
			
			<?php if (puca_tbay_get_config('enable_popup_login', false)) : ?>
				<a href="javascript:void(0)" title="<?php esc_attr_e('Login/Register', 'puca'); ?>" data-toggle="modal" data-target="#custom-login-wrapper"><i class="tb-icon tb-icon-zz-user"></i></a>        
			<?php else: ?> 
				<a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" title="<?php esc_attr_e('Login/Register', 'puca'); ?>"><i class="tb-icon tb-icon-zz-user"></i></a>        
			<?php endif; ?>
			
	<?php } ?> 

</div>

<?php endif; ?> 