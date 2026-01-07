<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property Location_model $Location_model
 * @property Package_model $Package_model
 * @property Activity_model $Activity_model
* @property Currency_model $Currency_model
 * @property CI_Output $output
 */
class LocationsController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Location_model');
        $this->load->model('Activity_model');
        $this->load->model('Currency_model');
        $this->load->model('Package_model');
        $this->load->helper(['url', 'text', 'form']);
        $this->output->set_content_type('application/json'); // Always respond in JSON
    }
     protected function get_rates()
        {
            $curr = $this->Currency_model->get_currency();
            $usd = isset($curr->usd_rate) ? (float) $curr->usd_rate : 0;
            $aed = isset($curr->aed_rate) ? (float) $curr->aed_rate : 0;

            return [
                'USD'       => $usd,
                'AED'       => $aed,
                'timestamp' => date('Y-m-d H:i:s'),
            ];
        }


    public function index() {
        $response = [
            'status' => false,
            'message' => 'Invalid API endpoint.'
        ];
        $this->output->set_output(json_encode($response));
    }


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

//  public function get_location_details($slug = null)
// {
//     if (empty($slug)) {
//         $this->output->set_content_type('application/json')
//                      ->set_output(json_encode([
//                          'status' => false,
//                          'message' => 'Invalid location slug.'
//                      ]));
//         return;
//     }

//     $location = $this->Location_model->get_by_slug($slug);

//     if (!$location) {
//         $this->output->set_content_type('application/json')
//                      ->set_output(json_encode([
//                          'status' => false,
//                          'message' => 'Location not found.'
//                      ]));
//         return;
//     }

// $gallery = [];
// if (!empty($location['gallery'])) {
//     $decoded = json_decode($location['gallery'], true);

//     if (is_string($decoded)) {
//         $decoded = json_decode($decoded, true);
//     }

//     $gallery = is_array($decoded) ? $decoded : [];
// }

// $full_gallery = array_map(function($img) {
//     return base_url('uploads/location/gallery/' . $img);
// }, $gallery);

// $location['gallery'] = $full_gallery;

//     $this->output->set_content_type('application/json')
//                  ->set_output(json_encode([
//                      'status'  => true,
//                      'message' => 'Location details fetched successfully.',
//                      'data'    => $location
//                  ]));
// }
   


   public function get_location_details($slug = null)
{
    if (empty($slug)) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'message' => 'Invalid location slug.'
            ]));
    }

    $location = $this->Location_model->get_by_slug($slug);

    if (!$location) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'message' => 'Location not found.'
            ]));
    }

    $gallery = [];
    if (!empty($location['gallery'])) {
        $decoded = json_decode($location['gallery'], true);
        if (is_string($decoded)) {
            $decoded = json_decode($decoded, true);
        }
        $gallery = is_array($decoded) ? $decoded : [];
    }

    $location['gallery'] = array_map(function ($img) {
        return base_url('uploads/location/gallery/' . $img);
    }, $gallery);

    $packages = $this->Package_model->get_by_location_id($location['id']);
    $rates = $this->get_rates();

    $location['packages'] = array_map(function ($pkg) use ($rates) {

        $priceInr = isset($pkg['price']) ? (float) $pkg['price'] : 0;

        return [
            'title'    => $pkg['title'],
            'slug'     => $pkg['slug'],
            'duration' => $pkg['duration'],
            'image'    => base_url($pkg['image']),
            'price' => [
                'inr' => $priceInr,
                'usd' => round($priceInr * $rates['USD'], 2),
                'aed' => round($priceInr * $rates['AED'], 2),
            ],
            'rate_timestamp' => $rates['timestamp'],
        ];
    }, $packages ?? []);

    return $this->output
        ->set_content_type('application/json')
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

    $data = array_map(function($loc) {
        return [
            'name'  => $loc->name,
            'slug'  => $loc->slug,
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

public function get_location_groups_with_package_count()
{
    try {
        $locations = $this->Location_model->get_all_active();
        $grouped = [];

        foreach ($locations as $loc) {
            $loc->package_count = $this->Package_model->count_by_location($loc->id);
            $cleanLocation = [
                'id'            => $loc->id,
                'slug'          => $loc->slug,
                'name'          => $loc->name,
                'package_count' => $loc->package_count
            ];

            $grouped[$loc->category][] = $cleanLocation;
        }

        $result = [];
        foreach ($grouped as $category => $locs) {
            $result[] = [
                'category'  => $category,
                'locations' => $locs
            ];
        }

        $response = [
            'status'  => true,
            'message' => 'Location groups fetched successfully.',
            'data'    => $result
        ];

    } catch (Exception $e) {

        $response = [
            'status'  => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }

    $this->output->set_output(json_encode($response));
}
public function get_location_groups_with_activity_count()
{
    try {

        $locations = $this->Location_model->get_all_active();
        $grouped = [];

        foreach ($locations as $loc) {

            $loc->activity_count = $this->Activity_model->count_by_location($loc->id);

            $cleanLocation = [
                'id'             => $loc->id,
                'slug'           => $loc->slug,
                'name'           => $loc->name,
                'activity_count' => $loc->activity_count
            ];

            $grouped[$loc->category][] = $cleanLocation;
        }

        $result = [];
        foreach ($grouped as $category => $locs) {
            $result[] = [
                'category'  => $category,
                'locations' => $locs
            ];
        }

        $response = [
            'status'  => true,
            'message' => 'Location groups with activity count fetched successfully.',
            'data'    => $result
        ];

    } catch (Exception $e) {

        $response = [
            'status'  => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }

    $this->output->set_output(json_encode($response));
}

public function searched_destination(){

  $location_name = $this->input->post('location_name');

   if (empty($location_name) ) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'message' => 'Value is required',
                'data' => []
            ]));
    }
        $this->load->model('Location_model');
        $location = $this->Location_model->get_destination_search(
        $location_name
       
    );

    $rates = $this->get_rates(); 

    foreach ($location as &$loc) {
        $price = isset($loc['price']) ? (float)$loc['price'] : 0;
        $loc['price_inr'] = $price;
        $loc['price_usd'] = round($price * $rates['USD'], 2);
        $loc['price_aed'] = round($price * $rates['AED'], 2);
        $loc['rate_timestamp'] = $rates['timestamp'];
    }

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'data' => $location
        ]));
}

}


