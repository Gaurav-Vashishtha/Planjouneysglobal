<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property Package_model $Package_model
 * @property CI_Output $output
 * @property Location_model $Location_model
 * @property Currency_model $Currency_model
 * @property db $db
 */

class PackageController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Location_model');
        $this->load->model('Currency_model');
        $this->load->model('Package_model');
        $this->load->helper(['url', 'form', 'text']);
        $this->output->set_content_type('application/json');
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


    public function get_packages()
    {
        try {
            $packages = $this->Package_model->get_all_active();
            $rates    = $this->get_rates();

            foreach ($packages as &$pkg) {
                if (is_array($pkg)) {
                    $pkg = (object) $pkg;
                }

                $inrPrice = isset($pkg->price) ? (float) $pkg->price : 0;

                $pkg->price_inr      = $inrPrice;
                $pkg->price_usd      = $inrPrice * $rates['USD'];
                $pkg->price_aed      = $inrPrice * $rates['AED'];
                $pkg->rate_timestamp = $rates['timestamp'];
            }

            $response = [
                'status'  => true,
                'message' => 'Packages fetched successfully.',
                'data'    => $packages,
            ];
        } catch (Exception $e) {
            $response = [
                'status'  => false,
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }

        $this->output->set_output(json_encode($response));
    }

    public function get_package_by_slug($slug = null)
    {
        if (empty($slug)) {
            return $this->output->set_output(json_encode([
                'status'  => false,
                'message' => 'Invalid slug provided.',
            ]));
        }

        $package = $this->Package_model->get_by_slug($slug);
        if (!$package) {
            return $this->output->set_output(json_encode([
                'status'  => false,
                'message' => 'Package not found.',
            ]));
        }

        $rates = $this->get_rates();

        if (is_array($package)) {
            $package = (object) $package;
        }

        $inrPrice = isset($package->price) ? (float) $package->price : 0;

        $package->price_inr      = $inrPrice;
        $package->price_usd      = $inrPrice * $rates['USD'];
        $package->price_aed      = $inrPrice * $rates['AED'];
        $package->rate_timestamp = $rates['timestamp'];

        return $this->output->set_output(json_encode([
            'status' => true,
            'data'   => $package,
        ]));
    }

    public function get_popular_packages()
    {
        try {
            $packages = $this->Package_model->get_all_popular();
            $rates    = $this->get_rates();

            foreach ($packages as &$pkg) {
                if (is_array($pkg)) {
                    $pkg = (object) $pkg;
                }

                $inrPrice = isset($pkg->price) ? (float) $pkg->price : 0;

                $pkg->price_inr      = $inrPrice;
                $pkg->price_usd      = $inrPrice * $rates['USD'];
                $pkg->price_aed      = $inrPrice * $rates['AED'];
                $pkg->rate_timestamp = $rates['timestamp'];
            }

            $response = [
                'status'  => true,
                'message' => 'Popular Packages fetched successfully.',
                'data'    => $packages,
            ];
        } catch (Exception $e) {
            $response = [
                'status'  => false,
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }

        $this->output->set_output(json_encode($response));
    }


public function get_filtered_packages()
{
    try {
        $categories = $this->input->post('categories');   
        $location   = $this->input->post('location');   
        $sort       = $this->input->post('sort');         

        $packages = $this->Package_model->get_packages_filtered($categories, $location, $sort);

        $rates = $this->get_rates();

        foreach ($packages as &$pkg) {

            if (is_array($pkg)) {
                $pkg = (object) $pkg;
            }


            $inrPrice = isset($pkg->price) ? (float) $pkg->price : 0;


            $pkg->price_inr = $inrPrice;
            $pkg->price_usd = $inrPrice * $rates['USD'];
            $pkg->price_aed = $inrPrice * $rates['AED'];
            $pkg->rate_timestamp = $rates['timestamp']; 
        }

        $response = [
            'status'  => true,
            'message' => 'Filtered packages fetched successfully.',
            'data'    => $packages,
        ];

    } catch (Exception $e) {
        $response = [
            'status'  => false,
            'message' => 'Error: ' . $e->getMessage(),
        ];
    }

    $this->output->set_output(json_encode($response));
}

public function get_searched_packages()
{
    try {
        $search_term = $this->input->post('search_term');
        if (empty($search_term)) {
            $response = [
                'status'  => false,
                'message' => 'Search term is required.',
            ];
            $this->output->set_output(json_encode($response));
            return;
        }
        $rates = $this->get_rates();  

        $packages = $this->Package_model->search_popular_packages($search_term);
        foreach ($packages as &$pkg) {
            if (is_array($pkg)) {
                $pkg = (object) $pkg;
            }

            $inrPrice = isset($pkg->price) ? (float) $pkg->price : 0;

            $pkg->price_inr = $inrPrice;  
            $pkg->price_usd = $inrPrice * $rates['USD'];  
            $pkg->price_aed = $inrPrice * $rates['AED']; 

            $pkg->rate_timestamp = $rates['timestamp']; 
        }

        $response = [
            'status'  => true,
            'message' => 'Popular packages fetched successfully.',
            'data'    => $packages,
        ];

    } catch (Exception $e) {
       
        $response = [
            'status'  => false,
            'message' => 'Error: ' . $e->getMessage(),
        ];
    }

 
    $this->output->set_output(json_encode($response));
}

public function search_package_locations()
{
$location_name = $this->input->post('location_name') ?? $this->input->get('location_name') ?? null;

    $this->load->model('Location_model');
    $locations = $this->Location_model->get_locations_with_package_count($location_name);

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'data'   => $locations
        ]));
}

