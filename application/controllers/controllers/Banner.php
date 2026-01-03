<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Banner_model $Banner_model
 * @property upload $upload
 */
class Banner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Banner_model');
        $this->load->helper(['url','form','text']);
        $this->load->library(['form_validation','upload','session']);

        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }
    }

    public function index() {
        $section = $this->input->get('section') ?? 'home'; 
        
        $data['section'] = $section;
        $data['banners'] = $this->Banner_model->get_by_section($section); 
        $data['title'] = 'Manage Banners';

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/banner/list', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function add() {
        $section = $this->input->get('section') ?? 'home';

        $data['section'] = $section;
        $data['title'] = 'Add Banner';

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/banner/add', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function save_add() {
        $this->form_validation->set_rules('banner_name', 'Banner Name', 'required');
        $this->form_validation->set_rules('link', 'Link', 'required');
        $this->form_validation->set_rules('section', 'Section', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Add Banner';
            $data['section'] = $this->input->post('section');
            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/banner/add', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }

        $uploaded_image = $this->_upload_file('banners_image', './uploads/banners/');
        $uploaded_video = $this->_upload_file('banner_video', './uploads/banner_video/', 'mp4|mov|avi|mkv');

        $payload = [
            'banner_name'      => $this->input->post('banner_name'),
            'link'             => $this->input->post('link'),
            'status'           => $this->input->post('status') ? 1 : 0,
            'meta_title'       => $this->input->post('meta_title'),
            'meta_keywords'    => $this->input->post('meta_keywords'),
            'meta_discription' => $this->input->post('meta_discription'),
            'banners_image'    => $uploaded_image,
            'banner_video'     => $uploaded_video,
            'section'          => $this->input->post('section')
        ];

        $this->Banner_model->insert($payload);
        $this->session->set_flashdata('success', 'Banner added successfully.');
        redirect('admin/banner?section=' . $this->input->post('section'));
    }

    public function edit($id) {
        $banner = $this->Banner_model->get_by_id($id);
        if (!$banner) show_404();

        $data['banner'] = $banner;
        $data['title'] = 'Edit Banner';
        $data['section'] = $banner->section ?? 'home';

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/banner/edit', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function save_edit($id) {
        $banner = $this->Banner_model->get_by_id($id);
        if (!$banner) show_404();

        $this->form_validation->set_rules('banner_name', 'Banner Name', 'required');
        $this->form_validation->set_rules('link', 'Link', 'required');
        $this->form_validation->set_rules('section', 'Section', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Banner';
            $data['banner'] = $banner;
            $data['section'] = $banner->section ?? 'home';

            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/banner/edit', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }

        $uploaded_image = $this->_upload_file('banners_image', './uploads/banners/', 'jpg|jpeg|png|webp', $banner->banners_image);
        $uploaded_video = $this->_upload_file('banner_video', './uploads/banner_video/', 'mp4|mov|avi|mkv', $banner->banner_video);

        $payload = [
            'banner_name'      => $this->input->post('banner_name'),
            'link'             => $this->input->post('link'),
            'status'           => $this->input->post('status') ? 1 : 0,
            'meta_title'       => $this->input->post('meta_title'),
            'meta_keywords'    => $this->input->post('meta_keywords'),
            'meta_discription' => $this->input->post('meta_discription'),
            'banners_image'    => $uploaded_image,
            'banner_video'     => $uploaded_video,
            'section'          => $this->input->post('section')
        ];

        $this->Banner_model->update($id, $payload);

        $this->session->set_flashdata('success', 'Banner updated successfully.');
        redirect('admin/banner?section=' . $this->input->post('section'));
    }

    public function delete($id) {
        $banner = $this->Banner_model->get_by_id($id);
        if (!$banner) show_404();

        if ($banner->banners_image && file_exists('./uploads/banners/'.$banner->banners_image)) {
            unlink('./uploads/banners/'.$banner->banners_image);
        }

        $this->Banner_model->delete($id);
        $this->session->set_flashdata('success', 'Banner deleted successfully.');
        redirect('admin/banner?section=' . ($banner->section ?? 'home'));
    }


    // Upload Helper
    private function _upload_file($field, $path, $types='jpg|jpeg|png|webp', $old_file=null) {

        if (!is_dir($path)) mkdir($path, 0755, TRUE);

        $config = [
            'upload_path'   => $path,
            'allowed_types' => $types,
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
        private function _upload_video($field, $path, $types='mp4|mov|avi|mkv', $old_file=null) {

        if (!is_dir($path)) mkdir($path, 0755, TRUE);

        $config = [
            'upload_path'   => $path,
            'allowed_types' => $types,
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