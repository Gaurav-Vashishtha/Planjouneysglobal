<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Admin_model $Admin_model
 */

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper(['form', 'url']);
    }

    public function index() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
        }
        $this->load->view('admin/login');
    }

    public function login() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/login');
            return;
        }

        $email = strtolower(trim($this->input->post('email', TRUE)));
        $password = $this->input->post('password', TRUE); 

        $admin = $this->Admin_model->get_by_email($email);

        if ($admin && password_verify($password, $admin->password)) {
            $this->session->sess_regenerate(TRUE);
            $this->session->set_userdata([
                'admin_id'        => $admin->id,
                'admin_email'     => $admin->email,
                'admin_name'      => $admin->name,
                'admin_logged_in' => TRUE
            ]);
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid email or password.');
            redirect('admin');
        }
    }

    public function dashboard() {
    if (!$this->session->userdata('admin_logged_in')) {
        redirect('admin');
    }
    $data['title'] = 'Dashboard';
    $this->load->view('admin/layouts/header', $data);
    $this->load->view('admin/dashboard', $data);
    $this->load->view('admin/layouts/footer');
}


    public function logout() {
        $this->session->sess_destroy();
        redirect('admin');
    }

    
    public function changePassword() {
    if (!$this->session->userdata('admin_logged_in')) {
        redirect('admin');
    }

    $this->form_validation->set_rules('current_password', 'Current Password', 'required');
    $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

    if ($this->form_validation->run() == FALSE) {  
        $this->load->view('admin/change_password');  
    } else {
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $admin_id = $this->session->userdata('admin_id');
        
        $admin = $this->Admin_model->get_by_id($admin_id);

        if ($admin && password_verify($current_password, $admin->password)) {
            $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
            $this->Admin_model->update_password($admin_id, $hashed_new_password);
            $this->session->set_flashdata('success', 'Password updated successfully.');
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Current password is incorrect.');
            redirect('admin/changePassword');
        }
    }
}

}
?>