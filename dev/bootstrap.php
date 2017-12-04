<?php

$GLOBALS['wp_tests_options']['active_plugins'][] = 'simple-links/simple-links.php';
$GLOBALS['wp_tests_options']['active_plugins'][] = 'simple-links-pro/simple-links-pro.php';
$GLOBALS['wp_tests_options']['permalink_structure'] = '%postname%/';

require dirname( __FILE__ ) . '/wp-tests-config.php';

global $wp_version;

require 'E:/SVN/wordpress-tests/includes/bootstrap-no-install.php';
