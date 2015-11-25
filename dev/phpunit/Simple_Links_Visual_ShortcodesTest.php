<?php


/**
 * Simple_Links_Visual_ShortcodesTest.php
 *
 * @author  Mat
 * @since   11/25/2015
 *
 * @package wordpress *
 */
class Simple_Links_Visual_ShortcodesTest extends WP_UnitTestCase {

	public function setUp(){
		parent::setUp();
		switch_to_blog( 2 );
	}


	public function test_turned_off(){
		update_option( Simple_Links_Visual_Shortcodes::SETTING, true );
		$object             = Simple_Links_Visual_Shortcodes::get_instance();
		$posts               = get_posts( 'numberposts=1' );
		$post = $posts[0];
		$post->post_content = "<p>[simple-links]
					</p><p>[ishoudlstay]</p><p>[simple-links]
					</p><p>[ishoudlstay]</p><p>[simple-links]
					</p><p>[embed][ishoudlstay][/embed]</p>";
		wp_insert_post( (array) $post );
		$updated = get_post( $post->ID );
		$this->assertFalse( (bool) strpos( $updated->post_content, '[embed][simple-links][/embed]' ), 'Shortcodes not being wrapped with embeds when setting is off' );
	}


	public function test_strip_embed_wraps_upon_save(){
		update_option( Simple_Links_Visual_Shortcodes::SETTING, true );

		$object = Simple_Links_Visual_Shortcodes::get_instance();

		$post[ 'post_content' ] = "<p>[embed][simple-links][/embed]
								</p><p>[embed][ishoudlstay][/embed]</p><p>[embed][simple-links][/embed]
								</p><p>[embed][ishoudlstay][/embed]</p><p>[embed][simple-links][/embed]
								</p><p>[embed][ishoudlstay][/embed]</p>";

		$post = $object->strip_embed_wraps_upon_save( $post );

		$this->assertFalse( strpos( $post[ 'post_content' ], '[embed][simple-links][/embed]' ), 'Embed are not being stripped out' );
		$this->assertTrue( (bool) strpos( $post[ 'post_content' ], '[embed][ishoudlstay][/embed]' ), 'Other embeds are being stripped out' );
	}


	public function test_wrap_shortcodes_in_embed(){
		update_option( Simple_Links_Visual_Shortcodes::SETTING, true );

		$object = Simple_Links_Visual_Shortcodes::get_instance();

		$content = "<p>[simple-links]
					</p><p>[ishoudlstay]</p><p>[simple-links]
					</p><p>[ishoudlstay]</p><p>[simple-links]
					</p><p>[embed][ishoudlstay][/embed]</p>";

		$wrapped_content = $object->wrap_shortcodes_in_embed( $content );

		$this->assertTrue( (bool) strpos( $wrapped_content, '[embed][simple-links][/embed]' ), 'Shortcodes are not being wrapped with embeds' );
		$this->assertFalse( (bool) strpos( $wrapped_content, '[/embed][/embed]' ), 'Embeds are doubling up' );

	}

}
