<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property Contact_model $Contact_model
 * @property Footer_model $Footer_model
 * @property Recent_experience_model $Recent_experience_model
 * @property About_model $About_model
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
        $this->load->model('Contact_model');
        $this->load->model('About_model');
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

  public function get_recent_experience() {
    $data = $this->Recent_experience_model->get_all();

    if(!empty($data)){
        // Loop through each experience to prepend base URL to images
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
    $about = $this->About_model->get_about(); 

    if (!empty($about)) {

        if (!empty($about->best_agency_image)) {
            $about->best_agency_image = base_url($about->best_agency_image);
        }

        $best_service = json_decode($about->about_best_service_places, true);
        if (!empty($best_service)) {
            foreach ($best_service as &$service) {
                if (!empty($service['image'])) {
                    $service['image'] = base_url($service['image']);
                }

                $service['heading'] = strip_tags($service['heading']);
                $service['description'] = strip_tags($service['description']);
            }
            $about->about_best_service_places = $best_service;
        }

        $best_agencies = json_decode($about->best_agencies, true);
        if (!empty($best_agencies)) {
            foreach ($best_agencies as &$agency) {
                if (!empty($agency['image'])) {
                    $agency['image'] = base_url($agency['image']);
                }
                $agency['heading'] = strip_tags($agency['heading']);
                $agency['paragraph'] = strip_tags($agency['paragraph']);
            }
            $about->best_agencies = $best_agencies;
        }

        $about->best_agency = strip_tags($about->best_agency);
        $about->behind_the_journey = strip_tags($about->behind_the_journey);
        $about->travel_with_us_des = strip_tags($about->travel_with_us_des);
        $about->here_it_from_travelrs = strip_tags($about->here_it_from_travelrs);

        echo json_encode([
            'status' => true,
            'data' => $about
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'About page not found.'
        ]);
    }
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

    if(!empty($data)){
        foreach($data as &$footer){
            if(!empty($footer->logo)){
                $footer->logo = base_url('uploads/footer/'.$footer->logo);
            }

            if(!empty($footer->section_image)){
                $footer->section_image = base_url('uploads/footer/'.$footer->section_image);
            }

            if(!empty($footer->additional_sections)){
                $sections = json_decode($footer->additional_sections, true);
                foreach($sections as &$section){
                    if(!empty($section['image'])){
                        $section['image'] = base_url('uploads/footer/'.$section['image']);
                    }
                }
                $footer->additional_sections = $sections;
            }
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



}