<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Footer_model extends CI_Model {

    public function get_footer($id = 1) {
        return $this->db->get_where('footer', ['id' => $id])->row();
    }

    public function insert_footer($data) {
        return $this->db->insert('footer', $data);
    }

    public function update_footer($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('footer', $data);
    }
}
