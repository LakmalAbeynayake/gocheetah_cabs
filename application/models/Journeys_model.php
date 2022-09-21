<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Journeys_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function get_journeys($start, $length, $filter){

        if ($start != '' && $length != '') {
            $this->db->select('j.*, c.cat_name, c.cat_description, c.cat_price');
        } else {
            $this->db->select('count(j.journey_id) as count');
        }

        $this->db->from('journeys j');
        
        $this->db->join('vehicle_category c','c.cat_id = j.veh_cat_id','left');

        if (isset($filter['cat_id'])) {
            if ($filter['cat_id'])
                $this->db->where("j.cat_id", $filter['cat_id']);
        }

        if (isset($filter['date'])) {
            if ($filter['date'])
                $this->db->where("date(j.added_date_time)", $filter['date']);
        }

        /* if (isset($filter['search_key_val'])) {
            if ($filter['search_key_val'])
                $this->db->where("p.product_name LIKE '%" . $filter['search_key_val'] . "%' OR p.product_code LIKE '%" . $filter['search_key_val'] . "%'");
        } */
        /* $this->db->where("p.product_type", 1); */

        $this->db->order_by("j.start_time", "desc");
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get();
            return $query->row()->count;
        }
    }
    function get_product_by_name($name = '', $product_id = '')
    {
        $this->db->select('p.*');
        $this->db->from('product p');
        $this->db->where('p.product_name', $name);
        if ($product_id) {
            $this->db->where_not_in("p.product_id", $product_id);
        }
        $this->db->order_by("p.product_name", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    function get_products_ajax($search)
    {
        $this->db->select('p.*');
        $this->db->from('product p');
        $this->db->like('p.product_name', $search);
        $this->db->where_not_in("p.product_type", 2);
        $this->db->order_by("p.product_name", "asc");
        $this->db->LIMIT(10);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_products_ajax_all($search)
    {
        $this->db->select('p.*');
        $this->db->from('product p');
        $this->db->like('p.product_name', $search);
        /* $this->db->where_not_in("p.product_type", 2); */
        $this->db->where("p.product_type", 2);
        $this->db->order_by("p.product_name", "asc");
        $this->db->LIMIT(10);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_product_by_id($product_id)
    {
        $this->db->select('p.*, c.cat_name,sc.sub_cat_name, u.unit_name, u.unit_code ');
        $this->db->from('product p');
        $this->db->join('product_category c', 'p.cat_id = c.cat_id', 'left');
        $this->db->join('product_sub_category sc', 'p.sub_cat_id = sc.sub_cat_id', 'left');
        $this->db->join('mstr_unit u', 'p.product_unit = u.unit_id', 'left');
        $this->db->where('p.product_id', $product_id);
        $query = $this->db->get();
        return $query->row();
    }
    function get_subcategory()
    {
        $this->db->select('*');
        $this->db->from('product_sub_category');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function update_product($pd, $prduct_id)
    {
        if ($prduct_id) {
            $this->db->where('product_id', $prduct_id);
            if ($this->db->update('product', $pd)) {
                return true;
            } else {
                return false;
            }
        } else return false;
    }
    function get_units()
    {
        $this->db->select('*');
        $this->db->from('mstr_unit');
        $this->db->where('unit_status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_prefix() {
		$this->db->select('*');
		$this->db->order_by("id", "asc");
		$this->db->where("id IS NOT NULL");//("id !=",$id);
		$this->db->where("si_status",1);//("id !=",$id);
		$query = $this->db->get('mstr_si');
		return $query->result();
	}
    function get_ref_number($product_type,$type_code){
        $this->db->select("count(product_id) as count");
        $this->db->where("product_type",$product_type);
        $query = $this->db->get("product");
        if($query->num_rows() >0)
        {
            $result = $query->row();
            $ref_no = $this->set_ref_no($result->count,$type_code);
            return  $ref_no;
        }
        else{
            return false;
        }
    }
    function set_ref_no($f,$w){
        $w =$w.sprintf("%06d",$f+1);
        return $w;
    }
    function disable($product_id)
    {
        if ($product_id)
            $this->db->query('UPDATE `product` SET `product_status`= 0 WHERE `product_id` = ' . $product_id . '');
    }
    function enable($product_id)
    {
        if ($product_id)
            $this->db->query('UPDATE `product` SET `product_status`= 1 WHERE `product_id` = ' . $product_id . '');
    }
    function get_products_suggestions($term = '')
    {
        $this->db->select('product_id,product_name,product_code,product_price,product_cost');
        $this->db->from('product');
        if ($term) {
            $this->db->where("product_status = '1' AND product_code LIKE '%$term%'");
            $this->db->or_where("product_status = '1' AND product_name LIKE '%$term%'");
        }
        $this->db->order_by("product_code", "asc");
        $this->db->limit(15);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_product($term = '')
    {
        $this->db->select('product_id,product_name,product_code,product_price,product_cost');
        $this->db->from('product');
        if ($term) {
            $this->db->where("product_status = '1' AND product_code LIKE '%$term%'");
            $this->db->or_where("product_status = '1' AND product_name LIKE '%$term%'");
        }
        $this->db->order_by("product_code", "asc");
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_stock_qty()
    {
    }

    function get_purchased_qty($product_id, $branch_id)
    {
        $this->db->select_sum('quantity');
        $this->db->from('purchase_items');
        $this->db->where('product_id', $product_id);
        $this->db->where('branch_id', $branch_id);
        $query = $this->db->get();
        return $query->row()->quantity;
    }
    function get_sold_qty($product_id, $branch_id)
    {
        $this->db->select_sum('quantity');
        $this->db->from('sale_items');
        $this->db->where('product_id', $product_id);
        $this->db->where('branch_id', $branch_id);
        $query = $this->db->get();
        return $query->row()->quantity;
    }

    function get_return_qty($product_id, $branch_id)
    {
        $this->db->select_sum('quantity');
        $this->db->from('sales_return_items');
        $this->db->where('product_id', $product_id);
        $this->db->where('branch_id', $branch_id);
        $query = $this->db->get();
        return $query->row()->quantity;
    }
    function get_transfer_in_qty($product_id, $branch_id)
    {
        $this->db->select_sum('trnsfr_itm_quantity');
        $this->db->from('transfer_item');
        $this->db->where('product_id', $product_id);
        $this->db->where('warehouse_to_id', $branch_id);
        $query = $this->db->get();
        return $query->row()->trnsfr_itm_quantity;
    }
    function get_transfer_out_qty($product_id, $branch_id)
    {
        $this->db->select_sum('trnsfr_itm_quantity');
        $this->db->from('transfer_item');
        $this->db->where('product_id', $product_id);
        $this->db->where('warehouse_from_id', $branch_id);
        $query = $this->db->get();
        return $query->row()->trnsfr_itm_quantity;
    }
    function get_damaged_qty($product_id, $branch_id)
    {
        $this->db->select_sum('quantity');
        $this->db->from('product_damage_item');
        $this->db->where('product_id', $product_id);
        $this->db->where('branch_id', $branch_id);
        $query = $this->db->get();
        return $query->row()->quantity;
    }
    function get_stock_summary_($filter)
    {
        $this->db->select_sum('payments.pymnt_amount');
        $this->db->from('payments');

        if (isset($filter['pymnt_type'])) {
            if ($filter['pymnt_type'] != "")
                $this->db->where("payments.pymnt_type", $filter['pymnt_type']);
        }

        if (isset($filter['paid_by'])) {
            if ($filter['paid_by'] != "")
                $this->db->where("payments.pay_by", $filter['paid_by']);
        }

        if (isset($filter['date_from'])) {
            if ($filter['date_from'] != "")
                $this->db->where("date(payments.pymnt_date_time) >= '" . $filter['date_from'] . "'");
        }

        if (isset($filter['date_to'])) {
            if ($filter['date_to'] != "")
                $this->db->where("date(payments.pymnt_date_time) <= '" . $filter['date_to'] . "'");
        }

        if (isset($filter['user_id'])) {
            if ($filter['user_id'] > 0)
                $this->db->where("payments.user_id", $filter['user_id']);
        }

        if (isset($filter['branch_id'])) {
            if ($filter['branch_id'] > 0)
                $this->db->where("payments.branch_id", $filter['branch_id']);
        }

        $query = $this->db->get();
        return $query->row();
    }
    /* Raw Materials */
    function get_raw_mats($start, $length, $filter)
    {
        if ($start != '' && $length != '') {
            $this->db->select('p.* , c.cat_name , s.sub_cat_name, u.unit_name, br.brand_name');
        } else {
            $this->db->select('count(p.product_id) as count');
        }
        $this->db->from('product p');
        $this->db->join('product_category c', 'c.cat_id = p.cat_id', 'left');
        $this->db->join('product_sub_category s', 's.sub_cat_id = p.sub_cat_id', 'left');
        $this->db->join('product_brands br', 'br.brand_id = p.brand_id', 'left');
        $this->db->join('mstr_unit u', 'u.unit_id = p.product_unit', 'left');
        if (isset($filter['cat_id'])) {
            if ($filter['cat_id'])
                $this->db->where("p.cat_id", $filter['cat_id']);
        }
        if (isset($filter['sub_cat_id'])) {
            if ($filter['sub_cat_id'])
                $this->db->where("p.sub_cat_id", $filter['sub_cat_id']);
        }
        if (isset($filter['search_key_val'])) {
            if ($filter['search_key_val'])
                $this->db->where("p.product_name LIKE '%" . $filter['search_key_val'] . "%' OR p.product_code LIKE '%" . $filter['search_key_val'] . "%'");
        }
        $this->db->where("p.product_type", 2);
        $this->db->order_by("p.product_id", "desc");
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get();
            return $query->row()->count;
        }
    }
    function update_raw_mat_qty($product_id,$raw_mat_id,$qty){
        if ($product_id) {
            $this->db->where('product_id', $product_id);
            $this->db->where('raw_mat_id', $raw_mat_id);
            if ($this->db->update('recipes', array('raw_mat_qty'=> $qty))) {
                return $this->db->affected_rows();
            } else {
                return false;
            }
        } else return false;
    }
    function get_recipes($product_id)
    {
        $this->db->select('rp.*,p.product_name,p.product_code,u.*, si.*');
        $this->db->from('recipes rp');
        $this->db->join('product p', 'rp.raw_mat_id = p.product_id', 'left');
        $this->db->join('mstr_unit u', 'p.product_unit = u.unit_id', 'left');
        $this->db->join('mstr_si si', 'p.product_prefix = si.id', 'left');
        $this->db->where('rp.product_id', $product_id);
        $query = $this->db->get();
        return $query->result();
    }
    function delete_recipe_item($product_id,$raw_mat_id){
        if($product_id >0 && $raw_mat_id > 0){
            $this->db->where("product_id", $product_id);
            $this->db->where("raw_mat_id", $raw_mat_id);
            if ($this->db->delete('recipes')) {
                return $this->db->affected_rows();
            } else {
                return false;
            }
        }
    }
}