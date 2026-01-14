<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property Activity_model $Activity_model
 * @property CI_Output $output
 * @property Location_model $Location_model
 * @property Currency_model $Currency_model
 * @property db $db
 */

class ActivityController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Location_model');
        $this->load->model('Activity_model');
        $this->load->model('Currency_model'); 
        $this->load->helper(['url', 'text', 'form']);

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
            $rates = $this->get_rates();

            foreach ($activities as &$activity) {
                if (is_array($activity)) {
                    $activity = (object) $activity;
                }

                 if (!empty($activity->gallery)) {
                 $gallery = json_decode($activity->gallery, true);
                 if (is_array($gallery)) {
                    foreach ($gallery as &$img) {
                        if (!empty($img['image'])) {
                            $img['image'] = base_url($img['image']);
                        }
                    }
                    $activity->gallery = json_encode($gallery);
                }
            }

                $inrPrice = isset($activity->price) ? (float) $activity->price : 0;

                $activity->price_inr = $inrPrice;
                $activity->price_usd = $inrPrice * $rates['USD'];
                $activity->price_aed = $inrPrice * $rates['AED'];
                $activity->rate_timestamp = $rates['timestamp'];
            }

            $response = [
                'status' => true,
                'message' => 'Activities fetched successfully.',
                'data' => $activities
            ];
        } catch (Exception $e) {
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

        $activity = $this->Activity_model->get_by_slug($slug);

        if (!$activity) {
            return $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Activity not found.'
            ]));
        }

        if (is_array($activity)) {
            $activity = (object) $activity;
        }

         if (!empty($activity->gallery)) {
                $gallery = json_decode($activity->gallery, true);
                if (is_array($gallery)) {
                    foreach ($gallery as &$img) {
                        if (!empty($img['image'])) {
                            $img['image'] = base_url($img['image']);
                        }
                    }
                    $activity->gallery = json_encode($gallery);
                }
            }

        $rates = $this->get_rates();
        $inrPrice = isset($activity->price) ? (float) $activity->price : 0;

        $activity->price_inr = $inrPrice;
        $activity->price_usd = $inrPrice * $rates['USD'];
        $activity->price_aed = $inrPrice * $rates['AED'];
        $activity->rate_timestamp = $rates['timestamp'];

        return $this->output->set_output(json_encode([
            'status' => true,
            'data' => $activity
        ]));
    }

    public function get_filtered_activities()
{
    try {
        $input = json_decode($this->input->raw_input_stream, true);

        $categories = $input['categories'] ?? null;
        $locations  = $input['locations'] ?? null;
        $sort       = $input['sort'] ?? null;

        $rates = $this->get_rates();

        $activities = $this->Activity_model->get_activities_filtered($categories, $locations, $sort);

    
        foreach ($activities as &$activity) {
            $inrPrice = isset($activity->price) ? (float) $activity->price : 0;

            $activity->price_inr = $inrPrice;
            $activity->price_usd = $inrPrice * $rates['USD'];
            $activity->price_aed = $inrPrice * $rates['AED'];
            $activity->rate_timestamp = $rates['timestamp'];
        }

        $response = [
            'status'  => true,
            'message' => 'Filtered activities fetched successfully.',
            'data'    => $activities
        ];

    } catch (Exception $e) {
        $response = [
            'status'  => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }

    echo json_encode($response);
}

public function search_locations()
{
 $keyword = $this->input->post('keyword') ?? $this->input->get('keyword') ?? null;

    $this->load->model('Location_model');
    $locations = $this->Location_model->get_locations_with_activity_count($keyword);

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'data'   => $locations
        ]));
}

public function search_activities()
{
    $location_id    = $this->input->post('location_id');
    $activity_name  = $this->input->post('activity_names');

    if (empty($location_id) && empty($activity_name)) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'message' => 'At least one filter is required',
                'data'    => []
            ]));
    }

    $this->load->model('Activity_model');

    $activities = $this->Activity_model->get_activities_search(
        $location_id,
        $activity_name
    );

    if (empty($activities)) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'message' => 'No activies found for this location',
                'data'   => []
            ]));
    }

    $rates = $this->get_rates();

    foreach ($activities as &$activity) {
        $price = (float) $activity['price'];

        $activity['price_inr']  = $price;
        $activity['price_usd']  = round($price * $rates['USD'], 2);
        $activity['price_aed']  = round($price * $rates['AED'], 2);
        $activity['rate_timestamp'] = $rates['timestamp'];
    }

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'data'   => $activities
        ]));
}


