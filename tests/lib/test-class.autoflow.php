<?php

require_once( WP_PLUGIN_DIR . "/api-connection-manager/index.php" );

class AutoflowTest extends WP_UnitTestCase{

	protected $active;
	protected $api;
	protected $obj;

	function setUp(){

		global $API_Con_Manager;

		$this->active = $API_Con_Manager->get_services('active');
		$this->api = $API_Con_Manager;
		$this->obj = new Autoflow();
	}

	function test_print_login_buttons(){
		
		global $dont_print;
		$dont_print = true;

		$actual = new DomDocument;
		$actual->loadHtml( $this->obj->get_login_buttons(false) );

		$this->assertEquals(count($this->active), $actual->getElementsByTagName('li')->length);
	}
}