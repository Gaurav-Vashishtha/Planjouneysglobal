<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property Contact_model $Contact_model
 * @property Footer_model $Footer_model
 * @property Recent_experience_model $Recent_experience_model
 * @property About_model $About_model
 * @property Currency_model $Currency_model
 * @property Visa_model $Visa_model
 * @property CI_Output $output
 * @property Location_model $Location_model
 * @property db $db
 */
class PagesConroller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Recent_experience_model');
        $this->load->model('Footer_model');
        $this->load->model('Visa_model');
        $this->load->model('Contact_model');
        $this->load->model('Currency_model');
        $this->load->model('About_model');
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

  public function get_recent_experience() {
    $data = $this->Recent_experience_model->get_all();

    if(!empty($data)){
        foreach($data as &$exp){
            if(!empty($exp->images)){
                $images = json_decode($exp->images, true);
                $full_urls = [];
                if($images){
                    foreach($images as $img){
                        $full_urls[] = base_url('uploads/recent_experience/'.$img);
                    }
                }
                $exp->images = $full_urls;
            } else {
                $exp->images = [];
            }
        }

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'No recent experiences found.'
        ]);
    }
}

public function get_about_page()
{
    header('Content-Type: application/json; charset=utf-8');

    $about = $this->About_model->get_about(); 

    if (!$about) {
        echo json_encode([
            'status' => false,
            'message' => 'About page not found.'
        ]);
        return;
    }

    function full_url($path) {
        return !empty($path) ? base_url(ltrim($path, '/')) : '';
    }

    $about->best_agency_main_image = full_url($about->best_agency_main_image ?? '');

    $best_service = json_decode($about->about_best_service_places, true);
    if (!empty($best_service)) {
        foreach ($best_service as &$service) {
            $service['image']       = full_url($service['image'] ?? '');
            $service['heading']     = strip_tags($service['heading'] ?? '');
            $service['description'] = strip_tags($service['description'] ?? '');
        }
        $about->about_best_service_places = $best_service;
    } else {
        $about->about_best_service_places = [];
    }

    $best_agencies = json_decode($about->best_agencies, true);
    if (!empty($best_agencies)) {
        foreach ($best_agencies as &$agency) {
            $agency['image']     = full_url($agency['image'] ?? '');
            $agency['heading']   = strip_tags($agency['heading'] ?? '');
            $agency['paragraph'] = strip_tags($agency['paragraph'] ?? '');
        }
        $about->best_agencies = $best_agencies;
    } else {
        $about->best_agencies = [];
    }

    $travel_with_us = json_decode($about->travel_with_us, true);
    if (!empty($travel_with_us)) {
        foreach ($travel_with_us as &$item) {
            $item['image']     = full_url($item['image'] ?? '');
            $item['paragraph'] = strip_tags($item['paragraph'] ?? '');
        }
        $about->travel_with_us = $travel_with_us;
    } else {
        $about->travel_with_us = [];
    }

    $about_team_members = json_decode($about->about_team_members, true);
    if (!empty($about_team_members)) {
        foreach ($about_team_members as &$team) {
            $team['image']       = full_url($team['image'] ?? '');
            $team['name']        = strip_tags($team['name'] ?? '');
            $team['degination']  = strip_tags($team['degination'] ?? '');
            $team['number']      = strip_tags($team['number'] ?? '');
            $team['email']       = strip_tags($team['email'] ?? '');
        }
        $about->about_team_members = $about_team_members;
    } else {
        $about->about_team_members = [];
    }

    $about->best_agency              = strip_tags($about->best_agency ?? '');
    $about->travel_with_us_des       = strip_tags($about->travel_with_us_des ?? '');
    $about->here_it_from_travelrs    = strip_tags($about->here_it_from_travelrs ?? '');

    echo json_encode([
        'status' => true,
        'data'   => $about
    ]);
}




public function get_contact_page() {
    $data = $this->Contact_model->get_contacts(); 

    if(!empty($data)){
        foreach($data as &$contact){

            if(!empty($contact->image)){
                $contact->image = base_url('uploads/contact/'.$contact->image);
            }

            if(!empty($contact->sections)){
                $sections = json_decode($contact->sections, true);
                foreach($sections as &$section){
                    if(!empty($section['image'])){
                        $section['image'] = base_url('uploads/contact_sections/'.$section['image']);
                    }
                }
                $contact->sections = $sections;
            }
        }

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'No contact page found.'
        ]);
    }
}
public function get_footer_page() {
    $data = $this->Footer_model->get_footer();

    if (!empty($data)) {

        if (!empty($data->logo)) {
            $data->logo = base_url('uploads/footer/' . $data->logo);
        }

        if (!empty($data->section_image)) {
            $data->section_image = base_url('uploads/footer/' . $data->section_image);
        }

        if (!empty($data->additional_sections)) {
            $sections = json_decode($data->additional_sections, true);

            foreach ($sections as &$sec) {
                if (!empty($sec['image'])) {
                    $sec['image'] = base_url('uploads/footer/' . $sec['image']);
                }
            }

            $data->additional_sections = $sections;
        }

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);

    } else {

        echo json_encode([
            'status' => false,
            'message' => 'No footer page found.'
        ]);

    }
}


