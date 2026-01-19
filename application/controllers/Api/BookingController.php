<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BookingController - Handles TravChap bookings and email notifications
 * 
 * @property CI_Input $input
 * @property CI_Output $output
 * @property Booking_model $Booking_model
 * @property email $email
 * 
 */
class BookingController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->library('email');
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

    // public function index()
    // {
 
    //     $input = json_decode($this->input->raw_input_stream, true);
    //     if (empty($input)) {
    //         $input = $this->input->post();
    //     }

    //     if (empty($input)) {
    //         return $this->_response(false, 'No input data received.');
    //     }


    //     $data = [
    //         'full_name'      => trim($input['full_name'] ?? ''),
    //         'email_address'  => trim($input['email_address'] ?? ''),
    //         'phone_no'    => trim($input['phone_no'] ?? ''),
    //         'total_persons'     => trim($input['total_persons'] ?? ''),
    //         'travel_date'     => trim($input['travel_date'] ?? ''),
    //         'destination'    => trim($input['destination'] ?? ''),
    //         'departure_city'    => trim($input['departure_city'] ?? ''),
    //         'package_name'    => trim($input['package_name'] ?? '')

            
    //     ];

    //     if (!$data['full_name'] || !$data['email_address'] || !$data['total_persons']) {
    //         return $this->_response(false, 'Please fill all required fields.');
    //     }

    //     $saved = $this->Booking_model->create($data);

    //     if ($saved) {

    //         return $this->_response(true, 'Enquiry.', [
    //             'full_name'      => $data['full_name'],
    //             'email_address'  => $data['email_address'],
    //             'total_persons'         => $data['total_persons'],
    //         ]);
    //     } else {
    //         return $this->_response(false, 'Enquiry failed. Please try again.');
    //     }
    // }


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
            'phone_no'       => trim($input['phone_no'] ?? ''),
            'total_persons'  => trim($input['total_persons'] ?? ''),
            'travel_date'    => trim($input['travel_date'] ?? ''),
            'destination'    => trim($input['destination'] ?? ''),
            'departure_city' => trim($input['departure_city'] ?? ''),
            'package_name'   => trim($input['package_name'] ?? ''),
            'created_at'     => date('Y-m-d H:i:s')
        ];

        if (!$data['full_name'] || !$data['email_address'] || !$data['total_persons']) {
            return $this->_response(false, 'Please fill all required fields including Package Name.');
        }

        $saved = $this->Booking_model->create($data);

        if ($saved) {
            $this->_send_enquiry_email($data);

            return $this->_response(true, 'Enquiry submitted successfully.', [
                'full_name'     => $data['full_name'],
                'email_address' => $data['email_address'],
                'total_persons' => $data['total_persons'],
                'package_name'  => $data['package_name']
            ]);
        } else {
            return $this->_response(false, 'Enquiry failed. Please try again.');
        }
    }

    private function _send_enquiry_email($data)
    {
        $this->load->library('email');

        $logo_path = FCPATH . 'assets/images/plan_journey.jpg';
        $this->email->attach($logo_path, 'inline');
        $cid = $this->email->attachment_cid($logo_path);

        $this->email->from('your_email@gmail.com', 'Planjourneyglobal Contact System');
        $this->email->to('admin_email@example.com'); 
        $this->email->subject('New Package Enquiry - ' . $data['package_name']);

        $admin_msg = "
        <table style='max-width:650px;margin:auto;font-family:Arial,sans-serif;border:1px solid #ccc;border-radius:10px;'>
            <tr style='background:#0a2740;color:#fff;text-align:center;'><td>
                <img src='cid:{$cid}' height='50'><h2>New Package Enquiry</h2>
            </td></tr>
            <tr><td style='padding:20px;'>
                <p><strong>Full Name:</strong> {$data['full_name']}</p>
                <p><strong>Email:</strong> {$data['email_address']}</p>
                <p><strong>Phone:</strong> {$data['phone_no']}</p>
                <p><strong>Total Persons:</strong> {$data['total_persons']}</p>
                <p><strong>Travel Date:</strong> {$data['travel_date']}</p>
                <p><strong>Departure City:</strong> {$data['departure_city']}</p>
                <p><strong>Destination:</strong> {$data['destination']}</p>
                <p><strong>Package Name:</strong> {$data['package_name']}</p>
                <p><strong>Submitted At:</strong> {$data['created_at']}</p>
            </td></tr>
            <tr style='background:#f0f4f8;text-align:center;padding:10px;'><td>
                <p>This is an automated message. Please do not reply.</p>
            </td></tr>
        </table>
        ";

        $this->email->message($admin_msg);
        $this->email->send();
        $this->email->clear(true);

        $this->email->from('your_email@gmail.com', 'Planjourneyglobal Contact System');
        $this->email->to($data['email_address']);
        $this->email->subject('Thank You for Your Enquiry - ' . $data['package_name']);
        $this->email->attach($logo_path, 'inline');
        $cid = $this->email->attachment_cid($logo_path);

        $customer_msg = "
        <table style='max-width:600px;margin:auto;font-family:Arial,sans-serif;border:1px solid #ccc;border-radius:10px;'>
            <tr style='background:#0a2740;color:#fff;text-align:center;'><td>
                <img src='cid:{$cid}' height='50'><h2>Thank You for Your Enquiry!</h2>
            </td></tr>
            <tr><td style='padding:20px;'>
                <p>Dear {$data['full_name']},</p>
                <p>Thank you for submitting an enquiry for <strong>{$data['package_name']}</strong> with Planjourneyglobal. We have received your request and our team will contact you shortly.</p>
                <p><strong>Your Details:</strong></p>
                <p>Total Persons: {$data['total_persons']}</p>
                <p>Travel Date: {$data['travel_date']}</p>
                <p>Destination: {$data['destination']}</p>
                <p>Departure City: {$data['departure_city']}</p>
            </td></tr>
            <tr style='background:#f0f4f8;text-align:center;padding:10px;'><td>
                <p>This is an automated message. Please do not reply.</p>
            </td></tr>
        </table>
        ";

        $this->email->message($customer_msg);
        $this->email->send();
        $this->email->clear(true);
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
        $input = json_decode($this->input->raw_input_stream, true);
        if (empty($input)) {
            $input = $this->input->post();
        }

        if (empty($input)) {
            return $this->_response(false, 'No input data received.');
        }

        $data = [
            'full_name'     => trim($input['full_name'] ?? ''),
            'email_address' => trim($input['email_address'] ?? ''),
            'phone_no'      => trim($input['phone_no'] ?? ''),
            'location_id'   => trim($input['location_id'] ?? ''),
            'Message'       => trim($input['Message'] ?? ''),
        ];

        if (!$data['full_name'] || !$data['email_address'] || !$data['phone_no']) {
            return $this->_response(false, 'Please fill all required fields.');
        }

        $contact_id = $this->Booking_model->contact_create($data);

        if ($contact_id) {
            $contactData = $this->Booking_model
                                ->get_booking_with_location($contact_id);

            $this->_send_admin_email($contactData);

            return $this->_response(true, 'Contact request submitted successfully.', [
                'full_name'     => $contactData['full_name'],
                'email_address' => $contactData['email_address'],
                'phone_no'      => $contactData['phone_no'],
                'location_name' => $contactData['location_name'],
            ]);
        }

        return $this->_response(false, 'Contact request failed.');
    }



  

