<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Package_model $Package_model
 * @property Location_model $Location_model
 * @property upload $upload
 */

class Package extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Package_model');
        $this->load->model('Location_model');
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','form','text']);
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }
    }



    public function index() {
        $filters = [
            'category' => $this->input->get('category') ?? '',
            'status'   => $this->input->get('status') !== null ? $this->input->get('status') : '',
            'search'   => $this->input->get('search') ?? '',
        ];

        $data['packages'] = $this->Package_model->get_all(null, null, $filters);
        $data['filters'] = $filters;
        $data['title'] = 'Manage Packages';
        $this->load->view('admin/layouts/header', $data);
        // echo 'hii'; die;
        $this->load->view('admin/packageManage/package', $data);
        $this->load->view('admin/layouts/footer');
    }


public function create() {
    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('category', 'Category', 'required');

    if ($this->form_validation->run() === FALSE) {
        $data['title'] = 'Add Package';
        $data['locations'] = $this->Location_model->get_all_active();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/packageManage/add', $data);
        $this->load->view('admin/layouts/footer');
        return;
    }

    $post = $this->input->post(NULL, TRUE);

    $slug = $this->Package_model->make_unique_slug($post['title']);

    $languages = !empty($post['language']) ? json_encode($post['language']) : json_encode([]);
    $tour_types = !empty($post['tour_type']) ? json_encode($post['tour_type']) : json_encode([]);
    $accommodations = !empty($post['accommodation']) ? json_encode($post['accommodation']) : json_encode([]);
  
  


    $payload = [
        'title'             => $post['title'],
        'slug'              => $slug,
        'category'          => $post['category'],
        'location_id' => $post['location_id'] ?? null,
        'destinations'      => $post['destinations'] ?? null,
        'short_description' => $post['short_description'] ?? null,
        'description'       => $post['description'] ?? null,
        'meta_title'        => $post['meta_title'] ?? null,
        'meta_description'  => $post['meta_description'] ?? null,
        'meta_keyword'  => $post['meta_keyword'] ?? null,
        'price'             => $post['price'] ?? 0,
        'duration'          => $post['duration'] ?? null,
        // 'accommodation'     => $post['accommodation'] ?? null,
        'accommodation'     => $accommodations,
        'meals'             => $post['meals'] ?? null,
        'transportation'    => $post['transportation'] ?? null,
        // 'group_size'        => $post['group_size'] ?? null,
        'language'          => $languages,
        // 'animal'            => $post['animal'] ?? null,
        // 'age_range'         => $post['age_range'] ?? null,
        // 'season'            => $post['season'] ?? null,
        // 'tour_type'         => $post['tour_type'] ?? null,
        'tour_type'         => $tour_types,
        'highlights_of_tours' => $post['highlights_of_tours'] ?? null,
        'additional_info' => $post['additional_info'] ?? null,
        'day_details'      => $post['day_details'] ?? null,
        'inclusion'        => $post['inclusion'] ?? null,
        'exclusion'        => $post['exclusion'] ?? null,
        'addtional_charge' => $post['addtional_charge'] ?? null,
        'note'             => $post['note'] ?? null,
        'status'           => isset($post['status']) ? 1 : 0,
        'popular'           => isset($post['popular']) ? 1 : 0,
    ];
    if (!empty($_FILES['image']['name'])) {

        $config['upload_path'] = './uploads/packages/';
        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);

        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $uploaded = $this->upload->data();
            $payload['image'] = 'uploads/packages/' . $uploaded['file_name'];
        } else {
            $data['error'] = $this->upload->display_errors('', '');
            $data['title'] = 'Add Package';
            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/packageManage/add', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }
    }

       if (!empty($_FILES['image_top']['name'])) {
        $config['upload_path'] = './uploads/packages/';
        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);

        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $this->upload->initialize($config); 

        if ($this->upload->do_upload('image_top')) {
            $uploaded = $this->upload->data();
            $payload['image_top'] = 'uploads/packages/' . $uploaded['file_name'];
        } else {
            $data['error'] = $this->upload->display_errors('', '');
            $data['title'] = 'Add Package';
            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/packageManage/add', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }
    }

    $package_id = $this->Package_model->insert($payload);
    $this->session->set_flashdata('success', 'Package created successfully.');
    redirect('admin/package');
}



