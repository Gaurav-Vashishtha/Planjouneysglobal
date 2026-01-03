<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Hotels_model $Hotels_model
 * @property Location_model $Location_model
 */
class Hotels extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Hotels_model');
        $this->load->model('Location_model');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);

        // Ensure admin logged in
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }
    }

    /**
     * List all hotels
     */
    public function index() {

        // echo 'hii';  die;
        $filters = [
            'hotel_type' => $this->input->get('hotel_type', TRUE),
            'status'     => $this->input->get('status', TRUE),
            'search'     => $this->input->get('search', TRUE),
        ];

        $data['filters'] = $filters;
        $data['hotels']  = $this->Hotels_model->get_all($filters);
        $data['title']   = 'Hotel Management';

        // echo 'hii';  die;

        $this->load->view('admin/layouts/header', $data);
        // echo 'hii';  die;
        $this->load->view('admin/hotelsManage/hotels', $data);
        // echo 'hii';  die;
        $this->load->view('admin/layouts/footer');
        //  echo 'hii';  die;
    }


    public function create() {
        $data['title'] = 'Add New Hotel';

        if ($this->input->method() === 'post') {
            $this->_set_validation_rules();

            if ($this->form_validation->run()) {
                $postData = $this->_collect_post_data();

                if (!empty($_FILES['hotel_image']['name'])) {
                    $upload = $this->Hotels_model->upload_image('hotel_image');
                    if (isset($upload['error'])) {
                        $this->session->set_flashdata('error', $upload['error']);
                        redirect(current_url());
                    } else {
                        $postData['hotel_image'] = 'uploads/hotels/' . $upload['file_name'];
                    }
                }

                $this->Hotels_model->insert($postData);
                $this->session->set_flashdata('success', 'Hotel added successfully.');
                redirect('admin/hotels');
            }
        }
        $data['locations'] = $this->Location_model->get_all_active();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/hotelsManage/form', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function edit($id) {
        $data['title']  = 'Edit Hotel';
        $data['hotels'] = $this->Hotels_model->get($id);


        if (empty($data['hotels'])) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            $this->_set_validation_rules();

            if ($this->form_validation->run()) {
                $postData = $this->_collect_post_data();


                if (!empty($_FILES['hotel_image']['name'])) {
                    $upload = $this->Hotels_model->upload_image('hotel_image');
                    if (isset($upload['error'])) {
                        $this->session->set_flashdata('error', $upload['error']);
                        redirect(current_url());
                    } else {
                        if (!empty($data['hotels']->hotel_image) && file_exists(FCPATH . $data['hotels']->hotel_image)) {
                            unlink(FCPATH . $data['hotels']->hotel_image);
                        }
                        $postData['hotel_image'] = 'uploads/hotels/' . $upload['file_name'];
                    }
                }

                $this->Hotels_model->update($id, $postData);
                $this->session->set_flashdata('success', 'Hotel updated successfully.');
                redirect('admin/hotels');
            }
        }
        $data['locations'] = $this->Location_model->get_all_active();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/hotelsManage/form', $data);
        $this->load->view('admin/layouts/footer');
    }


    public function view($id) {
        $data['hotels'] = $this->Hotels_model->get($id);
        if (empty($data['hotels'])) {
            show_404();
        }
        $data['title'] = 'View Hotel Details';

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/hotelsManage/view', $data);
        $this->load->view('admin/layouts/footer');
    }

    public function delete($id) {
        $hotel = $this->Hotels_model->get($id);
        if ($hotel) {
            if (!empty($hotel->hotel_image) && file_exists(FCPATH . $hotel->hotel_image)) {
                unlink(FCPATH . $hotel->hotel_image);
            }
            $this->Hotels_model->delete($id);
            $this->session->set_flashdata('success', 'Hotel deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Hotel not found.');
        }
        redirect('admin/hotels');
    }


    public function toggle($id) {
        if ($this->Hotels_model->toggle_status($id)) {
            $this->session->set_flashdata('success', 'Status updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Unable to update status.');
        }
        redirect('admin/hotels');
    }


    private function _set_validation_rules() {
        $this->form_validation->set_rules('hotel_type', 'Hotel Type', 'required');
        $this->form_validation->set_rules('hotel_name', 'Hotel Name', 'required|trim');
        $this->form_validation->set_rules('hotel_charge', 'Hotel Charge', 'numeric');
        $this->form_validation->set_rules('hotel_star', 'Hotel Star', 'integer');
    }

    private function _collect_post_data() {
        return [
            'hotel_type'        => $this->input->post('hotel_type', TRUE),
            'location_id' => $this->input->post('location_id', TRUE), 
            'hotel_name'        => $this->input->post('hotel_name', TRUE),
            'meta_title'        => $this->input->post('meta_title', TRUE),
            'meta_description'  => $this->input->post('meta_description', TRUE),
            'hotel_title'       => $this->input->post('hotel_title', TRUE),
            'city'              => $this->input->post('city', TRUE),
            'rate_label'        => $this->input->post('rate_label', TRUE),
            'hotel_charge'      => $this->input->post('hotel_charge', TRUE),
            // 'stay_day_night'    => $this->input->post('stay_day_night', TRUE),
            'hotel_star'        => $this->input->post('hotel_star', TRUE),
            'brief_description' => $this->input->post('brief_description', TRUE),
            'overview'          => $this->input->post('overview', TRUE),
            'features'          => $this->input->post('features', TRUE),
            'full_description'  => $this->input->post('full_description', TRUE),
            'status'            => $this->input->post('status') ? 1 : 0,
        ];
    }
}
