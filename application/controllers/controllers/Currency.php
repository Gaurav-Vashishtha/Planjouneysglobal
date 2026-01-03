<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Currency_model');
        $this->load->helper(['url','form','text']);
        $this->load->library('session');

         if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    public function index()
    {
        $data['title'] = "Currency Settings";
        $data['currency'] = $this->Currency_model->get_currency();

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/currencymanage/currency', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function update()
    {
        $usd = $this->input->post('usd_rate');
        $aed = $this->input->post('aed_rate');

        $data = [
            'usd_rate' => $usd,
            'aed_rate' => $aed
        ];

        $this->Currency_model->update_currency($data);

        $this->session->set_flashdata('success', 'Currency rates updated successfully!');
        redirect('admin/currency');
    }
}

