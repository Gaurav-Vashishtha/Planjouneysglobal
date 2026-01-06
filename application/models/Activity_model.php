<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_model extends CI_Model {

    protected $table = 'activities';

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

    public function get_by_activities_code($activities_code) {
        return $this->db->where('activities_code', $activities_code)->get($this->table)->row_array();
    }



    public function count_by_location($location_id)
    {
        return $this->db->where('location_id', $location_id)
                        ->count_all_results('activities');
    }


    public function get_activities_filtered($categories, $locations, $sort)
    {
        $this->db->select('activities.*, location.name as location_name');
        $this->db->from('activities');
        $this->db->join('location', 'location.id = activities.location_id', 'left');

        if (!empty($categories)) {
            if (!is_array($categories)) {
                $categories = explode(',', $categories);
            }

            $this->db->where_in('activities.category', $categories);
        }
        if (!empty($locations)) {
            if (!is_array($locations)) {
                $locations = explode(',', $locations);
            }

            $this->db->where_in('activities.location_id', $locations);
        }

        switch ($sort) {
            case 'price_asc':
                $this->db->order_by('activities.price', 'ASC');
                break;

            case 'price_desc':
                $this->db->order_by('activities.price', 'DESC');
                break;

            case 'latest':
                $this->db->order_by('activities.id', 'DESC');
                break;

            case 'oldest':
                $this->db->order_by('activities.id', 'ASC');
                break;

            default:
                $this->db->order_by('activities.id', 'DESC');
                break;
        }

        return $this->db->get()->result();
    }

 public function get_activities_search($location_id = null, $activity_names = null)
 {
    $this->db->select('*');
    $this->db->from('activities');
    $this->db->where('status', 1);

    if (!empty($location_id)) {
        $this->db->where('location_id', (int) $location_id);
    }

    if (!empty($activity_names)) {
        $this->db->where(
            "FIND_IN_SET(" .
            $this->db->escape(trim($activity_names)) .
            ", REPLACE(activity_names, ', ', ',')) !=", 
            0,
            false
        );
    }

    $this->db->order_by('created_at', 'DESC');

    return $this->db->get()->result_array();
 }



    public function get_by_category($category_id) {
        return $this->db
            ->where('category_id', $category_id)
            ->get('activities_name') 
            ->result();
    }


   public function get_activities($keyword = null)
    {
        $this->db->select('activity_name');
        $this->db->from('activities_name');
        $this->db->where('activity_name IS NOT NULL');

        if (!empty($keyword)) {
            $this->db->like('activity_name', $keyword);
        }

        $this->db->group_by('activity_name'); 
        $this->db->order_by('activity_name', 'ASC');
        $this->db->limit(10);   

        $query = $this->db->get();

        return array_column($query->result_array(), 'activity_name');
    }



}
