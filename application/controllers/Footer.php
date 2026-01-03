<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Footer_model $Footer_model
 * @property upload $upload
 */
class Footer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Footer_model');
        $this->load->helper(['url','form']);
        $this->load->library(['form_validation','upload','session']);

        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }
    }

    public function index() {
        $data['footer'] = $this->Footer_model->get_footer();
        $data['title'] = "Manage Footer";

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/footerManage/footer_form', $data);
        $this->load->view('admin/layouts/footer');
    }

  public function save() {
    $id = 1;

    
    $upload_path = './uploads/footer/';
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0755, true); 
    }

    $logo = null;
    if (!empty($_FILES['logo']['name'])) {
        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'encrypt_name'  => true
        ];
        $this->upload->initialize($config);

        if ($this->upload->do_upload('logo')) {
            $logo = $this->upload->data('file_name');
        } else {
            $logo = null;
           
         // echo $this->upload->display_errors(); exit;
        }
    } else {
        $footer = $this->Footer_model->get_footer($id);
        $logo = $footer->logo ?? null;
    }

    $section_image = null;
    if (!empty($_FILES['section_image']['name'])) {
        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'encrypt_name'  => true
        ];
        $this->upload->initialize($config);

        if ($this->upload->do_upload('section_image')) {
            $section_image = $this->upload->data('file_name');
        } else {
            $section_image = null;
        }
    } else {
        $footer = $this->Footer_model->get_footer($id);
        $section_image = $footer->section_image ?? null;
    }

    $add_heading = $this->input->post('add_heading');
    $add_contact = $this->input->post('add_contact');
    $existing_images = $this->input->post('add_image_hidden');

    $additional_sections = [];
    if ($add_heading) {
        foreach ($add_heading as $i => $heading) {
            $img = $existing_images[$i] ?? null;

            if (!empty($_FILES['add_image']['name'][$i])) {
                $_FILES['file']['name']     = $_FILES['add_image']['name'][$i];
                $_FILES['file']['type']     = $_FILES['add_image']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['add_image']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['add_image']['error'][$i];
                $_FILES['file']['size']     = $_FILES['add_image']['size'][$i];

                $config = [
                    'upload_path'   => $upload_path,
                    'allowed_types' => 'jpg|jpeg|png|webp',
                    'encrypt_name'  => true
                ];
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $img = $this->upload->data('file_name');
                }
            }

            $additional_sections[] = [
                'image' => $img,
                'heading' => $heading,
                'contact_info' => $add_contact[$i]
            ];
        }
    }

    $payload = [
        'logo' => $logo,
        'description' => $this->input->post('description'),
        'section_heading' => $this->input->post('section_heading'),
        'section_description' => $this->input->post('section_description'),
        'section_image' => $section_image,
        'additional_sections' => json_encode($additional_sections)
    ];

    if ($this->Footer_model->get_footer($id)) {
        $this->Footer_model->update_footer($id, $payload);
        $this->session->set_flashdata('success', 'Footer Updated Successfully.');
    } else {
        $this->Footer_model->insert_footer($payload);
        $this->session->set_flashdata('success', 'Footer Created Successfully.');
    }

    redirect('admin/footer');
}

}
