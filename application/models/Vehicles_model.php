<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class vehicles_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_vehicles()
    {
        $this->db->select('vehicle.*,driver.driver_first_name,driver.driver_last_name,driver.driver_phone,vehicle_category.cat_name,vehicle_category.cat_price');
        $this->db->from('vehicle');
        $this->db->join('driver','driver.driver_id = vehicle.driver_id','left');
        $this->db->join('vehicle_category','vehicle_category.cat_id = vehicle.veh_cat','left');
        $this->db->where('vehicle.branch_id', $this->session->userdata('ss_branch_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function check($cat_id){
        $this->db->select('count(veh_id) as count');
        $this->db->from('vehicle');
        $this->db->where('veh_cat', $cat_id);
        $this->db->where('branch_id', $this->session->userdata('ss_branch_id'));
        $this->db->where('veh_status', "available");
        $query = $this->db->get();
        return $query->row()->count;
    }
    function get_vehicle_by_id($vehicle_id = '')
    {
        $this->db->select('*');
        $this->db->from('vehicle');
        $this->db->where('veh_id', $vehicle_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    function vehicle_update($data,$cat_id)
    {
        $this->db->where('cat_id', $cat_id);
        if ($this->db->update('vehicle', $data)) {
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }
    function vehicle_change_status($vehicle_tbl_id = '', $status = '')
    {
        $cat_id = ($status == 0) ? 1 : 0;
        $data   = array(
            'cat_status' => $cat_id
        );
        $this->db->where('cat_id', $vehicle_tbl_id);
        if ($this->db->update('vehicle', $data)) {
            return true;
        } else {
            return false;
        }
    }
    function vehicle_permanent_delete($vehicle_id = '')
    {
            $this->db->where('cat_id', $vehicle_id);
            if ($this->db->delete('vehicle')) {
                return true;
            } else {
                return false;
            }
    }
    
}
