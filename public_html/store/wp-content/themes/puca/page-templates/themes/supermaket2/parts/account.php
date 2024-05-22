<div class="user-menu">

	<?php if( puca_tbay_get_config('enable_popup_login', false) ) : ?>
		<a href="javascript:void(0)" title="<?php esc_attr_e('My account','puca'); ?>" data-toggle="modal" data-target="#custom-login-wrapper">
			<i class="sim-icon icon-user"></i> 
			<span class="sub-title"><?php esc_html_e('My Account', 'puca'); ?></span>
		</a>        
	<?php else: ?> 
		<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('My account','puca'); ?>">
			<i class="sim-icon icon-user"></i> 
			<span class="sub-title"><?php echo esc_html_e('My Account', 'puca'); ?></span>
		</a>        
	<?php endif; ?>

</div>