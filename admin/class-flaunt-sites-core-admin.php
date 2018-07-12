<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://williambay.com
 * @since      1.0.0
 *
 * @package    Flaunt_Sites_Core
 * @subpackage Flaunt_Sites_Core/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Flaunt_Sites_Core
 * @subpackage Flaunt_Sites_Core/admin
 * @author     William Bay <william@flauntyoursite.com>
 */

class Flaunt_Sites_Core_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Flaunt_Sites_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Flaunt_Sites_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/flaunt-sites-core-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Flaunt_Sites_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Flaunt_Sites_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/flaunt-sites-core-admin.js', array( 'jquery' ), $this->version, true );

	}

}


require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/flaunt-sites-core-admin-display.php';
// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/flaunt-sites-core-admin-tutorial-page.php';


/**************************************************
TAWK.TO - ADDS TAWK.TO SUPPORT CHAT TO ALL BUT SUPERADMIN ADMIN AREAS
**************************************************/

function fsc_enqueue_tawkto() {
	$blog_id = get_current_blog_id();
		if ( 1 != $blog_id && is_admin() ) {

			wp_enqueue_script( 'Tawk-To', plugin_dir_url( __FILE__ ) . 'js/tawk-to.js', array(), '20180522', true );

		}
		
}

add_action( 'init', 'fsc_enqueue_tawkto' );


/**************************************************
ACF - REMOVES ACF OPTIONS FROM ALL BUT SUPER-ADMIN
**************************************************/

function fsc_acf_show_admin( $show ) {
	
	return current_user_can('manage_network_options');
	
}

add_filter('acf/settings/show_admin', 'fsc_acf_show_admin');



/**************************************************
ADMIN - REORDERS PAGES ABOVE POSTS
**************************************************/

function fsc_change_post_links() {
	global $menu;
	$menu[6] = $menu[5];
	$menu[5] = $menu[20];
	unset($menu[20]);
}

add_action('admin_menu', 'fsc_change_post_links');



/**************************************************
ADMIN - REORDERS PAGES ABOVE POSTS
**************************************************/
function fsc_unregister_tags() {
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'fsc_unregister_tags');




/**************************************************
ADMIN - ADDS A CLIENT SELECTOR TO BLOG & REVIEW POSTS
**************************************************/

function fsc_client_id_selector() {

	acf_add_local_field_group(array (
		'key' => 'group_58ebfeddc7579',
		'title' => 'Client ID',
		'fields' => array (
			array (
				'key' => 'field_58ebfeeb9e65a',
				'label' => 'Client ID',
				'name' => 'fsc_client_id',
				'type' => 'taxonomy',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'taxonomy' => 'client_id',
				'field_type' => 'select',
				'allow_null' => 0,
				'add_term' => 1,
				'save_terms' => 1,
				'load_terms' => 0,
				'return_format' => 'id',
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'reviews',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

}

// add_action('init', 'fsc_client_id_selector');
