<?php


class SimpleLinkDisplayByCategoryTest extends WP_UnitTestCase {

	private $default_args = array(
		'title'                        => false,
		'show_image'                   => false,
		'show_image_only'              => false,
		'image_size'                   => 'thumbnail',
		'fields'                       => false,
		'description'                  => false,
		'show_description_formatting'  => false,
		'separator'                    =>  '-',
		'id'                           => '',
		'remove_line_break'            => false,
		'display_category_description' => false,
		'display_category_title'       => false,
		'display_links_by_category'    => true,
		'category'                     => false,
		'include_child_categories'     => false
	);

	private $links = array();


	/**
	 * o
	 *
	 * @var SimpleLinksDisplayByCategory
	 */
	private $o;
	
	public function setUp() {
		parent::setUp();
		$this->o = new SimpleLinksDisplayByCategory();
		switch_to_blog( 2 );
		$this->links = get_posts( 'post_type=simple_link&numberposts=100' );
		
	}	


	public function test_sortByCategory(){
		$factory = new SimpleLinksFactory( $this->default_args );

		$links = $this->o->sortByCategory( $this->links, $this->default_args, $factory );

		$categories = wp_list_pluck( $links, 'category' );
		$this->assertContains( 'Aufsätze', $categories, 'Special characters are breaking category names' );
	}


	public function test_displayUsingCategoryIds(){
		$args = $this->default_args;

		$ids = wp_list_pluck( get_terms( Simple_Links_Categories::TAXONOMY ), 'term_id' );

		$args[ 'display_category_title' ] = true;
		$args[ 'category' ] = $ids;
		$factory = new SimpleLinksFactory( $args );

		$links = $this->o->sortByCategory( $this->links, $args, $factory );
		$this->assertNotEmpty( $links, "Display by category returned no links when using ids" );

	}


		
		
}
