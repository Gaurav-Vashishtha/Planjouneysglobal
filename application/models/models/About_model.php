<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_model extends CI_Model {

    protected $table = 'about';

    public function get_about() {
        return $this->db->get($this->table)->row();
    }

    public function get_about_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function insert_about($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update_about($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }
}
