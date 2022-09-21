<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class customers_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function get_customers($start = '', $length = '', $search_key = "")
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->order_by("cus_name", "desc");
        $this->db->like('cus_name',$search_key);
        
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get();
            return $query->num_rows();
        }
    }
    function get_all_customers()
    {
        $this->db->select('customer.*');
        $this->db->from('customer');
        $this->db->order_by("customer.cus_id", "desc");
        $this->db->where("customer.cus_status IS NOT NULL"); //("id !=",$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_customer_info($id)
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where("cus_id", $id);
        $this->db->order_by("cus_id", "desc");
        $query = $this->db->get();

        return $query->row_array();
    }

    function login($user_username, $user_password)
	{
		$pwHashed = hash('sha512', $user_password);
		$this->db->select('customer.*');
		$this->db->from('customer');
		$this->db->where("cus_phone", $user_username);
		$this->db->where("cus_password", $pwHashed);
        $this->db->where("cus_status", 1);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$row = $query->row();
            return $row->cus_id;
		}
		return false;
	}

    public function delete_customer($cus_id)
    {
        $this->db->where('cus_id', $cus_id);
        $this->db->delete('customer');
    }

    public function disable_customer($cus_id)
    {
        $data = array(
            'cus_status' => 0
        );
        $this->db->where('cus_id', $cus_id);
        $this->db->update('customer', $data);
    }

    public function enable_customer($cus_id)
    {
        $data = array(
            'cus_status' => 1
        );
        $this->db->where('cus_id', $cus_id);
        $this->db->update('customer', $data);
    }
    public function get_cus_count_by_user($user_id="")
    {
        $user_id = $user_id ? $user_id: $this->session->user_data['ss_user_id'];
        $this->db->select('count(cus_id) as count');
        $this->db->from('customer');
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();
        return $query->row()->count;
    }
}
