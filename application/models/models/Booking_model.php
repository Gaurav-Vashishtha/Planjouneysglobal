<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model
{
    private $table = 'bookings';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create($data)
    {
        return $this->db->insert($this->table, $data);
    }
    
    
    public function get_all()
    {
        return $this->db->order_by('id', 'DESC')->get($this->table)->result();
    }


    public function contact_create($data){
        return $this->db->insert('contact_us', $data);
    }
    
    public function visa_create($data){
        return $this->db->insert('visa_enquiries', $data);
    }
    
}
