<?php
/**
 * @package autoflow
 */
/*
  Plugin Name: AutoFlow
  Plugin URI: https://github.com/david-coombes/wp-plugin-framework
  Description: Framework for writing wordpress plugins
  Version: 1.0
  Author: Daithi Coombes
  Author URI: http://david-coombes.com
 */

//load api-con
require_once( WP_PLUGIN_DIR . '/api-connection-manager/index.php' );

//construct autoflow
require_once( 'lib/class.autoflow.php' );
$autoflow = new Autoflow();