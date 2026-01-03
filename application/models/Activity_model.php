<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_model extends CI_Model {

    protected $table = 'activities';

    public function __construct() {
        parent::__construct();
    }

   public function get_all()
    {
        return $this->db->order_by('id', 'DESC')->get($this->table)->result();
    }



    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => (int)$id])->row();
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', (int)$id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }

    public function toggle_status($id) {
        $pkg = $this->get_by_id($id);
        if (!$pkg) return false;
        $new = $pkg->status ? 0 : 1;   
        return $this->update($id, ['status' => $new]);
    }

    public function slug_exists($slug) {
        return (bool)$this->db->get_where($this->table, ['slug' => $slug])->num_rows();
    }

    public function make_unique_slug($title) {
        $this->load->helper('url');
        $slug = url_title($title, '-', TRUE);
        $base = $slug;
        $i = 1;
        while ($this->slug_exists($slug)) {
            $slug = $base . '-' . $i;
            $i++;
        }
        return $slug;
    }

    public function get_all_active() {
        return $this->db->where('status', 1)
                        ->order_by('id', 'DESC')
                        ->get($this->table)
                        ->result_array();
    }

    public function get_by_slug($slug) {
        return $this->db->where('slug', $slug)->get($this->table)->row_array();
    }

    public function get_by_activities_code($activities_code) {
        return $this->db->where('activities_code', $activities_code)->get($this->table)->row_array();
    }


}
