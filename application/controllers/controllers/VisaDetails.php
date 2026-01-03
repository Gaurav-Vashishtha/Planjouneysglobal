<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Visa_model $Visa_model
 * @property upload $upload
 */
class VisaDetails extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Visa_model');
        $this->load->helper(['url','form','text']);
        $this->load->library(['form_validation','upload','session']);

        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

  
  
    public function index() {

 

        $data['visa_details'] = $this->Visa_model->get_all();
        $data['title'] = 'Manage Visa Details';
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/visadetailsmanage/visadetails', $data);
        $this->load->view('admin/layouts/footer');
    }

  
    public function add() {
        $data['title'] = 'Add Visa Details';
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/visadetailsmanage/add', $data);
        $this->load->view('admin/layouts/footer');
    }

  
    public function save_add() {
        $post = $this->input->post();
     $slug = $this->Visa_model->make_unique_slug($post['country_name']);

        $banner_image = $this->upload_file('banner_image');
        $image = $this->upload_file('image');




        $faqs = [];
        if(isset($post['faq_question'])){
            foreach($post['faq_question'] as $i => $question){
                $faqs[] = [
                    'question' => $question,
                    'answer' => $post['faq_answer'][$i]
                ];
            }
        }

        $data = [
            'country_name' => $post['country_name'],
            'slug'              => $slug,
            'processing_time' => $post['processing_time'],
            'meta_title' => $post['meta_title'],
            'meta_description' => $post['meta_description'],
            'banner_image' => $banner_image,
            'image' => $image,
            'document_requirement' => $post['document_requirement'],
            'additional_requirement' => $post['additional_requirement'],
            'important_note' => $post['important_note'],
            'faq' => json_encode($faqs)
        ];

        $this->Visa_model->insert($data);
         $this->session->set_flashdata('success', 'Visa details added successfully.');
        redirect('admin/visadetails');
    }


  
    public function edit($id) {

        $data['visa'] = $this->Visa_model->get($id);
        $data['title'] = 'Edit Visa Details';
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/visadetailsmanage/edit', $data);
        $this->load->view('admin/layouts/footer');
    }


  
    public function update($id) {
        $post = $this->input->post();

        $banner_image = $this->upload_file('banner_image') ?? $post['banner_image_hidden'];
        $image = $this->upload_file('image') ?? $post['image_hidden'];

     
        $faqs = [];
        if(isset($post['faq_question'])){
            foreach($post['faq_question'] as $i => $question){
                $faqs[] = [
                    'question' => $question,
                    'answer' => $post['faq_answer'][$i]
                ];
            }
        }

        $data = [
            'country_name' => $post['country_name'],
            'processing_time' => $post['processing_time'],
            'meta_title' => $post['meta_title'],
            'meta_description' => $post['meta_description'],
            'banner_image' => $banner_image,
            'image' => $image,
            'document_requirement' => $post['document_requirement'],
            'additional_requirement' => $post['additional_requirement'],
            'important_note' => $post['important_note'],
            'faq' => json_encode($faqs)
        ];

        $this->Visa_model->update($id, $data);
         $this->session->set_flashdata('success', 'Visa details updated successfully.');
        redirect('admin/visadetails');
    }


    public function delete($id) {
        $this->Visa_model->delete($id);
        redirect('admin/visadetails');
    }

 
    private function upload_file($field){
        if(isset($_FILES[$field]) && $_FILES[$field]['name'] != ''){
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            if($this->upload->do_upload($field)){
                return 'uploads/'.$this->upload->data('file_name');
            }
        }
        return null;
    }

    
    private function upload_file_array($field, $index){
        if(isset($_FILES[$field]['name'][$index]) && $_FILES[$field]['name'][$index] != ''){
            $_FILES['temp']['name'] = $_FILES[$field]['name'][$index];
            $_FILES['temp']['type'] = $_FILES[$field]['type'][$index];
            $_FILES['temp']['tmp_name'] = $_FILES[$field]['tmp_name'][$index];
            $_FILES['temp']['error'] = $_FILES[$field]['error'][$index];
            $_FILES['temp']['size'] = $_FILES[$field]['size'][$index];

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            if($this->upload->do_upload('temp')){
                return 'uploads/'.$this->upload->data('file_name');
            }
        }
        return null;
    }



    // visa list details function

public function index_visa() {

    $data['packages'] = $this->Visa_model->get_all_visa();
    $data['title'] = 'Manage Visa Packages';
    $this->load->view('admin/layouts/header', $data);
    $this->load->view('admin/visadetailsmanage/visalist', $data);
    $this->load->view('admin/layouts/footer');
}


