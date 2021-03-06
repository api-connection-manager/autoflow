<?php
/**
 * @package autoflow
 * @author daithi coombes <webeire@gmail.com>
 */

class Autoflow{

	function __construct(){

		//hooks
		add_action( 'login_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		add_action( 'login_footer', array( &$this, 'get_login_buttons' ) );
		add_shortcode( 'AutoFlow', array( &$this, 'get_login_buttons' ) );
	}

	/**
	 * Enqueue styles and scripts for login page.
	 * Callback for action 'login_enqueue_scripts'
	 */
	public function enqueue_scripts(){

		wp_enqueue_style( 'autoflow', plugins_url() . '/autoflow/lib/css/style.css' );
	}

	/**
	 * Print and return login links
	 * @return string Returns the html after printing to stdout
	 */
	public function get_login_buttons(){

		$this->enqueue_scripts();

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

		print $html;
	}

	/**
	 * Callback for handling loging in to third party services
	 * @param  API_Con_Service $service The service object
	 * @param  API_Con_DTO     $dto     The data transport object
	 */
	public function do_callback( API_Con_Service $service, API_Con_DTO $dto ){

		//handle errors
		if ( is_wp_error($res) )
			die('Autoflow Error: ' . $res->get_error_message() );

		//get profile
		$uid = $service->get_uid();

		//login
		if ( !$this->login( $service, $uid ) )
			$url = wp_registration_url();
		else
			$url = admin_url( 'profile.php' );

		//print javascript window.opener
		?>
		<script type="text/javascript">
			window.opener.location.href = '<?php echo $url; ?>';
			window.close();
		</script>
		<?php
	}

	/**
	 * Try logging in user
	 * @param  API_Con_Service $service The service object
	 * @param  string          $uid     The user's service uid
	 */
	private function login( API_Con_Service $service, $uid ){

		global $API_Con_Manager;
		$connections = API_Con_Manager::get_connections();

		//look for uid in $connections
		foreach ( $connections as $user_id => $data )
			if ( $data[$service->name][0] == $uid ){

				$user = get_user_by( 'id', $user_id );

				wp_set_current_user( $user_id, $user->user_login );
				wp_set_auth_cookie( $user_id );
				do_action( 'wp_login', $user->user_login );

				return true;
			}

		return false;
	}
}
