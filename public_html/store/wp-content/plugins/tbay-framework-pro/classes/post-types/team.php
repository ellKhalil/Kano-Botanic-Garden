<?php
/**
 * mentor post type
 *
 * @package    tbay-framework
 * @author     TbayTheme <tbaythemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  13/06/2016 TbayTheme
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Tbay_PostType_Team{

	/**
	 * init action and filter data to define resource post type
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_action( 'init', array( __CLASS__, 'definition_taxonomy' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
	}
	/**
	 *
	 */
	public static function definition() {
		
		$labels = array(
			'name'                  => esc_html__( 'Tbay Teams', 'tbay-framework' ),
			'singular_name'         => esc_html__( 'Team', 'tbay-framework' ),
			'add_new'               => esc_html__( 'Add New Team', 'tbay-framework' ),
			'add_new_item'          => esc_html__( 'Add New Team', 'tbay-framework' ),
			'edit_item'             => esc_html__( 'Edit Team', 'tbay-framework' ),
			'new_item'              => esc_html__( 'New Team', 'tbay-framework' ),
			'all_items'             => esc_html__( 'All Tbay Teams', 'tbay-framework' ),
			'view_item'             => esc_html__( 'View Team', 'tbay-framework' ),
			'search_items'          => esc_html__( 'Search Team', 'tbay-framework' ),
			'not_found'             => esc_html__( 'No Teams found', 'tbay-framework' ),
			'not_found_in_trash'    => esc_html__( 'No Teams found in Trash', 'tbay-framework' ),
			'parent_item_colon'     => '',
			'menu_name'             => esc_html__( 'Tbay Teams', 'tbay-framework' ),
		);

		$labels = apply_filters( 'tbay_framework_postype_mentor_labels' , $labels );

		register_post_type( 'tbay_team',
			array(
				'labels'            => $labels,
				'supports'          => array( 'title', 'editor', 'thumbnail' ),
				'show_in_rest' 		=> true, 
				'public'            => true,
				'has_archive'       => false,
				'rewrite'           => array( 'slug' => esc_html__( 'mentor', 'tbay-framework' ) ),
				'menu_position'     => 53,
				'categories'        => array(),
				'show_in_menu'        => 'tbay_manager',
			)
		);
	}

	public static function definition_taxonomy() {
		$labels = array(
			'name'              => esc_html__( 'Team Categories', 'tbay-framework' ),
			'singular_name'     => esc_html__( 'Team Category', 'tbay-framework' ),
			'search_items'      => esc_html__( 'Search Team Categories', 'tbay-framework' ),
			'all_items'         => esc_html__( 'All Team Categories', 'tbay-framework' ),
			'parent_item'       => esc_html__( 'Parent Team Category', 'tbay-framework' ),
			'parent_item_colon' => esc_html__( 'Parent Team Category:', 'tbay-framework' ),
			'edit_item'         => esc_html__( 'Edit Team Category', 'tbay-framework' ),
			'update_item'       => esc_html__( 'Update Team Category', 'tbay-framework' ),
			'add_new_item'      => esc_html__( 'Add New Team Category', 'tbay-framework' ),
			'new_item_name'     => esc_html__( 'New Team Category', 'tbay-framework' ),
			'menu_name'         => esc_html__( 'Team Categories', 'tbay-framework' ),
		);

		register_taxonomy( 'tbay_team_category', 'tbay_team', array(
			'labels'            => apply_filters( 'tbay_framework_taxomony_team_category_labels', $labels ),
			'hierarchical'      => true,
			'query_var'         => 'team-category',
			'rewrite'           => array( 'slug' => esc_html__( 'team-category', 'tbay-framework' ) ),
			'public'            => true,
			'show_ui'           => true,
		) );
	}

	/**
	 *
	 */
	public static function metaboxes( array $metaboxes ) {
		$prefix = 'tbay_team_';
		
		$metaboxes[ $prefix . 'info' ] = array(
			'id'                        => $prefix . 'info',
			'title'                     => __( 'More Informations', 'tbay-framework' ),
			'object_types'              => array( 'tbay_team' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_info_fields()
		);
		
		return $metaboxes;
	}

	public static function metaboxes_info_fields() {
		$prefix = 'tbay_team_';
		$fields = array(
			array(
				'name'              => esc_html__( 'Job', 'tbay-framework' ),
				'id'                => $prefix . 'job',
				'type'              => 'text'
			),
			array(
				'name'              => esc_html__( 'Facebook', 'tbay-framework' ),
				'id'                => $prefix . 'facebook',
				'type'              => 'text'
			),
			array(
				'name'              => esc_html__( 'Twitter', 'tbay-framework' ),
				'id'                => $prefix . 'twitter',
				'type'              => 'text'
			),
			array(
				'name'              => esc_html__( 'Behance', 'tbay-framework' ),
				'id'                => $prefix . 'behance',
				'type'              => 'text'
			),
			array(
				'name'              => esc_html__( 'Linkedin', 'tbay-framework' ),
				'id'                => $prefix . 'linkedin',
				'type'              => 'text'
			),
			array(
				'name'              => esc_html__( 'Instagram', 'tbay-framework' ),
				'id'                => $prefix . 'instagram',
				'type'              => 'text'
			),
			array(
				'name'              => esc_html__( 'Google Plus', 'tbay-framework' ),
				'id'                => $prefix . 'google_plus',
				'type'              => 'text'
			),
			array(
				'name'              => esc_html__( 'Pinterest', 'tbay-framework' ),
				'id'                => $prefix . 'pinterest',
				'type'              => 'text'
			),
		);

		return apply_filters( 'tbay_framework_postype_tbay_team_metaboxes_fields' , $fields );
	}

}

Tbay_PostType_Team::init();