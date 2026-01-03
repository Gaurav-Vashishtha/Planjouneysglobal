<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $table = 'users';

    public function register($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function exists($field, $value)
    {
        return $this->db->where($field, $value)->get($this->table)->num_rows() > 0;
    }

    public function find_by($field, $value)
    {
        return $this->db->where($field, $value)->get($this->table)->row_array();
    }
}
