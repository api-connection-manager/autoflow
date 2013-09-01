<?php
/**
 * @package autoflow
 * @author daithi coombes <webeire@gmail.com>
 */

class Autoflow{

	function __construct(){

		//hooks
		add_action( 'login_footer', array( &$this, 'print_login_buttons' ) );
	}

	/**
	 * Print login links for wp login form footer
	 * @todo  write unit tests
	 */
	function print_login_buttons(){

		global $API_Con_Manager;
		$links = array();

		//get active services
		foreach( $API_Con_Manager->get_services( 'active' ) as $service )
			$links[] = $service->get_login_link( array( __CLASS__, 'do_callback', ) );

		print '<ul><li>' . implode( '</li><li>', $links ) . '</ul>';
	}

	public function do_callback( API_Con_DTO $dto ){
		var_dump("doing callback");
		var_dump($dto);
	}
}