public function visa_package_add() {
// echo "working"; die;

    $data['title'] = 'Add Visa Package';
    $this->load->view('admin/layouts/header', $data);
    $this->load->view('admin/visadetailsmanage/form', $data);
    $this->load->view('admin/layouts/footer');
}


public function visa_package_save() {
    $post = $this->input->post();

    // $image_1 = $this->upload_file('image_1');
    $image_2 = $this->upload_file('image_2');

    $visa_agencies = [];
    if(isset($post['agency_title'])) {
        foreach($post['agency_title'] as $i => $title){
            $visa_agencies[] = [
                'title' => $title,
                'description' => $post['agency_description'][$i],
                'image' => isset($_FILES['agency_image']['name'][$i]) && $_FILES['agency_image']['name'][$i] != '' 
                            ? $this->upload_file_array('agency_image', $i) 
                            : null
            ];
        }
    }

    $working_process = [];
    if(isset($post['process_title'])) {
        foreach($post['process_title'] as $i => $title){
            $working_process[] = [
                'title' => $title,
                'description' => $post['process_description'][$i]
            ];
        }
    }

    $faq = [];
    if(isset($post['faq_question'])) {
        foreach($post['faq_question'] as $i => $q){
            $faq[] = [
                'question' => $q,
                'answer' => $post['faq_answer'][$i]
            ];
        }
    }

    $data = [
        'heading' => $post['heading'],
        'agency_heading' => $post['agencyheading'],
        'meta_title' => $post['meta_title'],
        'meta_description' => $post['meta_description'],
        'visa_agencies' => json_encode($visa_agencies),
        'sub_title' => $post['sub_title'],
        'link' => $post['link'],
        'image_2' => $image_2,
        'working_process_head' => $post['working_process_head'],
        'working_process_link' => $post['working_process_link'],
        'working_process_mail' => $post['working_process_mail'],
        'working_process' => json_encode($working_process),
        'faq' => json_encode($faq),
      
    ];

    $this->Visa_model->insert_visa($data);
    $this->session->set_flashdata('success', 'Visa package added successfully.');
    redirect('admin/visalistdetail');
}


public function visa_package_edit($id) {
    $data['package'] = $this->Visa_model->get_visa($id);
    $data['title'] = 'Edit Visa Package';
    $this->load->view('admin/layouts/header', $data);
    $this->load->view('admin/visadetailsmanage/form', $data);
    $this->load->view('admin/layouts/footer');
}


public function visa_package_update($id) {
    $post = $this->input->post();

    // $image_1 = $this->upload_file('image_1') ?? $post['image_1_hidden'];
    $image_2 = $this->upload_file('image_2') ?: ($post['image_2_hidden'] ?? null);


    $visa_agencies = [];
    if(isset($post['agency_title'])) {
        foreach($post['agency_title'] as $i => $title){
            $visa_agencies[] = [
                'title' => $title,
                'description' => $post['agency_description'][$i],
               'image' => (isset($_FILES['agency_image']['name'][$i]) && $_FILES['agency_image']['name'][$i] != '')  
                ? $this->upload_file_array('agency_image', $i)
                : ($post['agency_image_hidden'][$i] ?? null)

            ];
        }
    }

    $working_process = [];
    if(isset($post['process_title'])) {
        foreach($post['process_title'] as $i => $title){
            $working_process[] = [
                'title' => $title,
                'description' => $post['process_description'][$i]
            ];
        }
    }

    $faq = [];
    if(isset($post['faq_question'])) {
        foreach($post['faq_question'] as $i => $q){
            $faq[] = [
                'question' => $q,
                'answer' => $post['faq_answer'][$i]
            ];
        }
    }

    $data = [
        'heading' => $post['heading'],
        'agency_heading' => $post['agencyheading'],
        'meta_title' => $post['meta_title'],
        'meta_description' => $post['meta_description'],
        'visa_agencies' => json_encode($visa_agencies),
        'sub_title' => $post['sub_title'],
        'link' => $post['link'],
        'image_2' => $image_2,
        'working_process_head' => $post['working_process_head'],
        'working_process_link' => $post['working_process_link'],
        'working_process_mail' => $post['working_process_mail'],
        'working_process' => json_encode($working_process),
        'faq' => json_encode($faq),
       
    ];

    $this->Visa_model->update_visa($id, $data);
    $this->session->set_flashdata('success', 'Visa package updated successfully.');
    redirect('admin/visalistdetail');
}


public function visa_package_delete($id) {
    $this->Visa_model->delete_visa($id);
    $this->session->set_flashdata('success', 'Visa package deleted successfully.');
    redirect('admin/visalistdetail');
}

}
