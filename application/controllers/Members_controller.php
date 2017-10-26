<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members_controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library( array('user_security', 'page_actions') );
		$this->load->library( array('form_validation', 'session', 'encryption') );
		$this->load->helper( array('url', 'html') );
		$this->load->database();
		$this->load->model('Members_model', 'members_mdl');
	}

	public function save_member($member_id = null) {

		if ( $this->user_security->is_user_logged_in( 'CE_sess_' ) ) {

			if ( $this->__is_agreement_checked( array("agreement_one", "agreement_two", "agreement_three") ) == true ) {

				// call member registration to action
				$this->form_validation->set_rules('first_name', 'First Name', 'required', array('required' => 'You must provide a %s.'));
				$this->form_validation->set_rules('middle_name', 'Middle Name', 'required', array('required' => 'You must provide a %s.'));
				$this->form_validation->set_rules('last_name', 'Last Name', 'required', array('required' => 'You must provide a %s.'));
				$this->form_validation->set_rules('mobile', 'Mobile Number', 'required', array('required' => 'You must provide a %s.'));
				$this->form_validation->set_rules('mailing_address', 'Mailing Address', 'required', array('required' => 'You must provide a %s.'));
				$this->form_validation->set_rules('email_address', 'Email Address', 'required', array('required' => 'You must provide a %s.'));

				$this->form_validation->set_rules('gender', 'Gender', 'required', array('required' => 'You must provide a %s.'));
				$this->form_validation->set_rules('birthdate', 'Birthday', 'required', array('required' => 'You must provide a %s.'));
				$this->form_validation->set_rules('civil_status', 'Marital Status', 'required', array('required' => 'You must provide a %s.'));
				$this->form_validation->set_rules('username', 'Username', 'required', array('required' => 'You must provide a %s.'));
				$this->form_validation->set_rules('password', 'Password', 'required', array('required' => 'You must provide a %s.'));
				$this->form_validation->set_rules('c_password', 'Password', 'required', array('required' => 'You must confirm your %s.'));
				// Commented temporarily
				$this->form_validation->set_rules('business', 'Business', 'required', array('required' => 'You must provide a %s.'));

				// set validation html
				$this->form_validation->set_error_delimiters('<div class="col s12 red-text">', '</div>');

				if ($this->form_validation->run() == FALSE) {

					// Call members registration form
					$this->__get_entry_form();

				} else {

					$password = $this->input->post('password');
					$c_password = $this->input->post('c_password');

					// Compare passwords
					if ($password == $c_password) {
						$salt_param = '$6$rounds=5000$' . $this->config->item('salt_str') . '$';
						$password = crypt( $password, $salt_param );

						// assign values
						$tbl_member_group = array(); // member table
						$tbl_member_group['member_first_name']		=	$this->input->post('first_name');
						$tbl_member_group['member_middle_name']		=	$this->input->post('middle_name');
						$tbl_member_group['member_last_name']		=	$this->input->post('last_name');
						$tbl_member_group['member_mobile']			=	$this->input->post('mobile');
						$tbl_member_group['member_landline']		=	$this->input->post('landline');
						$tbl_member_group['member_mailing_address']	=	$this->input->post('mailing_address');
						$tbl_member_group['member_email_address']	=	$this->input->post('email_address');
						$tbl_member_group['member_gender']			=	$this->input->post('gender');
						$tbl_member_group['member_birthdate']		=	$this->input->post('birthdate');
						$tbl_member_group['member_civil_status']	=	$this->input->post('civil_status');

						$tbl_users_group = array(); // users group
						$tbl_users_group['user_name']				=	$this->input->post('username');
						$tbl_users_group['user_password']			=	$password;

						$tbl_business_group = array(); // business group
						$tbl_business_group['business_name']		=	$this->input->post('business');

						$tbl_heirarchy_group = array(); // heirarchy group
						$tbl_heirarchy_group['h_parent_id']			=	$this->input->post('recruiter_id');

						if ( $member_id == null ) {
							// pass to save new datas.
							$save_values = $this->members_mdl->save_new_member( $tbl_member_group, $tbl_users_group, $tbl_business_group, $tbl_heirarchy_group );
							if ($save_values) {
								$target_url = $this->input->post('target_url');
								redirect($target_url . $save_values);
							}
						} else {
							// pass to save edited datas.
							if ( is_numeric($member_id) ) {

							}
						}
						
					} else {
						// password mismatch
						die("Password Mismatch!");
					}

				}

			} else {

				$this->__get_entry_form();

			}

		} else {
			// Call Login Form
			$this->__get_login_form();
		}

	}

	/**
	 * --------------------------------------------------------------------------------------------------------------
	 * |												Private Functions											|
	 * --------------------------------------------------------------------------------------------------------------
	 **/

	private function __is_agreement_checked( $arrayCheckboxes ) {

		if ( is_array($arrayCheckboxes) ) {
			$countArrays = count($arrayCheckboxes);
			if ( $countArrays > 0 ) {
				for ($i=0; $i < $countArrays; $i++) {
					$chkbox_name = $arrayCheckboxes[$i];
					$this->form_validation->set_rules( $chkbox_name, ucwords( str_replace("_", " ", $chkbox_name ) ), 'required', array('required' => 'You must provide a %s.') );
				}
				if ( $this->form_validation->run() == TRUE ) {
					return true;
				}
				return false;
			}
		}

	}

	// The entry form
	private function __get_entry_form($page_title = 'Error Registration &mdash; CE Patron Plus', $entry_action = 'failed') {

		$data['page_title'] = $page_title;
		$data['entry_action'] = $entry_action;
		$this->load->view('header',$data);
		$this->load->view('administrator/member/Entry_view');
		$this->load->view('footer');

	}

	// The login form
	private function __get_login_form($page_title = 'CE Patron Plus &mdash; User Log In') {

		$data['page_title'] = $page_title;
		$this->load->view('header',$data);
		$this->load->view('Login_view');
		$this->load->view('footer');

	}

}