public function get_visa_list() {

    try {
        $visa = $this->Visa_model->get_all_active();

        if (!empty($visa)) {

            $filtered_visa = [];

            foreach ($visa as $v) {

                $image_url = base_url($v->image); 
                $filtered_visa[] = [
                    'id' => $v->id,
                    'country_name' => $v->country_name,
                    'slug' => $v->slug,
                    'processing_time' => $v->processing_time,
                    'image' => $image_url
                ];
            }

            $response = [
                'status' => true,
                'message' => 'visa fetched successfully.',
                'data' => $filtered_visa
            ];

        } else {
            $response = [
                'status' => false,
                'message' => 'No visa found.',
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


public function get_popular_visa() {

    try {
        $visa = $this->Visa_model->get_popular_visa();

        if (!empty($visa)) {

            $filtered_visa = [];

            foreach ($visa as $v) {

                $image_url = base_url($v->image); 
                $filtered_visa[] = [
                    'id' => $v->id,
                    'country_name' => $v->country_name,
                    'slug' => $v->slug,
                    'processing_time' => $v->processing_time,
                    'image' => $image_url
                ];
            }

            $response = [
                'status' => true,
                'message' => 'visa fetched successfully.',
                'data' => $filtered_visa
            ];

        } else {
            $response = [
                'status' => false,
                'message' => 'No visa found.',
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

// public function get_visa_detail($slug = null)
// {
//     $this->output->set_content_type('application/json');

//     if (empty($slug)) {
//         return $this->output
//             ->set_status_header(400)
//             ->set_output(json_encode([
//                 'status' => false,
//                 'code'   => 400,
//                 'message'=> 'Invalid visa slug.',
//                 'data'   => null
//             ]));
//     }

//     $visa = $this->Visa_model->get_by_slug($slug);

//     if (empty($visa) || !is_array($visa)) {
//         return $this->output
//             ->set_status_header(404)
//             ->set_output(json_encode([
//                 'status' => false,
//                 'code'   => 404,
//                 'message'=> 'Visa not found.',
//                 'data'   => null
//             ]));
//     }

//     try {
//         $rates = $this->get_rates();

//         $visa['visa_categories'] = !empty($visa['visa_categories'])
//             ? json_decode($visa['visa_categories'], true)
//             : [];

//         if (!is_array($visa['visa_categories'])) {
//             $visa['visa_categories'] = [];
//         }

//         foreach ($visa['visa_categories'] as &$category) {

//             $inrPrice = isset($category['price']) && is_numeric($category['price'])
//                 ? (float)$category['price']
//                 : 0;

//             $category['price_inr'] = round($inrPrice, 2);
//             $category['price_usd'] = round($inrPrice * ($rates['USD'] ?? 0), 2);
//             $category['price_aed'] = round($inrPrice * ($rates['AED'] ?? 0), 2);
//             $category['rate_timestamp'] = $rates['timestamp'] ?? null;
//         }
//         unset($category);

//         return $this->output
//             ->set_status_header(200)
//             ->set_output(json_encode([
//                 'status'  => true,
//                 'code'    => 200,
//                 'message' => 'Visa details fetched successfully.',
//                 'data'    => $visa
//             ]));

//     } catch (Exception $e) {

//         log_message('error', 'Visa API Error: ' . $e->getMessage());

//         return $this->output
//             ->set_status_header(500)
//             ->set_output(json_encode([
//                 'status' => false,
//                 'code'   => 500,
//                 'message'=> 'Internal server error.',
//                 'data'   => null
//             ]));
//     }
// }
public function get_visa_detail($slug = null)
{
    $this->output->set_content_type('application/json');

    if (empty($slug)) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Invalid visa slug.',
                'data'    => null
            ]));
    }

    $visa = $this->Visa_model->get_by_slug($slug);

    if (empty($visa) || !is_array($visa)) {
        return $this->output
            ->set_status_header(404)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 404,
                'message' => 'Visa not found.',
                'data'    => null
            ]));
    }

    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Visa details fetched successfully.',
            'data'    => $visa
        ]));
}

