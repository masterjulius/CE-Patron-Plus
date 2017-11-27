<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library( array('user_security', 'page_actions') );
		$this->load->library( array('form_validation', 'session', 'encryption') );
		$this->load->helper( array('url', 'html') );
		$this->load->database();
		$this->load->model('Inventory_model', 'inventory_mdl');
	}

	public function save_item($item_id = null) {

		if ( $this->user_security->is_user_logged_in( 'CE_sess_' ) ) {

			// Form validation
			$this->form_validation->set_rules('item_name', 'Item Name', 'required', array('required' => 'You must provide a %s.'));
			$this->form_validation->set_rules('item_price', 'Item Price', 'required', array('required' => 'You must provide a %s.'));
			$this->form_validation->set_rules('item_qty', 'Item Quantity', 'required', array('required' => 'You must provide a %s.'));

				// set validation html
			$this->form_validation->set_error_delimiters('<div class="col s12 red-text">', '</div>');

			if ($this->form_validation->run() == FALSE) {

					// Call members registration form
				$this->__get_entry_form();

			} else {

				$inventory_args = array();
				if (is_numeric($item_id)) {	
					$inventory_args['item_id'] = $item_id;
				}

				$inventory_args['item_code'] = $this->input->post('item_code');
				$inventory_args['item_name'] = $this->input->post('item_name');
				$inventory_args['item_price'] = $this->input->post('item_price');
				$inventory_args['item_qty'] = $this->input->post('item_qty');
				$inventory_args['item_remarks'] = $this->input->post('item_remarks');

				$save_item = $this->inventory_mdl->save_item($inventory_args);
				if ($save_item) {
					echo 'Go';
					$target_url = $this->input->post('target_url');
					if ( is_numeric($item_id) ) {
						redirect($target_url);
					} else {
						redirect($target_url . $save_item);
					}
				} else {
					echo '?????';
				}

			}

			

		} else {
			// Call Login Form
			$this->__get_login_form();
		}

	}

	// Private Methods
	// The entry form
	private function __get_entry_form($page_view = 'new', $page_title = 'Error Registration &mdash; CE Patron Plus', $entry_action = 'failed') {

		$data['page_title'] = $page_title;
		$data['entry_action'] = $entry_action;
		$this->load->view('header',$data);
		if ($page_view === 'new') {
			$this->load->view('administrator/inventory/Entry_view');
		} else {
			$this->load->view('administrator/inventory/Edit_view');
		}
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

?>
