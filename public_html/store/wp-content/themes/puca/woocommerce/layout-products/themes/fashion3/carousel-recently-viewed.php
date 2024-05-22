<?php

wp_enqueue_script( 'slick' );
wp_enqueue_script( 'puca-custom-slick' );
  
$type = apply_filters( 'besa_woo_config_product_layout', 10,2 );            
$inner = 'inner';

$columns 		= isset($columns) ? $columns : 4;
$skin = puca_tbay_get_theme();

 
if( isset($attr_row) && !empty($attr_row) ) : ?>
	<div <?php echo trim($attr_row); ?>>
<?php else : ?>

	<?php 

		if( isset($responsive) && !empty($responsive) ) {
			$screen_desktop 			= $responsive['desktop'];
			$screen_desktopsmall 		= $responsive['desktopsmall'];
			$screen_tablet 				= $responsive['tablet'];
			$screen_mobile 				= $responsive['mobile'];
		}

		if( isset($data_carousel) && !empty($data_carousel) ) {
			$nav_type 				= $data_carousel['nav_type'];
			$pagi_type 				= $data_carousel['pagi_type'];
			$loop_type 				= $data_carousel['loop_type'];
			$auto_type 				= $data_carousel['auto_type'];
			$autospeed_type 		= $data_carousel['autospeed_type'];
			$disable_mobile 		= $data_carousel['disable_mobile'];
			$rows 					= $data_carousel['rows'];

			$rows_count 	= isset($rows) ? $rows : 1;
		}

		$pagi_type      	= ($pagi_type == 'yes') ? 'true' : 'false';
		$nav_type       	= ($nav_type == 'yes') ? 'true' : 'false';
		$data_loop      	= ($data_loop == 'yes') ? 'true' : 'false';
		$data_auto      	= ($data_auto == 'yes') ? 'true' : 'false';
		$disable_mobile     = ($disable_mobile == 'yes') ? 'true' : 'false';
        $classes = array('products-grid', 'product');
	?>
    
	
<?php endif; 


?>
<div class="owl-carousel scroll-init products" data-items="<?php echo esc_attr($columns); ?>" data-large="<?php echo esc_attr($screen_desktop);?>" data-medium="<?php echo esc_attr($screen_desktopsmall); ?>" data-smallmedium="<?php echo esc_attr($screen_tablet); ?>" data-verysmall="<?php echo esc_attr($screen_mobile); ?>" data-carousel="owl" data-pagination="<?php echo esc_attr( $pagi_type ); ?>" data-nav="<?php echo esc_attr( $nav_type ); ?>" data-loop="<?php echo esc_attr( $data_loop ); ?>" data-auto="<?php echo esc_attr( $data_auto ); ?>" data-autospeed="<?php echo esc_attr( $data_autospeed )?>" data-unslick="<?php echo esc_attr( $disable_mobile ); ?>">
    <?php $count = 0; while ( $loop->have_posts() ): $loop->the_post(); ?>
		
            <?php if($count%$rows_count == 0){ ?>
				<div class="item">
			<?php } ?>
			
            <div <?php wc_product_class( $classes, $post_object ); ?>>
	            <?php 
					$post_object = get_post( get_the_ID() );
					setup_postdata( $GLOBALS['post'] =& $post_object );
					
					wc_get_template_part( 'item-product/'.$active_theme.'/'.$inner );  
				?>
	        </div>
	
            <?php if($count%$rows_count == $rows_count-1 || $count==$loop->post_count -1){ ?>
				</div>
			<?php }
			$count++; ?>
		
    <?php endwhile; ?>
</div> 
<?php wp_reset_postdata(); ?>