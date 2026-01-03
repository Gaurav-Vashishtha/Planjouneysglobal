<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_page_model extends CI_Model {

    private $table = 'home_page';

    public function get_home() {
        return $this->db->get($this->table)->row();
    }

    public function get_home_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function insert_home($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update_home($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete_home($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
