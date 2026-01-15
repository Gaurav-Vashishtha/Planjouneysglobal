<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Package_model $Package_model
 * @property Home_page_model $Home_page_model
 * @property upload $upload
 */

class Homepage extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Home_page_model');
        $this->load->helper(['url','form','text']);
        $this->load->library(['form_validation','upload','session']);

        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }
    }

    public function index() {
        $data['home'] = $this->Home_page_model->get_home();
        $data['title'] = 'Manage Home Page';
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/homepageManage/home_page', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function save() {
        $id = $this->input->post('id') ?: null;

        $this->form_validation->set_rules('title','Title','required');
        if ($this->form_validation->run() === FALSE) {
            $home = $id ? $this->Home_page_model->get_home_by_id($id) : null;
            $data['title'] = $id ? 'Edit Home Page' : 'Add Home Page';
            $data['home'] = $home;
            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/homepageManage/form', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }

        $post = $this->input->post(NULL, TRUE);
        $home = $id ? $this->Home_page_model->get_home_by_id($id) : null;


    $top_agency_image = $home ? $home->top_agency_image : '';

    // echo('<pre>');
    // print_r($post);
    // echo('</pre>');
    // die();

    if (!empty($_FILES['top_agency_image']['name'])) {

        $top_agency_image = $this->_upload_file(
            'top_agency_image',
            './uploads/home/best_agency/',  
            'jpg|jpeg|png|webp',            
            $home->top_agency_image ?? null 
        );
    }

        $desire_places = [];
        if(isset($post['desire_place_heading'])){
            foreach($post['desire_place_heading'] as $k => $heading){
                $desire_places[] = [
                    'heading' => $heading,
                    'description' => $post['desire_place_description'][$k] ?? '',
                    'image' => isset($_FILES['desire_place_image']['name'][$k]) && $_FILES['desire_place_image']['name'][$k] ? 
                               'uploads/home/desire/'.$this->_upload_file_for_array('desire_place_image', $k, './uploads/home/desire/') : $post['desire_place_image_hidden'][$k]
                ];
            }
        }

        $top_destinations = [];
        if(isset($post['top_destination_paragraph'])){
            foreach($post['top_destination_paragraph'] as $k => $paragraph){
                $top_destinations[] = [
                    'image' => isset($_FILES['top_destination_image']['name'][$k]) && $_FILES['top_destination_image']['name'][$k] ? 
                    'uploads/home/top_destination/'.$this->_upload_file_for_array('top_destination_image', $k, './uploads/home/top_destination/') : $post['top_destination_image_hidden'][$k],
                    'paragraph' => $paragraph
                ];
            }
        }

        $best_agencies = [];
        if(isset($post['best_agency_heading'])){
            foreach($post['best_agency_heading'] as $k => $heading){
                $best_agencies[] = [
                    'heading' => $heading,
                    'paragraph' => $post['best_agency_paragraph'][$k] ?? '',
                    'image' => isset($_FILES['best_agency_image']['name'][$k]) && $_FILES['best_agency_image']['name'][$k] ? 
                               'uploads/home/best_agency/'.$this->_upload_file_for_array('best_agency_image', $k, './uploads/home/best_agency/') : $post['best_agency_image_hidden'][$k]
                ];
            }
        }

        $payload = [
            'title' => $post['title'],
            'tab_title' => $post['tab_title'] ?? '',
            'tab_description' => $post['tab_description'] ?? '',
            'tab_link' => $post['tab_link'] ?? '',
            'desire_places' => json_encode($desire_places),
            'popular_packages' => $post['popular_packages'] ?? '',
            'popular_activies' => $post['popular_activies'] ?? '',
            'popular_blogs' => $post['popular_blogs'] ?? '',
            'popular_visa' => $post['popular_visa'] ?? '',
            'popular_packages_bottom' => $post['popular_packages_bottom'] ?? '',
            'popular_activies_bottom' => $post['popular_activies_bottom'] ?? '',
            'popular_blogs_bottom' => $post['popular_blogs_bottom'] ?? '',
            'popular_visa_bottom' => $post['popular_visa_bottom'] ?? '',
            'top_destination_heading' => $post['heading'] ?? '',
            'top_destination_description' => $post['top_destination_description'] ?? '',
            'top_destinations' => json_encode($top_destinations),
            'rating' => $post['rating'] ?? 0,
            'best_agencies' => json_encode($best_agencies),
            'top_agency' => $post['top_agency'] ?? '',
            'final_editor' => $post['final_editor'] ?? '',
            'final_link' => $post['final_link'] ?? '',
            'final_paragraph' => $post['final_paragraph'] ?? '',
            'testimonial_section' => $post['testimonial_section'] ?? '',
            'top_agency_image' => $top_agency_image,
            'top_agency_link' => $post['top_agency_link'] ?? ''
        ];


        if ($id) {
            $this->Home_page_model->update_home($id, $payload);
            $this->session->set_flashdata('success','Home Page updated successfully.');
        } else {
            $this->Home_page_model->insert_home($payload);
            $this->session->set_flashdata('success','Home Page added successfully.');
        }

        redirect('admin/home_page');
    }

    public function edit($id) {
        $home = $this->Home_page_model->get_home_by_id($id);
        if (!$home) show_404();

        $data['home'] = $home;
        $data['title'] = 'Edit Home Page';

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/homepageManage/form', $data);
        $this->load->view('admin/layouts/footer');
    }

    private function _upload_file($field_name, $upload_path, $allowed_types='jpg|jpeg|png|webp', $old_file=null) {
        if (!is_dir($upload_path)) mkdir($upload_path, 0755, TRUE);

        $config = [
            'upload_path' => $upload_path,
            'allowed_types' => $allowed_types,
            'encrypt_name' => true,
            'max_size' => 25000
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            return $this->upload->data('file_name');
        }

        return $old_file;
    }

    private function _upload_file_for_array($field_name, $index, $upload_path){
        if (!is_dir($upload_path)) mkdir($upload_path, 0755, TRUE);

        $_FILES['temp']['name'] = $_FILES[$field_name]['name'][$index];
        $_FILES['temp']['type'] = $_FILES[$field_name]['type'][$index];
        $_FILES['temp']['tmp_name'] = $_FILES[$field_name]['tmp_name'][$index];
        $_FILES['temp']['error'] = $_FILES[$field_name]['error'][$index];
        $_FILES['temp']['size'] = $_FILES[$field_name]['size'][$index];

        $config = [
            'upload_path' => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'encrypt_name' => true,
            'max_size' => 25000
        ];

        $this->upload->initialize($config);

        if($this->upload->do_upload('temp')){
            return $this->upload->data('file_name');
        }
        return '';
    }

    
}
