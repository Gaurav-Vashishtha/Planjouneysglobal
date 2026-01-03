<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {

    protected $table = 'contacts';

    public function get_contacts() {
        return $this->db->get($this->table)->result();
    }

    public function get_contact_by_id($id) {
        $row = $this->db->get_where($this->table, ['id' => $id])->row();
        if ($row) {
            $row->sections = json_decode($row->sections, true); 
        }
        return $row;
    }

    public function insert_contact($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update_contact($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }
}
