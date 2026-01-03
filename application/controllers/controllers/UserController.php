<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Package_model $Package_model
 * @property Package_hotel_model $Package_hotel_model
 * @property Location_model $Location_model
 * @property Hotels_model $Hotels_model
 * @property Address_model $Address_model
 * @property upload $upload
 */

class UserController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Location_model');
        $this->load->model('Address_model');
        $this->load->model('Package_model');
        $this->load->model('Package_hotel_model');
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','form','text']);
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }
    }

}
