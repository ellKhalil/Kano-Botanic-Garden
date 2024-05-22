<?php
/**
* ------------------------------------------------------------------------------------------------
* puca Product Recently Viewed map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('puca_vc_map_tbay_product_recently_viewed')) {
    require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-custom-heading.php' );
    function puca_vc_map_tbay_product_recently_viewed()
    {
        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__('Title', 'puca'),
                "param_name" => "title",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__('Sub Title', 'puca'),
                "param_name" => "subtitle",
                "admin_label" => true
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'heading' => esc_html__( 'Empty text', 'puca' ),
                'param_name' => 'empty_text',
                'value' => '<p>' . esc_html__( 'You have not recently viewed item.', 'puca' ) . '</p>',
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Product Item', 'puca'),
                "param_name" => "product_item",
                "value" => array(
                    esc_html__('Inner', 'puca') =>'inner',
                    esc_html__('Only Image', 'puca') => 'inner-only-image',
                ),
                "admin_label" => true,
                'std' => 'inner-only-image',
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Layout', 'puca'),
                "param_name" => "layout_type",
                "value" => array(
                    'Grid'=>'grid',
                    'Carousel'=>'carousel',
                ),
                "admin_label" => true,
                "description" => esc_html__('Select Layout.', 'puca')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Number items to show', 'puca'),
                "param_name" => "number",
                'std' => '8',
            ),
            array(
				'type' => 'font_container',
				'param_name' => 'font_container',
                'group' 		=> esc_html__('Heading Style', 'puca'),
				'value' => 'tag:h3',
				'settings' => array(
					'fields' => array(
						'font_size',
						'line_height',
						'color',
						'font_size_description' => esc_html__( 'Enter font size.', 'puca' ),
						'line_height_description' => esc_html__( 'Enter line height.', 'puca' ),
						'color_description' => esc_html__( 'Select heading color.', 'puca' ),
					),
				),
			),
            array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Use theme default font family?', 'puca' ),
				'param_name' => 'use_theme_fonts',
                'std'           => 'yes', 
				'value' => array( 
                    esc_html__( 'Yes', 'puca' ) => 'yes' 
                ),
                'group' 		=> esc_html__('Heading Style', 'puca'),
				'description' => esc_html__( 'Use font family from the theme.', 'puca' ),
			),
			array(
				'type' => 'google_fonts',
				'param_name' => 'google_fonts',
				'value' => 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
                'group' 		=> esc_html__('Heading Style', 'puca'),
				'settings' => array(
					'fields' => array(
						'font_family_description' => esc_html__( 'Select font family.', 'puca' ),
						'font_style_description' => esc_html__( 'Select font styling.', 'puca' ),
					),
				),
				'dependency' => array(
					'element' => 'use_theme_fonts',
					'value_not_equal_to' => 'yes',
				),
			),
        );

        $custom_params = array(
            array(
                "type" 			=> "checkbox",
                "heading" 		=> esc_html__('Show custom link?', 'puca'),
                "description" 	=> esc_html__('Show/hidden custom link', 'puca'),
                "param_name" 	=> "check_link_rv",
                "value" 		=> array(
                                    esc_html__('Yes', 'puca') =>'yes' ),
            ),
            array(
                'type' 			=> 'vc_link',
                'heading' 		=> esc_html__('Custom link', 'puca'),
                "group" 		=> esc_html__('Custom Link', 'puca'),
                'param_name' 	=> 'link',
                'description' 	=> esc_html__('Add custom link.', 'puca'),
                'dependency' 	=> array(
                        'element' 	=> 'check_link_rv',
                        'value' 	=> 'yes',
                ),
            ),
        );

        $columns = apply_filters('puca_admin_visualcomposer_recently_viewed_columns', array(1,2,3,4,5,6,7,8,9,10,12));
        $responsive     = array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Columns', 'puca'),
                "description" => esc_html__('Column apply when the width is than 1600px', 'puca'),
                "param_name" => 'columns',
                "value" => $columns,
                'std' => '4',
            ),
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__('Show config Responsive?', 'puca'),
                "description"   => esc_html__('Show/hidden config Responsive', 'puca'),
                "param_name"    => "responsive_type",
                "std"           => "yes",
                "value"         => array(
                                    esc_html__('Yes', 'puca') =>'yes' ),
            ),
            array(
                "type"    => "dropdown",
                "heading" => esc_html__('Number of columns screen desktop', 'puca'),
                "description" => esc_html__('Column apply when the width is between 1200px and 1600px', 'puca'),
                "group" => esc_html__('Responsive Settings', 'puca'),
                "param_name" => 'screen_desktop',
                "value" => $columns,
                'std'       => '4',
                'dependency'    => array(
                        'element'   => 'responsive_type',
                        'value'     => 'yes',
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Number of columns screen desktopsmall', 'puca'),
                "description" => esc_html__('Column apply when the width is between 992px and 1199px', 'puca'),
                "group" => esc_html__('Responsive Settings', 'puca'),
                "param_name" => 'screen_desktopsmall',
                "value" => $columns,
                'std'       => '3',
                'dependency'    => array(
                        'element'   => 'responsive_type',
                        'value'     => 'yes',
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Number of columns screen tablet', 'puca'),
                "description" => esc_html__('Column apply when the width is between 768px and 991px', 'puca'),
                "group" => esc_html__('Responsive Settings', 'puca'),
                "param_name" => 'screen_tablet',
                "value" => $columns,
                'std'       => '3',
                'dependency'    => array(
                        'element'   => 'responsive_type',
                        'value'     => 'yes',
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Number of columns screen mobile landscape', 'puca'),
                "group" => esc_html__('Responsive Settings', 'puca'),
                "description" => esc_html__('Column apply when the width is between 480px and 767px', 'puca'),
                "param_name" => 'screen_landscape_mobile',
                "value" => $columns,
                'std'       => '3',
                'dependency'    => array(
                        'element'   => 'responsive_type',
                        'value'     => 'yes',
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Number of columns screen mobile', 'puca'),
                "group" => esc_html__('Responsive Settings', 'puca'),
                "description" => esc_html__('Column apply when the width is less 479px', 'puca'),
                "param_name" => 'screen_mobile',
                "value" => $columns,
                'std'       => '2',
                'dependency'    => array(
                        'element'   => 'responsive_type',
                        'value'     => 'yes',
                ),
            )
        );

        $rows       = apply_filters('puca_admin_visualcomposer_rows', array(1,2,3));
        $carousel = array(
            array(
                "type"      => "dropdown",
                "heading"   => esc_html__('Rows', 'puca'),
                "group" => esc_html__('Carousel Settings', 'puca'),
                "param_name" => 'rows',
                "value"     => $rows,
                'dependency'    => array(
                        'element'   => 'layout_type',
                        'value'     => 'carousel'
                ),
            ),
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__('Show Navigation?', 'puca'),
                "group" => esc_html__('Carousel Settings', 'puca'),
                "description"   => esc_html__('Show/hidden Navigation ', 'puca'),
                "param_name"    => "nav_type",
                "value"         => array(
                                    esc_html__('Yes', 'puca') =>'yes' ),
                'dependency'    => array(
                        'element'   => 'layout_type',
                        'value'     => 'carousel'
                ),
            ),
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__('Show Pagination?', 'puca'),
                "group" => esc_html__('Carousel Settings', 'puca'),
                "description"   => esc_html__('Show/hidden Pagination', 'puca'),
                "param_name"    => "pagi_type",
                "value"         => array(
                                    esc_html__('Yes', 'puca') =>'yes' ),
                'dependency'    => array(
                        'element'   => 'layout_type',
                        'value'     => 'carousel'
                ),
            ),

            array(
                "type"          => "checkbox",
                "heading"       => esc_html__('Loop Slider?', 'puca'),
                "group" => esc_html__('Carousel Settings', 'puca'),
                "description"   => esc_html__('Show/hidden Loop Slider', 'puca'),
                "param_name"    => "loop_type",
                "value"         => array(
                                    esc_html__('Yes', 'puca') =>'yes' ),
                'dependency'    => array(
                        'element'   => 'layout_type',
                        'value'     => 'carousel'
                ),
            ),
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__('Auto Slider?', 'puca'),
                "group" => esc_html__('Carousel Settings', 'puca'),
                "description"   => esc_html__('Show/hidden Auto Slider', 'puca'),
                "param_name"    => "auto_type",
                "value"         => array(
                                    esc_html__('Yes', 'puca') =>'yes' ),
                'dependency'    => array(
                        'element'   => 'layout_type',
                        'value'     => 'carousel'
                ),
            ),
            array(
                "type"          => "textfield",
                "heading"       => esc_html__('Auto Play Speed', 'puca'),
                "group" => esc_html__('Carousel Settings', 'puca'),
                "description"   => esc_html__('Auto Play Speed Slider', 'puca'),
                "param_name"    => "autospeed_type",
                "value"         => '2000',
                'dependency'    => array(
                        'element'   => 'auto_type',
                        'value'     => array(
                            'yes',
                        ),
                ),
            ),
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__('Disable Carousel On Mobile', 'puca'),
                "group"         => esc_html__('Carousel Settings', 'puca'),
                "description"   => esc_html__('To help load faster in mmobile', 'puca'),
                "param_name"    => "disable_mobile",
                "std"           => "yes",
                "value"         => array( esc_html__('Yes', 'puca') =>'yes' ),
                'dependency'    => array(
                        'element'   => 'layout_type',
                        'value'     => 'carousel'
                ),
            ) 
        );

        $last_params = array(
            vc_map_add_css_animation(true),
            array(
                'type' => 'css_editor',
                'heading' => esc_html__('CSS box', 'puca'),
                'param_name' => 'css',
                'group' => esc_html__('Design Options', 'puca'),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra class name', 'puca'),
                'param_name' => 'el_class',
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'puca')
            )
        );

        $params = array_merge($params, $carousel, $responsive, $custom_params, $last_params);

        vc_map(array(
            "name" => esc_html__('Puca Product Recently Viewed', 'puca'),
            "base" => "tbay_product_recently_viewed",
            "icon" 	   	  => "vc-icon-tbay",
            "class" => "",
            "category" => esc_html__('Puca Woocommerce', 'puca'),
            'description'	=> esc_html__('Display Product Recently Viewed', 'puca'),
            "params" => $params
        ));
    }
    add_action('vc_before_init', 'puca_vc_map_tbay_product_recently_viewed');
}

if (class_exists('WPBakeryShortCode_Vc_Custom_Heading')) {
    class WPBakeryShortCode_tbay_product_recently_viewed extends WPBakeryShortCode_Vc_Custom_Heading{}
}
