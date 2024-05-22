
<header id="tbay-header" class="site-header header-v4 hidden-sm hidden-xs <?php echo (puca_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">

	<div id="tbay-topbar">
		<div class="container container-full">
			<div class="row">
				<div class="col-md-8 top-info">
					<?php if(is_active_sidebar('top-left-header-v4')) : ?>
						<?php dynamic_sidebar('top-left-header-v4'); ?>
						<!-- End Bottom Header Widget -->
					<?php endif;?>
				</div>
				<div class="col-md-4 header-right">
					<?php
						if( class_exists( 'WOOCS' ) ) {
							?>
							<div class="tbay-currency">
								<?php 
									wp_enqueue_style('sumoselect');
									wp_enqueue_script('jquery-sumoselect'); 
									echo do_shortcode( '[woocs]' ); 
								?>
							</div>
							<?php
						}
				    ?>
					<?php if(is_active_sidebar('top-right-header-v4')) : ?>
						<?php dynamic_sidebar('top-right-header-v4'); ?>
						<!-- End Bottom Header Widget -->
					<?php endif;?> 

				    <?php puca_tbay_get_page_templates_parts('topbar-account'); ?>

				</div>	
			</div>
		</div>		
	</div>
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
					
				    <div class="header-center tbay-mainmenu col-md-6 col-xlg-9 hidden-xs hidden-sm">
						<?php puca_tbay_get_page_templates_parts('nav'); ?>
				    </div> 

                    <div class="header-right col-md-3 col-xlg-1 hidden-sm hidden-xs">

						<?php puca_tbay_get_page_templates_parts('search-click-v2'); ?>  

						<!-- Wishlist -->
						<div class="top-wishlist">
							<?php puca_tbay_get_page_templates_parts('wishlist'); ?>
						</div>
 
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