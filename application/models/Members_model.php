<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members_model extends CI_Model {

	// fetch default datas
	public function get_datas(  ) {

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
		$this->db->where('tbl_members.member_is_active',true);
		$query = $this->db->get();

		if ( $query ) {

			if ( $query->num_rows() > 0 ) {
				return $query->result();
			}	
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
						return $last_id;
					}
				}
			}
		}
		return false;

	}

	public function save_edited_member($params) {
		$this->db->trans_start();
		$this->db->trans_complete();
	}

	// --------------
	// SAVE META LOGS
	private function save_meta_logs($params) {

	}

}

?>