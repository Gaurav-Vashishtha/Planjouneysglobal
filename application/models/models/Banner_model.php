<?php
class Banner_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('id','DESC')->get('banner')->result();
    }

    public function insert($data) {
        return $this->db->insert('banner', $data);
    }

    public function get_by_id($id) {
        return $this->db->where('id',$id)->get('banner')->row();
    }

    public function update($id, $data) {
        return $this->db->where('id',$id)->update('banner',$data);
    }

    public function delete($id) {
        return $this->db->where('id',$id)->delete('banner');
    }
  public function banner_name($banner_name) {
        return $this->db->where('banner_name',$banner_name)->get('banner')->row();
    }

  public function get_all_active() {
       return $this->db->where('status', 1)
            ->order_by('id', 'DESC')
            ->get('banner')
            ->result();
    }

public function get_by_section($section = 'home') {
    return $this->db->where('section', $section)->get('banner')->result();
}

public function get_all_active_by_section($section) {
    return $this->db->where('status', 1)
                    ->where('section', $section) 
                    ->get('banner')
                    ->result();
}

    }
?>
