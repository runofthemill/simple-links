<?php
/**
 * simple_linksTest.php
 * 
 * @author Mat
 * @since 5/15/2015
 *
 * @package wordpress *
 */

class simple_linksTest extends WP_UnitTestCase {
	public function setUp(){
		parent::setUp();
		switch_to_blog( 2 );
	}

	public function test_getAdditionalFields(){
		add_filter( 'option_link_additional_fields', '__return_false' );

		$fields = simple_links()->getAdditionalFields();
		$this->assertTrue( is_array( $fields ), 'Additional fields are not returning as array' );

	}
}
