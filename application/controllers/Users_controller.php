<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library( array('user_security', 'page_actions') );
		$this->load->library( array('form_validation', 'session', 'encryption') );
		$this->load->helper( array('url', 'html') );
	}

	public function user_sign_in() {

		if ( $this->user_security->is_user_logged_in( 'CE_sess_' ) ) {
			redirect('/administrator/');
		} else {

			// call login to action
			$this->form_validation->set_rules('username', 'Username', 'required', array('required' => 'You must provide a %s.'));
			$this->form_validation->set_rules('password', 'Password', 'required', array('required' => 'You must provide a %s.'));

			if ($this->form_validation->run() == FALSE) {

				// set validation html
				$this->form_validation->set_error_delimiters('<div class="col s12 red-text">', '</div>');

				$data['page_title'] = "Sign In Error!";
				$this->load->view('header',$data);
				$this->load->view('Login_view');
				$this->load->view('footer');

			} else {

				// get values
				$usr_name = $this->input->post('username');
				$usr_password = $this->input->post('password');

				$salt_param = '$6$rounds=5000$' . $this->config->item('salt_str') . '$';
				$usr_password = crypt( $usr_password, $salt_param );

				// Load database
				$this->load->database();

				$this->load->model('User_model','usr_mdl');
				$get_usr_credentials = $this->usr_mdl->get_user_credentials( array('user_name'=>$usr_name,'user_password'=>$usr_password) );
				if ( $get_usr_credentials != null ) {

					// set session
					$session_datas = array(
						'user_id'	=>	$get_usr_credentials->user_id,
						'user_name'	=>	$get_usr_credentials->user_name,
						'user_role'	=>	$get_usr_credentials->user_role
					);
					$this->user_security->register_session_data( $session_datas, 'CE_sess_' );
					$target_url = !empty($this->input->post('target_url')) ? $this->input->post('target_url') : '/administrator/';
					redirect( $target_url );

				}

			}

		}

	}

}

?>