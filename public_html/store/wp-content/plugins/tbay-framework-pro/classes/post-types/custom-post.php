<?php
/**
 * Footer manager for WPthembay Core
 *
 * @package    WPThembay
 * @author     Thembay Teams <thembayteam@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  2021-2022 WPthembay Core
 */
 
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Tbay_PostType_Custom_Post {

	/**
	 * Instance of Tbay_PostType_Custom_Post
	 *
	 * @var Tbay_PostType_Custom_Post
	 */
	private static $_instance = null;

	/**
	 * Instance of Tbay_PostType_Custom_Post
	 *
	 * @return Tbay_PostType_Custom_Post Instance of Tbay_PostType_Custom_Post
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}


	/**
	 * Constructor
	 */
	private function __construct() {
    	add_action( 'init', array( $this, 'register_post_type' ) );
    	add_action( 'admin_init', array( $this, 'add_role_caps' ) );

		add_action( 'add_meta_boxes', [ $this, 'register_metabox' ] );
		add_action( 'save_post', [ $this, 'save_meta' ] );

		add_filter( 'manage_tbay_custom_post_posts_columns', [ $this, 'set_shortcode_columns' ] );
		add_action( 'manage_tbay_custom_post_posts_custom_column', [ $this, 'render_shortcode_column' ], 10, 2 );
  	} 
	  
  	public static function register_post_type() {
	    $labels = array(
			'name'               => esc_html__( 'Tbay Blocks', 'tbay-framework' ),
			'singular_name'      => esc_html__( 'Thembay', 'tbay-framework' ),
			'menu_name'          => esc_html__( 'Tbay Blocks', 'tbay-framework' ),
			'name_admin_bar'     => esc_html__( 'Thembay', 'tbay-framework' ),
			'add_new'            => esc_html__( 'Add New', 'tbay-framework' ),
			'add_new_item'       => esc_html__( 'Add New Block', 'tbay-framework' ),
			'new_item'           => esc_html__( 'New Thembay Block', 'tbay-framework' ),
			'edit_item'          => esc_html__( 'Edit Thembay Block', 'tbay-framework' ),
			'view_item'          => esc_html__( 'View Thembay Block', 'tbay-framework' ),
			'all_items'          => esc_html__( 'All Tbay Blocks', 'tbay-framework' ),
			'search_items'       => esc_html__( 'Search Tbay Blocks', 'tbay-framework' ),
			'parent_item_colon'  => esc_html__( 'Parent Tbay Blocks:', 'tbay-framework' ),
			'not_found'          => esc_html__( 'No Tbay Blocks found.', 'tbay-framework' ),
			'not_found_in_trash' => esc_html__( 'No Tbay Blocks found in Trash.', 'tbay-framework' ),
	    ); 

	    $type = 'tbay_custom_post';
 
	    register_post_type( $type,
	      	array(
		        'labels'            => apply_filters( 'tbay_postype_custom_post_labels' , $labels ),
		        'supports'          => array( 'title', 'editor' ),
		        'public'            => true,
				'show_ui'             => true,
				'show_in_menu'        => 'tbay_manager',
				'show_in_nav_menus'   => false,
		        'has_archive'       => false,
				'exclude_from_search' => false,
		        'menu_icon' 		=> 'dashicons-layout',
		        'menu_position'     => 51,
				'capability_type'   => array($type,'{$type}s'),
				'map_meta_cap'      => true,	      	
			)
	    );

  	}

  	public static function add_role_caps() {
 
		 // Add the roles you'd like to administer the custom post types
		 $roles = array('administrator');

		 $type  = 'tbay_custom_post';
		 
		 // Loop through each role and assign capabilities
		 foreach($roles as $the_role) { 
		 
		    $role = get_role($the_role);
		 
			$role->add_cap( 'read' );
			$role->add_cap( 'read_{$type}');
			$role->add_cap( 'read_private_{$type}s' );
			$role->add_cap( 'edit_{$type}' );
			$role->add_cap( 'edit_{$type}s' );
			$role->add_cap( 'edit_others_{$type}s' );
			$role->add_cap( 'edit_published_{$type}s' );
			$role->add_cap( 'publish_{$type}s' );
			$role->add_cap( 'delete_others_{$type}s' );
			$role->add_cap( 'delete_private_{$type}s' ); 
			$role->add_cap( 'delete_published_{$type}s' );
		 
		 }
	}

	/**
	 * Adds the custom list table column content.
	 *
	 * @since 1.2.0
	 * @param array $column Name of column.
	 * @param int   $post_id Post id.
	 * @return void
	 */
	public function column_content( $column, $post_id ) {

		if ( 'tbay_display_rules' == $column ) {

			$type = get_post_meta( $post_id, 'tbay_block_type', true );


			if ( isset( $type ) ) { 
				echo '<div class="ast-advanced-headers-location-wrap" style="margin-bottom: 5px;">';
				echo '<strong>Type: '. $this->get_title_column_content($type) .'</strong>';
				echo '</div>';
			}
		}
	}

	private function get_title_column_content( $type ) {
		switch ($type) {
			case 'type_header':
				return esc_html__('Header', 'tbay-framework');
				break;

			case 'type_footer':
				return esc_html__('Footer', 'tbay-framework');
				break;

			case 'type_megamenu':
				return esc_html__('Mega Menu', 'tbay-framework');
				break;

			default:
				return esc_html__('Custom Block', 'tbay-framework');
				break;
		}
	}

	/**
	 * Set shortcode column for template list.
	 *
	 * @param array $columns template list columns.
	 */
	function set_shortcode_columns( $columns ) {
		$date_column = $columns['date'];

		unset( $columns['date'] );

		$columns['shortcode'] = esc_html__( 'Shortcode', 'tbay-framework' );
		$columns['date']      = $date_column;

		return $columns;
	}

	/**
	 * Display shortcode in block list column.
	 *
	 * @param array $column block list column.
	 * @param int   $post_id post id.
	 */
	function render_shortcode_column( $column, $post_id ) {

		$slug = get_post_field( 'post_name', $post_id );
		switch ( $column ) {
			case 'shortcode':
				ob_start(); 
				?>
				<span class="tbay-shortcode-col-wrap">
					<input type="text" onfocus="this.select();" readonly="readonly" value='[tbay_block id="<?php echo esc_attr( $slug ); ?>"]' class="tbay-large-text code">
				</span>

				<?php

				ob_get_contents();
				break;
		}
	}

	
	/**
	 * Adds or removes list table column headings.
	 *
	 * @param array $columns Array of columns.
	 * @return array
	 */
	public function column_headings( $columns ) {
		unset( $columns['date'] );

		$columns['date']                    = esc_html__( 'Date', 'tbay-framework' );

		return $columns;
	}

		/**
	 * Register meta box(es).
	 */
	function register_metabox() {
		add_meta_box(
			'wpthembay-meta-box',
			esc_html__( 'Tbay Blocks Options', 'tbay-framework' ),
			[
				$this,
				'tbay_metabox_render',
			],
			'tbay_custom_post',
			'normal',
			'high'
		);
	}

	
	/**
	 * Render Meta field.
	 *
	 * @param  POST $post Currennt post object which is being displayed.
	 */
	public function tbay_metabox_render( $post ) {
		$values            = get_post_custom( $post->ID );
		$template_type     = isset( $values['tbay_block_type'] ) ? esc_attr( $values['tbay_block_type'][0] ) : '';

		// We'll use this nonce field later on when saving.
		wp_nonce_field( 'tbay_meta_nounce', 'tbay_meta_nounce' );

		$slug = get_post_field( 'post_name', $post->ID );
		?>
		<table class="tbay-options-table widefat">
			<tbody>

				<tr class="tbay-options-row tbay-shortcode">
					<td class="tbay-options-row-heading">
						<label for="tbay_block_type"><?php _e( 'Shortcode', 'tbay-framework' ); ?></label>
						<i class="tbay-options-row-heading-help dashicons dashicons-editor-help" title="<?php _e( 'Copy this shortcode and paste it into your post, page, or text widget content.', 'tbay-framework' ); ?>">
						</i>
					</td>
					<td class="tbay-options-row-content">
						<span class="tbay-shortcode-col-wrap">
							<input type="text" onfocus="this.select();" readonly="readonly" value='[tbay_block id="<?php echo esc_attr( $slug ); ?>"]' class="tbay-large-text code">
						</span>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Save meta field.
	 *
	 * @param  POST $post_id Currennt post object which is being displayed.
	 *
	 * @return Void
	 */
	public function save_meta( $post_id ) {

		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['tbay_meta_nounce'] ) || ! wp_verify_nonce( $_POST['tbay_meta_nounce'], 'tbay_meta_nounce' ) ) {
			return;
		}

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		if ( isset( $_POST['tbay_block_type'] ) ) {
			update_post_meta( $post_id, 'tbay_block_type', esc_attr( $_POST['tbay_block_type'] ) );
			update_post_meta( $post_id, '_wp_page_template', 'elementor_canvas' );
		}
	}

	function set_custom_sortable_columns( $columns ) {
		$columns['shortcode'] = 'shortcode'; 
		$columns['tbay_display_rules'] = 'tbay_display_rules'; 
	  
		return $columns;
	}
	
}

Tbay_PostType_Custom_Post::instance();