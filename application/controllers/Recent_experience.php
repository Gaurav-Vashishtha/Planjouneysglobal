<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 /**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Package_model $Package_model
 * @property Recent_experience_model $Recent_experience_model
 * @property upload $upload
 */
class Recent_experience extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Recent_experience_model');
        $this->load->helper(['url','form']);
        $this->load->library(['form_validation','upload','session']);

        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }

        $upload_path = './uploads/recent_experience/';
        if (!is_dir($upload_path)) mkdir($upload_path, 0755, true);
    }

    public function index() {
        $data['experiences'] = $this->Recent_experience_model->get_all();
        $data['title'] = "Manage Recent Customer Experience";

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/recentExperienceManage/list', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function save($id = null) {
        $existing_images = [];

        if ($id) {
            $record = $this->Recent_experience_model->get_by_id($id);
            $existing_images = json_decode($record->images, true) ?? [];
        }

        $images = $existing_images;

        if (!empty($_FILES['images']['name'][0])) {
            $files = $_FILES['images'];
            $upload_path = './uploads/recent_experience/';
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['encrypt_name'] = true;

            $this->load->library('upload');

            for ($i=0; $i < count($files['name']); $i++) {
                $_FILES['file']['name'] = $files['name'][$i];
                $_FILES['file']['type'] = $files['type'][$i];
                $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['file']['error'] = $files['error'][$i];
                $_FILES['file']['size'] = $files['size'][$i];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $images[] = $this->upload->data('file_name');
                }
            }
        }

        $payload = ['images' => json_encode($images)];

        if ($id) {
            $this->Recent_experience_model->update($id, $payload);
            $this->session->set_flashdata('success', 'Updated Successfully.');
        } else {
            $this->Recent_experience_model->insert($payload);
            $this->session->set_flashdata('success', 'Created Successfully.');
        }

        redirect('admin/recent_experience');
    }

    public function delete_image($id, $image_name) {
        $record = $this->Recent_experience_model->get_by_id($id);
        if ($record) {
            $images = json_decode($record->images, true);
            if (($key = array_search($image_name, $images)) !== false) {
                unset($images[$key]);
                $this->Recent_experience_model->update($id, ['images' => json_encode(array_values($images))]);

                // Delete file physically
                $path = './uploads/recent_experience/' . $image_name;
                if (file_exists($path)) unlink($path);

                $this->session->set_flashdata('success', 'Image deleted.');
            }
        }
        redirect('admin/recent_experience');
    }

    public function delete($id) {
        $record = $this->Recent_experience_model->get_by_id($id);
        if ($record) {
            $images = json_decode($record->images, true);
            foreach($images as $img) {
                $path = './uploads/recent_experience/'.$img;
                if (file_exists($path)) unlink($path);
            }
            $this->Recent_experience_model->delete($id);
            $this->session->set_flashdata('success','Record deleted successfully.');
        }
        redirect('admin/recent_experience');
    }
}
