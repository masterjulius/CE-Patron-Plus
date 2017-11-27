<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members_model extends CI_Model {

	// fetch default datas / view in the main members action controller
	public function get_datas( $params = null ) {

		$status_param = is_array($params) && array_key_exists('status', $params) ? $params['status'] : true;

		$paramArray = array(
			'query_type'=> 'join',
			'from'		=> 'tbl_members',
			'tables'	=>	array(
							'tbl_members'			=> array('member_id', 'member_first_name', 'member_middle_name', 'member_last_name', 'member_mobile', 'member_landline', 'member_mailing_address', 'member_email_address', 'member_gender', 'member_birthdate', 'member_civil_status', 'member_date_registered'),
							'tbl_users'				=> array('user_name'),
							'tbl_business'			=> array('business_name', 'business_date_registered')
						),
			'is_active'	=>	true
		);
		$selectedFields = '';
		foreach ($paramArray['tables'] as $tableKey => $tableValue) {
			
			foreach ($tableValue as $columnValue) {
				$selectedFields .= (' ' . $tableKey . '.' . $columnValue . ',');	
			}

		}
		$this->db->select( rtrim($selectedFields, ',') );
		$this->db->from( $paramArray['from'] );
		$this->db->join('tbl_users', 'tbl_users.user_member_id = tbl_members.member_id', 'left');
		$this->db->join('tbl_business', 'tbl_business.business_owner_id = tbl_members.member_id', 'left');
		$this->db->order_by('tbl_members.member_last_name', 'ASC');
		$this->db->where( array('tbl_members.member_is_active'=>$status_param) );
		if (is_array($params)) {
			if ( array_key_exists('search', $params) ) {
				if ( is_array($params['search']) ) {
					$this->db->group_start();
					$index = 0;
					foreach ($params['search'] as $key => $value) {
						if ($index == 0) {
							$this->db->like($key, $value);
						} else {
							$this->db->or_like($key, $value);
						}
						$index++;
					}
					$this->db->group_end();
				}
			}
		}
		// echo $sql = $this->db->get_compiled_select();
		$query = $this->db->get();
		if ( $query ) {

			if ( $query->num_rows() > 0 ) {
				return $query->result();
			}
			return false;
		}
		return false;

	}

	// get datas by id
	public function get_datas_by_id( $member_id ) {

		if ( !is_null( $member_id ) ) {

			$paramArray = array(
				'query_type'=> 'join',
				'from'		=> 'tbl_members',
				'tables'	=>	array(
								'tbl_members'			=> array('member_id', 'member_first_name', 'member_middle_name', 'member_last_name', 'member_mobile', 'member_landline', 'member_mailing_address', 'member_email_address', 'member_gender', 'member_birthdate', 'member_civil_status', 'member_date_registered'),
								'tbl_users'				=> array('user_name'),
								'tbl_business'			=> array('business_name', 'business_date_registered'),
								'tbl_member_heirarchy'	=> array('h_parent_id')
							),
				'is_active'	=>	true
			);
			$selectedFields = '';
			foreach ($paramArray['tables'] as $tableKey => $tableValue) {
				
				foreach ($tableValue as $columnValue) {
					$selectedFields .= (' ' . $tableKey . '.' . $columnValue . ',');	
				}

			}
			$this->db->select( rtrim($selectedFields, ',') );
			$this->db->from( $paramArray['from'] );
			$this->db->join('tbl_users', 'tbl_users.user_member_id = tbl_members.member_id', 'left');
			$this->db->join('tbl_business', 'tbl_business.business_owner_id = tbl_members.member_id', 'left');
			$this->db->join('tbl_member_heirarchy', 'tbl_member_heirarchy.h_member_id = tbl_members.member_id');
			$this->db->where('tbl_members.member_id',$member_id);
			$this->db->where('tbl_members.member_is_active',true);
			$query = $this->db->get();
			if ( $query ) {
				if ( $query->num_rows() > 0 ) {
					return $query->row();
				}
				return false;
			}
			return false;

		}

	}

	// get bonuses by id
	public function get_bonus_by_id($member_id, $type='unilevel') {
		if ($type === 'unilevel') {
			$this->db->select_sum('unilevel_amount');
			$query = $this->db->get('tbl_unilevel_bonuses');
		} else {
			$this->db->select_sum('bonus_amount');
			$query = $this->db->get('tbl_unilevel_bonuses');
		}
		if ($query) {
			if ( $query->num_rows() > 0 ) {
				return $query->row();
			}
		}
		return false;
	}

	// get tree view

	// get member with limit
	public function search_get_limited_member( $limit = 12 ) {

		$stmt = "SELECT `tbl_members`.`member_id`, `tbl_members`.`member_first_name`, `tbl_members`.`member_middle_name`, `tbl_members`.`member_last_name`, ";
		$stmt .= "(SELECT COUNT(`h_id`) FROM `tbl_member_heirarchy` WHERE `h_parent_id`=`tbl_members`.`member_id` AND `h_is_active`=1) AS `child_count` ";
		$stmt .= "FROM `tbl_members` ";
		$stmt .= "LEFT JOIN `tbl_member_heirarchy` ON `tbl_member_heirarchy`.`h_member_id`=`tbl_members`.`member_id` ";
		$stmt .= "WHERE `tbl_members`.`member_is_active`=1 AND `tbl_member_heirarchy`.`h_is_active`=1 GROUP BY `tbl_members`.`member_id` HAVING `child_count`<12";
		$query = $this->db->query( $stmt );
		if ( $query ) {
			if ( $query->num_rows() > 0 ) {
				return $query->result();
			}
			return false;
		}
		return false;

	}

	/**
	 * This is the Tree View Group
	 */
	public function get_tree_datas( $member_id ) {

		if (!is_null($member_id)) {

			$stmt = "SELECT `tbl_members`.`member_id`, `tbl_members`.`member_first_name`, `tbl_members`.`member_middle_name`, `tbl_members`.`member_last_name`, `tbl_members`.`member_gender`, ";
			$stmt .= "(SELECT COUNT(`h_id`) FROM `tbl_member_heirarchy` WHERE `h_parent_id`=`tbl_members`.`member_id` AND `h_is_active`=1) AS `child_count` ";
			$stmt .= "FROM `tbl_members` ";
			$stmt .= "LEFT JOIN `tbl_member_heirarchy` ON `tbl_member_heirarchy`.`h_member_id`=`tbl_members`.`member_id` ";
			$stmt .= "WHERE `tbl_members`.`member_is_active`=1 AND `tbl_member_heirarchy`.`h_is_active`=1 AND `tbl_member_heirarchy`.`h_parent_id`=? GROUP BY `tbl_members`.`member_id`";
			$query = $this->db->query( $stmt, array( $member_id ) );
			if ( $query ) {
				if ( $query->num_rows() > 0 ) {
					return $query->result();
				}
				return false;
			}
			return false;

		}

	}

	// Construct the tree
	public function construct_tree( $data_list ) {

		if ( $data_list != false ) {
			$return_obj = (array) $data_list;
			// first level
			foreach ($data_list as $key => $list) {
				$return_obj[$key] = array(
					'parent'	=>	(array) $data_list[$key]
				);
			}

			// second level
			foreach ($return_obj as $key => $value) {
				$member_id = $value['parent']['member_id'];
				$children_data = $this->get_tree_datas( $member_id );
				$return_obj[$key]['childrens'] = NULL;
				if ( $children_data == true ) {
					$return_obj[$key]['childrens'] = (array) $children_data;
					// second level assigning
					foreach ($level_two_list = $return_obj[$key]['childrens'] as $subKey => $subValue) {
						$return_obj[$key]['childrens'][$subKey] = array(
							'parent'	=>	(array) $level_two_list[$subKey]
						);
					}

				}

			}

			// third level
			foreach ($return_obj as $key => $value) {
				
				foreach ( (array) $value['childrens'] as $subKey => $subValue) {
					$member_id = $subValue['parent']['member_id'];
					$children_data = $this->get_tree_datas( $member_id );
					$return_obj[$key]['childrens'][$subKey]['childrens'] = NULL;
					if ( $children_data == true ) {
						$return_obj[$key]['childrens'][$subKey]['childrens'] = (array) $children_data;
						// second level assigning
						foreach ($level_three_list = $return_obj[$key]['childrens'][$subKey]['childrens'] as $subChildKey => $subChildValue) {
							$return_obj[$key]['childrens'][$subKey]['childrens'][$subChildKey] = array(
								'parent'	=>	(array) $level_three_list[$subChildKey]
							);
						}

				}
				}
			}

			// ----------------------------------------
			return $return_obj;
			
		}
		return false;

	}

	public function save_new_member($tbl_member_group, $tbl_users_group, $tbl_business_group, $tbl_heirarchy_group) {

		$this->db->trans_start();
		if ( $this->db->insert('tbl_members', $tbl_member_group) ) {
			$last_id = $this->db->insert_id(); // member id
			$tbl_users_group['user_member_id'] = $last_id;
			if ( $this->db->insert('tbl_users', $tbl_users_group) ) {
				$tbl_business_group['business_owner_id'] = $last_id;
				if ( $this->db->insert('tbl_business', $tbl_business_group) ) {
					$tbl_heirarchy_group['h_member_id'] = $last_id;
					if ( $this->db->insert('tbl_member_heirarchy', $tbl_heirarchy_group) ) {
						$this->db->trans_complete();
						if ( $tbl_heirarchy_group['h_parent_id'] != 0 ) {
							// echo '<script>alert("not zero");</script>';
							$this->__save_bonuses( $tbl_heirarchy_group['h_parent_id'], $last_id );
						}
						return $last_id;
					}
				}
			}
		}
		return false;

	}

	// Delete Member
	public function delete_restore_member($member_id, $action = false /*true for restore, false for delete*/) {
		$where_status = $action == false ? true : false;
		if ( $this->db->update( 'tbl_members', array('member_is_active' => $action), array('member_is_active' => $where_status, 'member_id' => $member_id)) ) {
			return true;
		}

	}

	private function __save_bonuses($parent_id,$child_id) {

		$this->db->trans_start();
		$bott_args = array(
			'unilevel_member_id'=>	$parent_id,
			'unilevel_child_id'	=>	$child_id,
			'unilevel_amount'	=>	100
		);
		if ($this->db->insert('tbl_unilevel_bonuses', $bott_args)) {
			// echo '<script>alert("success bottom")</script>';
			// get parent
			$mid_parent = $this->get_datas_by_id($parent_id);
			if ( $mid_parent->h_parent_id != 0 ){

				$mid_args = array(
					'unilevel_member_id'=>	$mid_parent->h_parent_id, // parent id
					'unilevel_child_id'	=>	$parent_id,
					'unilevel_amount'	=>	400
				);
				if ($this->db->insert('tbl_unilevel_bonuses', $mid_args)) {
					// echo '<script>alert("success middle")</script>';

					$top_parent = $this->get_datas_by_id($mid_parent->h_parent_id);
					if ( $top_parent->h_parent_id != 0 ){

						$top_args = array(
							'unilevel_member_id'=>	$top_parent->h_parent_id, // parent id
							'unilevel_child_id'	=>	$mid_parent->h_parent_id,
							'unilevel_amount'	=>	300
						);
						if ($this->db->insert('tbl_unilevel_bonuses', $top_args)) {
							// echo '<script>alert("success top")</script>';
						}

					}
				}

			}
		}
		$this->db->trans_complete();

	}

	// --------------
	// SAVE META LOGS
	private function save_meta_logs($params) {

	}

}

?>