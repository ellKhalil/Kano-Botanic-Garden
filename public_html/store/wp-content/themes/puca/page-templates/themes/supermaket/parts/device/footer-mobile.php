<?php if (!(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('PUCA_WOOCOMMERCE_ACTIVED') && PUCA_WOOCOMMERCE_ACTIVED): ?>

    <?php if (is_product() || is_cart() || is_checkout()) : ?>
    <?php else: ?>
    <div class="footer-device-mobile visible-xxs clearfix">
        <div class="device-home <?php echo is_front_page() ? 'active' : ''; ?> ">
            <a href="<?php echo esc_url(home_url('/')); ?>" >
                <i class="sim-icon icon-home"></i>
            </a>   
        </div>

        <div class="search-device-mobile visible-xxs">
            <span class="show-search"><i class="sim-icon icon-magnifier"></i></span>
            <?php puca_tbay_get_page_templates_parts('productsearchform', 'mobile'); ?>
        </div>

        <?php if (class_exists('YITH_WCWL')) { ?>
        <div class="device-wishlist">
            <a class="text-skin wishlist-icon" href="<?php $wishlist_url = YITH_WCWL()->get_wishlist_url(); echo esc_url($wishlist_url); ?>">
    			<span class="icon">
    				<i class="sim-icon icon-heart"></i>
    			</span>
            </a>
        </div>
        <?php } ?>

        <?php if (!(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('PUCA_WOOCOMMERCE_ACTIVED') && PUCA_WOOCOMMERCE_ACTIVED): ?>
        <div class="device-account <?php echo is_account_page() ? 'active' : ''; ?>">

            <?php if (puca_tbay_get_config('enable_popup_login', false) && !is_user_logged_in()) : ?>   
                <a href="javascript:void(0)" title="<?php esc_attr_e('Login', 'puca'); ?>" data-toggle="modal" data-target="#custom-login-wrapper">
                    <i class="sim-icon icon-user"></i>
                </a>    
            <?php else: ?> 
                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" title="<?php esc_attr_e('Login', 'puca'); ?>">
                    <i class="sim-icon icon-user"></i>
                </a>     
            <?php endif; ?>
            
        </div>
        <?php endif; ?> 
		
		<?php if (!(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('PUCA_WOOCOMMERCE_ACTIVED') && PUCA_WOOCOMMERCE_ACTIVED): ?>
            <div class="device-cart <?php echo is_cart() ? 'active' : ''; ?>">
                <a class="mobil-view-cart" href="<?php echo esc_url(wc_get_cart_url()); ?>" >
    				<span class="icon">
    					<i class="sim-icon icon-bag"></i>
    				</span>
                </a>   
            </div>
        <?php endif; ?>

    </div>

    <?php endif; ?>
<?php endif; ?>