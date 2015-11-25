<?php


/**
 * Simple_Links_Visual_Shortcodes
 *
 * All the display the the rendered shortcodes within the
 * content editor.
 *
 * Uses the oembed api to convert [simple-links] to <ul></ul>
 *
 * @author Mat Lipe
 * @since  11/25/2015
 *
 */
class Simple_Links_Visual_Shortcodes {

	const SETTING = 'simple-links-visual-shortcodes-enabled';


	private function __construct(){
		$this->hooks();
	}


	private function hooks(){

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