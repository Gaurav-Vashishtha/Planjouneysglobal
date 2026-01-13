<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Activity_model $Activity_model
 * @property Location_model $Location_model
 * @property db $db
 * @property upload $upload
 */

class Activity extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Activity_model');
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
    $data['activities'] = $this->Activity_model->get_all(null, null, $filters);

    $data['filters'] = $filters;
    $data['title'] = 'Manage Activity';

    $this->load->view('admin/layouts/header', $data);
    $this->load->view('admin/activityManage/list', $data);
    $this->load->view('admin/layouts/footer');
}




public function create() {
    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('category', 'Category', 'required');

    if ($this->form_validation->run() === FALSE) {
        $data['title'] = 'Add Activity';
        $data['locations'] = $this->Location_model->get_all_active();
        $data['activity_categories'] = $this->db->get('activity_categories')->result();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/activityManage/add', $data);
        $this->load->view('admin/layouts/footer');
        return;
    }

    $post = $this->input->post(NULL, TRUE);

    $slug = $this->Activity_model->make_unique_slug($post['title']);
    $activity_category_id = $post['category_id'] ?? null;
    $activity_category_name = null;
    if ($activity_category_id) {
        $cat = $this->db
            ->where('id', $activity_category_id)
            ->get('activity_categories')
            ->row();

        $activity_category_name = $cat ? $cat->category_name : null;
    }


    $activity_ids = $post['activities'] ?? [];
    $activity_names = [];

    if (!empty($activity_ids)) {
        $acts = $this->db
            ->select('activity_name')
            ->where_in('id', $activity_ids)  
            ->get('activities_name')           
            ->result();

        foreach ($acts as $a) {
            $activity_names[] = $a->activity_name;
        }
    }



    $payload = [
        'title'             => $post['title'],
        'slug'              => $slug,
        'category'          => $post['category'],
        'location_id' => $post['location_id'] ?? null,
        'category_id'      => $activity_category_id,
        'activity_category_name' => $activity_category_name,
        'activity_names' => !empty($activity_names)? implode(', ', $activity_names): null,
        'short_description' => $post['short_description'] ?? null,
        'description'       => $post['description'] ?? null,
        'meta_title'        => $post['meta_title'] ?? null,
        'meta_description'  => $post['meta_description'] ?? null,
        'price'             => $post['price'] ?? 0,
        'highlights_of_activity' => $post['highlights_of_activity'] ?? null,
        'additional_info' => $post['additional_info'] ?? null,
        'inclusion'         => $post['inclusion'] ?? null,
        'exclusion'         => $post['exclusion'] ?? null,
        'addtional_charge'  => $post['addtional_charge'] ?? null,
        'activity_overview'              => $post['activity_overview'] ?? null,
        'status'           => isset($post['status']) ? 1 : 0,
        'popular'           => isset($post['popular']) ? 1 : 0

    ];
    if (!empty($_FILES['image']['name'])) {

        $config['upload_path'] = './uploads/activities/';
        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);

        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $uploaded = $this->upload->data();
            $payload['image'] = 'uploads/activities/' . $uploaded['file_name'];
        } else {
            $data['error'] = $this->upload->display_errors('', '');
            $data['title'] = 'Add Activity';
            $this->load->view('admin/layouts/header', $data);
            $this->load->view('admin/activityManage/add', $data);
            $this->load->view('admin/layouts/footer');
            return;
        }
    }

    $image_names = $this->input->post('image_name');
    $activity_images = [];

    if (!empty($_FILES['multi_image']['name'])) {

        $count = count($_FILES['multi_image']['name']);

        for ($i = 0; $i < $count; $i++) {

            if ($_FILES['multi_image']['name'][$i] != '') {

                $_FILES['file']['name']     = $_FILES['multi_image']['name'][$i];
                $_FILES['file']['type']     = $_FILES['multi_image']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['multi_image']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['multi_image']['error'][$i];
                $_FILES['file']['size']     = $_FILES['multi_image']['size'][$i];

                $config = [
                    'upload_path'   => './uploads/activity_gallery/',
                    'allowed_types' => 'jpg|jpeg|png|gif|webp',
                    'max_size'      => 5120
                ];

                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0755, true);
                }
               $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $uploaded = $this->upload->data();
                    $activity_images[$i] = 'uploads/activity_gallery/' . $uploaded['file_name'];
                } else {
                    $activity_images[$i] = null;
                }

            } else {
                $activity_images[$i] = null;
            }
        }
    }
    $final_activity_images = [];

    if (!empty($image_names)) {
        foreach ($image_names as $index => $name) {
            $final_activity_images[] = [
                'image_name' => $name,
                'image'      => $activity_images[$index] ?? null
            ];
        }
    }
    $payload['gallery'] = !empty($final_activity_images) ? json_encode($final_activity_images) : null;
    $activities_id = $this->Activity_model->insert($payload);
    $this->session->set_flashdata('success', 'Activity created successfully.');
    redirect('admin/activities');
}



