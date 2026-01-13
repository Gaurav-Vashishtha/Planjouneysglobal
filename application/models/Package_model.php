<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package_model extends CI_Model {

    protected $table = 'packages';

    public function __construct() {
        parent::__construct();
    }

 public function get_all($limit = null, $offset = null, $filters = []) {
    $this->db->from($this->table);

    if (!empty($filters['category'])) $this->db->where('category', $filters['category']);
    if (isset($filters['status']) && $filters['status'] !== '') $this->db->where('status', (int)$filters['status']);
    if (!empty($filters['search'])) {
        $this->db->group_start();
        $this->db->like('title', $filters['search']);
        $this->db->or_like('short_description', $filters['search']);
        $this->db->group_end();
    }

    $this->db->order_by('created_at', 'DESC');
    if ($limit !== null) $this->db->limit((int)$limit, (int)$offset);

    return $this->db->get()->result(); 
}


    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => (int)$id])->row();
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', (int)$id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }

    public function toggle_status($id) {
        $pkg = $this->get_by_id($id);
        if (!$pkg) return false;
        $new = $pkg->status ? 0 : 1;   
        return $this->update($id, ['status' => $new]);
    }

    public function slug_exists($slug) {
        return (bool)$this->db->get_where($this->table, ['slug' => $slug])->num_rows();
    }

    public function make_unique_slug($title) {
        $this->load->helper('url');
        $slug = url_title($title, '-', TRUE);
        $base = $slug;
        $i = 1;
        while ($this->slug_exists($slug)) {
            $slug = $base . '-' . $i;
            $i++;
        }
        return $slug;
    }

    public function get_all_active() {
        return $this->db->where('status', 1)
                        ->order_by('id', 'DESC')
                        ->get($this->table)
                        ->result_array();
    }

    public function get_by_slug($slug) {
        return $this->db->where('slug', $slug)->get($this->table)->row_array();
    }

    public function get_by_package_code($package_code) {
        return $this->db->where('package_code', $package_code)->get($this->table)->row_array();
    }

    public function get_all_popular()
{
    return $this->db->where('popular', 1)
                    ->where('status', 1) 
                    ->order_by('id', 'DESC')
                    ->get($this->table)
                    ->result_array();
}

public function count_by_location($location_id)
{
    return $this->db->where('location_id', $location_id)
                    ->count_all_results('packages');
}
public function get_packages_filtered($categories, $locations, $sort)
{
    $this->db->select('packages.*, location.name as location_name');
    $this->db->from('packages');
    $this->db->join('location', 'location.id = packages.location_id', 'left');

    if (!empty($categories)) {

        if (!is_array($categories)) {
            $categories = explode(',', $categories);
        }

        $this->db->where_in('packages.category', $categories);
    }

    if (!empty($locations)) {

        if (!is_array($locations)) {
            $locations = explode(',', $locations);
        }

        $this->db->where_in('packages.location_id', $locations);
    }

    switch ($sort) {
        case 'price_asc':
            $this->db->order_by('packages.price', 'ASC');
            break;

        case 'price_desc':
            $this->db->order_by('packages.price', 'DESC');
            break;

        case 'latest':
            $this->db->order_by('packages.id', 'DESC');
            break;

        case 'oldest':
            $this->db->order_by('packages.id', 'ASC');
            break;

        default:
            $this->db->order_by('packages.id', 'DESC');
            break;
    }

    return $this->db->get()->result();
}


public function search_popular_packages($search_term)
{
    $columns = $this->db->list_fields('packages');
    $this->db->group_start();
    foreach ($columns as $column) {
        $this->db->or_like($column, $search_term);
    }
    $this->db->group_end();
    $this->db->where('status', 1);
    $this->db->where('popular', 1);
    

    $this->db->order_by('id', 'DESC');

    return $this->db->get('packages')->result_array();
}

public function get_packages_search($location_id = null, $tour_type = null)
{
    $this->db->select('*');
    $this->db->from('packages');
    $this->db->where('status', 1);

    if (!empty($location_id)) {
        $this->db->where('location_id', (int)$location_id);
    }

    if (!empty($tour_type)) {
        $this->db->like('tour_type', '"' . trim($tour_type) . '"');
    }

    $this->db->order_by('created_at', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
}



public function get_domestic_package()
{
    return $this->db
        ->where('category', 'domestic')
        ->where('status', 1)
        ->order_by('id', 'DESC')
        ->get($this->table)
        ->result_array();
}

public function get_domestic_honeymoon_package()
{
    return $this->db
        ->where('category', 'domestic')
        ->like('tour_type', '"Honeymoon"')
        ->where('status', 1)
        ->order_by('id', 'DESC')
        ->get($this->table)
        ->result_array();
}


public function get_by_location_id($location_id)
{
    return $this->db
        ->select('title, slug, image, duration, price')
        ->where('location_id', $location_id)
        ->where('status', 1) 
        ->get('packages')
        ->result_array();
}


public function search_packages_with_destination($search_term)
{
    $search_term = trim($search_term);

    $packages = [];
    $locations = [];
    $this->db->select('*');
    $this->db->from('packages');
    $this->db->group_start();
    $this->db->like('title', $search_term); 
    $this->db->or_like('description', $search_term); 
    $this->db->group_end();
    $this->db->where('status', 1);  
    $this->db->order_by('id', 'DESC'); 
    $packages = $this->db->get()->result_array();

    $this->db->select('*');
    $this->db->from('location');
    $this->db->like('name', $search_term); 
    $this->db->where('status', 1); 
    $locations = $this->db->get()->result_array();

    return [
        'packages' => $packages,
        'locations' => $locations
    ];
}


public function get_related_packages($location_id, $exclude_package_id, $limit = 8)
{
    return $this->db
        ->select('title, slug, image, duration, price')
        ->where('location_id', $location_id)
        ->where('id !=', $exclude_package_id)
        ->where('status', 1)
        ->limit($limit)
        ->get('packages')
        ->result_array();
}



}
