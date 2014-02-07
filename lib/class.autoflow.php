<?php
/**
 * @package autoflow
 * @author daithi coombes <webeire@gmail.com>
 */

class Autoflow{

	function __construct(){

		//hooks
		add_action( 'login_enqueue_scripts', array( &$this, 'login_enqueue_scripts' ) );
		add_action( 'login_footer', array( &$this, 'get_login_buttons' ) );
		add_shortcode( 'AutoFlow', array( &$this, 'get_login_buttons' ) );
	}

	/**
	 * Enqueue styles and scripts for login page.
	 * Callback for action 'login_enqueue_scripts'
	 */
	public function login_enqueue_scripts(){

		wp_enqueue_style( 'autoflow', plugins_url() . '/autoflow/lib/css/style.css' );
	}

	/**
	 * Print and return login links
	 * @return string Returns the html after printing to stdout
	 */
	public function get_login_buttons(){

		global $API_Con_Manager;
		global $dont_print;
		$links = array();
		$html = '<div class="autoflow-login">';

		//get active services
		foreach( $API_Con_Manager->get_services( 'active' ) as $service )
			$links[] = $service->get_login_link( array( __CLASS__, 'do_callback', ) );

		$html .= '<ul><li>' 
			. implode( '</li><li>', $links ) 
			. '</ul>'
			. '</div>';

		if ( !$dont_print )
			print $html;
		return $html;
	}

	/**
	 * Callback for handling loging in to third party services
	 * @param  API_Con_Service $service The service object
	 * @param  API_Con_DTO     $dto     The data transport object
	 */
	public function do_callback( API_Con_Service $service, API_Con_DTO $dto ){

		//check connection
		$res = $service->request('/me', null, null, false);
		var_dump($res);
		$body = json_decode( $res['body'] );

		if ( !$body->error )
			var_dump(API_Con_Manager::connect_user( $service ));

		var_dump(API_Con_Manager::get_user_connections());
	}
}
