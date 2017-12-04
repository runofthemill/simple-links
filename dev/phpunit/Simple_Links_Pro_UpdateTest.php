<?php
/**
 * Simple_Links_Pro_Update.php
 *
 * @author  mat
 * @since   12/4/2017
 *
 * @package wordpress *
 */


class Simple_Links_Pro_UpdateTest extends WP_UnitTestCase {
	public function testCheckForUpdate() {
		$update = new Simple_Links_Pro_Update();
		$data = $update->checkForUpdate( $this->generate_transient_data() );
		$this->assertEquals( SIMPLE_LINKS_PRO_VERSION, $data->response[ 'simple-links-pro/simple-links-pro.php' ]->version );
	}


	public function testPlugin_api_call() {
		add_filter( 'pre_site_transient_update_plugins', array( $this, 'generate_transient_data' ) );
		$result = apply_filters( 'plugins_api',
			'_x', 'plugin_information', (object) array( 'slug' => 'simple-links-pro' ) );
		$this->assertEquals( SIMPLE_LINKS_PRO_VERSION, $result->version );
	}


	public function generate_transient_data() {
		return (object) array(
			'checked' => array(
				'simple-links-pro/simple-links-pro.php' => '0.0.1',
			),
		);
	}
}
