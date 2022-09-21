<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class dealer_issue_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function get_dealer_issues($start = '', $length = '', $filters)
    {
        if ($start != '' && $length != '') {
            $this->db->select('dealer_issue.*');
        } else {
            $this->db->select('count(dealer_issue.id) as count');
        }
        $this->db->from('dealer_issue');
        $this->db->order_by("dealer_issue.id", "desc");
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
    function get_dealer_issue($dealer_issue_id)
    {
        $this->db->select('dealer_issue.*,name,user_first_name,user_last_name');
        $this->db->from('dealer_issue');
        $this->db->join("branches", 'branches.id = dealer_issue.branch_id', 'left');
        $this->db->join("user", 'user.user_id = dealer_issue.user_id', 'left');
        $this->db->where("dealer_issue.id", $dealer_issue_id);
        $this->db->order_by("dealer_issue.id", "desc");
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }
    function get_dealer_issue_batch_info($prdb_id)
    {
        $this->db->select('dealer_issue_batch.*,name,user_first_name,user_last_name');
        $this->db->from('dealer_issue_batch');
        $this->db->join("branches", 'branches.id = dealer_issue_batch.branch_id', 'left');
        $this->db->join("user", 'user.user_id = dealer_issue_batch.prdb_added_by', 'left');
        $this->db->where("dealer_issue_batch.prdb_id", $prdb_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }
    function get_dealer_issue_items($dealer_issue_id)
    {
        $this->db->select('dealer_issue_items.*,product_name,product_code');
        $this->db->from('dealer_issue_items');
        $this->db->join('product', 'product.product_id = dealer_issue_items.product_id', 'left');
        //$this->db->order_by("dealer_issue_items.dealer_issue_id", "desc");
        $this->db->where("dealer_issue_items.dealer_issue_id", $dealer_issue_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_dealer_issue_items_info_by_batch_id($dealer_issue_id)
    {
        $this->db->select('dealer_issue_items.*,product_name,product_code');
        $this->db->from('dealer_issue_items');
        $this->db->join('product', 'product.product_id = dealer_issue_items.product_id', 'left');
        //$this->db->order_by("dealer_issue_items.dealer_issue_id", "desc");
        $this->db->where("dealer_issue_items.dealer_issue_id", $dealer_issue_id);
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
        $this->db->from('dealer_issue_items');
        $this->db->order_by("dealer_issue_items.pb_id", "desc");
        if (!empty($filters))
            $this->db->where($filters);

        $query = $this->db->get();
        return $query->result();
    } */
    /* function get_batches($filters)
    {
        $this->db->select('batch_no,product_cost,product_id');
        $this->db->from('dealer_issue_items');
        $this->db->group_by("batch_no");
        if (!empty($filters))
            $this->db->where($filters);

        $query = $this->db->get();
        return $query->result();
    } */
    function get_batches($filters)
    {
        $this->db->select('*');
        $this->db->from('dealer_issue_batch');
        if (!empty($filters))
            $this->db->where($filters);

        $query = $this->db->get();
        return $query->result();
    }
    function get_dealer_issue_batches($start = '', $length = '', $filters = array())
    {
        if ($start != '' && $length != '') {
            $this->db->select('product.product_name, dealer_issue_batch.*');
        } else {
            $this->db->select('count(dealer_issue_batch.prdb_id) as count');
        }
        $this->db->from('dealer_issue_batch');
        $this->db->join('product', 'product.product_id = dealer_issue_batch.product_id', 'left');
        $this->db->order_by("dealer_issue_batch.prdb_id", "desc");
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
    function get_dealer_issue_batch_info_by_batch_no($batch_no,$prdb_cost,$branch_id="")
    {
        $this->db->select('dealer_issue_batch.*');
        $this->db->from('dealer_issue_batch');
        $this->db->where("dealer_issue_batch.prdb_code", $batch_no);
        $this->db->where("dealer_issue_batch.prdb_cost", $prdb_cost);
        if($branch_id)
            $this->db->where("dealer_issue_batch.branch_id", $branch_id);
        //prdb_ref_no
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }
    /* Open Close dealer_issue sheet */
    function open($dealer_issue_id)
    {
        if ($dealer_issue_id) {
            $this->db->query('UPDATE `dealer_issue` SET `dealer_issue_status`= 1 WHERE `dealer_issue_id` = ' . $dealer_issue_id . '');
            return $this->db->affected_rows();
        } else return 0;
    }
    function close($dealer_issue_id)
    {
        if ($dealer_issue_id) {
            $this->db->query('UPDATE `dealer_issue` SET `dealer_issue_status`= 0 WHERE `dealer_issue_id` = ' . $dealer_issue_id . '');
            return $this->db->affected_rows();
        } else return 0;
    }
    /* Enable Disable dealer_issue Batch */
    function enable($prdb_id)
    {
        if ($prdb_id) {
            $this->db->query('UPDATE `dealer_issue_batch` SET `prdb_in_use`= 1 WHERE `prdb_id` = ' . $prdb_id . '');
            return $this->db->affected_rows();
        } else return 0;
    }
    function disable($prdb_id)
    {
        if ($prdb_id) {
            $this->db->query('UPDATE `dealer_issue_batch` SET `prdb_in_use`= 0 WHERE `prdb_id` = ' . $prdb_id . '');
            return $this->db->affected_rows();
        } else return 0;
    }
    // dealer_issue batch id ekakata HADAPU products gaana
    function get_manufactured_qty_by_prdb_id($prdb_id,$branch_id=""){
        $this->db->select_sum('dealer_issue_items.dealer_issue_quantity');
        $this->db->from('dealer_issue_items');
        $this->db->where("dealer_issue_items.dealer_issue_batch_id", $prdb_id);
        if($branch_id)
            $this->db->where("dealer_issue_items.branch_id", $branch_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }
    function get_manufactured_qty_consumption($prdb_id,$branch_id=""){
        $this->db->select_sum('pi.raw_mat_qty');
        $this->db->from('dealer_issue_raw_materials pi');
        $this->db->where('pi.batch_id', $prdb_id);
        $this->db->where('pi.batch_type', 'dealer_issue');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->raw_mat_qty;
        } else {
            return 0;
        }
    }
}
