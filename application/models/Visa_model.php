<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visa_model extends CI_Model {

    protected $table = 'visa_details';

    public function __construct() {
        parent::__construct();
    }



    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }


    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function get($id = null) {
        if ($id) {
            return $this->db->get_where($this->table, ['id' => $id])->row();
        }
        return $this->db->get($this->table)->result();
    }


    public function get_all() {
        return $this->db->get($this->table)->result();
    }

        public function slug_exists($slug) {
        return (bool)$this->db->get_where($this->table, ['slug' => $slug])->num_rows();
    }

    public function make_unique_slug($country_name) {
        $this->load->helper('url');
        $slug = url_title($country_name, '-', TRUE);
        $base = $slug;
        $i = 1;
        while ($this->slug_exists($slug)) {
            $slug = $base . '-' . $i;
            $i++;
        }
        return $slug;
    }

        public function get_by_slug($slug) {
        return $this->db->where('slug', $slug)->get($this->table)->row_array();
    }

    public function get_visas_search($country_name = null, $visa_categories = null)
    {
    $this->db->select('*');
    $this->db->from('visa_details');
    if (!empty($country_name)) {
        $this->db->where('country_name', $country_name);
    }
    if (!empty($visa_categories)) {
        $this->db->where('visa_categories', trim($visa_categories));
    }
    $this->db->order_by('created_at', 'DESC');
    $query = $this->db->get();
    return $query->result_array();
    }



    public function get_visa_countries($country_name = '')
    {
        $this->db->select('DISTINCT(country_name) as country_name, slug');
        $this->db->from($this->table);
        
        if (!empty($country_name)) {
            $this->db->like('country_name', $country_name);
        }

        $this->db->order_by('country_name', 'ASC');

        return $this->db->get()->result_array();
    }




    // visa_packages table functions


     public function insert_visa($data) {
        $this->db->insert('visa_packages', $data);
        return $this->db->insert_id();
    }

        public function update_visa($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('visa_packages', $data);
    }

    public function delete_visa($id) {
        $this->db->where('id', $id);
        return $this->db->delete('visa_packages');
    }

    public function get_visa($id = null) {
        if ($id) {
            return $this->db->get_where('visa_packages', ['id' => $id])->row();
        }
        return $this->db->get('visa_packages')->result();
    }


    public function get_all_visa() {
        return $this->db->get('visa_packages')->result();
    }
}
