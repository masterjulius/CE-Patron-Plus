<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function get_user_credentials($params, $selectFields = '') {

		if ( !$this->user_security->is_user_logged_in( 'CE_sess_' ) ) {

			if ( !is_null($params) && !empty($params) ) {

				if ( is_array($params) ) {

					if ( count($params) > 0 ) {

						$params['user_is_active'] = true;
						if (!empty($selectFields)) {
							if (is_string($selectFields)) {
								$this->db->select($selectFields);
							}
						}
						$this->db->where($params);
						$query = $this->db->get('tbl_users');
						if ($query) {
							return $query->unbuffered_row();
						}
						return null;

					} else {
						die( 'FIrst parameter has zero values' );
					}

				} else {
					die( 'First Parameter must be array' );
				}

			}

		} else {
			redirect('');
		}

	}

}
?>
