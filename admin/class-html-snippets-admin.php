<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.saturdaynightbattleship.com
 * @since      1.0.0
 *
 * @package    Html_Snippets
 * @subpackage Html_Snippets/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Html_Snippets
 * @subpackage Html_Snippets/admin
 * @author     Elise Ferguson <egaetz@gmail.com>
 */
class Html_Snippets_Admin {

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

	 static $this_term;
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this::actions();

	}

	/**
	 *
	 */
	 /* Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Html_Snippets_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Html_Snippets_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/html-snippets-admin.css', array(), $this->version, 'all' );

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
		 * defined in Html_Snippets_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Html_Snippets_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/html-snippets-admin.js', array( 'jquery' ), $this->version, false );

	}

	public static function actions() {
		add_action( 'init', array( 'Html_Snippets_Admin' ,'register_post_types' ) );
		add_action( 'add_meta_boxes', array( 'Html_Snippets_Admin', 'snippet_meta_box') );
		add_action( 'wp_ajax_load_snippet_content', array( 'Html_Snippets_Admin', 'load_snippet_content') );
	}

	public static function register_post_types() {
	    self::html_snippets();
	}

	private static function html_snippets() {
		// create new post stype and add item to the admin dashboard

	     $labels = array(
	       'name'               => _x( 'Snippets', 'post type general name' ),
	       'singular_name'      => _x( 'Snippet', 'post type singular name' ),
	       'add_new'            => _x( 'Add New', 'book' ),
	       'add_new_item'       => __( 'Add New Snippet' ),
	       'edit_item'          => __( 'Edit Snippet' ),
	       'new_item'           => __( 'New Snippet' ),
	       'all_items'          => __( 'All Snippets' ),
	       'view_item'          => __( 'View Snippets' ),
	       'search_items'       => __( 'Search Snippets' ),
	       'not_found'          => __( 'No snippets found' ),
	       'not_found_in_trash' => __( 'No snippets found in the Trash' ),
	       'parent_item_colon'  => '',
	       'menu_name'          => 'Snippets'
	     );
	     $args = array(
	       'labels'        => $labels,
	       'description'   => 'HTML Snippets for inserting into posts and pages',
	       'public'        => true,
	       'menu_position' => 5,
	       'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
	       'has_archive'   => true,
	     );
	     register_post_type( 'snippet', $args );

	}


	public static function snippet_meta_box() {
		add_meta_box(
			'snippet_meta_box',
			'Insert Snippet',
			array( 'Html_Snippets_Admin', 'display_meta_box'),
			'',
			'side',
			'high'
		);
	}
	public static function display_meta_box( $post ) {
		$query = new WP_Query( array(
			'post_type' => 'snippet',

		));

		//Build the array of snippets available
		$options = array();
		foreach( $query -> posts as $post ) {
			$options[] = '<option value="' . $post->ID . '">' . "{$post->post_title}</option>";
		}
		$options = implode( "\n", $options );

		//Display the select box with the available snippets
		$html = <<<HTML
	<div class="insert-snippet-box">
		<select id="snippet-listing">
			<option value="0">Select a Snippet: </option>
			$options
		</select>
		<a id="insert-snippet-button" href="#insert-snippet" class="button">Insert</a>
	</div>
HTML;

		echo $html;
	}
	static function load_snippet_content() {
		if (empty($_POST['snippet_id'])) {

			$content = null;
		} else {
			$post = get_post($_POST['snippet_id']);
			$content = htmlspecialchars(apply_filters('the_content',$post->post_content));
		}
		echo json_encode(array(
			'result' => (!is_null($content) ? 'success' : 'No Content Available!'),
			'content' => $content,
		));
		exit;
	}
}
