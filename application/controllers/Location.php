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
class Location extends CI_Controller {


  
    public function __construct() {
        parent::__construct();
        $this->load->model('Location_model');
        $this->load->library('upload'); 
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','form','text']);
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }
    }

    public function index() {
        $data['locations'] = $this->Location_model->get_all();
        $data['title'] = 'Manage Locations';
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/locationManage/list', $data);
        $this->load->view('admin/layouts/footer');
    }


    public function add()
{
    $this->form_validation->set_rules('name','Name','required');

    if ($this->form_validation->run() === FALSE) {
        $data['title'] = 'Add Location';
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/locationManage/add', $data);
        $this->load->view('admin/layouts/footer');
        return;
    }

    $post = $this->input->post(NULL, TRUE);
    $slug = $this->Location_model->make_unique_slug($post['name']);

    $payload = [
        'name'        => $post['name'],
        'slug'        => $slug,
        'category'    => $post['category'],
        'description' => $post['description'],
        'markup'      => $post['markup'] ?? '0',
        'language'    => $post['language'],
        'capital'     => $post['capital'],
        'currency'    => $post['currency'],
        'status'      => isset($post['status']) ? 1 : 0,
        'top_destination'      => isset($post['top_destination']) ? 1 : 0,
        'popular'      => isset($post['popular']) ? 1 : 0,

    ];

    // === Location Icon Upload ===
    $location_icon = null;
    if (!empty($_FILES['location_icon']['name'])) {
        $location_icon = $this->_upload_file('location_icon', './uploads/location/');
        if ($location_icon) {
             $payload['location_icon'] = 'uploads/location/' .$location_icon;
        }
    }

    // === Main Image Upload ===
    if (!empty($_FILES['image']['name'])) {
        $config = [
            'upload_path'   => './uploads/location/',
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size'      => 50000
        ];

        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $uploaded = $this->upload->data();
            $payload['image'] = 'uploads/location/'.$uploaded['file_name'];
        }
    }

    // === Gallery Images Upload ===
    $gallery_files = [];
    if (!empty($_FILES['gallery']['name'][0])) {
        $count = count($_FILES['gallery']['name']);
        for ($i=0; $i < $count; $i++) {
            $_FILES['file']['name']     = $_FILES['gallery']['name'][$i];
            $_FILES['file']['type']     = $_FILES['gallery']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['gallery']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['gallery']['error'][$i];
            $_FILES['file']['size']     = $_FILES['gallery']['size'][$i];

            $config = [
                'upload_path'   => './uploads/location/gallery/',
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 250000
            ];

            if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $uploaded = $this->upload->data();
                $gallery_files[] = $uploaded['file_name'];
            }
        }
    }
    $payload['gallery'] = json_encode($gallery_files);

    // === Video Upload ===
    if (!empty($_FILES['video']['name'])) {
        $config = [
            'upload_path'   => './uploads/location/video/',
            'allowed_types' => 'mp4|mov|avi|mkv',
            'max_size'      => 250000  
        ];

        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('video')) {
            $video_file = $this->upload->data();
            $payload['video'] = 'uploads/location/video/' .$video_file['file_name'];
        }
    }

    // === Best Time to Visit ===
    $best_time = $this->input->post('best_time');
    $best_time_images = [];

    if(!empty($_FILES['best_time_image']['name'])){
        $count = count($_FILES['best_time_image']['name']);
        for($i=0; $i<$count; $i++){
            if($_FILES['best_time_image']['name'][$i] != ''){
                $_FILES['file']['name']     = $_FILES['best_time_image']['name'][$i];
                $_FILES['file']['type']     = $_FILES['best_time_image']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['best_time_image']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['best_time_image']['error'][$i];
                $_FILES['file']['size']     = $_FILES['best_time_image']['size'][$i];

                $config = [
                    'upload_path'   => './uploads/location/best_time/',
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'max_size'      => 250000
                ];
                if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, true);
                $this->upload->initialize($config);

                if($this->upload->do_upload('file')){
                    $uploaded = $this->upload->data();
                    $best_time_images[$i] = 'uploads/location/best_time/' .$uploaded['file_name'];
                }else{
                    $best_time_images[$i] = null;
                }
            }else{
                $best_time_images[$i] = null;
            }
        }
    }

    $final_best_time = [];
    if(!empty($best_time['season'])){
        foreach($best_time['season'] as $index=>$season){
            $final_best_time[] = [
                'season'      => $season,
                'weather'     => $best_time['weather'][$index] ?? '',
                'highlights'  => $best_time['highlights'][$index] ?? '',
                'perfect_for' => $best_time['perfect_for'][$index] ?? '',
                'image'       => $best_time_images[$index] ?? null
            ];
        }
    }
    $payload['best_time_to_visit'] = json_encode($final_best_time);

    // === FAQ ===
    $faq_q = $this->input->post('faq_question');
    $faq_a = $this->input->post('faq_answer');
    $faq_list = [];

    if (!empty($faq_q)) {
        foreach ($faq_q as $i => $q) {
            $faq_list[] = [
                'question' => $q,
                'answer'   => $faq_a[$i] ?? ''
            ];
        }
    }

    $payload['faqs'] = json_encode($faq_list);

    // === Insert into DB ===
    $this->Location_model->insert($payload);

    $this->session->set_flashdata('success', 'Location added successfully.');
    redirect('admin/locations');
}


