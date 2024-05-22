<?php
/**
 * Testimonial manager for tbay framework
 *
 * @package    tbay-framework
 * @author     Team Thembays <tbaythemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  2015-2016 Tbay Framework
 */
 
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Tbay_PostType_Testimonial {

  	public static function init() {
    	add_action( 'init', array( __CLASS__, 'register_post_type' ) );
    	add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
  	}

  	public static function register_post_type() {
	    $labels = array(
			'name'                  => esc_html__( 'Tbay Testimonial', 'tbay-framework' ),
			'singular_name'         => esc_html__( 'Testimonial', 'tbay-framework' ),
			'add_new'               => esc_html__( 'Add New Testimonial', 'tbay-framework' ),
			'add_new_item'          => esc_html__( 'Add New Testimonial', 'tbay-framework' ),
			'edit_item'             => esc_html__( 'Edit Testimonial', 'tbay-framework' ),
			'new_item'              => esc_html__( 'New Tbay Testimonial', 'tbay-framework' ),
			'all_items'             => esc_html__( 'All Tbay Testimonials', 'tbay-framework' ),
			'view_item'             => esc_html__( 'View Testimonial', 'tbay-framework' ),
			'search_items'          => esc_html__( 'Search Testimonial', 'tbay-framework' ),
			'not_found'             => esc_html__( 'No Testimonials found', 'tbay-framework' ),
			'not_found_in_trash'    => esc_html__( 'No Testimonials found in Trash', 'tbay-framework' ),
			'parent_item_colon'     => '',
			'menu_name'             => esc_html__( 'Tbay Testimonials', 'tbay-framework' ),
	    );

	    register_post_type( 'tbay_testimonial',
	      	array(
		        'labels'            => apply_filters( 'tbay_postype_testimonial_labels' , $labels ),
		        'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		        'show_in_rest' 		=> true, 
		        'public'            => true,
		        'has_archive'       => false,
		        'menu_position'     => 52,
				'show_in_menu'        => 'tbay_manager',
	      	)
	    );

  	}
  	
  	public static function metaboxes(array $metaboxes){
		$prefix = 'tbay_testimonial_';
	    
	    $metaboxes[ $prefix . 'settings' ] = array(
			'id'                        => $prefix . 'settings',
			'title'                     => esc_html__( 'Testimonial Information', 'tbay-framework' ),
			'object_types'              => array( 'tbay_testimonial' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_fields()
		);

	    return $metaboxes;
	}

	public static function metaboxes_fields() {
		$prefix = 'tbay_testimonial_';
	
		$fields =  array(
			array(
	            'name' => esc_html__( 'Job', 'tbay-framework' ),
	            'id'   => "{$prefix}job",
	            'type' => 'text',
	            'description' => esc_html__('Enter Job example CEO, CTO','tbay-framework')
          	), 
			array(
				'name' => esc_html__( 'Testimonial Link', 'tbay-framework' ),
				'id'   => $prefix."link",
				'type' => 'text'
			)
		);  
		
		return apply_filters( 'tbay_framework_postype_tbay_testimonial_metaboxes_fields' , $fields );
	}
}

Tbay_PostType_Testimonial::init();