public function edit($id = null)
{
    if (!$id) show_404();

    $package = $this->Package_model->get_by_id($id);
    if (!$package) show_404();


    $package->language = !empty($package->language) ? json_decode($package->language, true) : [];


    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('category', 'Category', 'required');

    if ($this->form_validation->run() === FALSE) {
        $data['title'] = 'Edit Package';
        $data['locations'] = $this->Location_model->get_all_active();
        $data['package'] = $package;
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/packageManage/edit', $data);
        $this->load->view('admin/layouts/footer');
        return;
    }

    $post = $this->input->post(NULL, TRUE);
    $old_title = trim($package->title);
    $new_title = trim($post['title']);
     $slug = ($package->title !== $post['title']) ? $this->Package_model->make_unique_slug($post['title']) : $package->slug;

    $languages = !empty($post['language']) ? json_encode($post['language']) : json_encode([]);
    $tour_types = !empty($post['tour_type']) ? json_encode($post['tour_type']) : json_encode([]);
    $accommodations = !empty($post['accommodation']) ? json_encode($post['accommodation']) : json_encode([]);
   

    $payload = [
        'title'             => $post['title'],
        'slug'              => $slug,
        'category'          => $post['category'],
        'location_id' => $post['location_id'] ?? null,
        'destinations'      => $post['destinations'] ?? null,
        'short_description' => $post['short_description'] ?? null,
        'description'       => $post['description'] ?? null,
        'meta_title'        => $post['meta_title'] ?? null,
        'meta_description'  => $post['meta_description'] ?? null,
        'meta_keyword'  => $post['meta_keyword'] ?? null,
        'price'             => $post['price'] ?? 0,
        'duration'          => $post['duration'] ?? null,
        // 'accommodation'     => $post['accommodation'] ?? null,
        'accommodation'     => $accommodations,
        'meals'             => $post['meals'] ?? null,
        'transportation'    => $post['transportation'] ?? null,
        // 'group_size'        => $post['group_size'] ?? null,
        'language'          => $languages,
        // 'animal'            => $post['animal'] ?? null,
        // 'age_range'         => $post['age_range'] ?? null,
        // 'season'            => $post['season'] ?? null,
        // 'tour_type'         => $post['tour_type'] ?? null,
        'tour_type'         => $tour_types,
        'highlights_of_tours' => $post['highlights_of_tours'] ?? null,
        'additional_info' => $post['additional_info'] ?? null,
        'day_details'       => $post['day_details'] ?? null,
        'inclusion'         => $post['inclusion'] ?? null,
        'exclusion'         => $post['exclusion'] ?? null,
        'addtional_charge'  => $post['addtional_charge'] ?? null,
        'note'              => $post['note'] ?? null,
        'status'            => isset($post['status']) ? 1 : 0,
        'popular'             => isset($post['popular']) ? 1 : 0,
    ];

    if (!empty($_FILES['image']['name'])) {

        $config['upload_path'] = './uploads/packages/';
        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);

        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $uploaded = $this->upload->data();
            $payload['image'] = 'uploads/packages/' . $uploaded['file_name'];
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('admin/package/edit/' . $id);
            return;
        }
    }

        if (!empty($_FILES['image_top']['name'])) {
        $config['upload_path']   = './uploads/packages/';
        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size']      = 2048;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image_top')) {
            $uploaded = $this->upload->data();
            $payload['image_top'] = 'uploads/packages/' . $uploaded['file_name'];
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('admin/package/edit/' . $id);
            return;
        }
    }

        $this->Package_model->update($id, $payload);
        $this->session->set_flashdata('success', 'Package updated successfully.');
        redirect('admin/package');
}

    public function view($id = null) 
    {
        if (!$id) show_404();
        $package = $this->Package_model->get_by_id($id);
        if (!$package) show_404();
        $data['title'] = 'View Package';
        $data['package'] = $package;
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/packageManage/view', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function delete($id)
    {
        if (!$id) show_404();
        $this->Package_model->delete($id);
        $this->session->set_flashdata('success', 'Package and related stays deleted successfully.');
        redirect('admin/package');
    }


    public function toggle($id = null) {
        if (!$id) show_404();
        $this->Package_model->toggle_status($id);
        $this->session->set_flashdata('success', 'Status changed.');
        redirect('admin/package');
    }
     public function get_locations_by_category($category)
{
    $this->load->model('Location_model');
    $location = $this->Location_model->get_by_category($category);

    echo json_encode($location);
}
}


