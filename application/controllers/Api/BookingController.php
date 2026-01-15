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
            'phone_no'    => trim($input['phone_no'] ?? ''),
            'total_persons'     => trim($input['total_persons'] ?? ''),
            'travel_date'     => trim($input['travel_date'] ?? ''),
            'destination'    => trim($input['destination'] ?? ''),
            'departure_city'    => trim($input['departure_city'] ?? ''),
            'package_name'    => trim($input['package_name'] ?? '')

            
        ];

        if (!$data['full_name'] || !$data['email_address'] || !$data['total_persons']) {
            return $this->_response(false, 'Please fill all required fields.');
        }

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

 public function visa_form_sumbit()
{
    $input = json_decode($this->input->raw_input_stream, true);
    if (empty($input)) {
        $input = $this->input->post();
    }

    if (empty($input)) {
        return $this->_response(false, 'No input data received.');
    }

    $data = [
        'name'           => trim($input['name'] ?? ''),
        'email'          => trim($input['email'] ?? ''),
        'contact_number' => trim($input['contact_number'] ?? ''),
        'adult'          => (int) ($input['adult'] ?? 0),
        'child'          => (int) ($input['child'] ?? 0),
        'infant'         => (int) ($input['infant'] ?? 0),
        'nationality'    => trim($input['nationality'] ?? ''),
        'hear_about_us'  => trim($input['hear_about_us'] ?? ''),
        'message'        => trim($input['message'] ?? ''),
        'country_name'        => trim($input['country_name'] ?? ''),
        'created_at'     => date('Y-m-d H:i:s')
    ];

    if (
        empty($data['name']) ||
        empty($data['email']) ||
        empty($data['contact_number']) ||
        empty($data['nationality'])
    ) {
        return $this->_response(false, 'Please fill all required fields.');
    }

    $saved = $this->Booking_model->visa_create($data);

    if ($saved) {
        return $this->_response(true, 'Enquiry submitted successfully.', [
            'name'  => $data['name'],
            'email' => $data['email']
        ]);
    }

    return $this->_response(false, 'Enquiry failed. Please try again.');
}



public function poster_form_sumbit(){

$input = json_decode($this->input->raw_input_stream, true);

if(empty($input)){
    $input = $this->input->post();
    }

    if(empty($input)){
        return $this->_response(false, 'no input data recived');
    }

    $data =[
      
    'name'  => trim($input['name'] ?? ''),
    'email' => trim($input['email'] ?? ''),
    'phone' => trim($input['phone'] ?? ''),
    'poster_name' => trim($input['poster_name'] ?? ''),
    'message' => trim($input['message'] ?? '')
    ];

    if (
        empty($data['name']) ||
        empty($data['email']) 
      
        
    ) {
        return $this->_response(false, 'Please fill all required fields.');
    }

    $saved = $this->Booking_model->poster_create($data);

    if ($saved) {
        return $this->_response(true, 'Enquiry submitted successfully.', [
            'name'  => $data['name'],
            'email' => $data['email']
        ]);
    }

    return $this->_response(false, 'Enquiry failed. Please try again.');
}

}
    

