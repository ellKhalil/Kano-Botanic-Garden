<?php

$columns 		= isset($columns) ? $columns : 4;


$screen_desktop          =      isset($screen_desktop) ? $screen_desktop : 4;
$screen_desktopsmall     =      isset($screen_desktopsmall) ? $screen_desktopsmall : 3;
$screen_tablet           =      isset($screen_tablet) ? $screen_tablet : 3;
$screen_mobile           =      isset($screen_mobile) ? $screen_mobile : 1;

if( isset($attr_row) && !empty($attr_row) ) {
	$class = 'products products-grid';
} else {

	$data_responsive = '';
	$data_responsive .= ' data-xlgdesktop='. esc_attr($columns) .'';
	$data_responsive .= ' data-desktop='. esc_attr($screen_desktop) .'';
	$data_responsive .= ' data-desktopsmall='. esc_attr($screen_desktopsmall) .'';
	$data_responsive .= ' data-tablet='. esc_attr($screen_tablet) .'';
	$data_responsive .= ' data-mobile='. esc_attr($screen_mobile) .'';
}


$class_columns = ($columns <= 1) ? 'w-recently-list' : 'recently-viewed recently-grid';
?>
<div class="<?php echo esc_attr( $class_columns ); ?>">
	<div class="row <?php echo esc_attr($layout_type); ?>" <?php echo $data_responsive; ?>>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

			<?php 
				$post_object = get_post( get_the_ID() );
				setup_postdata( $GLOBALS['post'] =& $post_object );

				wc_get_template( 'content-recent-viewed.php', array('screen_desktop' => $screen_desktop,'screen_desktopsmall' => $screen_desktopsmall,'screen_tablet' => $screen_tablet,'screen_mobile' => $screen_mobile) ); 
			?>

		<?php endwhile; ?>
	</div>
</div>
 
<?php wp_reset_postdata(); ?>