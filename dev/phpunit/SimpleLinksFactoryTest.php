<?php
/**
 * SimpleLinksFactoryTest.php
 * 
 * @author mat
 * @since 9/25/2014
 *
 * @package wordpress
 */


class SimpleLinksFactoryTest extends WP_UnitTestCase {

	public function setUp(){
		parent::setUp();
		switch_to_blog( 2 );
	}

	public function test_description(){
		$o = new SimpleLinksFactory( array( 'description' => true ), 'phpunit' );
		$this->assertContains( array( 'description' => true) , $o->args, "The description arg did not retain it's value. See 89d56ae1699aa6c95075ae702d61ae039f0dc794" );

	}


	public function test_include_children(){
		$cats = get_terms( Simple_Links_Categories::TAXONOMY, array( 'fields' => 'ids', 'hide_empty' => false ) );

		foreach( $cats as $_cat_id ){
			$o = new SimpleLinksFactory( array( 'category' => $_cat_id ) );

			foreach( $o->links as $_link ){
				$_cats = wp_get_post_terms( $_link->ID, Simple_Links_Categories::TAXONOMY, array( 'fields' => 'ids' ) );

				$this->assertContains( $_cat_id, $_cats, "A link from another category was retrived" );
			}

		}

	}

}
 