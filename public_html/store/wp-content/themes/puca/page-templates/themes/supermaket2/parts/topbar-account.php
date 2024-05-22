<?php if( !(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && has_nav_menu( 'nav-account' )) : ?>

	<ul class="list-inline account">
		<?php if( !is_user_logged_in() ){ ?>
			<li> 
				<?php if( puca_tbay_get_config('enable_popup_login', false) ) : ?>
					<a href="javascript:void(0)" title="<?php esc_attr_e('Login','puca'); ?>" data-toggle="modal" data-target="#custom-login-wrapper"><i class="sim-icon icon-lock"></i> <?php esc_html_e('Login / Register', 'puca'); ?> </a>        
				<?php else: ?> 
					<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Login','puca'); ?>"><i class="sim-icon icon-lock"></i> <?php esc_html_e('Login / Register', 'puca'); ?> </a>        
				<?php endif; ?>
			</li>
		<?php }else{ ?>
			<?php $current_user = wp_get_current_user(); ?>
		  <li> <i class="sim-icon icon-lock"></i> <span class="hidden-xs"><?php esc_html_e('Welcome ','puca'); ?><?php echo esc_html( $current_user->display_name); ?> !</span></li>
		  <li><a href="<?php echo wp_logout_url(home_url()); ?>"><?php esc_html_e('Logout ','puca'); ?></a></li>
		<?php } ?>
	</ul>
	
<?php endif; ?> 