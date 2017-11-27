<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	private $__application_name = "CE Patron Plus";

	public function __construct() {
		parent::__construct();
		$this->load->library( array('user_security', 'page_actions') );
		$this->load->helper( array( 'url', 'html', 'form' ) );
		$this->load->database();
	}

	public function index() {

		if ( $this->user_security->is_user_logged_in( 'CE_sess_' ) ) {

			$data['page_title'] = "Dashboard &mdash; " . $this->__application_name;
			$this->load->view('header', $data);
			$this->load->view('sidebar');
			$this->load->view('administrator/Dashboard_view');
			$this->load->view('footer');

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
			$this->load->model('Members_model', 'members_mdl');
			if ($action === 'new') {

				// Call new form
				$data['page_title'] = "New Member &mdash; " . $this->__application_name;
				$data['materialize_custom_JS'] = true;
				$this->load->view('header', $data);
				$this->load->view('sidebar');
				$this->load->view('administrator/member/Entry_view');
				$this->load->view('footer');

			} else if ($action === 'edit') {

				if ( is_numeric($paramTwo) ) {
					// Call edit form
					$data['page_title'] = "Edit Member &mdash; " . $this->__application_name;
					$data['materialize_custom_JS'] = true;
					$data['data_list'] = $this->members_mdl->get_datas_by_id($paramTwo);
					// recruiter details
					if ( $data['data_list'] ) {
						$data['parent_metadata'] = $this->members_mdl->get_datas_by_id( $data['data_list']->h_parent_id );
						// print_r($data['parent_metadata']);
					}
					$this->load->view('header', $data);
					$this->load->view('sidebar');
					$this->load->view('administrator/member/Edit_view');
					$this->load->view('footer');
				}

			} else if ($action === 'view') {

				if ( is_numeric($paramTwo) ) {
					// View section
					$data['page_title'] = "Profile &mdash; " . $this->__application_name;
					$data['data_list'] = $this->members_mdl->get_datas_by_id($paramTwo);
					$this->load->view('header', $data);
					$this->load->view('sidebar');
					$this->load->view('administrator/member/Profile_view');
					$this->load->view('footer');
				}

			} else if ($action === 'treeview') {

				if ( is_numeric($paramTwo) ) {
					// Tree view section
					$data['include_files'] = array(
						'css'	=>	array(
										array(
											'folder'	=>	'getorgchart',
											'files'		=>	array('getorgchart')
										)
								),
						'js'	=>	array(
										array(
											'folder'	=>	'getorgchart',
											'files'		=>	array('getorgchart')
										),
										array(
											'folder'	=>	'js',
											'files'		=>	array('init-chart')
										)
								),
					);

					$data['page_title'] = "Tree View &mdash; " . $this->__application_name;
					$data['member_metadata'] = $this->members_mdl->get_datas_by_id($paramTwo);
					$top_data = $this->members_mdl->get_tree_datas($paramTwo);
					$data['data_list'] = $this->members_mdl->construct_tree($top_data);
					$this->load->view('header', $data);
					$this->load->view('sidebar');
					$this->load->view('administrator/member/Tree_view');
					$this->load->view('footer');
				}

			} else if ($action === 'tree') {
				// The test tree view controller
				if ( is_numeric($paramTwo) ) {
					// Tree view section
					$data['include_files'] = array(
						'css'	=>	array(
										array(
											'folder'	=>	'getorgchart',
											'files'		=>	array('getorgchart')
										)
								),
						'js'	=>	array(
										array(
											'folder'	=>	'getorgchart',
											'files'		=>	array('getorgchart')
										),
										array(
											'folder'	=>	'js',
											'files'		=>	array('init-chart')
										)
								),
					);

					$data['page_title'] = "Tree View &mdash; " . $this->__application_name;
					$data['member_metadata'] = $this->members_mdl->get_datas_by_id($paramTwo);
					$top_data = $this->members_mdl->get_tree_datas($paramTwo);
					$data['data_list'] = $this->members_mdl->construct_tree($top_data);
					$data['data_lists'] = $top_data;
					$this->load->view('header', $data);
					$this->load->view('sidebar');
					$this->load->view('administrator/member/Tree_bk_view');
					$this->load->view('footer');
				}

			} else if ($action === 'search' || $action === 'searchtrash' ) {
				if (is_null($paramTwo)) {
					$searchValue = $this->input->get('s', TRUE);
					redirect( site_url( $this->uri->slash_rsegment(1) . $this->uri->slash_rsegment(2) . $this->uri->slash_rsegment(3) . urlencode($searchValue) ) );
				} else {
					switch ($action) {
						case 'search':
							$search_menu = 'search';
							$param_status = true;
							break;
						case 'searchtrash':
							$search_menu = 'search_trash';
							$param_status = false;
							break;
						default:
							$search_menu = 'search';
							$param_status = true;
							break;
					}
					$searchValue = urldecode( $paramTwo );
					$data['page_title'] = "Search results for '" . $searchValue . "' &mdash; " . $this->__application_name;
					$data['data_list'] = $this->members_mdl->get_datas(
						array(
							'search'	=>	array(
								'tbl_members.member_first_name'		=>	$searchValue,
								'tbl_members.member_middle_name'	=>	$searchValue,
								'tbl_members.member_last_name'		=>	$searchValue,
								'tbl_members.member_mobile'			=>	$searchValue,
								'tbl_members.member_landline'		=>	$searchValue,
								'tbl_members.member_mailing_address'=>	$searchValue,
								'tbl_members.member_email_address'	=>	$searchValue
							),
							'status'	=>	$param_status
						)
					);
					$data['nav_menus'] = array('new',$search_menu,'trash','logs');
					$this->load->view('header', $data);
					$this->load->view('sidebar');
					$this->load->view('administrator/Navbar_view');
					$this->load->view('administrator/member/Search_view');
					$this->load->view('footer');
				}

			} else if ($action === 'trash') {

				// Trash/Recycle Bin
				$data['page_title'] = "Recycle Bin &mdash; " . $this->__application_name;
				$data['data_list'] = $this->members_mdl->get_datas( array('status'=>false) );
				$data['nav_menus'] = array('search_trash','logs');
				$this->load->view('header', $data);
				$this->load->view('sidebar');
				$this->load->view('administrator/Navbar_view');
				$this->load->view('administrator/member/Recycle_bin_view');
				$this->load->view('footer');

			} else if ($action === 'delete' || $action === 'restore') {

				// Delete
				if (is_numeric($paramTwo)) {
					
					if ( $this->input->post('delete_yes') ) {
						$request_member_id = $this->input->post('member_id');
						if ($paramTwo == $request_member_id) {
							$this->__delete_restore_member($request_member_id);
						} else {
							echo "<h4>Error Deleting: Request ID and URL did not match</h4>";
						}

					} else if ( $this->input->post('restore_yes') ) {
						$request_member_id = $this->input->post('member_id');
						if ($paramTwo == $request_member_id) {
							$this->__delete_restore_member($request_member_id, true);
						} else {
							echo "<h4>Error Restoring: Request ID and URL did not match</h4>";
						}

					} else if ( $this->input->post('delete_no') || $this->input->post('restore_no') ) {

						echo '<script type="text/javascript">history.go(-2);</script>';

					} else {
						$data['page_title'] = "Confirm Delete &mdash; " . $this->__application_name;
						$data['nav_menus'] = array('search','logs');
						$this->load->view('header', $data);
						$this->load->view('sidebar');
						$this->load->view('administrator/Navbar_view');
						$this->load->view('administrator/member/Delete_view');
						$this->load->view('footer');
					}

				}

			} else {
				// View all / Default
				$data['page_title'] = "View All &mdash; " . $this->__application_name;
				$data['data_list'] = $this->members_mdl->get_datas();
				$data['nav_menus'] = array('new','search','trash','logs');
				$this->load->view('header', $data);
				$this->load->view('sidebar');
				$this->load->view('administrator/Navbar_view');
				$this->load->view('administrator/member/List_view');
				$this->load->view('footer');
			}

		} else {

			// Call login form
			$this->__get_login_form();

		}

	}

	/**
	 * Members Controller
	 */
	public function inventory( $action = '', $paramTwo = null ) {

		if ( $this->user_security->is_user_logged_in( 'CE_sess_' ) ) {

			$this->load->model('Inventory_model', 'inventory_mdl');

			if ( $action === 'new' ) {

				$data['page_title'] = "New Item &mdash; " . $this->__application_name;
				$this->load->view('header', $data);
				$this->load->view('sidebar');
				$this->load->view('administrator/inventory/Entry_view');
				$this->load->view('footer');

			} else if ( $action === 'edit' ) {

				$data['page_title'] = "Edit Item &mdash; " . $this->__application_name;
				$data['meta_datas'] = $this->inventory_mdl->get_data_by_id($paramTwo);
				$this->load->view('header', $data);
				$this->load->view('sidebar');
				$this->load->view('administrator/inventory/Edit_view');
				$this->load->view('footer');

			} else if ( $action === 'view' ) {

				$data['page_title'] = "Item Details &mdash; " . $this->__application_name;
				$data['meta_datas'] = $this->inventory_mdl->get_data_by_id($paramTwo);
				$this->load->view('header', $data);
				$this->load->view('sidebar');
				$this->load->view('administrator/inventory/Single_view');
				$this->load->view('footer');

			} else if ($action === 'search') {

				if (is_null($paramTwo)) {
					$searchValue = $this->input->get('s', TRUE);
					redirect( site_url( $this->uri->slash_rsegment(1) . $this->uri->slash_rsegment(2) . $this->uri->slash_rsegment(3) . urlencode($searchValue) ) );
				} else {
					$searchValue = urldecode( $paramTwo );
					$data['page_title'] = "Search results for '" . $searchValue . "' &mdash; " . $this->__application_name;
					$data['data_list'] = $this->inventory_mdl->get_datas(
						array(
							'search'	=>	array(
								'item_code'		=>	$searchValue,
								'item_name'		=>	$searchValue,
								'item_remarks'	=>	$searchValue
							),
							'status'	=>	true
						)
					);
					$data['nav_menus'] = array('new','search','trash','logs');
					$this->load->view('header', $data);
					$this->load->view('sidebar');
					$this->load->view('administrator/Navbar_view');
					$this->load->view('administrator/inventory/Search_view');
					$this->load->view('footer');
				}

			} else if ($action === 'trash') {

				// Trash/Recycle Bin
				$data['page_title'] = "Recycle Bin &mdash; " . $this->__application_name;
				$data['data_list'] = $this->inventory_mdl->get_datas( array('status'=>false) );
				$data['nav_menus'] = array('search_trash','logs');
				$this->load->view('header', $data);
				$this->load->view('sidebar');
				$this->load->view('administrator/Navbar_view');
				$this->load->view('administrator/inventory/Recycle_bin_view');
				$this->load->view('footer');

			} else if ($action === 'delete' || $action === 'restore') {

				// Delete
				if (is_numeric($paramTwo)) {
					
					if ( $this->input->post('delete_yes') ) {
						$request_item_id = $this->input->post('item_id');
						if ($paramTwo == $request_item_id) {
							$this->__delete_restore_item($request_item_id);
						} else {
							echo "<h4>Error Deleting: Request ID and URL did not match</h4>";
						}

					} else if ( $this->input->post('restore_yes') ) {
						$request_item_id = $this->input->post('item_id');
						if ($paramTwo == $request_item_id) {
							$this->__delete_restore_item($request_item_id, true);
						} else {
							echo "<h4>Error Restoring: Request ID and URL did not match</h4>";
						}

					} else if ( $this->input->post('delete_no') || $this->input->post('restore_no') ) {

						echo '<script type="text/javascript">history.go(-2);</script>';

					} else {
						$data['page_title'] = "Confirm Delete &mdash; " . $this->__application_name;
						$data['nav_menus'] = array('search','logs');
						$this->load->view('header', $data);
						$this->load->view('sidebar');
						$this->load->view('administrator/Navbar_view');
						$this->load->view('administrator/inventory/Delete_view');
						$this->load->view('footer');
					}

				}

			} else {

				$data['page_title'] = "Item List &mdash; " . $this->__application_name;
				$data['data_list'] = $this->inventory_mdl->get_datas();
				$data['nav_menus'] = array('new','search','trash','logs');
				$this->load->view('header', $data);
				$this->load->view('sidebar');
				$this->load->view('administrator/Navbar_view');
				$this->load->view('administrator/inventory/List_view');
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

	// Delete / Restore Member
	private function __delete_restore_member($member_id, $action = false /*true for restore, false for delete*/ ) {
		if ( $this->members_mdl->delete_restore_member($member_id, $action) ) {
			redirect( site_url( $this->uri->slash_rsegment(1) . $this->uri->slash_rsegment(2) ) );
		}
	}

	// Delete / Restore Item
	private function __delete_restore_item($item_id, $action = false /*true for restore, false for delete*/ ) {
		if ( $this->inventory_mdl->delete_restore_item($item_id, $action) ) {
			redirect( site_url( $this->uri->slash_rsegment(1) . $this->uri->slash_rsegment(2) ) );
		}
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