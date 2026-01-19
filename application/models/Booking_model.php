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


        public function contact_create($data)
    {
        $this->db->insert('contact_us', $data);
        return $this->db->insert_id(); 
    }


    public function get_booking_with_location($contact_id)
    {
        return $this->db
            ->select('b.*, l.name AS location_name')
            ->from('contact_us b')
            ->join('location l', 'l.id = b.location_id', 'left')
            ->where('b.id', $contact_id)
            ->get()
            ->row_array();
    }




    
    public function visa_create($data){
        return $this->db->insert('visa_enquiries', $data);
    }

    public function poster_create($data){
        return $this->db->insert('poster_query', $data);
    }
    
}
