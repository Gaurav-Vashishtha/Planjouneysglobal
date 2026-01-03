<?php
class Testimonial_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('id','DESC')->get('testimonial')->result();
    }

    public function insert($data) {
        return $this->db->insert('testimonial', $data);
    }

    public function get_by_id($id) {
        return $this->db->where('id',$id)->get('testimonial')->row();
    }

    public function update($id, $data) {
        return $this->db->where('id',$id)->update('testimonial',$data);
    }

    public function delete($id) {
        return $this->db->where('id',$id)->delete('testimonial');
    }

    
//   public function testimonial_name($testimonial_name) {
//         return $this->db->where('testimonial_name',$testimonial_name)->get('testimonial')->row();
//     }

  public function get_all_active() {
       return $this->db->where('status', 1)
            ->order_by('id', 'DESC')
            ->get('testimonial')
            ->result();
    }

    }
?>
