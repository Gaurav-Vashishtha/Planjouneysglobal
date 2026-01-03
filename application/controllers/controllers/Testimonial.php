<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Testimonial_model');
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
        $data['testimonial'] = $this->Testimonial_model->get_all();
        $data['title'] = 'Manage Testimonials';

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/testimonialmanage/testimonial', $data);
        $this->load->view('admin/layouts/footer');
    }

    // -------------------------------------------------------
    // ADD PAGE
    // -------------------------------------------------------
    public function add() {
        $data['title'] = 'Add Testimonial';

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/testimonialmanage/add', $data);
        $this->load->view('admin/layouts/footer');
    }

    // -------------------------------------------------------
    // EDIT PAGE
    // -------------------------------------------------------
    public function edit($id) {
        $testimonial = $this->Testimonial_model->get_by_id($id);
        if (!$testimonial) show_404();

        $data['testimonial'] = $testimonial;
        $data['title'] = 'Edit Testimonial';

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/testimonialmanage/edit', $data);
        $this->load->view('admin/layouts/footer');
    }

    // -------------------------------------------------------
    // SAVE NEW TESTIMONIAL
    // -------------------------------------------------------
    public function save_add() {

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('specialization', 'Specialization', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Add Testimonial';
            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/testimonialmanage/add', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }

        $image = $this->_upload_file('image', './uploads/testimonial/');
        $iconimage = $this->_upload_file('iconimage', './uploads/testimonial/');

        $status = $this->input->post('status') ? 1 : 0;

        $payload = [
            'name'              => $this->input->post('name'),
            'title'             => $this->input->post('title'),
            'specialization'    => $this->input->post('specialization'),
            'content'           => $this->input->post('content'),
            'meta_title'        => $this->input->post('metatitle'),
            'meta_keyword'      => $this->input->post('metakeyword'),
            'meta_description'  => $this->input->post('metadescription'),
            'image'             => $image,
            'iconimage'         => $iconimage,
            'status'            => $status,
        ];

        $this->Testimonial_model->insert($payload);

        $this->session->set_flashdata('success', 'Testimonial added successfully.');
        redirect('admin/testimonial');
    }



    // -------------------------------------------------------
    // SAVE EDIT TESTIMONIAL
    // -------------------------------------------------------
    public function save_edit($id) {
        $testimonial = $this->Testimonial_model->get_by_id($id);
        if (!$testimonial) show_404();

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('specialization', 'Specialization', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Testimonial';
            $data['testimonial'] = $testimonial;
            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/testimonialmanage/edit', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }

        $image = $this->_upload_file('image', './uploads/testimonial/', $testimonial->image);
        $iconimage = $this->_upload_file('iconimage', './uploads/testimonial/', $testimonial->iconimage);

        $status = $this->input->post('status') ? 1 : 0;
        

        $payload = [
            'name'              => $this->input->post('name'),
            'title'             => $this->input->post('title'),
            'specialization'    => $this->input->post('specialization'),
            'content'           => $this->input->post('content'),
            'meta_title'        => $this->input->post('metatitle'),
            'meta_keyword'      => $this->input->post('metakeyword'),
            'meta_description'  => $this->input->post('metadescription'),
            'image'             => $image,
            'iconimage'         => $iconimage,
            'status'            => $status,
        ];

        $this->Testimonial_model->update($id, $payload);
        $this->session->set_flashdata('success', 'Testimonial updated successfully.');
        redirect('admin/testimonial');
    }

    // -------------------------------------------------------
    // DELETE TESTIMONIAL
    // -------------------------------------------------------

    public function delete($id) {
        $testimonial = $this->Testimonial_model->get_by_id($id);
        if (!$testimonial) show_404();

        if ($testimonial->image && file_exists('./uploads/testimonial/'.$testimonial->image)) {
            unlink('./uploads/testimonial/'.$testimonial->image);
        }

        if ($testimonial->iconimage && file_exists('./uploads/testimonial/'.$testimonial->iconimage)) {
            unlink('./uploads/testimonial/'.$testimonial->iconimage);
        }

        $this->Testimonial_model->delete($id);
        $this->session->set_flashdata('success', 'Testimonial deleted successfully.');
        redirect('admin/testimonial');
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
