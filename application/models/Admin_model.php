<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_by_email($email) {
        return $this->db->get_where('admins', ['email' => $email])->row();
    }

    public function create($data) {
        $this->db->insert('admins', $data);
        return $this->db->insert_id();
    }
    
    public function update_password($admin_id, $new_password) {
        $this->db->where('id', $admin_id);
        return $this->db->update('admins', ['password' => $new_password]);
    }
    
    public function get_by_id($admin_id) {
        return $this->db->get_where('admins', ['id' => $admin_id])->row();
    }
}   
?>