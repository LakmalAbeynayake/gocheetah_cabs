<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class api_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function add_session()
    {
        $data = array(
            'details'   => "",
            'page'  => "pos-java",
            'user_id'  =>  $this->session->userdata('ss_user_id'),
            'branch_id'  => $this->session->userdata('ss_branch_id'),
            'session_id'  => $this->session->userdata('__ci_last_regenerate'),
            'datetime'     => date("Y-m-d H:i:s"),
            'ip'     => $this->input->ip_address()
        );

        if ($this->db->insert('session_logs', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function get_products_suggestions($term='') {
		$this->db->select('product_id,product_name,product_code,product_price,product_cost');
		$this->db->from('product');
		if($term){
			$this->db->where("product_status = '1' AND product_code LIKE '%$term%'");
			$this->db->or_where("product_status = '1' AND product_name LIKE '%$term%'");
		}
		$this->db->order_by("product_code", "asc");
		$this->db->limit(15);
		$query = $this->db->get();
		return $query->result();
	}
    public function get_product_by_product_id($product_id,$product_code="")
    {
        $this->db->select('product_id,product_name,product_code,product_price,product_cost');
		$this->db->from('product');
		if($product_id)
            $this->db->where('product_id', $product_id);

        if($product_code)
            $this->db->where('product_code', $product_code);

		$this->db->order_by("product_code", "asc");
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
    }
    public function get_product_by_cat_id($category_id = '')
    {
        $this->db->select('product_id,product_name,product_code,product_price,product_thumb,product_image,cat_id,sub_cat_id,product_weight,product_details,min_order_qty');
        $this->db->from('product');
        if ($category_id)
            $this->db->where('cat_id', $category_id);
        $this->db->where('product_status', 1);
        $this->db->where('show_on_app', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_session($ss_session_id)
    {
        if ($ss_session_id) {
            $this->db->select('*');
            $this->db->from('session_logs');
            $this->db->where('session_id', $ss_session_id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }



    function get_next_ref_no()
    {
        $this->db->select("COUNT(`sale_id`) AS sale_id");
        //$this->db->where("DATE(`sale_datetime`)", date("Y-m-d"));
        $this->db->where("sale_type", "android_pos_sale");
        return $this->db->get("`sales`");
    }
    function save_sale_header(&$sales_data, $sale_id = false)
    {
        if (!$sale_id) {
            if ($this->db->insert('sales', $sales_data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        }
    }
    function sale_items_in($sale_details)
    {
        if ($this->db->insert('sale_items', $sale_details)) {
            return true;
        } else {
            return false;
        }
    }
    function sales_payment($data)
    {
        if ($this->db->insert('sale_payments', $data)) {
            return true;
        } else {
            return false;
        }
    }
}
