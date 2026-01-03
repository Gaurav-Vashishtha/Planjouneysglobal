<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property Booking_model $Booking_model
 * @property dbutil $dbutil
 * @property db $db
 */
class Booking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->helper(['url', 'download']); 
        $this->load->dbutil(); 
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }
    }

    public function index() {
        $data['bookings'] = $this->Booking_model->get_all();
        $data['title'] = 'Bookings';
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/bookingList/bookings', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function download() {
        $query = $this->db->query("SELECT 
            id AS ID,
            package_code AS 'Package Code',
            first_guest_name AS 'Guest Name',
            total_persons AS 'Total Persons',
            check_in_date AS 'Check-In Date',
            check_out_date AS 'Check-Out Date',
            extra_bed AS 'Extra Bed',
            child_without_bed AS 'Child Without Bed',
            meal_plan AS 'Meal Plan',
            mobile_no AS 'Mobile No',
            additional_info AS 'Additional Info',
            created_at AS 'Created At'
        FROM bookings ORDER BY id DESC");

        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "bookings_" . date('Ymd_His') . ".csv";

        $csv_data = $this->dbutil->csv_from_result($query, $delimiter, $newline);

        force_download($filename, $csv_data);
    }
}
