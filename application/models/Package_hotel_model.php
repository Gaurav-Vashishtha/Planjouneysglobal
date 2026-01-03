<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package_hotel_model extends CI_Model {

    protected $table = 'package_hotels';

    public function __construct() {
        parent::__construct();
    }

    public function insert_batch($data) {
        return $this->db->insert_batch($this->table, $data);
    }

    public function get_by_package($package_id) {
        return $this->db->select('ph.*, l.name as location_name, h.hotel_name')
                        ->from($this->table . ' as ph')
                        ->join('location l', 'l.id = ph.location_id', 'left')
                        ->join('hotels h', 'h.id = ph.hotel_id', 'left')
                        ->where('ph.package_id', $package_id)
                        ->order_by('ph.day_number', 'ASC')
                        ->get()->result();
    }

    public function delete_by_package($package_id) {
        return $this->db->where('package_id', $package_id)->delete($this->table);
    }

    public function get_hotels_by_package_id($package_id)
{
    return $this->db->where('package_id', $package_id)
                    ->order_by('day_no', 'ASC')
                    ->get('package_hotel')
                    ->result();
}

}
