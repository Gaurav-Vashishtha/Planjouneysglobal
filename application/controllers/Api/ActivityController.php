<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property Activity_model $Activity_model
 * @property CI_Output $output
 * @property Location_model $Location_model
 * @property db $db
 */
class ActivityController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Location_model');
        $this->load->model('Activity_model');
        $this->load->helper(['url', 'text', 'form']);

        $this->output->set_content_type('application/json');
    }

    public function index()
    {
        $response = [
            'status' => false,
            'message' => 'Invalid API endpoint.'
        ];
        $this->output->set_output(json_encode($response));
    }

    public function get_activities()
    {
        try {
            $activities = $this->Activity_model->get_all_active();

            foreach ($activities as &$pkg) {

              
            }

            $response = [
                'status' => true,
                'message' => 'Activities fetched successfully.',
                'data'    => $activities
            ];
        }
        catch (Exception $e) {
            $response = [
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }

        $this->output->set_output(json_encode($response));
    }
       
    public function get_activity_by_slug($slug = null)
    {
      
        $this->output->set_content_type('application/json');

        if (empty($slug)) {
            return $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Invalid slug provided.'
            ]));
        }

        $activities = $this->Activity_model->get_by_slug($slug);

        if (!$activities) {
            return $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Activities not found.'
            ]));
        }

        return $this->output->set_output(json_encode([
            'status' => true,
            'data' => $activities
        ]));
    }

}