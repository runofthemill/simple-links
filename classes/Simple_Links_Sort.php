<?php
/**
 * Simple_Links_Sort
 *
 * Handle all the link sorting requirements
 *
 * @author Mat Lipe
 *
 * @since 4/15/2015 - ( 4.0 maybe )
 *
 */
class Simple_Links_Sort {
	const NONCE = 'simple_links_sort';

	private function __construct(){
		$this->hooks();
	}


	private function hooks(){
		add_action( 'admin_enqueue_scripts', array( $this, 'js' ) );
		add_action( 'wp_ajax_simple_links_sort', array( $this, 'ajax_sort' ) );

		add_action( 'admin_menu', array( $this, 'ordering_menu' ) );
	}


	/**
	 * The link Ordering Page
	 *
	 * @since 9/11/12
	 *
	 * @return void
	 */
	function link_ordering_page(){
		$categories = get_terms( Simple_Links_Categories::TAXONOMY );

		$args = array(
			'post_type'   => Simple_Link::POST_TYPE,
			'orderby'     => 'menu_order',
			'order'       => 'ASC',
			'numberposts' => 500
		);
		$links = get_posts( $args );
		foreach( $links as &$link ){
			$cats = '';

			//All Cats Assigned to this
			$all_assigned_cats = get_the_terms( $link->ID, 'simple_link_category' );
			if( !is_array( $all_assigned_cats ) ){
				$all_assigned_cats = array();
			}

			//Create a sting of cats assigned to this link
			foreach( $all_assigned_cats as $cat ){
				$cats .= ' ' . $cat->term_id;
			}

			$link->cats = $cats;
		}

		require( SIMPLE_LINKS_DIR . 'admin-views/link-ordering.php' );
	}


	/**
	 * Create the Link Ordering Menu
	 *
	 * @uses This has built in filters to change the permissions of the link ordering and settings
	 * @uses to change the permissions outside of the dashboard settings setup the filters here
	 *
	 * @return void
	 */
	public function ordering_menu(){
		add_submenu_page(
			'edit.php?post_type=simple_link',
			'simple-link-ordering',
			__( 'Link Ordering', 'simple-links' ),
			$this->get_ordering_cap(),
			'simple-link-ordering',
			array( $this, 'link_ordering_page' )
		);

	}


	/**
	 * Get Ordering Cap
	 *
	 * Get the capability required to order links
	 *
	 * @return string
	 */
	public function get_ordering_cap(){
		if( get_option( 'sl-hide-ordering', false ) ){
			$cap_for_ordering = apply_filters( 'simple-link-ordering-cap', 'manage_options' );
		} else {
			$cap_for_ordering = apply_filters( 'simple-link-ordering-cap', 'edit_posts' );
		}
		return $cap_for_ordering;
	}


	/**
	 * Edits the menu_order in the database for links
	 *
	 * @since 8/28/12
	 * @return null
	 *
	 * return void
	 */
	function ajax_sort(){
		check_ajax_referer( self::NONCE );
		global $wpdb;

		foreach( $_POST[ 'postID' ] as $order => $postID ){
			$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET menu_order = %d WHERE ID = %d", $order, $postID ) );
		}
		die();

	}


	public function js(){
		wp_enqueue_script( 'jquery-ui-sortable' );

		$url = admin_url( 'admin-ajax.php?action=simple_links_sort' );
		$url = add_query_arg( '_wpnonce', wp_create_nonce( self::NONCE ), $url );

		wp_localize_script( 'jquery-ui-sortable', 'sl_sort_url', $url );

	}


	//********** SINGLETON FUNCTIONS **********/

	/**
	 * Instance of this class for use as singleton
	 */
	private static $instance;


	/**
	 * Create the instance of the class
	 *
	 * @static
	 * @return void
	 */
	public static function init(){
		self::$instance = self::get_instance();
	}


	/**
	 * Get (and instantiate, if necessary) the instance of the
	 * class
	 *
	 * @static
	 * @return self
	 */
	public static function get_instance(){
		if( !is_a( self::$instance, __CLASS__ ) ){
			self::$instance = new self();
		}

		return self::$instance;
	}
}