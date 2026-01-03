<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {

    private $table = 'blogs';

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function get($id) {
        return $this->db->get_where($this->table, ['id'=>$id])->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

     public function get_all_active() {
       return $this->db->where('status', 1)
            ->order_by('id', 'DESC')
            ->get('blogs')
            ->result();
    }


    public function slug_exists($slug)
    {
        return (bool)$this->db->get_where($this->table, ['slug' => $slug])->num_rows();
    }
        public function make_unique_slug($name)
    {
        $this->load->helper('url');
        $slug = url_title($name, '-', TRUE);
        $base = $slug;
        $i = 1;

        while ($this->slug_exists($slug)) {
            $slug = $base . '-' . $i;
            $i++;
        }

        return $slug;
    }

 public function get_by_slug($slug) {
    return $this->db->where('slug', $slug)  
        ->get('blogs')
        ->row();
}

}
