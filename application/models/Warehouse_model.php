<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class warehouse_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get_warehouses()
    {
        $this->db->select('*');
        $this->db->from('branches');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_warehouse_info($id)
    {
        $this->db->select('*');
        $this->db->from('branches');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
}
