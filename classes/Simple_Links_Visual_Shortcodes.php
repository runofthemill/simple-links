<?php
/**
 * Simple_Links_Visual_Shortcodes
 *
 * All the display the the rendered shortcodes within the
 * content editor.
 *
 * Uses the embed to convert [embed][simple-links][/embed] to <ul></ul>
 *
 * @see    I went this route because it was difficult to get the oembed api to
 *        work with non url based patterns. I explored the second option of
 *        tapping into wp.shortcodes and added an additional view, however this
 *        js structure is likely to change in the future so it is not very forward
 *        compatible. Also, simple-links will not work because of the hyphen and it
 *        would become a bear to convert everyone over to simplelinks.
 *
 * @author Mat Lipe
 * @since  11/25/2015
 *
 */
class Simple_Links_Visual_Shortcodes {

	const SETTING = 'simple-links-visual-shortcodes-enabled';
	const ACTION = 'simple_links_visual_shortcode';


	private function __construct(){
		if( $this->is_visual_shortcodes_enabled() ){
			$this->add_simple_links_to_embed();
		}
	}


	/**
	 * Add the [simple-links] shortcode to list of embed providers.
	 * If [simple-links] is wrapped with [embed][/embed] WP will
	 * parse and use our method to render the result
	 *
	 *
	 * @param $providers
	 *
	 * @return mixed
	 */
	public function add_simple_links_to_embed(){
		wp_embed_register_handler(
			'simple-links',
			"/\[simple-links[[:space:]]?(.*?)\]/",
			array(
				$this,
				'generate_oembed_results',
			)
		);
	}


	/**
	 * Render the [embed][simple-links][/embed] shortcode
	 * into the complete generated list
	 *
	 * @return string
	 */
	public function generate_oembed_results( $matches ){
		//because embed strips all shortcodes
		simple_links()->register_shortcode();

		$content = do_shortcode( $matches[ 0 ] );

		return $content;

	}


	/**
	 * Do have have the option set in settings to
	 * turn this feature on
	 *
	 * @return bool
	 */
	public function is_visual_shortcodes_enabled(){
		static $enabled = null;
		if( $enabled !== null ){
			return $enabled;
		}
		$enabled = get_option( self::SETTING );
		return (bool)$enabled;
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