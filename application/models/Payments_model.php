<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class payments_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_total_paid($pymnt_type, $reference_id)
    {
        $this->db->select_sum('pymnt_amount');
        $this->db->from('payments');
        $this->db->where("reference_id", $reference_id);
        $this->db->where("pymnt_type", $pymnt_type);
        $query = $this->db->get();
        if ($query->row()->pymnt_amount) {
            return $query->row()->pymnt_amount;
        } else {
            return 0;
        }
    }
    function get_paid($pymnt_type, $reference_id)
    {
        $this->db->select('*');
        $this->db->from('payments');
        $this->db->where("reference_id", $reference_id);
        $this->db->where("pymnt_type", $pymnt_type);
        $query = $this->db->get();
        return $query->result();
        
    }
    function get_payments($start, $length, $filter)
    {
        $this->db->select('p.*,u.user_first_name,u.user_last_name,w.name');
        $this->db->from('payments p');
        $this->db->join('user u','p.user_id = u.user_id','left');
        $this->db->join('branches w','p.branch_id = p.branch_id','left');

        if (isset($filter['pymnt_type'])) {
            if ($filter['pymnt_type'] != "")
                $this->db->where("p.pymnt_type", $filter['pymnt_type']);
        }

        if (isset($filter['paid_by'])) {
            if ($filter['paid_by'] != "")
                $this->db->where("p.pay_by", $filter['paid_by']);
        }

        if (isset($filter['date_from'])) {
            if ($filter['date_from'] != "")
                $this->db->where("date(p.pymnt_date_time) >= '" . $filter['date_from'] . "'");
        }

        if (isset($filter['date_to'])) {
            if ($filter['date_to'] != "")
                $this->db->where("date(p.pymnt_date_time) <= '" . $filter['date_to'] . "'");
        }

        if (isset($filter['user_id'])) {
            if ($filter['user_id'] > 0)
                $this->db->where("p.user_id", $filter['user_id']);
        }

        if (isset($filter['branch_id'])) {
            if ($filter['branch_id'] > 0)
                $this->db->where("p.branch_id", $filter['branch_id']);
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
    function get_payment_summary($filter)
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
}