public function edit($id = null)
{
    if (!$id) show_404();
    $location = $this->Location_model->get($id);
    if (!$location) show_404();

    $this->form_validation->set_rules('name','Name','required');

    if ($this->form_validation->run() === FALSE) {
        $data['title'] = 'Edit Location';
        $data['location'] = $location;
        $data['best_time'] = json_decode($location->best_time_to_visit, true) ?: [];
        $data['faqs'] = json_decode($location->faqs, true) ?: [];

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/locationManage/edit', $data);
        $this->load->view('admin/layouts/footer');
        return;
    }

    $post = $this->input->post(NULL, TRUE);

    $payload = [
        'name'        => $post['name'],
        'description' => $post['description'] ?? null,
        'markup'      => $post['markup'] ?? '0',
        'category'    => $post['category'] ?? null,
        'language'    => $post['language'] ?? null,
        'capital'     => $post['capital'] ?? null,
        'currency'    => $post['currency'] ?? null,
        'status'      => isset($post['status']) ? 1 : 0,
        'top_destination'      => isset($post['top_destination']) ? 1 : 0,
        'popular'      => isset($post['popular']) ? 1 : 0,

    ];

    $this->load->library('upload');

if (!empty($_FILES['location_icon']['name'])) {
    $config = [
        'upload_path'   => './uploads/location/',
        'allowed_types' => 'jpg|jpeg|png|webp',
        'max_size'      => 2048
    ];
    if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);
    $this->upload->initialize($config);

    if ($this->upload->do_upload('location_icon')) {
        $uploaded = $this->upload->data();
        $payload['location_icon'] = 'uploads/location/' .$uploaded['file_name'];

        
        if ($location->location_icon && file_exists('./uploads/location/' . $location->location_icon)) {
            unlink('./uploads/location/' . $location->location_icon);
        }
    } else {
       
        $this->session->set_flashdata('error', $this->upload->display_errors());
        redirect('admin/location/edit/'.$id);
    }
}

    if (!empty($_FILES['image']['name'])) {
        $config = [
            'upload_path'   => './uploads/location/',
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size'      => 2048
        ];
        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {
            $uploaded = $this->upload->data();
            $payload['image'] = 'uploads/location/'.$uploaded['file_name'];

            if ($location->image && file_exists('./uploads/location/' . $location->image)) {
                unlink('./uploads/location/' . $location->image);
            }
        }
    }

    // Gallery
    $existing_gallery = json_decode($location->gallery, true) ?: [];
    $new_gallery = [];
    if (!empty($_FILES['gallery']['name'][0])) {
        $count = count($_FILES['gallery']['name']);
        for ($i=0; $i<$count; $i++){
            $_FILES['file']['name']     = $_FILES['gallery']['name'][$i];
            $_FILES['file']['type']     = $_FILES['gallery']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['gallery']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['gallery']['error'][$i];
            $_FILES['file']['size']     = $_FILES['gallery']['size'][$i];

            $config = [
                'upload_path'   => './uploads/location/gallery/',
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 4096
            ];
            if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);
            $this->upload->initialize($config);

            if($this->upload->do_upload('file')){
                $file = $this->upload->data();
                $new_gallery[] = $file['file_name'];
            }
        }
    }
    $payload['gallery'] = json_encode(array_merge($existing_gallery, $new_gallery));

    // Video
    if (!empty($_FILES['video']['name'])) {
        $config = [
            'upload_path'   => './uploads/location/video/',
            'allowed_types' => 'mp4|mov|avi|mkv',
            'max_size'      => 250000
        ];
        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);
        $this->upload->initialize($config);

        if($this->upload->do_upload('video')){
            $video = $this->upload->data();
            $payload['video'] = 'uploads/location/'.$video['file_name'];

            if ($location->video && file_exists('./uploads/location/video/' . $location->video)) {
                unlink('./uploads/location/video/' . $location->video);
            }
        }
    }

    // Best Time to Visit
 $best_time = $this->input->post('best_time');
