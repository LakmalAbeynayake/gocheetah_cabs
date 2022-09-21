<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class stock_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * PURCHASED QUANTITY BY BATCH ID
     */
    function purchased_qty($batch_id)
    {
        $this->db->select_sum('pi.quantity');
        $this->db->from('purchase_items pi');
        $this->db->where('pi.batch_id', $batch_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->quantity;
        } else {
            return 0;
        }
    }
    function consumed_qty($batch_id)
    {
        $this->db->select_sum('pi.raw_mat_qty');
        $this->db->from('production_raw_materials pi');
        $this->db->where('pi.batch_id', $batch_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->raw_mat_qty;
        } else {
            return 0;
        }
    }
    /**
     * FINAL QUANTITY CAL
     */
    function get_qty($batch_id){
        $purchased_qty = $this->purchased_qty($batch_id);
        $consumed_qty = $this->consumed_qty($batch_id);
        $balance_qty = $purchased_qty-$consumed_qty;
        return $balance_qty;
    }

    /**
     * QUANTITY BY PRODUCT ID & WAREHOUSE ID
     */
    
    /* purchased */
    function purchased_by_product_id_n_warehouse_id($product_id,$branch_id)
    {
        $this->db->select_sum('pi.quantity');
        $this->db->from('purchase_items pi');
        $this->db->where('pi.product_id', $product_id);
        $this->db->where('pi.branch_id', $branch_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row()->quantity;
        } else {
            return 0;
        }
    }
    /* production */
    function production_by_product_id_n_warehouse_id($product_id,$branch_id,$batch_id="",$batch_type="")
    {
        $this->db->select_sum('pi.production_quantity');
        $this->db->from('production_items pi');
        $this->db->where('pi.product_id', $product_id);
        $this->db->where('pi.branch_id', $branch_id);
        if($batch_id){
            $this->db->where('pi.production_batch_id', $batch_id);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row()->production_quantity;
        } else {
            return 0;
        }
    }
    /* consumed */
    function consumed_by_product_id_n_warehouse_id($product_id,$branch_id,$batch_id="",$batch_type="")
    {
        $this->db->select_sum('pi.raw_mat_qty');
        $this->db->from('production_raw_materials pi');
        $this->db->where('pi.raw_mat_id', $product_id);
        $this->db->where('pi.branch_id', $branch_id);
        if($batch_id && $batch_type){
            $this->db->where('pi.batch_id', $batch_id);
            $this->db->where('pi.batch_type', $batch_type);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row()->raw_mat_qty;
        } else {
            return 0;
        }
    }
    function get_qty_by_product_id_n_warehouse_id($product_id,$branch_id,$batch_id="",$batch_type=""){
        $purchased_qty = $this->purchased_by_product_id_n_warehouse_id($product_id,$branch_id);
        $production_qty = $this->production_by_product_id_n_warehouse_id($product_id,$branch_id,$batch_id);
        $consumed_qty = $this->consumed_by_product_id_n_warehouse_id($product_id,$branch_id,$batch_id,$batch_type);

        $balance_qty = $purchased_qty + $production_qty - $consumed_qty;
        return $balance_qty;
    }
}