<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_place extends CI_Model {
    public function get_places() {
        return $this->db->select('place_id, place_name, state_code')
            ->from('place')
            ->where('is_deleted', 0)
            ->get()
            ->result_array();
    }
} 