public function search_activities_with_list()

{
 $keyword = $this->input->post('keyword') ?? $this->input->get('keyword') ?? null;

    $activities = $this->Activity_model->get_activities($keyword);

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'data'   => $activities
        ]));
}

public function get_searched_activities()
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
        $result = $this->Activity_model->search_activites_with_detail($search_term);
        if (!empty($result)) {
            foreach ($result as &$act) {
                if (is_array($act)) {
                    $act = (object) $act;
                }

                 if (!empty($activity->gallery)) {
                    $gallery = json_decode($activity->gallery, true);
                    if (is_array($gallery)) {
                    foreach ($gallery as &$img) {
                        if (!empty($img['image'])) {
                            $img['image'] = base_url($img['image']);
                        }
                    }
                    $activity->gallery = json_encode($gallery);
                }
            }
                $inrPrice = isset($act->price) ? (float) $act->price : 0;
                $act->price_inr = $inrPrice;  
                $act->price_usd = $inrPrice * $rates['USD'];  
                $act->price_aed = $inrPrice * $rates['AED']; 
                $act->rate_timestamp = $rates['timestamp']; 
            }

            $response = [
                'status'  => true,
                'message' => 'Activities fetched successfully.',
                'data'    => [
                    'activities' => $result
                ],
            ];
        } else {
            $response = [
                'status'  => false,
                'message' => 'No activities found for the given search term.',
            ];
        }

    } catch (Exception $e) {
        $response = [
            'status'  => false,
            'message' => 'Error: ' . $e->getMessage(),
        ];
    }

    $this->output->set_output(json_encode($response));
}



    public function get_popularActivities()
    {
        try {
            $activities = $this->Activity_model->get_popular_activities();
            $rates = $this->get_rates();

            foreach ($activities as &$activity) {
                if (is_array($activity)) {
                    $activity = (object) $activity;
                }

                 if (!empty($activity->gallery)) {
                    $gallery = json_decode($activity->gallery, true);
                    if (is_array($gallery)) {
                    foreach ($gallery as &$img) {
                        if (!empty($img['image'])) {
                            $img['image'] = base_url($img['image']);
                        }
                    }
                    $activity->gallery = json_encode($gallery);
                }
            }

                $inrPrice = isset($activity->price) ? (float) $activity->price : 0;

                $activity->price_inr = $inrPrice;
                $activity->price_usd = $inrPrice * $rates['USD'];
                $activity->price_aed = $inrPrice * $rates['AED'];
                $activity->rate_timestamp = $rates['timestamp'];
            }

            $response = 
            [
                'status' => true,
                'message' => 'Activities fetched successfully.',
                'data' => $activities
            ];
        } catch (Exception $e) {
            $response = [
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }

        $this->output->set_output(json_encode($response));
    }



public function get_relevant_activities($location_id = null, $exclude_activity_id = null)
{
    $location_id = (int) $location_id;
    $exclude_activity_id = (int) $exclude_activity_id;

    if ($location_id <= 0) {
        echo json_encode([
            'status'  => false,
            'message' => 'Location ID  is required.'
        ]);
        return;
    }
    $activities = $this->Activity_model->get_relevant_activities(
        $location_id,
        $exclude_activity_id
    );

     $rates = $this->get_rates();

            foreach ($activities as &$activity) {
                if (is_array($activity)) {
                    $activity = (object) $activity;
                }

                $inrPrice = isset($activity->price) ? (float) $activity->price : 0;

                $activity->price_inr = $inrPrice;
                $activity->price_usd = $inrPrice * $rates['USD'];
                $activity->price_aed = $inrPrice * $rates['AED'];
                $activity->rate_timestamp = $rates['timestamp'];
            }

    if (empty($activities)) {
        echo json_encode([
            'status'  => true,
            'message' => 'No relevant activities found.',
            'data'    => []
        ]);
        return;
    }

    echo json_encode([
        'status' => true,
        'data'   => $activities
    ]);
}


}
?>
