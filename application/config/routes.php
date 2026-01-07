<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'admin';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = FALSE;


$route['admin/login'] = 'admin/login';
$route['admin/logout'] = 'admin/logout';
$route['admin/dashboard'] = 'admin/dashboard';

$route['admin/change_password'] = 'admin/changePassword';

$route['admin/package'] = 'package/index';
$route['admin/package/create'] = 'package/create';
$route['admin/package/edit/(:num)'] = 'package/edit/$1';

$route['admin/package/view/(:num)'] = 'package/view/$1';
$route['admin/package/delete/(:num)'] = 'package/delete/$1';
$route['admin/package/toggle/(:num)'] = 'package/toggle/$1';
$route['admin/package/get_location/(:any)'] = 'package/get_locations_by_category/$1';



$route['admin/package/get_hotels_by_location/(:num)'] = 'package/get_hotels_by_location/$1';
$route['admin/package/search_countries'] = 'package/search_countries';
$route['admin/package/search_states']    = 'package/search_states';
$route['admin/package/search_cities']    = 'package/search_cities';




$route['admin/hotels'] = 'hotels/index';
$route['admin/hotels/create'] = 'hotels/create';
$route['admin/hotels/edit/(:num)'] = 'hotels/edit/$1';
$route['admin/hotels/view/(:num)'] = 'hotels/view/$1';
$route['admin/hotels/delete/(:num)'] = 'hotels/delete/$1';
$route['admin/hotels/toggle/(:num)'] = 'hotels/toggle/$1';

$route['admin/locations'] = 'location/index';
$route['admin/location/add'] = 'location/add';
$route['admin/location/edit/(:num)'] = 'location/edit/$1';
$route['admin/location/view/(:num)'] = 'location/view/$1';
$route['admin/location/delete/(:num)'] = 'location/delete/$1';
$route['admin/location/toggle/(:num)'] = 'location/toggle/$1';
$route['admin/location/search_countries'] = 'location/search_countries';
$route['admin/location/search_states']    = 'location/search_states';
$route['admin/location/search_cities']    = 'location/search_cities';
$route['admin/location/delete-gallery/(:num)/(:any)'] = 'location/delete_gallery_image/$1/$2';



$route['admin/bookings'] = 'Booking/index';
$route['admin/bookings/download'] = 'Booking/download';
$route['admin/package/download/(:num)'] = 'package/download_pdf/$1';

//blog
$route['admin/blog'] = 'blog/index';
$route['admin/blog/add'] = 'blog/add';
$route['admin/blog/edit/(:num)'] = 'blog/edit/$1';
$route['admin/blog/delete/(:num)'] = 'blog/delete/$1';


// home page 
$route['admin/home_page'] = 'homepage/index';
$route['admin/home_page/save'] = 'homepage/save';
$route['admin/home_page/edit/(:num)'] = 'homepage/edit/$1';

//AdvertiesBanner
$route['admin/adverties_banner'] = 'advertiesBanner/index';
$route['admin/adverties_banner/create'] = 'advertiesBanner/create';
$route['admin/adverties_banner/save'] = 'advertiesBanner/save';
$route['admin/adverties_banner/edit/(:num)'] = 'advertiesBanner/edit/$1';
$route['admin/adverties_banner/update/(:num)'] = 'advertiesBanner/update/$1';
$route['admin/adverties_banner/delete/(:num)'] = 'advertiesBanner/delete/$1';


//Poster
$route['admin/poster'] = 'poster/index';
$route['admin/poster/create'] = 'poster/create';
$route['admin/poster/save'] = 'poster/save';
$route['admin/poster/edit/(:num)'] = 'poster/edit/$1';
$route['admin/poster/update/(:num)'] = 'poster/update/$1';
$route['admin/poster/delete/(:num)'] = 'poster/delete/$1';


//Banner
$route['admin/banner']                 = 'banner/index';
$route['admin/banner/add']             = 'banner/add';
$route['admin/banner/save_add']        = 'banner/save_add';
$route['admin/banner/edit/(:num)']     = 'banner/edit/$1';
$route['admin/banner/save_edit/(:num)']= 'banner/save_edit/$1';
$route['admin/banner/delete/(:num)']   = 'banner/delete/$1';

//video

$route['admin/video'] = 'video/index';       
$route['admin/video/add'] = 'video/add';     
$route['admin/video/edit/(:num)'] = 'video/edit/$1'; 
$route['admin/video/delete/(:num)'] = 'video/delete/$1'; 

