<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotels_model extends CI_Model {

    protected $table = 'hotels';

    public function __construct() {
        parent::__construct();
    }

    public function get_all($filters = []) {
        if (!empty($filters['hotel_type'])) {
            $this->db->where('hotel_type', $filters['hotel_type']);
        }
        if (isset($filters['status']) && $filters['status'] !== '') {
            $this->db->where('status', $filters['status']);
        }
        if (!empty($filters['search'])) {
            $this->db->group_start()
                     ->like('hotel_name', $filters['search'])
                     ->or_like('city', $filters['search'])
                     ->or_like('hotel_title', $filters['search'])
                     ->group_end();
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->table)->result();
    }

    public function get($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }


    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update($this->table, $data, ['id' => $id]);
    }


    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function toggle_status($id) {
        $hotel = $this->get($id);
        if ($hotel) {
            $newStatus = $hotel->status ? 0 : 1;
            return $this->update($id, ['status' => $newStatus]);
        }
        return false;
    }

    public function upload_image($field_name = 'hotel_image') {
        $config['upload_path']   = './uploads/hotels/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size']      = 2048; 
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($field_name)) {
            return ['error' => $this->upload->display_errors()];
        } else {
            $uploadData = $this->upload->data();
            return ['file_name' => $uploadData['file_name']];
        }
    }

       public function get_all_active()
    {
        return $this->db->where('status', 1)
            ->order_by('id', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('hotels', ['id' => (int)$id])->row_array();
    }

        public function getHotelsByLocation($location_id)
        {
        return $this->db->where('location_id', $location_id)
                        ->get('hotels')
                        ->result();
        }

}
