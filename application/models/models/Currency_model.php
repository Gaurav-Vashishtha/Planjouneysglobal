<?php
class Currency_model extends CI_Model {

    public function get_currency()
    {
        return $this->db->get('currency_settings')->row();
    }

    public function update_currency($data)
    {
        return $this->db->update('currency_settings', $data, ['id' => 1]);
    }
}
