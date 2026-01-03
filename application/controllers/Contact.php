<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Contact_model $Contact_model
 * @property upload $upload
 */
class Contact extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Contact_model');
        $this->load->helper(['url','form']);
        $this->load->library(['form_validation','upload','session']);
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }
    }

    public function index() {
        $data['contacts'] = $this->Contact_model->get_contacts();
        $data['title'] = "Manage Contacts";

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/contactManage/contact', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function edit($id = null) {
        $data['contact'] = $id ? $this->Contact_model->get_contact_by_id($id) : null;
        $data['title'] = $id ? "Edit Contact" : "Add Contact";

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/contactManage/contact_form', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function save() {
        $id = $this->input->post('id');

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('meta_title', 'Meta Title', 'required');
        $this->form_validation->set_rules('meta_discription', 'Meta Description', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
            return;
        }

        $image = null;
        $upload_path = './uploads/contact/';
        if (!is_dir($upload_path)) mkdir($upload_path, 0755, true);

        if (!empty($_FILES['image']['name'])) {
            $config = [
                'upload_path' => $upload_path,
                'allowed_types' => 'jpg|jpeg|png|webp',
                'encrypt_name' => true
            ];
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $image = $this->upload->data('file_name');
            }
        } else if ($id) {
            $contact = $this->Contact_model->get_contact_by_id($id);
            $image = $contact->image ?? null;
        }

        $sections = [];
        $state_names = $this->input->post('state_name');
        $contact_nos = $this->input->post('contact_no');
        $addresses = $this->input->post('address');
        $existing_images = $this->input->post('section_image_hidden');

        if ($state_names) {
            foreach ($state_names as $i => $state_name) {
                $img = $existing_images[$i] ?? null;

                if (!empty($_FILES['section_image']['name'][$i])) {
                    $_FILES['file']['name'] = $_FILES['section_image']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['section_image']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['section_image']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['section_image']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['section_image']['size'][$i];

                    $config = [
                        'upload_path' => $upload_path . 'sections/',
                        'allowed_types' => 'jpg|jpeg|png|webp',
                        'encrypt_name' => true
                    ];
                    if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, true);

                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $img = $this->upload->data('file_name');
                    }
                }

                $sections[] = [
                    'state_name' => $state_name,
                    'contact_no' => $contact_nos[$i],
                    'address' => $addresses[$i],
                    'image' => $img
                ];
            }
        }

        $payload = [
            'title' => $this->input->post('title'),
            'image' => $image,
            'meta_title' => $this->input->post('meta_title'),
            'meta_discription' => $this->input->post('meta_discription'),
            'sections' => json_encode($sections)
        ];

        if ($id) {
            $this->Contact_model->update_contact($id, $payload);
            $this->session->set_flashdata('success', 'Contact Updated Successfully.');
        } else {
            $this->Contact_model->insert_contact($payload);
            $this->session->set_flashdata('success', 'Contact Created Successfully.');
        }

        redirect('admin/contact');
    }
}
