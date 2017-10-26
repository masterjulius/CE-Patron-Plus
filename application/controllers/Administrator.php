<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	private $__application_name = "CE Patron Plus";

	public function __construct() {
		parent::__construct();
		$this->load->library( array('user_security', 'page_actions') );
		$this->load->helper( array( 'url', 'html', 'form' ) );
	}

	public function index() {

		if ( $this->user_security->is_user_logged_in( 'CE_sess_' ) ) {

			

		} else {

			// Call login form
			$this->__get_login_form();

		}

	}

	/**
	 * Members Controller
	 */
	public function members( $action = '', $paramTwo = null ) {

		if ( $this->user_security->is_user_logged_in( 'CE_sess_' ) ) {

			/** Actions if Role is administrator
			 * New
			 * Edit
			 * Delete
			 * Restore
			 * View Trash
			 * View All
			 * View Heirarchies
			 */
			$action = strtolower($action);
			// load model
			$this->load->database();
			$this->load->model('Members_model', 'members_mdl');
			if ($action === 'new') {

				// Call new form
				$data['page_title'] = "New Member &mdash; " . $this->__application_name;
				$this->load->view('header', $data);
				$this->load->view('administrator/member/Entry_view');
				$this->load->view('footer');

			} else if ($action === 'edit') {

				// Call edit form
				$data['page_title'] = "Edit Member &mdash; " . $this->__application_name;
				$this->load->view('header', $data);
				$this->load->view('administrator/member/Entry_view');
				$this->load->view('footer');

			} else {
				// View all / Default
				$data['page_title'] = "View All &mdash; " . $this->__application_name;
				$data['data_list'] = $this->members_mdl->get_datas();
				$this->load->view('header', $data);
				$this->load->view('administrator/member/List_view');
				$this->load->view('footer');
			}

		} else {

			// Call login form
			$this->__get_login_form();

		}

	}

	/**
	 * --------------------------------------------------------------------------------------------------------------
	 * |												Private Functions											|
	 * --------------------------------------------------------------------------------------------------------------
	 **/

	// The login form
	private function __get_login_form($page_title = 'CE Patron Plus &mdash; User Log In') {

		$data['page_title'] = $page_title;
		$this->load->view('header',$data);
		$this->load->view('Login_view');
		$this->load->view('footer');

	}

}

?>