<?php
/**
* ------------------------------------------------------------------------------------------------
* puca Product Recently Viewed map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('puca_vc_map_tbay_safe_checkout')) {
    function puca_vc_map_tbay_safe_checkout()
    {
        $bg_color_value = array(
            esc_html__( 'Fashion 01', 'puca' ) => 'safe_fashion_01',
            esc_html__( 'Fashion 02', 'puca' ) => 'safe_fashion_02',
            esc_html__( 'Fashion 03', 'puca' ) => 'safe_fashion_03',
            esc_html__( 'Furniture', 'puca' ) => 'safe_furniture',
            esc_html__( 'supermaket 01', 'puca' ) => 'safe_supermaket_01',
            esc_html__( 'supermaket 02', 'puca' ) => 'safe_supermaket_02',
            esc_html__( 'Theme Color', 'puca' ) => 'safe_theme_color',
            esc_html__( 'Custom Color', 'puca' ) => 'safe_custom',
        );


        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "value" => esc_html__( 'Guaranteed Safe Checkout', 'puca' ),
                "heading" => esc_html__('Title', 'puca'),
                "param_name" => "title",
            ),
            array(
                "type" => "attach_image",
                "param_name" => "image",
                "value" => '',
                'heading'	=> esc_html__('Image', 'puca' )
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'list elements', 'puca' ),
                'param_name' => 'list_elements',
                'description' => '',
                'value' => rawurlencode( wp_json_encode( array(
                    array(
                        'title' => esc_html__( 'Free', 'puca' ),
                        'subtitle' => esc_html__( 'Worldwide Shopping', 'puca' ),
                    ),
                    array(
                        'title' => esc_html__( '100%', 'puca' ),
                        'subtitle' => esc_html__( 'Guaranteed Satisfaction', 'puca' ),
                    ),
                    array(
                        'title' => esc_html__( '30 Day', 'puca' ),
                        'subtitle' => esc_html__( 'Guaranteed Money Back', 'puca' ),
                    ),
                ) ) ),
                'params' => array(
                    array(
                        "type" => "textfield",
                        "param_name" => "title",
                        "holder" => "div",
                        "heading" => esc_html__('Title', 'puca'),
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "param_name" => "subtitle",
                        "heading" => esc_html__('Sub Title', 'puca'),
                    ),
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Color', 'puca' ),
                'param_name' => 'bgcolor',
                'value' => $bg_color_value,
                'description' => esc_html__( 'Select color.', 'puca' ),
                'admin_label' => true,
                'param_holder_class' => 'vc_colored-dropdown',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__( 'Safe checkout custom background color', 'puca' ),
                'param_name' => 'custombgcolor',
                'dependency' => array(
                    'element' => 'bgcolor',
                    'value' => array( 'safe_custom' ),
                ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__( 'Safe checkout custom text color', 'puca' ),
                'param_name' => 'customtxtcolor',
                'dependency' => array(
                    'element' => 'bgcolor',
                    'value' => array( 'safe_custom' ),
                ),
            ),
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

        $params = array_merge($params, $last_params);

        vc_map(array(
            "name" => esc_html__('Puca Safe Checkout', 'puca'),
            "base" => "tbay_safe_checkout",
            "icon" 	   	  => "vc-icon-tbay",
            "category" => esc_html__('Tbay Widgets', 'puca'),
            "params" => $params
        ));
    }
    add_action('vc_before_init', 'puca_vc_map_tbay_safe_checkout');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_safe_checkout extends WPBakeryShortCode{}
}
