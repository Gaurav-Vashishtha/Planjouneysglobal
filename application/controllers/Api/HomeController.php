<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property Home_page_model $Home_page_model
 * @property Banner_model $Banner_model
 * @property Blog_model Blog_model
 * @property AdvertiesBanner_model $AdvertiesBanner_model
 * @property Video_model $Video_model
 * @property CI_Output $output
 */
class HomeController extends CI_Controller {

    public function __construct() {
        parent::__construct();
         $this->load->model('Home_page_model');
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
                    ? base_url('uploads/home/desire/' . $dp['image'])
                    : "";
            }
        }


        if (!empty($home->top_destinations)) {
            foreach ($home->top_destinations as &$td) {
                $td['image_url'] = !empty($td['image'])
                    ? base_url('uploads/home/top_destination/' . $td['image'])
                    : "";
            }
        }

        if (!empty($home->best_agencies)) {
            foreach ($home->best_agencies as &$ba) {
                $ba['image_url'] = !empty($ba['image'])
                    ? base_url('uploads/home/best_agency/' . $ba['image'])
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


public function get_bannner_list() {

    try {
        $banner = $this->Banner_model->get_all_active();

        if (!empty($banner)) {

            foreach ($banner as &$b) {
                $b->image_url = base_url('uploads/banner/' . $b->banners_image);
                $b->video_url = base_url('uploads/banner_video/' . $b->banner_video);

            }

            $response = [
                'status' => true,
                'message' => 'banner fetched successfully.',
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

    $this->output->set_output(json_encode($response));
}





public function get_banner($banner_name = null)
{
    if (empty($banner_name)) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'message' => 'Invalid banner name.'
            ]));
    }

    $banner = $this->Banner_model->banner_name($banner_name);

    if (!$banner) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'message' => 'Banner not found.'
            ]));
    }


    $banner->image_url = base_url('uploads/banner/' . $banner->banners_image);
    $banner->video_url = base_url('uploads/banner_video/' . $banner->banner_video);
    
    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'  => true,
            'message' => 'Banner details fetched successfully.',
            'data'    => $banner
        ]));
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


public function get_all_advertiesBanner()
{
    $banners = $this->AdvertiesBanner_model->get_all();

    $base_url = base_url(); 

    $result = [];

    foreach ($banners as $b) {
        $result[] = [


            'banner1' => !empty($b->banner1) ? $base_url . $b->banner1 : null,
            'banner2' => !empty($b->banner2) ? $base_url . $b->banner2 : null,

        ];
    }

    echo json_encode([
        'status' => true,
        'message' => 'Banners fetched successfully',
        'data' => $result
    ]);
}

}