public function search_packages()
{
    $location_id = $this->input->post('location_id');
    $tour_type = $this->input->post('tour_type');

    if (empty($location_id) && empty($tour_type)) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'message' => 'At least one filter is required',
                'data' => []
            ]));
    }

    $this->load->model('Package_model');
    $packages = $this->Package_model->get_packages_search(
        $location_id,
        $tour_type
    );

    $rates = $this->get_rates(); 

    foreach ($packages as &$package) {
        $price = isset($package['price']) ? (float)$package['price'] : 0;
        $package['price_inr'] = $price;
        $package['price_usd'] = round($price * $rates['USD'], 2);
        $package['price_aed'] = round($price * $rates['AED'], 2);
        $package['rate_timestamp'] = $rates['timestamp'];
    }

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'data' => $packages
        ]));
}

public function get_domestic_packages()
{
    try {
        $packages = $this->Package_model->get_domestic_package();
        $data = array_map(function ($pkg) {
            if (is_object($pkg)) {
                $pkg = (array) $pkg;
            }
            return [
                'title' => $pkg['title'] ?? null,
                'slug'  => $pkg['slug'] ?? null,
            ];
        }, $packages);

        $response = [
            'status'  => true,
            'message' => 'Packages fetched successfully.',
            'data'    => $data,
        ];

    } catch (Exception $e) {
        $response = [
            'status'  => false,
            'message' => 'Error: ' . $e->getMessage(),
        ];
    }

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}



public function domestic_honeymoon_packages()
{
    try {
        $packages = $this->Package_model->get_domestic_honeymoon_package();
        $data = array_map(function ($pkg) {
            if (is_object($pkg)) {
                $pkg = (array) $pkg;
            }
            return [
                'title' => $pkg['title'] ?? null,
                'slug'  => $pkg['slug'] ?? null,
            ];
        }, $packages);

        $response = [
            'status'  => true,
            'message' => 'Packages fetched successfully.',
            'data'    => $data,
        ];

    } catch (Exception $e) {
        $response = [
            'status'  => false,
            'message' => 'Error: ' . $e->getMessage(),
        ];
    }

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}

public function get_package_by_location($location_id = null)
{
    if (empty($location_id)) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'message' => 'Invalid location ID.'
            ]));
    }

    $packages = $this->Package_model->get_by_location_id($location_id);

    if (empty($packages)) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'message' => 'No packages found for this location.'
            ]));
    }

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'  => true,
            'message' => 'Packages fetched successfully.',
            'data'    => $packages
        ]));
}

public function get_searched_packages_destination()
{
    try {
        $search_term = $this->input->post('search_term');
        if (empty($search_term)) {
            $response = [
                'status'  => false,
                'message' => 'Search term is required.',
            ];
            $this->output->set_output(json_encode($response));
            return;
        }
        $rates = $this->get_rates();  

        $result = $this->Package_model->search_packages_with_destination($search_term);

        foreach ($result['packages'] as &$pkg) {
            if (is_array($pkg)) {
                $pkg = (object) $pkg;
            }

            $inrPrice = isset($pkg->price) ? (float) $pkg->price : 0;
            $pkg->price_inr = $inrPrice;  
            $pkg->price_usd = $inrPrice * $rates['USD'];  
            $pkg->price_aed = $inrPrice * $rates['AED']; 
            $pkg->rate_timestamp = $rates['timestamp']; 
        }

        $response = [
            'status'  => true,
            'message' => 'Packages and locations fetched successfully.',
            'data'    => [
                'packages' => $result['packages'],
                'locations' => $result['locations']
            ],
        ];

    } catch (Exception $e) {
        $response = [
            'status'  => false,
            'message' => 'Error: ' . $e->getMessage(),
        ];
    }
    $this->output->set_output(json_encode($response));
}



}

