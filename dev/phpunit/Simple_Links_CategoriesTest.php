<?php
/**
 * Simple_Links_CategoriesTest.php
 * 
 * @author Mat
 * @since 4/27/2015
 *
 * @package wordpress *
 */

class Simple_Links_CategoriesTest extends WP_UnitTestCase {
	public function setUp(){
		parent::setUp();
		switch_to_blog( 2 );
	}


	public function test_get_links_by_category_count(){
		$o = Simple_Links_Categories::get_instance();
		foreach( get_terms( Simple_Links_Categories::TAXONOMY, array( 'hide_empty' => false ) ) as $cat ){
			$links = $o->get_links_by_category( $cat->term_id, 2 );
			$this->assertLessThanOrEqual( 2, count( $links ), "Get links by category is returning more than specified count for category $cat->name" );
		}
	}
}
