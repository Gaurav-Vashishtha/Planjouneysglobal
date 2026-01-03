<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tourguide extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Tourguide_model');
        $this->load->helper(['url','form','text']);
        $this->load->library(['form_validation','upload','session']);

        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    // -------------------------------------------------------
    // LIST PAGE
    // -------------------------------------------------------
    public function index() {
        $data['tourguide'] = $this->Tourguide_model->get_all();
        $data['title'] = 'Manage Tourguide';
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/tourguidemanage/tourguide', $data);
        $this->load->view('admin/layouts/footer');
    }

    // -------------------------------------------------------
    // ADD PAGE
    // -------------------------------------------------------
    public function add() {
        $data['title'] = 'Add Tourguide';
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/tourguidemanage/add', $data);
        $this->load->view('admin/layouts/footer');
    }

    // -------------------------------------------------------
    // EDIT PAGE
    // -------------------------------------------------------
    public function edit($id) {
        $tourguide = $this->Tourguide_model->get_by_id($id);
        if (!$tourguide) show_404();

        $data['tourguide'] = $tourguide;
        $data['title'] = 'Edit Tourguide';

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/tourguidemanage/edit', $data);
        $this->load->view('admin/layouts/footer');
    }

    // -------------------------------------------------------
    // SAVE NEW TOURGUIDE
    // -------------------------------------------------------
    public function save_add() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('specialization', 'Specialization', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Add Tourguide';
            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/tourguidemanage/add', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }

        $image = $this->_upload_file('image', './uploads/tourguide/');

         $status = $this->input->post('status') ? 1 : 0;
         
        $payload = [
            'name'           => $this->input->post('name'),
            'specialization' => $this->input->post('specialization'),
            'image'          => $image,
            'meta_title'        => $this->input->post('metatitle'),
            'meta_keyword'      => $this->input->post('metakeyword'),
            'meta_description'  => $this->input->post('metadescription'),
            'status'            => $status,
        ];

        $this->Tourguide_model->insert($payload);
        $this->session->set_flashdata('success', 'Tourguide added successfully.');
        redirect('admin/tourguide');
    }

    // -------------------------------------------------------
    // SAVE EDIT Tourguide
    // -------------------------------------------------------
    public function save_edit($id) {
        $tourguide = $this->Tourguide_model->get_by_id($id);
        if (!$tourguide) show_404();

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('specialization', 'Specialization', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Tourguide';
            $data['tourguide'] = $tourguide;
            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/tourguidemanage/edit', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }

        $image = $this->_upload_file('image', './uploads/tourguide/', $tourguide->image);
        $iconimage = $this->_upload_file('iconimage', './uploads/tourguide/', $tourguide->iconimage);

         $status = $this->input->post('status') ? 1 : 0;

        $payload = [
            'name'           => $this->input->post('name'),
            'specialization' => $this->input->post('specialization'),
            'image'          => $image,
            'meta_title'        => $this->input->post('metatitle'),
            'meta_keyword'      => $this->input->post('metakeyword'),
            'meta_description'  => $this->input->post('metadescription'),
            'status'            => $status,
            
        ];

        $this->Tourguide_model->update($id, $payload);
        $this->session->set_flashdata('success', 'Tourguide updated successfully.');
        redirect('admin/tourguide');
    }

    // -------------------------------------------------------
    // DELETE Tourguide
    // -------------------------------------------------------
    public function delete($id) {
        $tourguide = $this->Tourguide_model->get_by_id($id);
        if (!$tourguide) show_404();

        if ($tourguide->image && file_exists('./uploads/tourguide/'.$tourguide->image)) {
            unlink('./uploads/tourguide/'.$tourguide->image);
        }

        $this->Tourguide_model->delete($id);
        $this->session->set_flashdata('success', 'Tourguide deleted successfully.');
        redirect('admin/tourguide');
    }

    // -------------------------------------------------------
    // UPLOAD HELPER
    // -------------------------------------------------------
    private function _upload_file($field, $path, $old_file=null) {
        if (!is_dir($path)) mkdir($path, 0755, TRUE);

        $config = [
            'upload_path'   => $path,
            'allowed_types' => 'jpg|jpeg|png|gif|webp',
            'encrypt_name'  => TRUE,
            'max_size'      => 5000
        ];

        $this->upload->initialize($config);

        if (!empty($_FILES[$field]['name'])) {
            if ($this->upload->do_upload($field)) {
                if ($old_file && file_exists($path . $old_file)) {
                    unlink($path . $old_file);
                }
                return $this->upload->data('file_name');
            }
        }

        return $old_file;
    }
}
