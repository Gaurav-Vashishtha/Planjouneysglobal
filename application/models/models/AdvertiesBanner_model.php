<?php
class AdvertiesBanner_model extends CI_Model {

    private $table = "adverties_banner";

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function get($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
