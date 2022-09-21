<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class sales_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function get_sales($start = '', $length = '', $filter)
    {

        $this->db->select('sales.*, customer.cus_name');
        $this->db->from('sales');
        $this->db->join('customer', 'sales.sale_customer_id = customer.cus_id', 'left');
        $this->db->order_by("sales.sale_id", "desc");

        if (isset($filter["customer_id"]))
            $this->db->where("sales.sale_customer_id", $filter["customer_id"]);

        if (isset($filter['reference_no']))
            $this->db->where("sales.sale_reference_no", $filter['reference_no']);

        if (isset($filter['sale_date']))
            $this->db->where("date(sales.sale_date_time)", $filter['sale_date']);

        if (isset($filter['sale_date_from']))
            $this->db->where("date(sales.sale_date_time) >= '" . $filter['sale_date_from'] . "'");

        if (isset($filter['sale_date_to']))
            $this->db->where("date(sales.sale_date_time) <= '" . $filter['sale_date_to'] . "'");

        if (isset($filter['user_id'])) {
            if ($filter['user_id'] > 0)
                $this->db->where("sales.sale_user_id", $filter['user_id']);
        }

        if (isset($filter['branch_id']))
            $this->db->where("sales.branch_id", $filter['branch_id']);


        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get();
            return $query->num_rows();
        }
    }
    function get_sales_summary($filter)
    {

        $this->db->select_sum('sales.sale_total');
        $this->db->select_sum('sales.sale_cost');
        $this->db->from('sales');
        //$this->db->join('customer', 'sales.sale_customer_id = customer.cus_id', 'left');
        //$this->db->order_by("sales.sale_id", "desc");
        /* 
        if (isset($filter["customer_id"]))
            $this->db->where("sales.sale_customer_id", $filter["customer_id"]);
 */
        /*         if (isset($filter['reference_no']))
            $this->db->where("sales.sale_reference_no", $filter['reference_no']);
 */
        if (isset($filter['sale_date']))
            $this->db->where("date(sales.sale_date_time)", $filter['sale_date']);

        if (isset($filter['sale_date_from']))
            $this->db->where("date(sales.sale_date_time) >= '" . $filter['sale_date_from'] . "'");

        if (isset($filter['sale_date_to']))
            $this->db->where("date(sales.sale_date_time) <= '" . $filter['sale_date_to'] . "'");

        if (isset($filter['user_id'])) {
            if ($filter['user_id'] > 0)
                $this->db->where("sales.sale_user_id", $filter['user_id']);
        }

        if (isset($filter['branch_id']))
            $this->db->where("sales.branch_id", $filter['branch_id']);



        $query = $this->db->get();

        return $query->row();
    }
    function get_sale_info($sale_id)
    {
        $this->db->select('sales.*, customer.cus_name,customer.cus_phone,customer.cus_address,wh.name,wh.address,wh.phone');
        $this->db->from('sales');
        $this->db->from('branches wh','sales.branch_id = wh.id','left');
        $this->db->join('customer', 'sales.sale_customer_id = customer.cus_id', 'left');
        $this->db->where("sale_id", $sale_id);
        $query = $this->db->get();
        return $query->row();
    }
    function get_sale_item_info($sale_id)
    {
        $this->db->select('sale_items.*,product.product_name,product.product_code');
        $this->db->from('sale_items');
        $this->db->join('product', 'sale_items.product_id = product.product_id', 'left');
        $this->db->order_by("sale_items.id", "asc");
        $this->db->where("sale_items.sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result();
    }
    function get_total_paid_by_sale_id($sale_id)
    {
        $this->db->select_sum('pymnt_amount');
        $this->db->from('payments');
        $this->db->where("reference_id", $sale_id);
        $this->db->where("pymnt_type", "sale");
        $query = $this->db->get();
        if ($query->row()->pymnt_amount) {
            return $query->row()->pymnt_amount;
        } else {
            return 0;
        }
    }
    function get_products_suggestions($term = '',$sale_id='')
    {
        $this->db->select('sale_items.*, sale_items.single_unit_price_wd as product_cost, product.product_name,product.product_code');
        $this->db->from('sale_items');
        $this->db->join('product', 'sale_items.product_id = product.product_id', 'left');
        $this->db->order_by("sale_items.id", "asc");
        
        if ($term) {
            $this->db->where('sale_items.sale_id = "'.$sale_id.'" AND product.product_code LIKE "%'.$term.'%"');
            $this->db->or_where('sale_items.sale_id = "'.$sale_id.'" AND product.product_name LIKE "%'.$term.'%"');
        }else
            $this->db->where("sale_items.sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    /* //controller part
    $branch_id                 = $this->input->post('branch_id');
    $warehouse_dtls               = $this->Warehouse_Model->get_warehouse_info($branch_id);
    $prefix = $warehouse_dtls['code']."S/".date("ym")."/";
    $result = $this->sales_model->get_ref_number($branch_id,$prefix);
    $warehouse_last_id            = $result['warehouse_last_id'];
    $sale_reference_no            = $result['ref_no'];
    */
    function get_ref_number($branch_id,$type_code){
        $this->db->select_max("warehouse_last_id");
        $this->db->where("branch_id",$branch_id);
        $this->db->where("date(sales.sale_datetime) <=",date("Y-m-t"));
        $query = $this->db->get("sales");
        if($query->num_rows() >0)
        {
            $result = $query->result();
            $ref_no = $this->set_ref_no($result[0]->warehouse_last_id,$type_code);
            return array(
                'warehouse_last_id' => ($result[0]->warehouse_last_id)+1,
                'ref_no' => $ref_no
            );
        }
        else{
            return false;
        }
    }
    function set_ref_no($f,$w){
        $w =$w.sprintf("%04d",$f+1);
        return $w;
    }
}