private function _send_admin_email($contact_us)
{
    $this->load->library('email');

    $logo_path = FCPATH . 'assets/images/plan_journey.jpg';
    $this->email->attach($logo_path, 'inline');
    $cid = $this->email->attachment_cid($logo_path);

    $this->email->from('gp8122002@gmail.com', 'Planjourneyglobal Contact System');
    $this->email->to('gp8122002@gmail.com'); 
    $this->email->subject('New Contact Us Enquiry - ' . ($contact_us['location_name'] ?? 'N/A'));

    $admin_message = "
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset='UTF-8'>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f7fa; padding: 20px; }
        .email-container { max-width: 650px; margin: auto; background: #fff; border-radius: 10px; }
        .header { background-color: #0a2740; color: #fff; text-align: center; padding: 20px; }
        .content { padding: 25px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #e5e5e5; }
        th { background-color: #f0f4f8; width: 35%; text-align: left; }
        .footer { text-align: center; background-color: #f0f4f8; padding: 15px; font-size: 13px; }
    </style>
    </head>
    <body>
    <div class='email-container'>
        <div class='header'>
        <img src='cid:{$cid}' height='40'><br>
        <h2>New Contact Us Enquiry</h2>
        </div>
        <div class='content'>
        <table>
            <tr><th>Full Name</th><td>{$contact_us['full_name']}</td></tr>
            <tr><th>Email</th><td>{$contact_us['email_address']}</td></tr>
            <tr><th>Phone</th><td>{$contact_us['phone_no']}</td></tr>
            <tr><th>Location</th><td>{$contact_us['location_name']}</td></tr>
            <tr><th>Message</th><td>{$contact_us['Message']}</td></tr>
            <tr><th>Created At</th><td>{$contact_us['created_at']}</td></tr>
        </table>
        </div>
        <div class='footer'>
        <p>This is an automated message. Please do not reply.</p>
        </div>
    </div>
    </body>
    </html>
    ";

    $this->email->message($admin_message);

    if (!$this->email->send()) {
        log_message('error', 'Admin email failed: ' . $this->email->print_debugger());
    } else {
        log_message('info', 'Admin email sent successfully.');
    }


    if (!empty($contact_us['email_address'])) {
    $this->email->clear(true); 
    $this->email->from('gp8122002@gmail.com', 'Planjourneyglobal Contact System');
    $this->email->to($contact_us['email_address']);
    $this->email->subject('Thank You for Contacting Planjourneyglobal');

    $this->email->attach($logo_path, 'inline');
    $cid = $this->email->attachment_cid($logo_path);

    $customer_message = "
    <table style='max-width:600px;margin:auto;background:#ffffff;border-radius:10px;font-family:Arial,sans-serif;'>
    <tr>
    <td style='background:#0a2740;color:#fff;text-align:center;padding:20px;'>
    <img src='cid:{$cid}' height='50' style='margin-bottom:10px;'>
    <h2 style='margin:0;'>Thank You for Contacting Us!</h2>
    </td>
    </tr>
    <tr>
    <td style='padding:20px;color:#333;'>
    <p>Dear {$contact_us['full_name']},</p>
    <p>Thank you for reaching out to <strong>Planjourneyglobal</strong>. We have received your query and our team will get back to you shortly.</p>
    <table style='width:100%;border-collapse:collapse;'>
    <tr><th style='text-align:left;padding:8px;border-bottom:1px solid #e5e5e5;'>Your Message</th><td style='padding:8px;border-bottom:1px solid #e5e5e5;'>{$contact_us['Message']}</td></tr>
    <tr><th style='text-align:left;padding:8px;border-bottom:1px solid #e5e5e5;'>Location</th><td style='padding:8px;border-bottom:1px solid #e5e5e5;'>{$contact_us['location_name']}</td></tr>
    </table>
    </td>
    </tr>
    <tr>
    <td style='background:#f0f4f8;color:#555;text-align:center;padding:15px;font-size:13px;'>
    <p>This is an automated message. Please do not reply.</p>
    </td>
    </tr>
    </table>
    ";

    $this->email->message($customer_message);
    $this->email->send();

    }

}


//  public function visa_form_sumbit()
// {
//     $input = json_decode($this->input->raw_input_stream, true);
//     if (empty($input)) {
//         $input = $this->input->post();
//     }

//     if (empty($input)) {
//         return $this->_response(false, 'No input data received.');
//     }

//     $data = [
//         'name'           => trim($input['name'] ?? ''),
//         'email'          => trim($input['email'] ?? ''),
//         'contact_number' => trim($input['contact_number'] ?? ''),
//         'adult'          => (int) ($input['adult'] ?? 0),
//         'child'          => (int) ($input['child'] ?? 0),
//         'infant'         => (int) ($input['infant'] ?? 0),
//         'nationality'    => trim($input['nationality'] ?? ''),
//         'hear_about_us'  => trim($input['hear_about_us'] ?? ''),
//         'message'        => trim($input['message'] ?? ''),
//         'country_name'        => trim($input['country_name'] ?? ''),
//         'created_at'     => date('Y-m-d H:i:s')
//     ];

//     if (
//         empty($data['name']) ||
//         empty($data['email']) ||
//         empty($data['contact_number']) ||
//         empty($data['nationality'])
//     ) {
//         return $this->_response(false, 'Please fill all required fields.');
//     }

//     $saved = $this->Booking_model->visa_create($data);

//     if ($saved) {
//         return $this->_response(true, 'Enquiry submitted successfully.', [
//             'name'  => $data['name'],
//             'email' => $data['email']
//         ]);
//     }

//     return $this->_response(false, 'Enquiry failed. Please try again.');
// }

public function visa_form_submit()
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
        'nationality'    => trim($input['nationality'] ?? ''),
        'hear_about_us'  => trim($input['hear_about_us'] ?? ''),
        'message'        => trim($input['message'] ?? ''),
        'country_name'   => trim($input['country_name'] ?? ''),
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
        $this->_send_visa_email($data); 

        return $this->_response(true, 'Enquiry submitted successfully.', [
            'name'  => $data['name'],
            'email' => $data['email']
        ]);
    }

    return $this->_response(false, 'Enquiry failed. Please try again.');
}

private function _send_visa_email($data)
{
    $this->load->library('email');

    $logo_path = FCPATH . 'assets/images/plan_journey.jpg';
    $cid = '';

    $this->email->clear(true);
    $this->email->from('gp8122002@gmail.com', 'Planjourneyglobal Contact System');
    $this->email->to('gp8122002@gmail.com');
    $this->email->subject('New Visa Enquiry - ' . ($data['country_name'] ?? 'N/A'));
    
    if (file_exists($logo_path)) {
        $this->email->attach($logo_path, 'inline');
        $cid = $this->email->attachment_cid($logo_path);
    }

    $admin_message = "
    <html>
    <head>
    <meta charset='UTF-8'>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f7fa; padding: 20px; }
        .email-container { max-width: 650px; margin:auto; background:#fff; border-radius:10px; }
        .header { background:#0a2740; color:#fff; text-align:center; padding:20px; }
        .content { padding:20px; }
        table { width:100%; border-collapse: collapse; }
        th, td { padding:10px; border-bottom:1px solid #e5e5e5; text-align:left; }
        th { width:35%; background:#f0f4f8; }
        .footer { text-align:center; padding:15px; background:#f0f4f8; font-size:13px; }
    </style>
    </head>
    <body>
    <div class='email-container'>
        <div class='header'>
            " . ($cid ? "<img src='cid:{$cid}' height='40'><br>" : "") . "
            <h2>New Visa Enquiry</h2>
        </div>
        <div class='content'>
            <table>
                <tr><th>Name</th><td>{$data['name']}</td></tr>
                <tr><th>Email</th><td>{$data['email']}</td></tr>
                <tr><th>Contact Number</th><td>{$data['contact_number']}</td></tr>
                <tr><th>Adults</th><td>{$data['adult']}</td></tr>
                <tr><th>Children</th><td>{$data['child']}</td></tr>
                <tr><th>Nationality</th><td>{$data['nationality']}</td></tr>
                <tr><th>Country</th><td>{$data['country_name']}</td></tr>
                <tr><th>Message</th><td>{$data['message']}</td></tr>
                <tr><th>Heard About Us</th><td>{$data['hear_about_us']}</td></tr>
                <tr><th>Submitted At</th><td>{$data['created_at']}</td></tr>
            </table>
        </div>
        <div class='footer'>This is an automated message. Please do not reply.</div>
    </div>
    </body>
    </html>
    ";
    $this->email->message($admin_message);
    $this->email->send();

    if (!empty($data['email'])) {
        $this->email->clear(true);
        $this->email->from('gp8122002@gmail.com', 'Planjourneyglobal Contact System');
        $this->email->to($data['email']);
        $this->email->subject('Thank You for Your Visa Enquiry');

        if (file_exists($logo_path)) {
            $this->email->attach($logo_path, 'inline');
            $cid = $this->email->attachment_cid($logo_path);
        }

        $customer_message = "
        <table style='max-width:600px;margin:auto;background:#fff;border-radius:10px;font-family:Arial,sans-serif;'>
            <tr>
                <td style='background:#0a2740;color:#fff;text-align:center;padding:20px;'>
                    " . ($cid ? "<img src='cid:{$cid}' height='50' style='margin-bottom:10px;'>" : "") . "
                    <h2 style='margin:0;'>Thank You for Contacting Us!</h2>
                </td>
            </tr>
            <tr>
                <td style='padding:20px;color:#333;'>
                    <p>Dear {$data['name']},</p>
                    <p>Thank you for your visa enquiry. We have received your details and our team will contact you shortly.</p>
                    <table style='width:100%;border-collapse:collapse;'>
                        <tr><th style='text-align:left;padding:8px;border-bottom:1px solid #e5e5e5;'>Your Message</th><td style='padding:8px;border-bottom:1px solid #e5e5e5;'>{$data['message']}</td></tr>
                        <tr><th style='text-align:left;padding:8px;border-bottom:1px solid #e5e5e5;'>Country</th><td style='padding:8px;border-bottom:1px solid #e5e5e5;'>{$data['country_name']}</td></tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style='background:#f0f4f8;color:#555;text-align:center;padding:15px;font-size:13px;'>
                    <p>This is an automated message. Please do not reply.</p>
                </td>
            </tr>
        </table>
        ";
        $this->email->message($customer_message);
        $this->email->send();
    }
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
    

