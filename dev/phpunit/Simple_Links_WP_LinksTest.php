<?php
/**
 * Simple_Links_WP_LinksTest.php
 * 
 * @author Mat
 * @since 5/1/2015
 *
 * @package wordpress *
 */

class Simple_Links_WP_LinksTest extends WP_UnitTestCase {
	public function setUp(){
		parent::setUp();
		switch_to_blog( 2 );
	}


	public function test_categories_import(){
		$o = Simple_Links_WP_Links::get_instance();
		$_REQUEST['_wpnonce'] = wp_create_nonce( 'simple_links_import_links' );
		$links = $o->import_links();

		foreach( $links as $_old => $new ){
			$old_terms = wp_get_object_terms( $_old, 'link_category' );
			$new_terms = wp_list_pluck( wp_get_post_terms( $new, Simple_Links_Categories::TAXONOMY ), 'slug' );
			foreach( $old_terms as $_term ){
				$this->assertContains( $_term->slug, $new_terms, 'There is on matching category found in the newly imported link ' . get_bookmark( $_old )->link_name );

			}
		}

	}
}
