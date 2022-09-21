<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class purchases_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function get_purchases($start = '', $length = '', $filters)
    {

        $this->db->select('purchases.*, supplier.supp_company_name');
        $this->db->from('purchases');
        $this->db->join('supplier', 'purchases.supplier_id = supplier.supp_id', 'left');
        $this->db->order_by("purchases.purchase_id", "desc");
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
    function get_purchase_info($purchase_id)
    {
        $this->db->select('purchases.*, supplier.supp_company_name,supp_id,user_first_name,user_last_name,name');
        $this->db->from('purchases');
        $this->db->join('supplier', 'purchases.supplier_id = supplier.supp_id', 'left');
        $this->db->join('branches', 'purchases.branch_id = branches.id', 'left');
        $this->db->join('user', 'user.user_id = purchases.user_id', 'left');
        $this->db->where("purchases.purchase_id", $purchase_id);
        $query = $this->db->get();
        return $query->row();
    }
    function get_purchase_items_info($purchase_id)
    {
        $this->db->select('purchase_items.*,product_name,product_code,pb_code,pb_cost,pb_expire_date');
        $this->db->from('purchase_items');
        $this->db->join('product', 'product.product_id = purchase_items.product_id', 'left');
        $this->db->join('purchase_batch', 'purchase_batch.pb_id = purchase_items.batch_id', 'left');
        $this->db->where("purchase_items.purchase_id", $purchase_id);
        $query = $this->db->get();
        return $query->result();
    }
    function get_purchases_batches($start = '', $length = '', $filters = array())
    {
        if ($start != '' && $length != '') {
            $this->db->select('product.product_name, purchase_batch.*');
        } else {
            $this->db->select('count(purchase_batch.pb_id) as count');
        }
        $this->db->from('purchase_batch');
        $this->db->join('product', 'product.product_id = purchase_batch.product_id', 'left');
        $this->db->order_by("purchase_batch.pb_id", "desc");
        if (!empty($filters))
            $this->db->where($filters);
        //$this->db->like("supplier.supp_company_name",$filters[0]);

        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get();
            return $query->row()->count;
        }
    }
    /* GET ACTIVE BATCHES FOR PURCHASES */
    function get_batches($filters)
    {
        $this->db->from('purchase_batch');
        $this->db->order_by("purchase_batch.pb_id", "desc");
        if (!empty($filters))
            $this->db->where($filters);

        $query = $this->db->get();
        return $query->result();
    }
    function get_purchase_batch_info($pb_id){
        $this->db->select('purchase_batch.*,name,user_first_name,user_last_name');
        $this->db->from('purchase_batch');
        $this->db->join("branches", "branches.id = purchase_batch.branch_id");
        $this->db->join('user', 'user.user_id = purchase_batch.pb_added_by', 'left');
        $this->db->where("purchase_batch.pb_id", $pb_id);
        //$this->db->order_by("purchase_batch.pb_id", "desc");
        /* if (!empty($filters))
            $this->db->where($filters); */
            /* 
            $this->db->select('purchases.*, supplier.supp_company_name,supp_id,user_first_name,user_last_name,name');
        $this->db->from('purchases');
        $this->db->join('supplier', 'purchases.supplier_id = supplier.supp_id', 'left');
        $this->db->join('branches', 'purchases.branch_id = branches.id', 'left');
        $this->db->where("purchases.purchase_id", $purchase_id);
         */
        $query = $this->db->get();
        return $query->row();
    }
    function get_purchase_items_info_by_batch_id($batch_id)
    {
        $this->db->select('purchase_items.*,product_name,product_code,pb_code,pb_cost,pb_expire_date');
        $this->db->from('purchase_items');
        $this->db->join('product', 'product.product_id = purchase_items.product_id', 'left');
        $this->db->join('purchase_batch', 'purchase_batch.pb_id = purchase_items.batch_id', 'left');
        $this->db->where("purchase_batch.pb_id", $batch_id);
        $query = $this->db->get();
        return $query->result();
    }
    /* SUMS */
    function get_purchased_item_qty_by_batch_id($batch_id)
    {
        $this->db->select('sum(purchase_items.quantity) as quantity');
        $this->db->from('purchase_items');
        $this->db->join('purchase_batch', 'purchase_batch.pb_id = purchase_items.batch_id', 'left');
        $this->db->where("purchase_batch.pb_id", $batch_id);
        $query = $this->db->get();
        return $query->row()->quantity > 0 ? $query->row()->quantity : 0;
    }
}
