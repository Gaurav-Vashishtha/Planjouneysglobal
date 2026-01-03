<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property AdvertiesBanner_model $AdvertiesBanner_model
 * @property Location_model $Location_model
 * @property upload $upload
 */
class AdvertiesBanner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('AdvertiesBanner_model');
    }

    public function index() {

        // echo "hii"; die;
        $data['title'] = "Manage Adverties Banner";
        $data['banners'] = $this->AdvertiesBanner_model->get_all();

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/adverties_banner/list', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function create() {
        $data['title'] = "Add Banner";
        $data['banner'] = null;

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/adverties_banner/form', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function save() {

        $img1 = $this->upload_image('banner1');
        $img2 = $this->upload_image('banner2');

        $insertData = [
            // 'title'   => $this->input->post('title'),
            'banner1' => $img1,
            'banner2' => $img2,
            'status'  => $this->input->post('status') ? 1 : 0,
            
        ];

        $this->AdvertiesBanner_model->insert($insertData);
        redirect('admin/adverties_banner');
    }

    public function edit($id) {
        $data['banner'] = $this->AdvertiesBanner_model->get($id);
        $data['title']  = "Edit Banner";

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/adverties_banner/form', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function update($id) {

        $banner = $this->AdvertiesBanner_model->get($id);

        $img1 = $this->upload_image('banner1', $banner->banner1);
        $img2 = $this->upload_image('banner2', $banner->banner2);

        $updateData = [
            // 'title'   => $this->input->post('title'),
            'banner1' => $img1,
            'banner2' => $img2,
            'status'  => $this->input->post('status') ? 1 : 0,
            
        ];

        $this->AdvertiesBanner_model->update($id, $updateData);

        redirect('admin/adverties_banner');
    }

    public function delete($id) {
        $banner = $this->AdvertiesBanner_model->get($id);

        if (!empty($banner->banner1) && file_exists($banner->banner1)) unlink($banner->banner1);
        if (!empty($banner->banner2) && file_exists($banner->banner2)) unlink($banner->banner2);

        $this->AdvertiesBanner_model->delete($id);
        redirect('admin/adverties_banner');
    }

    private function upload_image($field, $old = null) {

        if (!empty($_FILES[$field]['name'])) {

            $config['upload_path'] = './uploads/banner/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['file_name'] = time() . "_" . $field;

            if (!file_exists('./uploads/banner/')) {
                mkdir('./uploads/banner/', 0777, true);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload($field)) {
                return 'uploads/banner/' . $this->upload->data('file_name');
            }
        }

        return $old;
    }
}