public function edit($id = null)
{
    if (!$id) show_404();

    $activities = $this->Activity_model->get_by_id($id);
    if (!$activities) show_404();

    $activities->gallery = !empty($activities->gallery) ? json_decode($activities->gallery, true) : [];


    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('category', 'Category', 'required');

    if ($this->form_validation->run() === FALSE) {
        $data['title'] = 'Edit activities';
        $data['locations'] = $this->Location_model->get_all_active();
        $data['activity_categories'] = $this->db->get('activity_categories')->result();
        $data['activities'] = $activities;
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/activityManage/edit', $data);
        $this->load->view('admin/layouts/footer');
        return;
    }

    $post = $this->input->post(NULL, TRUE);
    $activity_category_id = $post['category_id'] ?? null;
    $activity_category_name = null;

    if ($activity_category_id) {
        $cat = $this->db
            ->where('id', $activity_category_id)
            ->get('activity_categories')
            ->row();

        $activity_category_name = $cat ? $cat->category_name : null;
    }

    $activity_ids = $post['activities'] ?? [];
    $activity_names = [];

    if (!empty($activity_ids)) {
        $acts = $this->db
            ->select('activity_name')
            ->where_in('id', $activity_ids) 
            ->get('activities_name')       
            ->result();

        foreach ($acts as $a) {
            $activity_names[] = $a->activity_name;
        }
    }

    $payload = [
        'title'             => $post['title'],
        'category'          => $post['category'],
        'location_id' => $post['location_id'] ?? null,
        'category_id'      => $activity_category_id,
        'activity_category_name' => $activity_category_name,
        'activity_names'         => !empty($activity_names) ? implode(', ', $activity_names) : null,
        'short_description' => $post['short_description'] ?? null,
        'description'       => $post['description'] ?? null,
        'meta_title'        => $post['meta_title'] ?? null,
        'meta_description'  => $post['meta_description'] ?? null,
        'price'             => $post['price'] ?? 0,
        'highlights_of_activity' => $post['highlights_of_activity'] ?? null,
        'additional_info' => $post['additional_info'] ?? null,
        'inclusion'         => $post['inclusion'] ?? null,
        'exclusion'         => $post['exclusion'] ?? null,
        'addtional_charge'  => $post['addtional_charge'] ?? null,
        'activity_overview'              => $post['activity_overview'] ?? null,
        'status'            => isset($post['status']) ? 1 : 0,
        'popular'           => isset($post['popular']) ? 1 : 0,
    ];

    if (!empty($_FILES['image']['name'])) {

        $config['upload_path'] = './uploads/activities/';
        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);

        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $uploaded = $this->upload->data();
            $payload['image'] = 'uploads/activities/' . $uploaded['file_name'];
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('admin/activities/edit/' . $id);
            return;
        }
    } 

    $image_names = $this->input->post('image_name'); 
    $existing_images = $this->input->post('existing_images'); 
    $activity_images = [];

   
    if (!empty($_FILES['multi_image']['name'])) {
        $count = count($_FILES['multi_image']['name']);

        for ($i = 0; $i < $count; $i++) {
            if ($_FILES['multi_image']['name'][$i] != '') {
                $_FILES['file']['name'] = $_FILES['multi_image']['name'][$i];
                $_FILES['file']['type'] = $_FILES['multi_image']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['multi_image']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['multi_image']['error'][$i];
                $_FILES['file']['size'] = $_FILES['multi_image']['size'][$i];

                $config = [
                    'upload_path' => './uploads/activity_gallery/',
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'max_size' => 5120
                ];

                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0755, true);
                }
                $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $uploaded = $this->upload->data();
                    $activity_images[$i] = 'uploads/activity_gallery/' . $uploaded['file_name'];
                } else {
                    $activity_images[$i] = null;
                }
            } else {
                $activity_images[$i] = null;
            }
        }
    }
    $final_activity_images = [];
    if (!empty($image_names)) {
        foreach ($image_names as $index => $name) {
            $final_activity_images[] = [
                'image_name' => $name,
                'image' => $activity_images[$index] ?? $existing_images[$index] ?? null
            ];
        }
    }
    $payload['gallery'] = !empty($final_activity_images) ? json_encode($final_activity_images) : null;
        $this->Activity_model->update($id, $payload);
        $this->session->set_flashdata('success', 'activities updated successfully.');
        redirect('admin/activities');
}

    public function view($id = null) 
    {
        if (!$id) show_404();
        $activities = $this->Activity_model->get_by_id($id);
        if (!$activities) show_404();
        $data['title'] = 'View activities';
        $data['activities'] = $activities;
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/activityManage/view', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function delete($id)
    {
        if (!$id) show_404();
        $this->Activity_model->delete($id);
        $this->session->set_flashdata('success', 'activities and related stays deleted successfully.');
        redirect('admin/activities');
    }


    public function toggle($id = null) {
        if (!$id) show_404();
        $this->Activity_model->toggle_status($id);
        $this->session->set_flashdata('success', 'Status changed.');
        redirect('admin/activities');
    }
     public function get_locations_by_category($category)
{
    $this->load->model('Location_model');
    $location = $this->Location_model->get_by_category($category);

    echo json_encode($location);
}

public function get_activities_by_category($category_id = null)
{
    if (empty($category_id)) {
        echo json_encode([]);
        return;
    }

    $activities = $this->db
        ->where('category_id', $category_id)
        ->select('id, activity_name')
        ->get('activities_name')
        ->result();

    echo json_encode($activities);
}



}


