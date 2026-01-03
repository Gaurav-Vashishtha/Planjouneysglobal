<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Output $output
 * @property User_model $User_model
 */
class UserController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(['url', 'security']);
        $this->output->set_content_type('application/json');

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
            $this->_response(false, 'No input data received.');
            return;
        }

        $full_name       = trim($input['full_name'] ?? '');
        $phone_no        = trim($input['phone_no'] ??'');
        $email           = trim($input['email'] ?? '');
        $username        = trim($input['username'] ?? '');
        $password        = $input['password'] ?? '';
        $confirmPassword = $input['confirmPassword'] ?? '';

        // if (!$full_name || !$phone_no || !$email || !$username || !$password || !$confirmPassword) {
        //     $this->_response(false, 'All fields are required.');
        //     return;
        // }

        if ($password !== $confirmPassword) {
            $this->_response(false, 'Passwords do not match.');
            return;
        }

        if ($this->User_model->exists('phone_no', $phone_no)) {
            $this->_response(false, 'Phone already registered.');
            return;
        }

        if ($this->User_model->exists('email', $email)) {
            $this->_response(false, 'Email already registered.');
            return;
        }

        if ($this->User_model->exists('username', $username)) {
            $this->_response(false, 'Username already taken.');
            return;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $data = [
            'full_name' => $full_name,
            'phone_no'  => $phone_no,
            'email'     => $email,
            'username'  => $username,
            'password'  => $hash,
           
        ];

        $saved = $this->User_model->register($data);

        if ($saved) {
            $this->_response(true, 'User registered successfully.', [
                'full_name' => $full_name,
                'phone_no'  => $phone_no,
                'email'     => $email,
                'username'  => $username,
            ]);
        } else {
            $this->_response(false, 'Registration failed. Please try again.');
        }
    }
    public function login()
    {
        $input = json_decode($this->input->raw_input_stream, true);
        if (empty($input)) {
            $input = $this->input->post();
        }

        if (empty($input)) {
            $this->_response(false, 'No input data received.');
            return;
        }

        $username_or_email = trim($input['username'] ?? $input['email'] ?? '');
        $password          = $input['password'] ?? '';

        if (!$username_or_email || !$password) {
            $this->_response(false, 'Username/email and password are required.');
            return;
        }

        $user = $this->User_model->find_by('email', $username_or_email);
        if (!$user) {
            $user = $this->User_model->find_by('username', $username_or_email);
        }

        if (!$user) {
            $this->_response(false, 'Invalid username or email.');
            return;
        }

        if (!password_verify($password, $user['password'])) {
            $this->_response(false, 'Invalid password.');
            return;
        }

        unset($user['password']); 

        $this->_response(true, 'Login successful.', ['user' => $user]);
    }



    public function change_password()
{
    $input = json_decode($this->input->raw_input_stream, true);
    if (empty($input)) {
        $input = $this->input->post();
    }

    $user_id          = $input['user_id'] ?? '';   
    $current_password = $input['current_password'] ?? '';
    $new_password     = $input['new_password'] ?? '';
    $confirm_password = $input['confirm_password'] ?? '';

    if (!$user_id || !$current_password || !$new_password || !$confirm_password) {
        return $this->_response(false, 'All fields are required.');
    }

    if ($new_password !== $confirm_password) {
        return $this->_response(false, 'New password & confirmation do not match.');
    }


    $user = $this->User_model->find_by('id', $user_id);

    if (!$user) {
        return $this->_response(false, 'User not found.');
    }

 
    if (!password_verify($current_password, $user['password'])) {
        return $this->_response(false, 'Current password is incorrect.');
    }

    if (password_verify($new_password, $user['password'])) {
        return $this->_response(false, 'New password cannot be same as current password.');
    }

    $hash = password_hash($new_password, PASSWORD_BCRYPT);


    $this->db->where('id', $user_id);
    $updated = $this->db->update('users', ['password' => $hash]);

    if ($updated) {
        return $this->_response(true, 'Password updated successfully.');
    }

    return $this->_response(false, 'Failed to update password.');
}


    private function _response($status, $message, $data = [])
    {
        $this->output->set_output(json_encode([
            'status'  => $status,
            'message' => $message,
            'data'    => $data
        ]));
    }

    
}
