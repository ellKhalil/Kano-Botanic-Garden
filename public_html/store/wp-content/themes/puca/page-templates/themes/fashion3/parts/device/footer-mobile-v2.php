<?php   global $woocommerce;
    $_id = puca_tbay_random_key();
?>

<?php if (!(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('PUCA_WOOCOMMERCE_ACTIVED') && PUCA_WOOCOMMERCE_ACTIVED): ?>

    <?php if (is_product() || is_cart() || is_checkout()) : ?>
    <?php else: ?>
    <div class="footer-device-mobile layout-v2 visible-xxs clearfix">
        <div class="device-home <?php echo is_front_page() ? 'active' : ''; ?> ">
            <a href="<?php echo esc_url(home_url('/')); ?>" >
                <i class="tb-icon tb-icon-zzz-home"></i>
                <span class="device-label"><?php esc_html_e('Home', 'puca'); ?></span>
            </a>   
        </div>

        <?php if (class_exists('YITH_WCWL')) { ?>

        <?php
            $wishlist_url = YITH_WCWL()->get_wishlist_url();
            $wishlist_count = YITH_WCWL()->count_products();
        ?>
        <div class="device-wishlist">
            <a class="text-skin wishlist-icon" href="<?php echo esc_url($wishlist_url); ?>">
    			<span class="icon">
                    <i class="tb-icon tb-icon-zz-heart"></i>
                    <span class="device-label"><?php esc_html_e('Wishlist', 'puca'); ?></span>(<span class="count count_wishlist"><?php echo trim($wishlist_count); ?></span>)
    			</span>
            </a>
        </div>
        <?php } ?>

        <?php if (!(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('PUCA_WOOCOMMERCE_ACTIVED') && PUCA_WOOCOMMERCE_ACTIVED): ?>
            <div class="tbay-topcart">
                <div id="cart-<?php echo esc_attr($_id); ?>" class="footer-cart dropdown version-1">
                    <a class="mini-cart v2" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('shopping cart', 'puca'); ?>">
                        <span class="text-skin cart-icon">
                            <i class="tb-icon tb-icon-zz-bag"></i>
                            <span class="footer-cart-title"><?php esc_html_e('Cart', 'puca'); ?>(<span class="mini-cart-items"><?php echo sprintf('%d', $woocommerce->cart->cart_contents_count); ?></span>)</span>
                        </span> 
                        
                    </a>             
                </div>
            </div>
        <?php endif; ?>

        <?php if (!(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('PUCA_WOOCOMMERCE_ACTIVED') && PUCA_WOOCOMMERCE_ACTIVED): ?>
        <div class="device-account <?php echo is_account_page() ? 'active' : ''; ?>">

            <?php if (puca_tbay_get_config('enable_popup_login', false) && !is_user_logged_in()) : ?>   
                <a href="javascript:void(0)" title="<?php esc_attr_e('Login', 'puca'); ?>" data-toggle="modal" data-target="#custom-login-wrapper">
                    <i class="tb-icon tb-icon-zz-user"></i>
                    <span class="device-label"><?php esc_html_e('Account', 'puca'); ?></span>
                </a>    
            <?php else: ?> 
                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" title="<?php esc_attr_e('Login', 'puca'); ?>">
                    <i class="tb-icon tb-icon-zz-user"></i>
                    <span class="device-label"><?php esc_html_e('Account', 'puca'); ?></span>
                </a>     
            <?php endif; ?>
            
        </div>
        <?php endif; ?> 

    </div>

    <?php endif; ?>
<?php endif; ?>