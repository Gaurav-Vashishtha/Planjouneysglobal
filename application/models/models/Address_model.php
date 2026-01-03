<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Address_model extends CI_Model
{

public function searchCountries($keyword, $category)
{
   
    $domestic_country = ['India'];

    $europe_countries = [
        'Austria','Belgium','France','Germany','Italy','Netherlands','Spain','Sweden','Norway','Switzerland',
        'Finland','Denmark','Greece','Portugal','Poland','Czech Republic','Hungary','Ireland','United Kingdom',
        'Croatia','Serbia','Slovenia','Slovakia','Romania','Bulgaria','Lithuania','Latvia','Estonia'
    ];

    $this->db->select('id as id, name as text');

    if ($category == 'domestic') {
        $this->db->where_in('name', $domestic_country);
    }
    elseif ($category == 'europe') {
        $this->db->where_in('name', $europe_countries);
    }
 

    if (!empty($keyword)) {
        $this->db->like('name', $keyword);
    }

    return $this->db->limit(20)->get('countries')->result();
}


    public function searchStates($country_id, $keyword)
    {
        return $this->db->select('id as id, name as text')
            ->where('country_id', $country_id)
            ->like('name', $keyword)
            ->limit(20)
            ->get('states')
            ->result();
    }

    public function searchCities($state_id, $keyword)
    {
        return $this->db->select('id as id, name as text')
            ->where('state_id', $state_id)
            ->like('name', $keyword)
            ->limit(20)
            ->get('state_cities')
            ->result();
    }

    public function insert_batch($data)
    {
        if (empty($data)) {
            return;
        }
        $country_ids = array_column($data, 'country_id');
        $state_ids   = array_column($data, 'state_id');
        $city_ids    = array_column($data, 'city_id');


        $countries = $this->db->select('id, name')->where_in('id', $country_ids)->get('countries')->result();
        $states    = $this->db->select('id, name')->where_in('id', $state_ids)->get('states')->result();
        $cities    = $this->db->select('id, name')->where_in('id', $city_ids)->get('state_cities')->result();

        $countryMap = [];
        foreach ($countries as $c) {
            $countryMap[$c->id] = $c->name;
        }

        $stateMap = [];
        foreach ($states as $s) {
            $stateMap[$s->id] = $s->name;
        }

        $cityMap = [];
        foreach ($cities as $ci) {
            $cityMap[$ci->id] = $ci->name;
        }

        foreach ($data as &$row) {
            $row['country_name'] = isset($countryMap[$row['country_id']]) ? $countryMap[$row['country_id']] : '';
            $row['state_name']   = isset($stateMap[$row['state_id']]) ? $stateMap[$row['state_id']] : '';
            $row['city_name']    = isset($cityMap[$row['city_id']]) ? $cityMap[$row['city_id']] : '';
        }
        $this->db->insert_batch('manage_stays', $data);
    }

    public function get_by_package($package_id)
    {
        return $this->db->get_where('manage_stays', ['package_id' => $package_id])->result();
    }

    public function delete_by_package($package_id)
    {
        return $this->db->delete('manage_stays', ['package_id' => $package_id]);
    }

    public function get_stays_by_package($package_id)
    {
        return $this->db->select('ms.*, c.name as country_name, s.name as state_name, ci.name as city_name')
                        ->from('manage_stays ms')
                        ->join('countries c', 'c.id = ms.country_id', 'left')
                        ->join('states s', 's.id = ms.state_id', 'left')
                        ->join('state_cities ci', 'ci.id = ms.city_id', 'left')
                        ->where('ms.package_id', $package_id)
                        ->get()
                        ->result();
    }
}
