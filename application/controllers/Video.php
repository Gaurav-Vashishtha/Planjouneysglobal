<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Video_model $Video_model
 * @property upload $upload
 */
class Video extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Video_model');
        $this->load->helper(['url','form']);
        $this->load->library(['form_validation','session','upload']);

        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }
    }

    public function index() {
        $data['videos'] = $this->Video_model->get_all();
        $data['title'] = 'Manage Videos';
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/video/list', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function add() {
        $data['title'] = 'Add Video';

        $this->form_validation->set_rules('video_name','Video Name','required');
        $this->form_validation->set_rules('status','Status','required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/layouts/header',$data);
            $this->load->view('admin/video/form',$data);
            $this->load->view('admin/layouts/footer');
            return;
        }

        $video_file = '';
        if (!empty($_FILES['video']['name'])) {
            $video_file = $this->_upload_file('video','./uploads/videos/');
        }

        $payload = [
            'video_name' => $this->input->post('video_name', TRUE),
            'video' => $video_file,
            'meta_title' => $this->input->post('meta_title', TRUE),
            'meta_keywords' => $this->input->post('meta_keywords', TRUE),
            'meta_description' => $this->input->post('meta_description', TRUE),
            'status' => $this->input->post('status', TRUE),
        ];

        $this->Video_model->insert($payload);
        $this->session->set_flashdata('success','Video added successfully.');
        redirect('admin/video');
    }

    public function edit($id) {
        $video = $this->Video_model->get_by_id($id);
        if (!$video) show_404();

        $data['video'] = $video;
        $data['title'] = 'Edit Video';

        $this->form_validation->set_rules('video_name','Video Name','required');
        $this->form_validation->set_rules('status','Status','required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/layouts/header',$data);
            $this->load->view('admin/video/form',$data);
            $this->load->view('admin/layouts/footer');
            return;
        }

        $video_file = $video->video;
        if (!empty($_FILES['video']['name'])) {
            $video_file = $this->_upload_file('video','./uploads/videos/',$video->video);
        }

        $payload = [
            'video_name' => $this->input->post('video_name', TRUE),
            'video' => $video_file,
            'link'       => $this->input->post('link', TRUE),
            'meta_title' => $this->input->post('meta_title', TRUE),
            'meta_keywords' => $this->input->post('meta_keywords', TRUE),
            'meta_description' => $this->input->post('meta_description', TRUE),
            'status' => $this->input->post('status', TRUE),
        ];

        $this->Video_model->update($id, $payload);
        $this->session->set_flashdata('success','Video updated successfully.');
        redirect('admin/video');
    }

    private function _upload_file($field_name, $upload_path, $old_file = null) {
        if (!is_dir($upload_path)) mkdir($upload_path,0755,true);

        $config = [
            'upload_path' => $upload_path,
            'allowed_types' => 'mp4|mov|avi|mkv',
            'encrypt_name' => true,
            'max_size' => 50000
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            if ($old_file && file_exists($upload_path.$old_file)) unlink($upload_path.$old_file);
            return $this->upload->data('file_name');
        }

        return $old_file;
    }

    public function delete($id) {
        $video = $this->Video_model->get_by_id($id);
        if ($video) {
            if (file_exists('./uploads/videos/'.$video->video)) unlink('./uploads/videos/'.$video->video);
            $this->Video_model->delete($id);
            $this->session->set_flashdata('success','Video deleted successfully.');
        }
        redirect('admin/video');
    }
}
