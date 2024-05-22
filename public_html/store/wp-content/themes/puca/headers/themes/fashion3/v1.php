<header id="tbay-header" class="site-header header-default header-v1 hidden-sm hidden-xs <?php echo (puca_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">
	<?php
		if ( puca_tbay_is_home_page() ) {
			?>
			<div class="top-bar clearfix">
				<div class="container container-full">
					<div class="shipping-contact-inner text-center">

						<div class="shipping-main">

							<?php if(is_active_sidebar('top-shipping')) : ?>
								<?php dynamic_sidebar('top-shipping'); ?>
							<?php endif;?>

						</div>
					</div>
				</div>
			</div>
			<?php
		}
	?>
	
    <div class="header-main clearfix">
        <div class="container container-full">
            <div class="header-inner">
                <div class="row">
					<!-- //LOGO -->
                    <div class="header-left col-md-3 col-xlg-2 text-left"> 

                        <?php 
                        	puca_tbay_get_page_templates_parts('logo'); 
                        ?> 
                    </div>
					
				    <div class="header-center tbay-mainmenu col-md-6 col-xlg-6 hidden-xs hidden-sm">
						
						<?php puca_tbay_get_page_templates_parts('nav'); ?>

				    </div> 

                    <div class="header-right col-md-3 col-xlg-4 hidden-sm hidden-xs">

						<?php puca_tbay_get_page_templates_parts('search-click-v1'); ?>

						<?php puca_tbay_get_page_templates_parts('topbar-account-v1'); ?>

						<?php if ( !(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('PUCA_WOOCOMMERCE_ACTIVED') && PUCA_WOOCOMMERCE_ACTIVED ): ?>
							<div class="top-cart">

								<!-- Cart -->
								<div class="top-cart hidden-xs">
									<?php puca_tbay_get_woocommerce_mini_cart(); ?>
								</div>

							</div> 
						<?php endif; ?>
					</div>

                </div>  
            </div>
        </div>
    </div>

	<div id="nav-cover"></div>
</header>