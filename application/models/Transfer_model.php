<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class transfer_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function get_transfers($start='',$length='',$filter) {
		
        $this->db->select('transfer.*');
		$this->db->from('transfer');
		$this->db->order_by("transfer.trnsfr_id", "desc");
		
        if (isset($filter['trnsfr_datetime']))
            $this->db->where("date(transfer.trnsfr_datetime)", $filter['trnsfr_datetime']);

        if (isset($filter['trnsfr_from_warehouse_id']))
            $this->db->where("date(transfer.trnsfr_from_warehouse_id) <= '" . $filter['trnsfr_from_warehouse_id'] . "'");

        if (isset($filter['trnsfr_from_warehouse_id'])) {
            if ($filter['trnsfr_from_warehouse_id'] > 0)
                $this->db->where("transfer.trnsfr_from_warehouse_id", $filter['trnsfr_from_warehouse_id']);
        }
        if (isset($filter['trnsfr_to_warehouse_id'])) {
            if ($filter['trnsfr_to_warehouse_id'] > 0)
                $this->db->where("transfer.trnsfr_to_warehouse_id", $filter['trnsfr_to_warehouse_id']);
        }

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