//Activites
$route['admin/activities'] = 'activity/index';
$route['admin/activities/create'] = 'activity/create';
$route['admin/activities/edit/(:num)'] = 'activity/edit/$1';

$route['admin/activities/view/(:num)'] = 'activity/view/$1';
$route['admin/activities/delete/(:num)'] = 'activity/delete/$1';
$route['admin/activities/toggle/(:num)'] = 'activity/toggle/$1';
$route['admin/activities/get_location/(:any)'] = 'activity/get_locations_by_category/$1';
$route['admin/activities/get_activities_by_category/(:num)'] = 'activity/get_activities_by_category/$1';

//Pages

$route['admin/about_us'] = 'about/index';                 
$route['admin/about_us/save'] = 'about/save';             
$route['admin/about_us/edit(:num)'] = 'about/edit/$1';
   
//Contact

$route['admin/contact'] = 'contact/index';              
$route['admin/contact/save'] = 'contact/save';          
$route['admin/contact/edit/(:num)'] = 'contact/edit/$1'; 

//Footer

$route['admin/footer'] = 'footer/index';        
$route['admin/footer/save'] = 'footer/save';      
$route['admin/footer/edit/(:num)'] = 'footer/edit/$1';  

// Recent Customer Experience
$route['admin/recent_experience'] = 'recent_experience/index';
$route['admin/recent_experience/save'] = 'recent_experience/save';
$route['admin/recent_experience/save/(:num)'] = 'recent_experience/save/$1';
$route['admin/recent_experience/edit/(:num)'] = 'recent_experience/edit/$1';
$route['admin/recent_experience/delete/(:num)'] = 'recent_experience/delete/$1';


//testimonial
 
$route['admin/testimonial'] = 'testimonial/index';
$route['admin/testimonial/add'] = 'testimonial/add';
$route['admin/testimonial/save_add'] = 'testimonial/save_add';
$route['admin/testimonial/edit/(:num)'] = 'testimonial/edit/$1';
$route['admin/testimonial/save_edit/(:num)'] = 'testimonial/save_edit/$1';
$route['admin/testimonial/delete/(:num)'] = 'testimonial/delete/$1';
 
//tourguide
 
 
$route['admin/tourguide'] = 'tourguide/index';
$route['admin/tourguide/add'] = 'tourguide/add';
$route['admin/tourguide/save_add'] = 'tourguide/save_add';
$route['admin/tourguide/edit/(:num)'] = 'tourguide/edit/$1';
$route['admin/tourguide/save_edit/(:num)'] = 'tourguide/save_edit/$1';
$route['admin/tourguide/delete/(:num)'] = 'tourguide/delete/$1';


// Visadetails Routes
$route['admin/visadetails'] = 'visaDetails/index';
$route['admin/visadetails/add'] = 'visaDetails/add';
$route['admin/visadetails/save_add'] = 'visaDetails/save_add';
$route['admin/visadetails/edit/(:num)'] = 'visaDetails/edit/$1';
$route['admin/visadetails/update/(:num)'] = 'visaDetails/update/$1';
$route['admin/visadetails/delete/(:num)'] = 'visaDetails/delete/$1';


$route['admin/visalistdetail'] = 'visaDetails/index_visa';
$route['admin/visa_package/add'] = 'visaDetails/visa_package_add';
$route['admin/visa_package/save'] = 'visaDetails/visa_package_save';
$route['admin/visa_package/edit/(:num)'] = 'visaDetails/visa_package_edit/$1';
$route['admin/visa_package/update/(:num)'] = 'visaDetails/visa_package_update/$1';
$route['admin/visa_package/delete/(:num)'] = 'visaDetails/visa_package_delete/$1';

//currency 
$route['admin/currency'] = 'currency/index';
$route['admin/currency/update'] = 'currency/update';

//APIs

// locations
$route['api/locations/list']['get'] = 'Api/LocationsController/get_locations';
$route['api/locations/(:any)']['get'] = 'Api/LocationsController/get_location_details/$1';
$route['api/location/full/(:any)']['get'] = 'Api/LocationsController/get_location/$1';
$route['api/locations/byCategory/(:any)']['get'] = 'Api/LocationsController/get_locationsByCategory/$1';
$route['api/top_destionations']['get'] = 'Api/LocationsController/get_top_destinations';
$route['api/popularlocations/byCategory/(:any)']['get'] = 'Api/LocationsController/get_popularlocationsByCategory/$1';



