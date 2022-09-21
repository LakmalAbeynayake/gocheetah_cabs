<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class damages_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function get_damages($start='',$length='',$filters) {
		
        $this->db->select('product_damage.*');
		$this->db->from('product_damage');
		$this->db->order_by("product_damage.damage_id", "desc");
		//$this->db->where("purchases.branch_id",$filters[1]);
		//$this->db->like("supplier.supp_company_name",$filters[0]);
		
		if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get();
            return $query->num_rows();
        }
	}
}
