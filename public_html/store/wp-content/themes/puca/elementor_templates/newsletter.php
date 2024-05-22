<?php 
/**
 * Templates Name: Elementor
 * Widget: Newsletter
 */

$style = '';
extract( $settings );

if( !empty($_css_classes) ) {  
	$this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->add_render_attribute('wrapper', 'class', [$style, 'widget-newletter']);
?>

<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>

    <?php if( !empty($heading_subtitle) || !empty($heading_title) ) : ?>
		<<?php echo trim($heading_title_tag); ?> class="heading-tbay-title widget-title">
			<?php if( !empty($heading_title) ) : ?>
				<span class="title"><?php echo trim($heading_title); ?></span>
			<?php endif; ?>	    	
			<?php if( !empty($heading_subtitle) ) : ?>
				<span class="subtitle"><?php echo trim($heading_subtitle); ?></span>
			<?php endif; ?>
		</<?php echo trim($heading_title_tag); ?>>
	<?php endif; ?>

    <div class="widget-content"> 
		<?php if (!empty($heading_description)) { ?>
			<p class="widget-description">
				<?php echo trim( $heading_description ); ?>
			</p>
		<?php } ?>		
		
		<?php
            if (function_exists('mc4wp_show_form')) {
            	try {
                    $form = mc4wp_get_form();
                    echo do_shortcode('[mc4wp_form id="'. $form->ID .'"]');
                } catch (Exception $e) {
                    esc_html_e('Please create a newsletter form from Mailchip plugins', 'puca');
                }
            }
        ?>
	</div>
</div>