<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Inventory_model extends CI_Model {

	public function get_datas($params = null) {

		$status_param = is_array($params) && array_key_exists('status', $params) ? $params['status'] : true;

		$this->db->select('item_id, item_code, item_name, item_price, item_qty, item_remarks, item_created_date');
		$this->db->order_by('item_name', 'ASC');
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
		$query = $this->db->get_where( 'tbl_items', array('item_is_active' => $status_param) );
		if ($query) {
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}
		return false;

	}

	public function get_data_by_id($item_id) {

		$this->db->select('item_id, item_code, item_name, item_price, item_qty, item_remarks, item_created_date');
		$query = $this->db->get_where( 'tbl_items', array('item_id'=>$item_id, 'item_is_active'=>true) );
		if ($query) {
			if ($query->num_rows() > 0) {
				return $query->row();
			}
		}
		return false;

	}

	public function save_item($inventory_args) {

		$this->db->trans_start();
		if ( array_key_exists('item_id', $inventory_args) ) {
			// update
			$query = $this->db->update( 'tbl_items', $inventory_args, array( 'item_id' => $inventory_args['item_id'], 'item_is_active' => true ) );
			if ($query) {
				$this->db->trans_complete();
				return $inventory_args['item_id'];
			}
		} else {
			$query = $this->db->insert( 'tbl_items', $inventory_args );
			if ($query) {
				$last_id = $this->db->insert_id();
				$this->db->trans_complete();
				return $last_id;
			}
		}

	}

	// Delete / Restore
	public function delete_restore_item($item_id, $action = false /*true for restore, false for delete*/) {
		$where_status = $action == false ? true : false;
		if ( $this->db->update( 'tbl_items', array('item_is_active' => $action), array('item_is_active' => $where_status, 'item_id' => $item_id)) ) {
			return true;
		}
	}

}
?>