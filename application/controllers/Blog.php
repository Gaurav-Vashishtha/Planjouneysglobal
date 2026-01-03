<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Blog_model $Blog_model
 * @property upload $upload
 */
class Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->helper(['url','form','text']);
        $this->load->library(['form_validation','upload','session']);
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }
    }

    public function index() {
        $data['blogs'] = $this->Blog_model->get_all();
        $data['title'] = 'Manage Blog';
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/blogManage/blog', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function add() {
        $this->form_validation->set_rules('blog_name','Blog Name','required');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Add Blog';
            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/blogManage/add', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }       
       $post = $this->input->post(NULL, TRUE);
       $slug = $this->Blog_model->make_unique_slug($post['blog_name']);


        $payload = [
            'blog_name' => $post['blog_name'],
            'slug' =>$slug,
            'category' => $post['category'],
            'blog_type' => $post['blog_type'],
            'blog_date' => $post['blog_date'],
            'blog_heading' => $post['blog_heading'],
            'blog_detail' => $post['blog_detail'],
            'blog_overview' => $post['blog_overview'],
            'keyword' => $post['keyword'],
            'meta_description' => $post['meta_description'],
            'meta_keywords_title' => $post['meta_keywords_title'],
            'status' => isset($post['status']) ? 1 : 0,
        ];


        if (!empty($_FILES['banner_image']['name'])) {
            $payload['banner_image'] = $this->_upload_file('banner_image', './uploads/blogs/');
        }


        if (!empty($_FILES['home_image']['name'])) {
            $payload['home_image'] = $this->_upload_file('home_image', './uploads/blogs/');
        }

  

        

        $this->Blog_model->insert($payload);
        $this->session->set_flashdata('success','Blog added successfully.');
        redirect('admin/blog');
    }

    public function edit($id) {
        $blog = $this->Blog_model->get($id);
        if (!$blog) show_404();

        $this->form_validation->set_rules('blog_name','Blog Name','required');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Blog';
            $data['blog'] = $blog;
            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/blogManage/edit', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }

        $post = $this->input->post(NULL, TRUE);

        $payload = [
            'blog_name' => $post['blog_name'],
            'category' => $post['category'],
            'blog_type' => $post['blog_type'],
            'blog_date' => $post['blog_date'],
            'blog_heading' => $post['blog_heading'],
            'blog_detail' => $post['blog_detail'],
            'blog_overview' => $post['blog_overview'],
            'keyword' => $post['keyword'],
            'meta_description' => $post['meta_description'],
            'meta_keywords_title' => $post['meta_keywords_title'],
            'status' => isset($post['status']) ? 1 : 0,
        ];


        if (!empty($_FILES['banner_image']['name'])) {
            $payload['banner_image'] = $this->_upload_file('banner_image', './uploads/blogs/', $blog->banner_image);
        }


        if (!empty($_FILES['home_image']['name'])) {
            $payload['home_image'] = $this->_upload_file('home_image', './uploads/blogs/', $blog->home_image);
        }


    
       

        $this->Blog_model->update($id, $payload);
        $this->session->set_flashdata('success','Blog updated successfully.');
        redirect('admin/blog');
    }

    public function delete($id) {
        $this->Blog_model->delete($id);
        $this->session->set_flashdata('success','Blog deleted successfully.');
        redirect('admin/blog');
    }

    /**
     * Generic file upload helper
     */
    private function _upload_file($field_name, $upload_path, $old_file = null, $allowed_types='jpg|jpeg|png|webp')
 {
        if (!is_dir($upload_path)) mkdir($upload_path, 0755, TRUE);

        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => $allowed_types,
            'encrypt_name'  => true,
            'max_size'      => 25000
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            if ($old_file && file_exists($upload_path . $old_file)) unlink($upload_path . $old_file);
            return $this->upload->data('file_name');
        }

        return $old_file;
    }

    
}