$best_time_images = [];

// Make sure we loop using the correct index
if (!empty($_FILES['best_time_image']['name'][0])) {
    $count = count($_FILES['best_time_image']['name']);
    for ($i = 0; $i < $count; $i++) {
        if ($_FILES['best_time_image']['name'][$i] != '') {
            $_FILES['file']['name']     = $_FILES['best_time_image']['name'][$i];
            $_FILES['file']['type']     = $_FILES['best_time_image']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['best_time_image']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['best_time_image']['error'][$i];
            $_FILES['file']['size']     = $_FILES['best_time_image']['size'][$i];

            $config = [
                'upload_path'   => './uploads/location/best_time/',
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 2048
            ];

            if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0755, TRUE);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $uploaded = $this->upload->data();
                $best_time_images[$i] = 'uploads/location/best_time/' .$uploaded['file_name'];
            }
        }
    }
}

// Merge old + new images
$existing_best_time = json_decode($location->best_time_to_visit, true) ?: [];
$final_best_time = [];

if (!empty($best_time['season'])) {
    foreach ($best_time['season'] as $index => $season) {
        $image = $best_time_images[$index] ?? ($existing_best_time[$index]['image'] ?? null);
        $final_best_time[] = [
            'season'      => $season,
            'weather'     => $best_time['weather'][$index] ?? '',
            'highlights'  => $best_time['highlights'][$index] ?? '',
            'perfect_for' => $best_time['perfect_for'][$index] ?? '',
            'image'       => $image
        ];
    }
}

$payload['best_time_to_visit'] = json_encode($final_best_time);


    // FAQ
    $faq_q = $this->input->post('faq_question');
    $faq_a = $this->input->post('faq_answer');
    $faq_list = [];
    if(!empty($faq_q)){
        foreach($faq_q as $i=>$q){
            $faq_list[] = ['question'=>$q,'answer'=>$faq_a[$i] ?? ''];
        }
    }
    $payload['faqs'] = json_encode($faq_list);

    $this->Location_model->update($id, $payload);

    $this->session->set_flashdata('success','Location updated successfully.');
    redirect('admin/locations');
}


    
public function delete_gallery_image($id, $filename)
{
    $filename = urldecode($filename);

    $location = $this->Location_model->get($id);
    if (!$location) show_404();

    $gallery = json_decode($location->gallery, true);

    // Remove file
    if (($key = array_search($filename, $gallery)) !== false) {
        unset($gallery[$key]);
    }

    // Delete from server
    $path = './uploads/location/gallery/' . $filename;
    if (file_exists($path)) unlink($path);

    // Save updated gallery
    $this->Location_model->update($id, [
        'gallery' => json_encode(array_values($gallery))
    ]);

    redirect('admin/location/edit/' . $id);
}


    public function view($id = null) {
        if (!$id) show_404();
        $location = $this->Location_model->get($id);
        if (!$location) show_404();

        $data['title'] = 'View Location';
        $data['location'] = $location;
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/locationManage/view', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function delete($id = null) {
        if (!$id) show_404();
        $this->Location_model->delete($id);
        $this->session->set_flashdata('success','Location deleted successfully.');
        redirect('admin/locations');
    }

    public function toggle($id = null) {
        if (!$id) show_404();
        $this->Location_model->toggle_status($id);
        $this->session->set_flashdata('success','Status changed successfully.');
        redirect('admin/locations');
    }

    private function _upload_file($field_name, $upload_path, $old_file = null, $allowed_types='jpg|jpeg|png|gif') {
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