public function get_visa_detail_list() {

    try {
        $visa_packages = $this->Visa_model->get_all_visa();

        if (!empty($visa_packages)) {

            $filtered_visa = [];

            foreach ($visa_packages as $v_p) {

                $image2_url = !empty($v_p->image_2)
                    ? base_url($v_p->image_2)
                    : null;

                $agencies = json_decode($v_p->visa_agencies, true) ?? [];
                $process  = json_decode($v_p->working_process, true) ?? [];
                $faq      = json_decode($v_p->faq, true) ?? [];

                foreach ($agencies as &$agency) {
                    if (!empty($agency['image'])) {
                        $agency['image'] = base_url($agency['image']);
                    }
                }

                $filtered_visa[] = [
                    'id' => $v_p->id,
                    'heading' => $v_p->heading,
                    'sub_title' => $v_p->sub_title,
                    'link' => $v_p->link,
                    'agency_heading' => $v_p->agency_heading,
                    'image_2' => $image2_url,
                    'visa_agencies' => $agencies,
                    'working_process_head' => $v_p->working_process_head,
                    'working_process_link' => $v_p->working_process_link,
                    'working_process_mail' => $v_p->working_process_mail,
                    'working_process' => $process,
                    'faq' => $faq,
                    'status' => $v_p->status
                ];
            }

            $response = [
                'status' => true,
                'message' => 'Visa list details fetched successfully.',
                'data' => $filtered_visa
            ];

        } else {

            $response = [
                'status' => false,
                'message' => 'No Visa list details found.',
                'data' => []
            ];
        }

    } catch (Exception $e) {
        $response = [
            'status' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }

    $this->output->set_content_type('application/json')->set_output(json_encode($response));
}


public function search_visa_countries()
{
    $country_name = trim(
        $this->input->post('country_name') ??
        $this->input->get('country_name') ??
        ''
    );

    $this->load->model('Visa_model');

    $countries = $this->Visa_model->get_visa_countries($country_name);

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'data'   => $countries
        ]));
}


// public function search_visa()
// {
//     $country_name  = trim($this->input->post('country_name'));
//     // $visa_category = trim($this->input->post('visa_category'));

//     if (empty($country_name)) {
//         return $this->output
//             ->set_content_type('application/json')
//             ->set_output(json_encode([
//                 'status'  => false,
//                 'message' => 'At least one filter is required',
//                 'data'    => []
//             ]));
//     }

//     $this->load->model('Visa_model');

//     $visas = $this->Visa_model->get_visas_search($country_name);

//     $rates = $this->get_rates();

//     $filtered = [];

//     foreach ($visas as $visa) {

//         $categories = json_decode($visa['visa_categories'], true);
//         if (!is_array($categories)) {
//             continue;
//         }

//         $matchedCategories = [];

//         foreach ($categories as $cat) {

//             if (!empty($visa_category) &&
//                 strcasecmp(trim($cat['name']), $visa_category) !== 0) {
//                 continue;
//             }

//             $price = (float)($cat['price'] ?? 0);

//             $cat['price_inr'] = $price;
//             $cat['price_usd'] = round($price * $rates['USD'], 2);
//             $cat['price_aed'] = round($price * $rates['AED'], 2);
//             $cat['rate_timestamp'] = $rates['timestamp'];

//             $matchedCategories[] = $cat;
//         }

//         if (!empty($matchedCategories)) {
//             $visa['visa_categories'] = $matchedCategories;
//             $filtered[] = $visa;
//         }
//         if (empty($filtered)) {
//             return $this->output
//                 ->set_content_type('application/json')
//                 ->set_output(json_encode([
//                     'status' => false,
//                     'message' => 'No visa categories found for this country',
//                     'data' => []
//                 ]));
//         }
//     }

//     return $this->output
//         ->set_content_type('application/json')
//         ->set_output(json_encode([
//             'status' => true,
//             'data'   => $filtered
//         ]));
// }
public function search_visa()
{
    $country_name = trim($this->input->post('country_name'));

    if (empty($country_name)) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'message' => 'Country name is required',
                'data'    => []
            ]));
    }

    $this->load->model('Visa_model');

    $visas = $this->Visa_model->get_visas_search($country_name);

    if (empty($visas)) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'message' => 'No visa details found for this country',
                'data'    => []
            ]));
    }

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'data'   => $visas
        ]));
}


}