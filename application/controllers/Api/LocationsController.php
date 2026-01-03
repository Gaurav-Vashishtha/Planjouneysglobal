<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property Location_model $Location_model
 * @property Location_model $Package_model
 * @property CI_Output $output
 */
class LocationsController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Location_model');
         $this->load->model('Package_model');
        $this->load->helper(['url', 'text', 'form']);
        $this->output->set_content_type('application/json'); // Always respond in JSON
    }

    /**
     * Default endpoint
     */
    public function index() {
        $response = [
            'status' => false,
            'message' => 'Invalid API endpoint.'
        ];
        $this->output->set_output(json_encode($response));
    }

    /**
     * Fetch all active locations
     * URL: /api/LocationsController/get_locations
     * Method: GET
     */
    public function get_locations() {
        try {
            $locations = $this->Location_model->get_all_active();

            if (!empty($locations)) {
                $response = [
                    'status' => true,
                    'message' => 'Locations fetched successfully.',
                    'data' => $locations
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No locations found.',
                    'data' => []
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }

        $this->output->set_output(json_encode($response));
    }

 public function get_location_details($slug = null)
{
    if (empty($slug)) {
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode([
                         'status' => false,
                         'message' => 'Invalid location slug.'
                     ]));
        return;
    }

    $location = $this->Location_model->get_by_slug($slug);

    if (!$location) {
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode([
                         'status' => false,
                         'message' => 'Location not found.'
                     ]));
        return;
    }

$gallery = [];
if (!empty($location['gallery'])) {
    $decoded = json_decode($location['gallery'], true);

    if (is_string($decoded)) {
        $decoded = json_decode($decoded, true);
    }

    $gallery = is_array($decoded) ? $decoded : [];
}

$full_gallery = array_map(function($img) {
    return base_url('uploads/location/gallery/' . $img);
}, $gallery);

$location['gallery'] = $full_gallery;

    $this->output->set_content_type('application/json')
                 ->set_output(json_encode([
                     'status'  => true,
                     'message' => 'Location details fetched successfully.',
                     'data'    => $location
                 ]));
}
   

public function get_locationsByCategory($category = null)
{
    if (empty($category)) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'message' => 'Invalid category name.'
            ]));
    }

    $category = $this->Location_model->getByCategory($category);

    if (!$category) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'message' => 'category not found.'
            ]));
    }

  

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'  => true,
            'message' => 'category details fetched successfully.',
            'data'    => $category
        ]));
}
   public function get_top_destinations() {
        try {
            $locations = $this->Location_model->get_all_top_destinations();

            if (!empty($locations)) {
                $response = [
                    'status' => true,
                    'message' => 'Top Destinations fetched successfully.',
                    'data' => $locations
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No locations found.',
                    'data' => []
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }

        $this->output->set_output(json_encode($response));
    }

public function get_popularlocationsByCategory($category = null)
{
    if (empty($category)) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'message' => 'Invalid category name.'
            ]));
    }

    $locations = $this->Location_model->getPopularLocation($category);

    if (!$locations) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'message' => 'Category not found.'
            ]));
    }

    // Transform data to only include name and full image URL (for objects)
    $data = array_map(function($loc) {
        return [
            'name'  => $loc->name,
            'image' => !empty($loc->image) ? base_url($loc->image) : null
        ];
    }, $locations);

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'  => true,
            'message' => 'Popular details fetched successfully.',
            'data'    => $data
        ]));
}



}