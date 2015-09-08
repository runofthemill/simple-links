<?php
/**
 * SimpleLinksCsvImportExportHandler_Test
 *
 * @author Mat Lipe
 * @since  9/8/2015
 *
 */
class SimpleLinksCsvImportExportHandler_Test extends WP_UnitTestCase {
	public function setUp(){
		parent::setUp();
		switch_to_blog( 2 );
	}


	public function test_import_file(){
		$_POST[ 'csv-file' ] = 774; //needs to be set to an importe csv file id
		$_POST[ 'post_status' ] = 'draft';

		$import = new SimpleLinksCsvImportExportHandler();
		$import->importLinks();
		$imported = get_posts(
			array(
				'post_type'   => Simple_link::POST_TYPE,
				'numberposts' => -1,
				'post_status' => 'draft',
				'fields'      => 'ids',
				'meta_key'    => 'sl-imported-from',
				'meta_value'  => $_POST[ 'csv-file' ]
			)
		);
		$this->assertEquals( 30, count( $imported ) );
	}
}