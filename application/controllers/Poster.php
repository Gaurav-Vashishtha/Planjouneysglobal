<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Poster_model $Poster_model
 * @property Location_model $Location_model
 * @property upload $upload
 */
class Poster extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Poster_model');
    }

    public function index() {
        $data['title'] = "Manage Poster";
        $data['poster'] = $this->Poster_model->get_all();

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/posterManage/list', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function create() {
        $data['title'] = "Add poster";
        $data['poster'] = null;

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/posterManage/form', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function save() {

        $img = $this->upload_image('poster');

        $insertData = [
            'link'   => $this->input->post('link'),
            'poster' => $img,
            'status'  => $this->input->post('status') ? 1 : 0,
            
        ];

        $this->Poster_model->insert($insertData);
        redirect('admin/poster');
    }

    public function edit($id) {
        $data['poster'] = $this->Poster_model->get($id);
        $data['title']  = "Edit poster";

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/posterManage/form', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function update($id) {

        $poster = $this->Poster_model->get($id);

        $img = $this->upload_image('poster', $poster->poster);


        $updateData = [
            'link'   => $this->input->post('link'),
            'poster' => $img,
            'status'  => $this->input->post('status') ? 1 : 0,
            
        ];

        $this->Poster_model->update($id, $updateData);

        redirect('admin/poster');
    }

    public function delete($id) {
        $poster = $this->Poster_model->get($id);

        if (!empty($poster->poster) && file_exists($poster->poster)) unlink($poster->poster);

        $this->Poster_model->delete($id);
        redirect('admin/poster');
    }

    private function upload_image($field, $old = null) {

        if (!empty($_FILES[$field]['name'])) {

            $config['upload_path'] = './uploads/poster/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['file_name'] = time() . "_" . $field;

            if (!file_exists('./uploads/poster/')) {
                mkdir('./uploads/poster/', 0777, true);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload($field)) {
                return 'uploads/poster/' . $this->upload->data('file_name');
            }
        }

        return $old;
    }
}
