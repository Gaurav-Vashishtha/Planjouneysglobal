<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BookingController - Handles TravChap bookings and email notifications
 * 
 * @property CI_Input $input
 * @property CI_Output $output
 * @property Booking_model $Booking_model
 */
class BookingController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model');
    
        $this->load->helper(['url', 'security']);
        $this->output->set_content_type('application/json');

        // Allow CORS for API access
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
    }

    public function index()
    {
 
        $input = json_decode($this->input->raw_input_stream, true);
        if (empty($input)) {
            $input = $this->input->post();
        }

        if (empty($input)) {
            return $this->_response(false, 'No input data received.');
        }


        $data = [
            'full_name'      => trim($input['full_name'] ?? ''),
            'email_address'  => trim($input['email_address'] ?? ''),
            'total_persons'     => trim($input['total_persons'] ?? ''),
            'travel_date'     => trim($input['travel_date'] ?? ''),
            'tour_detail'    => trim($input['tour_detail'] ?? ''),
            'created_at'        => date('Y-m-d H:i:s')
        ];

        // Basic validation
        if (!$data['full_name'] || !$data['email_address'] || !$data['total_persons']) {
            return $this->_response(false, 'Please fill all required fields.');
        }

        // Save booking
        $saved = $this->Booking_model->create($data);

        if ($saved) {

            return $this->_response(true, 'Enquiry.', [
                'full_name'      => $data['full_name'],
                'email_address'  => $data['email_address'],
                'total_persons'         => $data['total_persons'],
            ]);
        } else {
            return $this->_response(false, 'Enquiry failed. Please try again.');
        }
    }

    private function _response($status, $message, $data = [])
    {
        $this->output->set_output(json_encode([
            'status'  => $status,
            'message' => $message,
            'data'    => $data
        ]));
    }


      public function contact_us_form()
    {
    // echo "hii";  die();
        $input = json_decode($this->input->raw_input_stream, true);
        if (empty($input)) {
            $input = $this->input->post();
        }

        if (empty($input)) {
            return $this->_response(false, 'No input data received.');
        }


        $data = [
            'full_name'      => trim($input['full_name'] ?? ''),
            'email_address'  => trim($input['email_address'] ?? ''),
            'phone_no'     => trim($input['phone_no'] ?? ''),
            'location_id'     => trim($input['location_id'] ?? ''),
            'Message'    => trim($input['Message'] ?? '')
            // 'created_at'        => date('Y-m-d H:i:s')
        ];


        if (!$data['full_name'] || !$data['email_address'] || !$data['phone_no']) {
            return $this->_response(false, 'Please fill all required fields.');
        }

 
        $saved = $this->Booking_model->contact_create($data);

        if ($saved) {

            return $this->_response(true, 'Contact_us.', [
                'full_name'      => $data['full_name'],
                'email_address'  => $data['email_address'],
                'phone_no'         => $data['phone_no'],
            ]);
        } else {
            return $this->_response(false, 'Contact_us failed. Please try again.');
        }
    }

    

    
}
