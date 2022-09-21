<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class production_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function get_productions($start = '', $length = '', $filters)
    {
        if ($start != '' && $length != '') {
            $this->db->select('productions.*');
        } else {
            $this->db->select('count(productions.production_id) as count');
        }
        $this->db->from('productions');
        $this->db->order_by("productions.production_id", "desc");
        //$this->db->where("purchases.branch_id",$filters[1]);
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
    function get_production($production_id)
    {
        $this->db->select('productions.*,name,user_first_name,user_last_name');
        $this->db->from('productions');
        $this->db->join("branches", 'branches.id = productions.branch_id', 'left');
        $this->db->join("user", 'user.user_id = productions.user_id', 'left');
        $this->db->where("productions.production_id", $production_id);
        $this->db->order_by("productions.production_id", "desc");
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }
    function get_production_batch_info($prdb_id)
    {
        $this->db->select('production_batch.*,name,user_first_name,user_last_name');
        $this->db->from('production_batch');
        $this->db->join("branches", 'branches.id = production_batch.branch_id', 'left');
        $this->db->join("user", 'user.user_id = production_batch.prdb_added_by', 'left');
        $this->db->where("production_batch.prdb_id", $prdb_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }
    function get_production_items($production_id)
    {
        $this->db->select('production_items.*,product_name,product_code');
        $this->db->from('production_items');
        $this->db->join('product', 'product.product_id = production_items.product_id', 'left');
        //$this->db->order_by("production_items.production_id", "desc");
        $this->db->where("production_items.production_id", $production_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_production_items_info_by_batch_id($production_id)
    {
        $this->db->select('production_items.*,product_name,product_code');
        $this->db->from('production_items');
        $this->db->join('product', 'product.product_id = production_items.product_id', 'left');
        //$this->db->order_by("production_items.production_id", "desc");
        $this->db->where("production_items.production_id", $production_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }
    /* create batches */
    /* 1 group n get batches */
    /* function get_batches($product_id)
    {

        $this->db->select('batch_no');
        $this->db->from('production_items');
        $this->db->order_by("production_items.pb_id", "desc");
        if (!empty($filters))
            $this->db->where($filters);

        $query = $this->db->get();
        return $query->result();
    } */
    /* function get_batches($filters)
    {
        $this->db->select('batch_no,product_cost,product_id');
        $this->db->from('production_items');
        $this->db->group_by("batch_no");
        if (!empty($filters))
            $this->db->where($filters);

        $query = $this->db->get();
        return $query->result();
    } */
    function get_batches($filters)
    {
        $this->db->select('*');
        $this->db->from('production_batch');
        if (!empty($filters))
            $this->db->where($filters);

        $query = $this->db->get();
        return $query->result();
    }
    function get_production_batches($start = '', $length = '', $filters = array())
    {
        if ($start != '' && $length != '') {
            $this->db->select('product.product_name, production_batch.*');
        } else {
            $this->db->select('count(production_batch.prdb_id) as count');
        }
        $this->db->from('production_batch');
        $this->db->join('product', 'product.product_id = production_batch.product_id', 'left');
        $this->db->order_by("production_batch.prdb_id", "desc");
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
    function get_production_batch_info_by_batch_no($batch_no,$prdb_cost,$branch_id="")
    {
        $this->db->select('production_batch.*');
        $this->db->from('production_batch');
        $this->db->where("production_batch.prdb_code", $batch_no);
        $this->db->where("production_batch.prdb_cost", $prdb_cost);
        if($branch_id)
            $this->db->where("production_batch.branch_id", $branch_id);
        //prdb_ref_no
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }
    /* Open Close production sheet */
    function open($production_id)
    {
        if ($production_id) {
            $this->db->query('UPDATE `productions` SET `production_status`= 1 WHERE `production_id` = ' . $production_id . '');
            return $this->db->affected_rows();
        } else return 0;
    }
    function close($production_id)
    {
        if ($production_id) {
            $this->db->query('UPDATE `productions` SET `production_status`= 0 WHERE `production_id` = ' . $production_id . '');
            return $this->db->affected_rows();
        } else return 0;
    }
    /* Enable Disable production Batch */
    function enable($prdb_id)
    {
        if ($prdb_id) {
            $this->db->query('UPDATE `production_batch` SET `prdb_in_use`= 1 WHERE `prdb_id` = ' . $prdb_id . '');
            return $this->db->affected_rows();
        } else return 0;
    }
    function disable($prdb_id)
    {
        if ($prdb_id) {
            $this->db->query('UPDATE `production_batch` SET `prdb_in_use`= 0 WHERE `prdb_id` = ' . $prdb_id . '');
            return $this->db->affected_rows();
        } else return 0;
    }
    // production batch id ekakata HADAPU products gaana
    function get_manufactured_qty_by_prdb_id($prdb_id,$branch_id=""){
        $this->db->select_sum('production_items.production_quantity');
        $this->db->from('production_items');
        $this->db->where("production_items.production_batch_id", $prdb_id);
        if($branch_id)
            $this->db->where("production_items.branch_id", $branch_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }
    function get_manufactured_qty_consumption($prdb_id,$branch_id=""){
        $this->db->select_sum('pi.raw_mat_qty');
        $this->db->from('production_raw_materials pi');
        $this->db->where('pi.batch_id', $prdb_id);
        $this->db->where('pi.batch_type', 'production');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->raw_mat_qty;
        } else {
            return 0;
        }
    }
}
