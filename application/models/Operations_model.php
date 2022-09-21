<?php

class operations_model extends CI_Model
{


    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
    /* purchases */
    function get_purchases()
    {
        $this->db->select('*');
        $this->db->from('op_purchases');
        $this->db->where("op_user_id", $this->session->userdata('ss_user_id'));
        $query = $this->db->get();
        return $query->row();
    }
    function get_purchases_items($op_purchase_id)
    {
        $this->db->select('op_product_id as product_id,op_product_price as product_cost,op_quantity as product_quantity, product_name,product_code,op_batches as batches');
        $this->db->from('op_purchases_items');
        $this->db->join('product', 'product.product_id = op_purchases_items.op_product_id', 'left');
        $this->db->where("op_purchase_id", $op_purchase_id);
        $query = $this->db->get();
        return $query->result();
    }
    function get_purchases_item_quantity($op_purchase_id, $op_product_id)
    {
        $this->db->select('op_quantity');
        $this->db->from('op_purchases_items');
        $this->db->where("op_purchase_id", $op_purchase_id);
        $this->db->where("op_product_id", $op_product_id);
        $result = $this->db->get();
        if ($result->num_rows() > 0)
            return $result->row()->op_quantity;
        else return 0;
    }
    function handle_purchase($op_data, $op_id = "")
    {
        if (!$op_id) {
            if ($this->db->insert('op_purchases', $op_data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        } else {
            $this->db->where("op_id", $op_id);
            if ($this->db->update('op_purchases', $op_data)) {
                return true;
            } else {
                return false;
            }
        }
    }
    function handle_purchase_items($op_data, $op_id, $op_product_id)
    {
        if (!$op_id) {
            if ($this->db->insert('op_purchases_items', $op_data)) {
                return true;
            } else {
                return false;
            }
        } else {
            $this->db->where("op_purchase_id", $op_id);
            $this->db->where("op_product_id", $op_product_id);
            if ($this->db->update('op_purchases_items', $op_data)) {
                return true;
            } else {
                return false;
            }
        }
    }
    function delete_row($op_purchase_id, $op_product_id)
    {
        if ($op_product_id > 0 && $op_product_id > 0) {
            $this->db->where("op_purchase_id", $op_purchase_id);
            $this->db->where("op_product_id", $op_product_id);
            if ($this->db->delete('op_purchases_items')) {
                return true;
            } else {
                return false;
            }
        }
    }
    function clear_op($op_user_id)
    {
        if (!$op_user_id)
            return false;

        $where = array('op_user_id' => $op_user_id);
        if ($this->db->delete('op_purchases_items', $where)) {
            $this->db->delete('op_purchases', $where);
            if ($this->db->affected_rows()) {
                return $this->db->affected_rows();
            } else {
                return false;
            }
        }
    }
    function handle_purchase_items_test($op_purchase_id, $op_product_id, $op_quantity, $op_product_price)
    {
        $query = "INSERT INTO op_purchases_items (op_purchase_id,op_product_id,op_product_price, op_quantity) VALUES ($op_purchase_id,$op_product_id,$op_product_price,$op_quantity)
        ON DUPLICATE KEY UPDATE
        op_quantity    =  op_quantity + VALUES(op_quantity),
        op_product_price = VALUES(op_product_price) ";
        if ($this->db->query($query)) {
            return true;
        } else return false;
    }
    /**
     * PRODUCTION
     */
    function get_productions()
    {
        $this->db->select('*');
        $this->db->from('op_production');
        $this->db->where("op_user_id", $this->session->userdata('ss_user_id'));
        $query = $this->db->get();
        return $query->row();
    }
}
