<?php if (!(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && has_nav_menu('nav-account')) : ?>

	<div class="tbay-login">

		<?php if (is_user_logged_in()) { ?>
			<?php $current_user = wp_get_current_user(); ?>
			<div class="dropdown">
				<a class="account-button" href="javascript:void(0);"><i class="sim-icon icon-user"></i><span class="hidden-xs"><?php echo esc_html($current_user->display_name); ?>!</span></a>
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
					<a href="javascript:void(0)" class="account-button" title="<?php esc_attr_e('Login / Sign up', 'puca'); ?>" data-toggle="modal" data-target="#custom-login-wrapper"><i class="sim-icon icon-user"></i></a>        
				<?php else: ?> 
					<a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="account-button" title="<?php esc_attr_e('Login / Sign up', 'puca'); ?>"><i class="sim-icon icon-user"></i></a>        
				<?php endif; ?>
				
		<?php } ?> 

	</div>
	
<?php endif; ?> 