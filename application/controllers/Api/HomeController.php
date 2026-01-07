<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property Home_page_model $Home_page_model
 * @property Banner_model $Banner_model
 * @property Blog_model Blog_model
 * @property Tourguide_model $Tourguide_model
 * @property Testimonial_model $Testimonial_model
 * @property AdvertiesBanner_model $AdvertiesBanner_model
 * @property Video_model $Video_model
 * @property CI_Output $output
 */
class HomeController extends CI_Controller {

    public function __construct() {
        parent::__construct();
         $this->load->model('Home_page_model'); 
         $this->load->model('Testimonial_model');
         $this->load->model('Tourguide_model');
         $this->load->model('AdvertiesBanner_model');
         $this->load->model('Banner_model');
         $this->load->model('Video_model');
          $this->load->model('Blog_model');
        $this->load->helper(['url', 'text', 'form']);
        $this->output->set_content_type('application/json'); 
    }

    public function index(){
            $response = [
            'status' => false,
            'message' => 'Invalid API endpoint.'
        ];
        $this->output->set_output(json_encode($response));
    }


    public function get_home_page_data() {
    try {
        $home = $this->Home_page_model->get_home();

        if (!$home) {
            return $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'No home_page found.',
                'data' => []
            ]));
        }


        $home->desire_places = !empty($home->desire_places)
            ? json_decode($home->desire_places, true)
            : [];

        $home->top_destinations = !empty($home->top_destinations)
            ? json_decode($home->top_destinations, true)
            : [];

        $home->best_agencies = !empty($home->best_agencies)
            ? json_decode($home->best_agencies, true)
            : [];


        if (!empty($home->desire_places)) {
            foreach ($home->desire_places as &$dp) {
                $dp['image_url'] = !empty($dp['image'])
                    ? base_url('' . $dp['image'])
                    : "";
            }
        }


        if (!empty($home->top_destinations)) {
            foreach ($home->top_destinations as &$td) {
                $td['image_url'] = !empty($td['image'])
                    ? base_url('' . $td['image'])
                    : "";
            }
        }

        if (!empty($home->best_agencies)) {
            foreach ($home->best_agencies as &$ba) {
                $ba['image_url'] = !empty($ba['image'])
                    ? base_url('' . $ba['image'])
                    : "";
            }
        }


        $home->top_agency_image_url = !empty($home->top_agency_image)
            ? base_url('uploads/home/best_agency/' . $home->top_agency_image)
            : "";

     
        return $this->output->set_content_type('application/json')->set_output(json_encode([
            'status' => true,
            'message' => 'home_page fetched successfully.',
            'data' => $home
        ]));

    } catch (Exception $e) {
        return $this->output->set_output(json_encode([
            'status' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]));
    }
}

public function get_banner_list($section = null) {
    try {
        if ($section) {
            $banner = $this->Banner_model->get_all_active_by_section($section);
        } else {
            $banner = $this->Banner_model->get_all_active();
        }

        if (!empty($banner)) {
            foreach ($banner as &$b) {
                $b->image_url = base_url('uploads/banners/' . $b->banners_image);
                $b->video_url = base_url('uploads/banner_video/' . $b->banner_video);
            }

            $response = [
                'status' => true,
                'message' => 'Banners fetched successfully.',
                'data' => $banner
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'No banner found.',
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


public function get_video_list()
{
    try {
        $videos = $this->Video_model->get_all_active();

        if (!empty($videos)) {

            foreach ($videos as &$v) {
                $v->image_url = base_url('uploads/videos/' . $v->video);

            }

            $response = [
                'status' => true,
                'message' => 'videos fetched successfully.',
                'data' => $videos
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'No videos found.',
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


public function get_videos($video_name = null)
{
    if (empty($video_name)) {
        return $this->output->set_content_type('application/json')->set_output(json_encode([
            'status'  => false,
            'message' => 'Invalid video name.'
        ]));
    }

    $videos = $this->Video_model->video_name($video_name);

    if (!$videos) {
        return $this->output->set_content_type('application/json')->set_output(json_encode([
            'status'  => false,
            'message' => 'videos not found.'
        ]));
    }

    $videos->image_url = base_url('uploads/videos/' . $videos->video);


    return $this->output->set_content_type('application/json')->set_output(json_encode([
        'status'  => true,
        'message' => 'videos details fetched successfully.',
        'data'    => $videos
    ]));
}
public function get_blog_list() {

    try {
        $blogs = $this->Blog_model->get_all_active();

        if (!empty($blogs)) {

            foreach ($blogs as &$b) {
                $b->banner_image_url = base_url('uploads/blogs/' . $b->banner_image);
                $b->home_image_url = base_url('uploads/blogs/' . $b->home_image);

            }

            $response = [
                'status' => true,
                'message' => 'blogs fetched successfully.',
                'data' => $blogs
            ];

        } else {
            $response = [
                'status' => false,
                'message' => 'No blogs found.',
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


public function get_blog($slug = null)
{
    if (empty($slug)) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'message' => 'Invalid Blog slug.'
            ]));
    }

    $blog = $this->Blog_model->get_by_slug($slug);

    if (!$blog) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'message' => 'Blog not found.'
            ]));
    }

     $blog->banner_image_url = base_url('uploads/blogs/' . $blog->banner_image);
    $blog->home_image_url = base_url('uploads/blogs/' . $blog->home_image);

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'  => true,
            'message' => 'Blog details fetched successfully.',
            'data'    => $blog  
        ]));
}


public function get_popularBlog(){
        try {
        $blogs = $this->Blog_model->get_popular_blog();

        if (!empty($blogs)) {

            foreach ($blogs as &$b) {
                $b->banner_image_url = base_url('uploads/blogs/' . $b->banner_image);
                $b->home_image_url = base_url('uploads/blogs/' . $b->home_image);

            }

            $response = [
                'status' => true,
                'message' => 'blogs fetched successfully.',
                'data' => $blogs
            ];

        } else {
            $response = [
                'status' => false,
                'message' => 'No blogs found.',
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




public function get_all_advertiesBanner()
{
    $banners = $this->AdvertiesBanner_model->get_all();

    $base_url = base_url(); 

    $result = [];

    foreach ($banners as $b) {
        $result[] = [

              'link' =>  $b->link ? : null,
            'banner1' => !empty($b->banner1) ? $base_url . $b->banner1 : null,
            // 'banner2' => !empty($b->banner2) ? $base_url . $b->banner2 : null,

        ];
    }

    echo json_encode([
        'status' => true,
        'message' => 'Banners fetched successfully',
        'data' => $result
    ]);
}


public function get_tourguide()
{
    try {
        $tourguide = $this->Tourguide_model->get_all_active();
        
        if (!empty($tourguide)) {
            foreach ($tourguide as &$t) {
                if (isset($t->image)) {
                    $t->image_url = base_url('uploads/tourguide/' . $t->image);
                } else {
                    $t->image_url = null; 
                }
            }

            $response = [
                'status' => true,
                'message' => 'Tourguide fetched successfully.',
                'data' => $tourguide
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'No tourguide found.',
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

public function get_testimonial()
{
    try {
        $testimonial = $this->Testimonial_model->get_all_active();
        
        if (!empty($testimonial)) {
            foreach ($testimonial as &$t) {
                if (isset($t->image)) {
                    $t->image_url = base_url('uploads/testimonial/' . $t->image);
                } else {
                    $t->image_url = null; 
                }
            }

            $response = [
                'status' => true,
                'message' => 'Testimonial fetched successfully.',
                'data' => $testimonial
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'No Testimonial found.',
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


}