// for all
$route['api/tour-packages']['get'] = 'Api/PackageController/get_packages';
$route['api/tour-packages/(:any)']['get'] = 'Api/PackageController/get_package/$1';
$route['api/package/(:any)']['get'] = 'Api/PackageController/get_package_by_slug/$1';
$route['api/popular_Packages']['get'] = 'Api/PackageController/get_popular_packages';
$route['api/domestic_packages']['get'] = 'Api/PackageController/get_domestic_packages';
$route['api/domestic_honeymoon_packages']['get'] = 'Api/PackageController/domestic_honeymoon_packages';
$route['api/packages_by_location/(:any)']['get'] = 'Api/PackageController/get_package_by_location/$1';





 // Register
$route['api/userRegistration']['post']       = 'Api/UserController'; 
// reset password
$route['api/user/change_password']['post'] = 'Api/UserController/change_password';


 // Login
$route['api/user/login']['post'] = 'Api/UserController/login'; 


// Booking API
$route['api/booking']['post'] = 'Api/BookingController/index';

// Contact_Us API
$route['api/contact_us']['post'] = 'Api/BookingController/contact_us_form';
$route['api/visa_form']['post'] = 'Api/BookingController/visa_form_sumbit';



//home page 

$route['api/home_page']['get'] = 'Api/HomeController/get_home_page_data';
$route['api/home_page/banners/(:any)'] = 'Api/HomeController/get_banner_list/$1';
$route['api/home_page/videos']['get'] = 'Api/HomeController/get_video_list';
$route['api/home_page/video_detail/(:any)']['get'] = 'Api/HomeController/get_videos/$1';
$route['api/blogs']['get'] = 'Api/HomeController/get_blog_list';
$route['api/blog_detail/(:any)']['get'] = 'Api/HomeController/get_blog/$1';
$route['api/popular_blogs']['get'] = 'Api/HomeController/get_popularBlog';
$route['api/advertiesBanner']['get'] = 'Api/HomeController/get_all_advertiesBanner';


//Activity

$route['api/activities']['get'] = 'Api/ActivityController/get_activities';
$route['api/activity/(:any)']['get'] = 'Api/ActivityController/get_activity_by_slug/$1';
$route['api/popular_activities']['get'] = 'Api/ActivityController/get_popularActivities';



// Pages
$route['api/recent_experience']['get'] = 'Api/PagesConroller/get_recent_experience';
$route['api/about_page']['get'] = 'Api/PagesConroller/get_about_page';
$route['api/contact_page']['get'] = 'Api/PagesConroller/get_contact_page';
$route['api/footer_page']['get'] = 'Api/PagesConroller/get_footer_page';

//Testimonial Api
$route['api/tourguide']['get'] = 'Api/HomeController/get_tourguide';

//tourguide Api
$route['api/testimonial']['get'] = 'Api/HomeController/get_testimonial';

//filter for packages
$route['api/destinationwithcount']['get'] = 'Api/LocationsController/get_location_groups_with_package_count';
$route['api/packages/filter']['post']  = 'Api/PackageController/get_filtered_packages';


//filter for activities 
$route['api/destinationwithcountingactivity'] = 'Api/LocationsController/get_location_groups_with_activity_count';
$route['api/activities/filter']['post']  = 'Api/ActivityController/get_filtered_activities';


//visa
$route['api/visa_list']['get'] = 'Api/PagesConroller/get_visa_list';
$route['api/visa_detail/(:any)']['get'] = 'Api/PagesConroller/get_visa_detail/$1';
$route['api/visa_list_detail']['get'] = 'Api/PagesConroller/get_visa_detail_list';




//Searchbox apis
$route['api/search_packages']['post'] = 'Api/PackageController/get_searched_packages';
$route['api/search_visas']['post'] = 'Api/PagesConroller/search_visa';
$route['api/search_activities_with_value']['post'] = 'Api/ActivityController/search_activities';
$route['api/search_packages_with_value']['post'] = 'Api/PackageController/search_packages';


//Searchbox dropdown
$route['api/search_location']['post'] = 'Api/ActivityController/search_locations';
$route['api/search_packagelocation']['post'] = 'Api/PackageController/search_package_locations';
$route['api/search_visa_country']['post'] = 'Api/PagesConroller/search_visa_countries';

$route['api/search_activity_list_dropdown']['post'] = 'Api/ActivityController/search_activities_with_list';




$route['api/search_detination_with_package']['post'] = 'Api/LocationsController/searched_destination';




// search filter

$route['api/search_packages_destinations']['post'] = 'Api/PackageController/get_searched_packages_destination';
$route['api/search_activities']['post'] = 'Api/ActivityController/get_searched_activities';






