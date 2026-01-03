<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model {

    protected $table = 'videos';

    public function get_all() {
        return $this->db->order_by('id','DESC')->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id',$id)->get($this->table)->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id',$id)->update($this->table,$data);
    }

    public function delete($id) {
        return $this->db->where('id',$id)->delete($this->table);
    }

      public function video_name($video_name) {
        return $this->db->where('video_name',$video_name)->get('videos')->row();
    }

  public function get_all_active() {
       return $this->db->where('status', 1)
            ->order_by('id', 'DESC')
            ->get('videos')
            ->result();
    }
    
}
