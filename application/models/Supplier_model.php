<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class supplier_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function save_supplier(&$supplier_data,$supp_id=false)
	{
		if (!$supp_id)
		{
			$this->db->insert($this->tableName,$supplier_data);
		}else {
			$this->db->where('supp_id', $supp_id);
			return $this->db->update($this->tableName,$supplier_data);
		}
	}	
	
	function get_suppliers() {
		$this->db->select('*');
		$this->db->from('supplier');
		$this->db->order_by("supp_company_name", "ASC");
		$this->db->where("supp_status IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
}
