<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property Package_model $Package_model
 * @property CI_Output $output
 * @property Location_model $Location_model
 * @property db $db
 */
class PackageController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Location_model');
        $this->load->model('Package_model');
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

    public function get_packages()
    {
        try {
            $packages = $this->Package_model->get_all_active();

            foreach ($packages as &$pkg) {

              
            }

            $response = [
                'status' => true,
                'message' => 'Packages fetched successfully.',
                'data'    => $packages
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
       
    public function get_package_by_slug($slug = null)
    {
      
        $this->output->set_content_type('application/json');

        if (empty($slug)) {
            return $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Invalid slug provided.'
            ]));
        }

        $package = $this->Package_model->get_by_slug($slug);

        if (!$package) {
            return $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Package not found.'
            ]));
        }

        return $this->output->set_output(json_encode([
            'status' => true,
            'data' => $package
        ]));
    }

    
    public function get_popular_packages()
    {
        try {
            $packages = $this->Package_model->get_all_popular();

            foreach ($packages as &$pkg) {

              
            }

            $response = [
                'status' => true,
                'message' => 'Popular Packages fetched successfully.',
                'data'    => $packages
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

}