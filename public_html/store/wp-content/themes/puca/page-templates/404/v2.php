<?php 
	$sidebar_configs = puca_tbay_get_page_layout_configs();
	$skin = puca_tbay_get_theme();

	$icon = ($skin === 'fashion3') ? 'tb-icon tb-icon-zzz-home' : 'icon-home icons';
?>
<section id="main-container" class=" container inner">
	<div class="clearfix">
		<?php if ( isset($sidebar_configs['left']) ) : ?>
			<div class="<?php echo esc_attr($sidebar_configs['left']['class']) ;?>">
			  	<aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			   		<?php dynamic_sidebar( $sidebar_configs['left']['sidebar'] ); ?>
			  	</aside>
			</div>
		<?php endif; ?>
		<div id="main-content" class="main-page page-404 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">

			<section class="error-404 v2 not-found text-center clearfix">
			<div class="notfound-top">
				<i class="ti-heart-broken"></i>
				<h1><?php esc_html_e( 'Oops! I&sbquo;m embarrassed...', 'puca' ); ?></h1>
			</div>
				<div class="page-content notfound-bottom">
					<p class="sub-title"><?php esc_html_e( 'We can not seem to find the page you are looking for. Perhaps you are here because the page has been moved or It is no longer exists', 'puca' ); ?></p>

					<a class="backtohome" href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="<?php echo trim($icon) ?>"></i><?php esc_html_e('back to homepage', 'puca'); ?></a>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->  

		</div><!-- .content-area -->
		<?php if ( isset($sidebar_configs['right']) ) : ?>
			<div class="<?php echo esc_attr($sidebar_configs['right']['class']) ;?>">
			  	<aside class="sidebar sidebar-right" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			   		<?php dynamic_sidebar( $sidebar_configs['right']['sidebar'] ); ?>
			  	</aside>
			</div>
		<?php endif; ?>
		
	</div>
</section>