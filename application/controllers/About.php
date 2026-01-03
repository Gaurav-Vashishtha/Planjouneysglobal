<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property About_model $About_model
 * @property Home_page_model $Home_page_model
 * @property upload $upload
 */

class About extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('About_model');
        $this->load->helper(['url','form','text']);
        $this->load->library(['form_validation','upload','session']);

        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }
    }

    public function index() {
        $data['about'] = $this->About_model->get_about();
        $data['title'] = "Manage About Page";
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/aboutManage/about', $data);
        $this->load->view('admin/layouts/footer');
    }


    public function save() {

        // echo "hii"; die;
        $id = $this->input->post('id') ?: null;
        $this->form_validation->set_rules('title', 'Page Title', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['about'] = $id ? $this->About_model->get_about_by_id($id) : null;
            $data['title'] = $id ? "Edit About Page" : "Add About Page";

            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/aboutManage/form', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }

        $post = $this->input->post(NULL, TRUE);
        $about = $id ? $this->About_model->get_about_by_id($id) : null;


            $best_agency_main_image = $about->best_agency_main_image ?? ''; 
            if (!empty($_FILES['best_agency_main_image']['name'])) {
                $best_agency_main_image = 'uploads/home/best_agency/' .
                    $this->_upload_file('best_agency_main_image', './uploads/home/best_agency/');
            }


        $about_best_service = [];
        if (!empty($post['about_best_service_heading'])) {
            foreach ($post['about_best_service_heading'] as $i => $heading) {

                $img = $post['about_best_service_image_hidden'][$i] ?? '';

                if (!empty($_FILES['about_best_service_image']['name'][$i])) {
                    $img = 'uploads/home/best_service/' .
                        $this->_upload_file_array(
                            'about_best_service_image',
                            $i,
                            './uploads/home/best_service/'
                        );
                }

                $about_best_service[] = [
                    'heading' => $heading,
                    'description' => $post['about_best_service_description'][$i] ?? '',
                    'image' => $img
                ];
            }
        }

        $travel_with_us = [];
        if (!empty($post['travel_with_us_paragraph'])) {
            foreach ($post['travel_with_us_paragraph'] as $i => $paragraph) {

                $img = $post['travel_with_us_image_hidden'][$i] ?? '';

                if (!empty($_FILES['travel_with_us_image']['name'][$i])) {
                    $img = 'uploads/home/travel_with_us/' .
                        $this->_upload_file_array(
                            'travel_with_us_image',
                            $i,
                            './uploads/home/travel_with_us/'
                        );
                }

                $travel_with_us[] = [
                    'paragraph' => $paragraph,
                    'image' => $img
                ];
            }
        }

        $best_agencies = [];
        if (!empty($post['best_agency_heading'])) {

            foreach ($post['best_agency_heading'] as $i => $heading) {

                $img = $post['best_agency_image_hidden'][$i] ?? '';

                if (!empty($_FILES['best_agency_image']['name'][$i])) {
                    $img = 'uploads/home/best_agency_repeater/' .
                        $this->_upload_file_array(
                            'best_agency_image',
                            $i,
                            './uploads/home/best_agency_repeater/'
                        );
                }

                $best_agencies[] = [
                    'heading' => $heading,
                    'paragraph' => $post['best_agency_paragraph'][$i] ?? '',
                    'image' => $img
                ];
            }
        }


         $about_team_members = [];
        if (!empty($post['about_team_members_name'])) {
            foreach ($post['about_team_members_name'] as $i => $name) {

                $img = $post['about_team_members_image_hidden'][$i] ?? '';

                if (!empty($_FILES['about_team_members_image']['name'][$i])) {
                    $img = '/uploads/about/team/' .
                        $this->_upload_file_array(
                            'about_team_members_image',
                            $i,
                            './uploads/about/team/'
                        );
                }

                $about_team_members[] = [
                    'name' => $name,
                    'degination' => $post['about_team_members_degination'][$i] ?? '',
                    'number' => $post['about_team_members_number'][$i] ?? '',
                    'email' => $post['about_team_members_email'][$i] ?? '',
                    'image' => $img
                ];
            }
        }

        $payload = [
            'title'                         => $post['title'],
            'meta_title'                    => $post['meta_title'],
            'meta_discription'              => $post['meta_discription'],
            'best_agency_link'              => $post['best_agency_link'] ?? '',
            'best_agency'                   => $post['best_agency'] ?? '',
            'best_agency_main_image'        => $best_agency_main_image,
            'about_best_service_title'      => $post['about_best_service_title'] ?? '',
            'about_best_service_link'       => $post['about_best_service_link'] ?? '',
            'about_best_service_places'     => json_encode($about_best_service),
            'travel_with_us'                => json_encode($travel_with_us),
             'travel_with_us_des'             => $post['travel_with_us_des'] ?? '',
            'best_agencies'                 => json_encode($best_agencies),
            'here_it_from_travelrs'         => $post['here_it_from_travelrs'] ?? '',
            'about_team_members'     => json_encode($about_team_members)

        ];


        if ($id) {
            $this->About_model->update_about($id, $payload);
            $this->session->set_flashdata('success', 'About Page Updated Successfully.');
        } else {
            $this->About_model->insert_about($payload);
            $this->session->set_flashdata('success', 'About Page Created Successfully.');
        }

        redirect('admin/about_us');
    }




    private function _upload_file_array($field, $index, $path) {
        if (!is_dir($path)) mkdir($path, 0755, true);

        $_FILES['temp']['name']     = $_FILES[$field]['name'][$index];
        $_FILES['temp']['type']     = $_FILES[$field]['type'][$index];
        $_FILES['temp']['tmp_name'] = $_FILES[$field]['tmp_name'][$index];
        $_FILES['temp']['error']    = $_FILES[$field]['error'][$index];
        $_FILES['temp']['size']     = $_FILES[$field]['size'][$index];

        $config = [
            'upload_path' => $path,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'encrypt_name' => true,
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload('temp')) {
            return $this->upload->data('file_name');
        }

        return '';
    }

    private function _upload_file($field, $path) {
    if (!is_dir($path)) mkdir($path, 0755, true);

    $_FILES['temp']['name']     = $_FILES[$field]['name'];
    $_FILES['temp']['type']     = $_FILES[$field]['type'];
    $_FILES['temp']['tmp_name'] = $_FILES[$field]['tmp_name'];
    $_FILES['temp']['error']    = $_FILES[$field]['error'];
    $_FILES['temp']['size']     = $_FILES[$field]['size'];

    $config = [
        'upload_path' => $path,
        'allowed_types' => 'jpg|jpeg|png|webp',
        'encrypt_name' => true,
    ];

    $this->upload->initialize($config);

    if ($this->upload->do_upload('temp')) {
        return $this->upload->data('file_name');
    }

    return '';
}

    public function edit($id) {
    $data['about'] = $this->About_model->get_about_by_id($id);
    $data['title'] = "Edit About Page";

    $this->load->view('admin/layouts/header', $data);
    $this->load->view('admin/aboutManage/form', $data);
    $this->load->view('admin/layouts/footer');
}

}
