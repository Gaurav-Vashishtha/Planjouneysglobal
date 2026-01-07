<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location_model extends CI_Model
{

    protected $table = 'location';

    public function get_all()
    {
        return $this->db->order_by('id', 'DESC')->get($this->table)->result();
    }

    public function get($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    public function toggle_status($id)
    {
        $loc = $this->get($id);
        if ($loc) {
            $new_status = $loc->status ? 0 : 1;
            $this->update($id, ['status' => $new_status]);
        }
    }
    public function slug_exists($slug)
    {
        return (bool)$this->db->get_where($this->table, ['slug' => $slug])->num_rows();
    }

    public function make_unique_slug($name)
    {
        $this->load->helper('url');
        $slug = url_title($name, '-', TRUE);
        $base = $slug;
        $i = 1;

        while ($this->slug_exists($slug)) {
            $slug = $base . '-' . $i;
            $i++;
        }

        return $slug;
    }
    public function get_all_active()
    {
        return $this->db->where('status', 1)
            ->order_by('id', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get('location')->row_array();
    }


    public function get_by_slug($slug)
    {
        return $this->db->where('slug', $slug)->get($this->table)->row_array();
    }

    public function get_by_category($category)
    {
        return $this->db->where('category', $category)
            ->where('status', 1)
            ->order_by('name', 'ASC')
            ->get('location')
            ->result();
    }

  public function getByCategory($category)
    {
        return $this->db->where('category', $category)
            ->where('status', 1)
          ->order_by('id', 'DESC')
            ->get($this->table)
            ->result();
    }
        public function get_all_top_destinations()
    {
        return $this->db->where('top_destination', 1)
            ->order_by('id', 'DESC')
            ->get($this->table)
            ->result();
    }
  

     public function getPopularLocation($category)
    {
        return $this->db->where('category', $category)
            ->where('popular', 1)
          ->order_by('id', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_locations_with_activity_count($keyword = null)
{
    $this->db->select('l.id, l.name AS location, COUNT(a.id) AS activity_count');
    $this->db->from('location l');
    $this->db->join('activities a', 'a.location_id = l.id AND a.status = 1', 'left');

    if (!empty($keyword)) {
        $this->db->like('l.name', $keyword); 
    }

    $this->db->where('l.status', 1);      
    $this->db->group_by('l.id');
    $this->db->having('COUNT(a.id) >', 0);  
    $this->db->order_by('activity_count', 'DESC'); 
    $this->db->limit(50);               

    $query = $this->db->get();
    return $query->result_array();
}


public function get_locations_with_package_count($location_name = null)
{
    $this->db->select('l.id, l.name AS name, l.slug, COUNT(a.id) AS package_count');
    $this->db->from('location l');
    $this->db->join('packages a', 'a.location_id = l.id AND a.status = 1', 'left');

    if (!empty($location_name)) {
        $this->db->like('l.name', $location_name); 
    }

    $this->db->where('l.status', 1);      
    $this->db->group_by('l.id');
    $this->db->having('COUNT(a.id) >', 0);  
    $this->db->order_by('package_count', 'DESC'); 
    $this->db->limit(50);               

    $query = $this->db->get();
    return $query->result_array();
}

public function get_destination_search($location_name = null) {
    $this->db->select('*');
    $this->db->from('location');
    $this->db->where('status', 1);

    if (!empty($location_name)) {
        $this->db->where('LOWER(name)', strtolower($location_name)); 
    }

    $this->db->order_by('created_at', 'DESC');
    $query = $this->db->get();
    return $query->result_array();
}


}
